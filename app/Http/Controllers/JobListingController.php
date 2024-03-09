<?php
// app/Http/Controllers/JobListingController.php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobCategory;


class JobListingController extends Controller
{
    public function index()
    {
        try {
            // get and display a list of all job listings
            $jobListings = JobListing::all();

            // return the view with job listings data
            return view('recruiter.jobListings.createJob', ['jobListings' => $jobListings]);
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('recruiter.jobListings.createJob')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    // get the jobs for the applicants
    public function showAllJobListingsForApplicants()
    {
        try {
            // load the applicants relationship for all job listings
            $jobListings = JobListing::with('applicants')->get();

            // return the view with job listings data
            return view('students.applications.viewAllJobs', compact('jobListings'));
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('job_listings.applicant_allJobs')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function showMyJobListingsForApplicants()
    {
        try {
            // Load the user's preferences
            $userPreferences = auth()->user()->userPreferences;

            // Check if preferences are saved
            if ($userPreferences) {
                // Get job listings based on preferences
                $jobListings = JobListing::where(function ($query) use ($userPreferences) {
                    $query->where('job_category_id', $userPreferences->job_category_id)
                        ->orWhere('location', $userPreferences->location)
                        ->orWhere('job_title', $userPreferences->job_title);
                })->with('applicants')->get();

                // Check if personalized jobs were found
                if ($jobListings->isEmpty()) {
                    $message = trans('messages.user_job_listings.no_personalized_jobs');
                } else {
                    $message = trans('messages.user_job_listings.myJobsFound');
                }

            } else {
                // User has no preferences
                $message = trans('messages.user_job_listings.require_preferences');
                $jobListings = collect(); // Empty collection, as there are no preferences
            }

            // Return the view with personalized job listings data and optional message
            return view('students.applications.viewMyJobs', compact('jobListings', 'message'));

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in showMyJobListingsForApplicants: ' . $e->getMessage());
            // Redirect with an error message
            return redirect()->route('job_listings.applicant_myJobs')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }




    // get the categories for recruiters
    public function showJobListingsForRecruiters()
    {
        try {
            // authenticate and get job listings for the logged-in recruiter
            $jobListings = auth()->user()->jobListings;

            // also get the categories for the edit probability
            $jobCategories = JobCategory::all();

            // return the view with job listings and categories data
            return view('recruiter.jobListings.viewJob', ['jobListings' => $jobListings, 'job_categories' => $jobCategories]);
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('recruiter.jobListings.viewJob')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    // apply for a job (applicant)
    public function apply(JobListing $jobListing)
    {
        try {
            // check if the user is an applicant
            if (auth()->user()->isApplicant()) {
                // toggle the relationship between the user and the job listing
                auth()->user()->jobApplications()->toggle($jobListing);

                // redirect with success message
                return redirect()->route('job_listings.applicant_index')->with('success', 'Application submitted.');
            }

            // user is not authorized to apply for jobs, redirect with error message
            return redirect()->route('job_listings.applicant_index')->withErrors(['error' => 'You are not authorized to apply for jobs.']);
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('job_listings.applicant_index')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
