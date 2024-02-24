<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Models\JobDescription;

class JobDescriptionController extends Controller
{
    public function getJobDescription(Request $request)
    {
        $query = $request->query('query');

        // Assuming you have a relationship set up in your JobCategory model
        $jobCategory = JobCategory::where('english_name', 'like', '%' . $query . '%')
            ->orWhere('greek_name', 'like', '%' . $query . '%')
            ->first();

        if ($jobCategory) {
            $jobDescription = $jobCategory->jobDescription; // Access the relationship

            // Assuming you want to return the description in English
            return response()->json([
                'description' => $jobDescription ? $jobDescription->jobdescriptionenglish : 'No description found'
            ]);
        }

        return response()->json(['description' => 'No description found']);
    }
}
