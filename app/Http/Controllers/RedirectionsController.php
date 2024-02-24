<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Message;

class RedirectionsController extends Controller
{
    public function indexRedirect()
    {
        return view("index");
    }
    public function signInRedirect()
    {
        return view("signIn");
    }
    public function signUpRedirect()
    {
        return view("signUp");
    }
    // APPLICANT AUTHENTICATION & REDIRECT
    public function signedInRedirect(Request $request)
    {
        // Ensure the user is authenticated
        if (auth()->check() && auth()->user()->isApplicant()) {

            $user = auth()->user();

            return view('students.indexStudent', compact('user'));
        }

        // ERROR
        return redirect()->route('login')->with('error', 'ACCESS DENIED - err 403');
    }
    // ADMIN AUTHENTICATION & REDIRECT
    public function signedInAdminRedirect(Request $request)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            $admin = auth()->user();

            $userCount = User::where('role', 'user')->count();
            $adminCount = User::where('role', 'admin')->count();
            $recruiterCount = User::where('role', 'recruiter')->count();

            // Get timestamps for JobListings
            $jobListings = JobListing::select('created_at')->get();
            $jobListingsCount = $jobListings->count();

            // Get timestamps for JobApplications
            $jobApplications = JobApplication::select('created_at')->get();
            $jobApplicationsCount = $jobApplications->count();

            // Count sent messages from users
            $sentMessagesFromUsersCount = Message::whereHas('sender', function ($query) {
                $query->where('role', 'user');
            })->count();

            // Count sent messages from recruiters
            $sentMessagesFromRecruitersCount = Message::whereHas('sender', function ($query) {
                $query->where('role', 'recruiter');
            })->count();

            return view(
                'admin.signedInAdmin',
                compact(
                    'admin',
                    'userCount',
                    'adminCount',
                    'recruiterCount',
                    'jobListings',
                    'jobListingsCount',
                    'jobApplications',
                    'jobApplicationsCount',
                    'sentMessagesFromUsersCount',
                    'sentMessagesFromRecruitersCount'
                )
            );
        }

        // ERROR
        return redirect()->route('login')->with('error', 'ACCESS DENIED - err 403');

    }
    // RECRUITER AUTHENTICATION & REDIRECT
    public function signedInRecruiterRedirect(Request $request)
    {
        // Ensure the user is authenticated
        if (auth()->check() && auth()->user()->isRecruiter()) {

            $recruiter = auth()->user();

            // Check if the authenticated user has the 'recruiter' role
            if ($recruiter->role == 'recruiter') {

                // Get job listings created by the recruiter with applicants
                $jobListings = $recruiter->jobListings()->with('applicants')->get();

                // Prepare data for the chart
                $labels = [];
                $data = [];

                foreach ($jobListings as $jobListing) {
                    $labels[] = $jobListing->job_title;
                    $data[] = $jobListing->applicants->count();
                }

                // Pass data to the view
                return view('recruiter.indexRecruiter', compact('recruiter', 'jobListings', 'labels', 'data'));
            }
        }

        // ERROR
        return redirect()->route('login')->with('error', 'ACCESS DENIED - err 403');
    }

}
