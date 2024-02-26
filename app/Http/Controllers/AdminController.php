<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobDescription;
use App\Models\User;
use App\Models\JobCategory;



class AdminController extends Controller
{

    // setting the validation rules
    protected function getValidationRules()
    {
        return [
            'jobdescriptiongreek' => 'required|string',
            'jobdescriptionenglish' => 'required|string',
            'jobcategorygreek' => 'required|string',
            'jobcategoryenglish' => 'required|string',
            // for less redundancy
        ];
    }

    // if 'query' in session array get the jobdesciptions from the db
    public function viewJobs(Request $request)
    {
        if ($request->has('query')) {
            // if  'query' in session array  filter the results
            $query = $request->input('query');
            $jobDescriptions = JobDescription::with('job')
                ->where('jobdescriptiongreek', 'LIKE', "%$query%")
                ->orWhere('jobdescriptionenglish', 'LIKE', "%$query%")
                ->paginate(1);
        } else {
            //  no search query, retrieve all jobs
            $jobDescriptions = JobDescription::with('job')->paginate(10);
        }

        return view('admin.jobs.indexDescriptions', compact('jobDescriptions'));
    }

    // if 'query' in session array get the users from the db
    public function viewUsers(Request $request)
    {
        if ($request->has('query')) {
            // if 'query' in session array, filter the results
            $query = $request->input('query');
            $users = User::where('email', 'like', '%' . $query . '%')
                ->orWhere('id', $query)
                ->paginate(1);
        } else {
            //  no search query, retrieve all jobs
            $users = User::paginate(10);
        }
        return view('admin.viewUsers.indexUsers', compact('users'));
    }

    // if exists $id get jobdescriptions($id) from the db
    public function editJobs($id)
    {
        try {
            $jobDescription = JobDescription::findOrFail($id);

            return view('admin.jobs.editDescriptions', compact('jobDescription'));
        } catch (\Exception $e) {
            return redirect()->route('admin.jobs.indexDescriptions')->with('updateError', 'Failed to update job description');
        }
    }

    // if jobdescrription($id) exists and validated data, updated the db
    public function updateJobDescription(Request $request, $id)
    {
        try {
            $validatedData = $request->validate($this->getValidationRules());

            $jobDescription = JobDescription::findOrFail($id);

            // update job descriptions if $id exists
            $jobDescription->update([
                'jobdescriptiongreek' => $validatedData['jobdescriptiongreek'],
                'jobdescriptionenglish' => $validatedData['jobdescriptionenglish'],
            ]);

            // update job category name if validated data
            $job = $jobDescription->job;
            $jobCategory = $job->jobCategory;

            // update job category
            $jobCategory->update([
                'greek_name' => $validatedData['jobcategorygreek'],
                'english_name' => $validatedData['jobcategoryenglish'],
            ]);

            return redirect()->route('admin.jobs.indexDescriptions')->with('updateSuccess', 'Job description updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.jobs.indexDescriptions')->with('updateError', 'Failed to update job description');
        }
    }

    // if jobdescription($id) exists deleted jobdescription from db
    public function deleteJobDescription($id)
    {
        try {
            $jobDescription = JobDescription::find($id);

            if (!$jobDescription) {
                return redirect()->route('admin.jobs.editDescriptions')->with('error', 'Job description not found!');
            }

            $jobDescription->delete();

            return redirect()->route('admin.jobs.indexDescriptions')->with('deleteSuccess', 'Job description deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.jobs.indexDescriptions')->with('deleteError', 'Failed to delete job description');
        }
    }

    // return view for modal
    public function editUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return view('admin.viewUsers.indexViewUsers', ['user' => $user]);
        } catch (\Exception $e) {
            return redirect()->route('admin.viewUsers.indexViewUsers')->with('updateError', 'Failed to update user');
        }
    }


    // save the update changes
    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'role' => 'nullable|in:admin,recruiter,user', // user roles
            ]);

            $user->update($request->all());

            return redirect()->route('admin.viewUsers.indexViewUsers')->with('updateSuccess', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.viewUsers.indexViewUsers')->with('updateError', 'Failed to update user');
        }
    }

    // if user($id) exists delete from db
    public function deleteUser($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()->route('admin.viewUsers.indexViewUsers')->with('error', 'User not found!');
            }

            $user->delete();

            return redirect()->route('admin.viewUsers.indexViewUsers')->with('deleteSuccess', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.viewUsers.indexViewUsers')->with('deleteError', 'Failed to delete user');
        }
    }


    // suggest job_categories (search)
    public function suggestJobCategoriesAdmin(Request $request)
    {
        $query = $request->query('query');

        // fetch job categories that closely match the query
        $jobCategories = JobCategory::where('english_name', 'like', '%' . $query . '%')
            ->orWhere(
                'greek_name',
                'like',
                '%' . $query . '%'
            )
            ->get();

        // return a view with job category suggestions
        return view('admin.includes.partials.admin_search_jobs', ['jobCategories' => $jobCategories]);
    }
    // suggest users (search)
    public function suggestUsersAdmin(Request $request)
    {
        $query = $request->query('query');

        // fetch users based on email or ID
        $users = User::where('email', 'like', '%' . $query . '%')
            ->orWhere('id', $query)
            ->get();

        //dd($users);


        return view('admin.includes.partials.admin_search_users', ['users' => $users]);
    }

}
