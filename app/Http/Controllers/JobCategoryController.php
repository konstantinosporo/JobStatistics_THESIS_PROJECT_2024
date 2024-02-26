<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class JobCategoryController extends Controller
{
    // suggestion box query for job categories
    public function getJobCategorySuggestions(Request $request)
    {
        try {
            // get the query from the request
            $query = $request->input('query');

            // fetch job categories that closely match the query
            $jobCategories = JobCategory::where('english_name', 'like', "%{$query}%")->get(['id', 'english_name']);

            // return the job categories as JSON response
            return response()->json($jobCategories);
        } catch (\Exception $e) {
            // handle unexpected exceptions, return an error JSON response or log the error
            return response()->json(['error' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }

}
