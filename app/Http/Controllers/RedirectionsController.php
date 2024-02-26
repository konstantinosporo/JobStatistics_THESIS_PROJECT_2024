<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Message;
use App\Models\JobCategory;

class RedirectionsController extends Controller
{
    public function indexRedirect()
    {
        // return the view for the index page
        return view("index");
    }

    public function signInRedirect()
    {
        // return the view for the sign-in page
        return view("signIn");
    }

    public function signUpRedirect()
    {
        // return the view for the sign-up page
        return view("signUp");
    }

    // applicant authentication & redirect
    public function signedInRedirect(Request $request)
    {
        try {
            // ensure the user is authenticated
            if (auth()->check() && auth()->user()->isApplicant()) {
                // retrieve authenticated user
                $user = auth()->user();

                // fetch the authenticated user's preferences if they exist
                $userPreferences = $user->userPreferences ?? null;

                // also get the categories for the edit probability
                $jobCategories = JobCategory::all();

                // redirect to the index student page with user data
                return view('students.indexStudent', compact('user', 'userPreferences', 'jobCategories'));
            }

            // access denied, redirect to login with error message
            return redirect()->route('login')->with('error', 'ACCESS DENIED - err 403');
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to login with error message
            return redirect()->route('login')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


    // admin authentication & redirect
    public function signedInAdminRedirect(Request $request)
    {
        try {
            // ensure the user is authenticated and is an admin
            if (auth()->check() && auth()->user()->isAdmin()) {
                // retrieve authenticated admin user
                $admin = auth()->user();

                // count users based on roles
                $userCount = User::where('role', 'user')->count();
                $adminCount = User::where('role', 'admin')->count();
                $recruiterCount = User::where('role', 'recruiter')->count();

                // get timestamps for JobListings
                $jobListings = JobListing::select('created_at')->get();
                $jobListingsCount = $jobListings->count();

                // get timestamps for JobApplications
                $jobApplications = JobApplication::select('created_at')->get();
                $jobApplicationsCount = $jobApplications->count();

                // count sent messages from users
                $sentMessagesFromUsersCount = Message::whereHas('sender', function ($query) {
                    $query->where('role', 'user');
                })->count();

                // count sent messages from recruiters
                $sentMessagesFromRecruitersCount = Message::whereHas('sender', function ($query) {
                    $query->where('role', 'recruiter');
                })->count();

                // return the view with admin and related counts
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

            // access denied, redirect to login with error message
            return redirect()->route('login')->with('error', 'ACCESS DENIED - err 403');
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to login with error message
            return redirect()->route('login')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    // recruiter authentication & redirect
    public function signedInRecruiterRedirect(Request $request)
    {
        try {
            // ensure the user is authenticated and is a recruiter
            if (auth()->check() && auth()->user()->isRecruiter()) {
                // retrieve authenticated recruiter user
                $recruiter = auth()->user();

                // check if the authenticated user has the 'recruiter' role
                if ($recruiter->role == 'recruiter') {
                    // get job listings created by the recruiter with applicants
                    $jobListings = $recruiter->jobListings()->with('applicants')->get();

                    // prepare data for the chart
                    $labels = [];
                    $data = [];

                    foreach ($jobListings as $jobListing) {
                        $labels[] = $jobListing->job_title;
                        $data[] = $jobListing->applicants->count();
                    }

                    // pass data to the view
                    return view('recruiter.indexRecruiter', compact('recruiter', 'jobListings', 'labels', 'data'));
                }
            }

            // access denied, redirect to login with error message
            return redirect()->route('login')->with('error', 'ACCESS DENIED - err 403');
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to login with error message
            return redirect()->route('login')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


}
