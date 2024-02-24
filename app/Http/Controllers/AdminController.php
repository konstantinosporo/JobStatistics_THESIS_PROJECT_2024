<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobDescription;
use App\Models\User;
use App\Models\JobCategory;



class AdminController extends Controller
{


    protected function getValidationRules()
    {
        return [
            'jobdescriptiongreek' => 'required|string',
        ];
    }

    public function viewJobs(Request $request)
    {
        if ($request->has('query')) {
            // If a search query is provided, filter the results
            $query = $request->input('query');
            $jobDescriptions = JobDescription::with('job')
                ->where('jobdescriptiongreek', 'LIKE', "%$query%")
                ->orWhere('jobdescriptionenglish', 'LIKE', "%$query%")
                ->paginate(1);
        } else {
            // If no search query, retrieve all jobs
            $jobDescriptions = JobDescription::with('job')->paginate(10);
        }

        return view('admin.jobs.indexDescriptions', compact('jobDescriptions'));
    }

    public function viewUsers()
    {
        $users = User::paginate(10);

        return view('admin.viewUsers.indexUsers', compact('users'));
    }
    public function editJobs($id)
    {
        $jobDescription = JobDescription::findOrFail($id);

        return view('admin.jobs.editDescriptions', compact('jobDescription'));
    }

    public function updateJobDescription(Request $request, $id)
    {
        $validatedData = $request->validate($this->getValidationRules());

        $jobDescription = JobDescription::findOrFail($id);

        // Update job descriptions
        $jobDescription->update([
            'jobdescriptiongreek' => $validatedData['jobdescriptiongreek'],
            'jobdescriptionenglish' => $validatedData['jobdescriptionenglish'],
        ]);

        // Update job category name
        $job = $jobDescription->job;
        $jobCategory = $job->jobCategory;

        // Assuming you have fields like 'greek_name' and 'english_name' in your JobCategory model
        $jobCategory->update([
            'greek_name' => $validatedData['jobcategorygreek'],
            'english_name' => $validatedData['jobcategoryenglish'],
        ]);

        return redirect()->route('admin.jobs.indexDescriptions')->with('success', 'Job description updated successfully');
    }

    public function deleteJobDescription($id)
    {
        $jobDescription = JobDescription::find($id);

        if (!$jobDescription) {
            return redirect()->route('admin.jobs.editDescriptions')->with('error', 'Job description not found!');
        }

        $jobDescription->delete();

        return redirect()->route('admin.jobs.indexDescriptions')->with('success', 'Job description deleted successfully!');
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.viewUsers.indexViewUsers')->with('deleteSuccess', 'User deleted successfully.');
    }

    //return view for modal 
    public function editUser($id)
    {
        $user = User::findOrFail($id);

        return view('admin.viewUsers.indexViewUsers', ['user' => $user]);
    }

    //save the update changes
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'nullable|in:admin,recruiter,user', // user roles
        ]);

        $user->update($request->all());

        return redirect()->route('admin.viewUsers.indexViewUsers')->with('updateSuccess', 'User updated successfully.');
    }

    //suggest job_categories
    public function suggestJobCategoriesAdmin(Request $request)
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
        return view('admin.includes.partials.admin_search_jobs', ['jobCategories' => $jobCategories]);
    }
}
