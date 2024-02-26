<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Models\JobDescription;


class JobController extends Controller
{
    // get data for the "line" graph type (graphType1)
    public function showgraphType1(Request $request)
    {
        try {
            // retrieve the search query from the request
            $query = $request->query('query');
            // initialize data collection, selected category, and job description variables
            $data = collect();
            $selectedcategory = '';
            $jobdescription = '';

            if ($query) {
                // find the first jobcategory that matches the query
                $jobcategory = JobCategory::where('english_name', $query)
                    ->orWhere('greek_name', $query)
                    ->first();

                if ($jobcategory) {
                    // get employee statistics for the selected job category
                    $data = $this->getemployeestatistics($jobcategory->id);
                    // create an object with the selected category names
                    $selectedcategory = (object) [
                        'english_name' => $jobcategory->english_name,
                        'greek_name' => $jobcategory->greek_name,
                    ];

                    // get the job description based on the selected category
                    $jobdescription = JobDescription::where('job_id', $jobcategory->id)
                        ->first();
                }
            }

            // pass data, selected job category name, and job description to the view
            return view('students.statistics.graphtype1', ['data' => $data, 'selectedcategory' => $selectedcategory, 'jobdescription' => $jobdescription]);
        } catch (\Exception $e) {
            //  return an error response
            return view('students.statistics.graphtype1')->withErrors(['error' => 'Failed to retrieve statistics']);
        }
    }

    // get data for the "polar" graph type (graphType2)
    public function showgraphType2(Request $request)
    {
        try {
            // retrieve the query parameter from the request
            $query = $request->query('query');
            // create a collection to store data
            $data = collect();
            $selectedCategory = '';
            $jobDescription = '';

            if ($query) {
                // fetch the first job category that matches the query
                $jobCategory = JobCategory::where('english_name', $query)
                    ->orWhere('greek_name', $query)
                    ->first();

                if ($jobCategory) {
                    // get employee statistics for the selected job category
                    $data = $this->getEmployeeStatistics($jobCategory->id);
                    // create an object for the selected category
                    $selectedCategory = (object) [
                        'english_name' => $jobCategory->english_name,
                        'greek_name' => $jobCategory->greek_name,
                    ];

                    // fetch the job description based on the selected category
                    $jobDescription = JobDescription::where('job_id', $jobCategory->id)
                        ->first();
                }
            }

            // pass data and the selected job category name to the view
            return view('students.statistics.graphType2', [
                'data' => $data,
                'selectedCategory' => $selectedCategory,
                'jobDescription' => $jobDescription, // pass the job description to the view
            ]);
        } catch (\Exception $e) {
            // handle unexpected exceptions, log the error, or return an error response
            return view('students.statistics.graphType2', [
                'data' => collect(),
                'selectedCategory' => '',
                'jobDescription' => '',
            ]);
        }
    }

    // get the job category (used by both graphs)
    public function getemployeestatistics($jobcategoryid)
    {
        try {
            // aggregate employee data by year for the given job category
            return Job::where('job_category_id', $jobcategoryid)
                ->whereBetween('year', [1995, 2022])
                ->selectRaw('year, SUM(employees) as total_employees')
                ->groupBy('year')
                ->orderBy('year')
                ->get();
        } catch (\Exception $e) {
            // return with error response
            return redirect()->back()->with('error', 'Failed to retrieve the Employee Statistics.');
        }
    }

    // ajax calling method for async fetching
    public function suggestJobCategoriesLine(Request $request)
    {
        $query = $request->query('query');

        // fetch job categories that closely match the query
        $jobCategories = JobCategory::where('english_name', 'like', '%' . $query . '%')
            ->orWhere('greek_name', 'like', '%' . $query . '%')
            ->get();

        // return a view with job category suggestions
        return view('students.includes.partials.jcs_line', ['jobCategories' => $jobCategories]);
    }

    // ajax calling method for async fetching
    public function suggestJobCategoriesPie(Request $request)
    {
        $query = $request->query('query');

        // Fetch job categories that closely match the query
        $jobCategories = JobCategory::where('english_name', 'like', '%' . $query . '%')
            ->orWhere(
                'greek_name',
                'like',
                '%' . $query . '%'
            )
            ->get();

        // Return a view with job category suggestions
        return view('students.includes.partials.jcs_pie', ['jobCategories' => $jobCategories]);
    }








    public function __construct()
    {
        // Ensure only authenticated users can access methods in this controller
        $this->middleware('auth');
    }

}
