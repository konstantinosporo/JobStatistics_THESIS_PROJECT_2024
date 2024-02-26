<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\JobCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecruiterController extends Controller
{
    // get categories for form
    public function create()
    {
        try {
            // get all job categories
            $jobCategories = JobCategory::all();

            // return the view for creating a job listing with job categories data
            return view('recruiter.jobListings.createJob', ['jobCategories' => $jobCategories]);
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('recruiter.jobListings.createJob')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    // save a new job_listing
    public function store(Request $request)
    {
        try {
            // define validation rules
            $rules = [
                'job_title' => 'required|string|max:255',
                'job_description' => 'required|string',
                'location' => 'required|string',
                'qualifications' => 'required|string',
                'job_category_id' => 'required|exists:job_categories,id',
            ];

            // create a validator instance
            $validator = Validator::make($request->all(), $rules);

            // check if validation fails
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // if validation passes, continue with creating the job listing
            $jobListing = new JobListing([
                'job_title' => $request->input('job_title'),
                'job_description' => $request->input('job_description'),
                'location' => $request->input('location'),
                'qualifications' => $request->input('qualifications'),
                'job_category_id' => $request->input('job_category_id'),
            ]);

            // associate the job listing with the logged-in recruiter
            Auth::user()->jobListings()->save($jobListing);

            // return success message or redirect to a success page
            return redirect()->route('job_listings.index')->with('success', 'Job listing created successfully.');
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('job_listings.index')->with('error', 'Error creating job listing!');
        }
    }

    // show the applied users (recruiter)
    public function showApplicants()
    {
        try {
            // get the authenticated recruiter user
            $recruiter = Auth::user();

            // get job listings with applicants and their CVs
            $jobListings = $recruiter->jobListings()->with(['applicants.cv'])->get();

            // return the view with job listings and applicants data
            return view('recruiter.applicants.showApplicants', compact('jobListings'));
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('recruiter.applicants.showApplicants')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    // return view for modal
    public function edit($id)
    {
        try {
            // find the job listing by its ID
            $jobListing = JobListing::findOrFail($id);

            // get all job categories
            $jobCategories = JobCategory::all();

            // return the view for editing a job listing with job listing and categories data
            return view('recruiter.jobListings.viewJob', ['jobListings' => $jobListing, 'job_categories' => $jobCategories]);
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('recruiter.jobListings.viewJob')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    // save the update changes for a job listing
    public function update(Request $request, $id)
    {
        try {
            // find the job listing by its ID
            $jobListing = JobListing::findOrFail($id);

            // validate the request data
            $request->validate([
                'job_title' => 'required|string|max:255',
                'job_description' => 'required|string',
                'location' => 'required|string',
                'qualifications' => 'required|string',
                'job_category_id' => 'required|exists:job_categories,id'
            ]);

            // update the job listing with the new data
            $jobListing->update($request->all());

            // return success message or redirect to a success page
            return redirect()->route('recruiter.job_listings.view')->with('updateSuccess', 'Job listing updated successfully.');
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('recruiter.job_listings.view')->with('updateError', 'An unexpected error occurred. Please try again.');
        }
    }

    // destroy a job listing
    public function destroy(JobListing $jobListing)
    {
        try {
            // delete the job listing
            $jobListing->delete();

            // return success message or redirect to a success page
            return redirect()->route('recruiter.job_listings.view')->with('deleteSuccess', 'Job listing deleted successfully.');
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('recruiter.job_listings.view')->with('deleteError', 'An unexpected error occurred. Please try again.');
        }
    }



}
