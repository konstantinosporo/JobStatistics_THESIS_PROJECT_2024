<?php

// app/Http/Controllers/JobListingController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\JobCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobListingController extends Controller
{
    public function index()
    {
        // get and display a list of job listings
        $jobListings = JobListing::all();
        return view('recruiter.jobListings.createJob', ['jobListings' => $jobListings]);
    }

    //get the categories for the applicants
    public function showJobListingsForApplicants()
    {
        //  load the applicants relationship
        $jobListings = JobListing::with('applicants')->get();

        return view('students.applications.viewJobs', compact('jobListings'));
    }

    //get the categories for recrioters
    public function showJobListingsForRecruiters()
    {
        // auth/get joblistings
        $jobListings = auth()->user()->jobListings;
        //also get the catgories for the edit propability
        $jobCategories = JobCategory::all();

        return view('recruiter.jobListings.viewJob', ['jobListings' => $jobListings, 'job_categories' => $jobCategories]);
    }

    //get categories for form
    public function create()
    {
        $jobCategories = JobCategory::all();
        return view('recruiter.jobListings.createJob', ['jobCategories' => $jobCategories]);
    }

    //save a new job_listing
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'location' => 'required|string',
            'qualifications' => 'required|string',
            'job_category_id' => 'required|exists:job_categories,id',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // If validation passes, continue with creating the job listing
        $jobListing = new JobListing([
            'job_title' => $request->input('job_title'),
            'job_description' => $request->input('job_description'),
            'location' => $request->input('location'),
            'qualifications' => $request->input('qualifications'),
            'job_category_id' => $request->input('job_category_id'),
        ]);

        // Associate the job listing with the logged-in recruiter
        Auth::user()->jobListings()->save($jobListing);

        return redirect()->route('job_listings.index')->with('success', 'Job listing created successfully.');
    }

    //suggestion box query 
    public function getJobCategorySuggestions(Request $request)
    {
        $query = $request->input('query');
        $jobCategories = JobCategory::where('english_name', 'like', "%{$query}%")->get(['id', 'english_name']);

        return response()->json($jobCategories);
    }


    //apply for a job (applicant)
    public function apply(JobListing $jobListing)
    {
        // Check if the user is an applicant
        if (auth()->user()->isApplicant()) {
            // Toggle the relationship between the user and the job listing
            auth()->user()->jobApplications()->toggle($jobListing);

            return redirect()->route('job_listings.applicant_index')->with('success', 'Application submitted.');
        }

        return redirect()->route('job_listings.applicant_index')->withErrors(['error' => 'You are not authorized to apply for jobs.']);
    }



    // show the applied users (recruiter)
    public function showApplicants()
    {
        $recruiter = Auth::user();
        $jobListings = $recruiter->jobListings()->with(['applicants.cv'])->get();

        return view('recruiter.applicants.showApplicants', compact('jobListings'));
    }

    //destroy
    public function destroy(JobListing $jobListing)
    {
        $jobListing->delete();

        return redirect()->route('recruiter.job_listings.view')->with('deleteSuccess', 'Job listing deleted successfully.');
    }

    //return view for modal 
    public function edit($id)
    {
        $jobListing = JobListing::findOrFail($id);
        $jobCategories = JobCategory::all();

        return view('recruiter.jobListings.viewJob', ['jobListings' => $jobListing, 'job_categories' => $jobCategories]);
    }

    //save the update changes
    public function update(Request $request, $id)
    {
        $jobListing = JobListing::findOrFail($id);

        $request->validate([
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'location' => 'required|string',
            'qualifications' => 'required|string',
            'job_category_id' => 'required|exists:job_categories,id'
        ]);

        $jobListing->update($request->all());

        return redirect()->route('recruiter.job_listings.view')->with('updateSuccess', 'Job listing updated successfully.');
    }
}
