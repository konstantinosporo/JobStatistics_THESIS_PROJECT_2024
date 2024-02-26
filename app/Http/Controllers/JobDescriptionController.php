<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Models\JobDescription;

class JobDescriptionController extends Controller
{
    public function getjobdescription(Request $request)
    {
        try {
            // retrieve the search query from the request
            $query = $request->query('query');

            // find a jobcategory that matches the query
            $jobcategory = JobCategory::where('english_name', 'like', '%' . $query . '%')
                ->orWhere('greek_name', 'like', '%' . $query . '%')
                ->first();

            if ($jobcategory) {
                // access the jobdescription relationship
                $jobdescription = $jobcategory->jobDescription;

                // return the job description in english if available, otherwise a default message
                return response()->json([
                    'description' => $jobdescription ? $jobdescription->jobdescriptionenglish : 'No description found'
                ]);
            }

            // return a default message if no matching jobcategory is found
            return response()->json(['description' => 'No description found']);
        } catch (\Exception $e) {
            // handle unexpected exceptions, return an error response, or log the error
            return response()->json(['error' => 'Failed to retrieve job description']);
        }
    }

}
