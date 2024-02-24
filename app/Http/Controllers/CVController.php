<?php

namespace App\Http\Controllers;

use App\Models\CV;
use Illuminate\Http\Request;

class CVController extends Controller
{
    // method to show off the CV creation form
    public function create()
    {
        // grab the authenticated user
        $user = auth()->user();

        // snag the user's CV or set it to null
        $cv = $user->cv ?? null;

        // show the view with the CV data (if any)
        return view('students.CV.createCV', compact('cv'));
    }

    // method to stash a new CV in the database
    // method to stash a new CV in the database
    public function store(Request $request)
    {
        // grab the authenticated user
        $user = auth()->user();

        // validate the incoming request data, including the photo
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'proficiency' => 'required|string',
            'description' => 'required|string',
            'experience' => 'required|string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // handle file upload
        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('public/cv_photos');
        }

        // create a new CV instance with the validated data
        $cv = new CV($validatedData);

        // set the user_id for the CV
        $cv->user_id = $user->id;

        // save the CV to the database and redirect with a success or error message
        if ($cv->save()) {
            return redirect()->route('createCv')->with('success', 'CV saved successfully!');
        } else {
            return redirect()->route('createCv')->with('error', 'Error saving CV.');
        }
    }

    // method to show off the CV editing form
    public function edit()
    {
        // grab the authenticated user
        $user = auth()->user();

        // snag the user's CV or set it to null
        $cv = $user->cv ?? null;

        // show the view with the CV data (if any)
        return view('students.CV.createCV', compact('cv'));
    }

    // method to update an existing CV in the database
    // method to update an existing CV in the database
    public function update(Request $request)
    {
        // grab the authenticated user
        $user = auth()->user();

        // snag the user's CV
        $cv = $user->cv;

        // validate the incoming request data, including the photo
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'proficiency' => 'required|string',
            'description' => 'required|string',
            'experience' => 'required|string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // handle file upload
        if ($request->hasFile('photo')) {
            // Delete the previous photo if it exists
            if ($cv->photo) {
                // Use the public_path function to get the absolute path
                // and unlink to delete the file
                unlink(storage_path('app/' . $cv->photo));
            }

            // Store the new photo
            $validatedData['photo'] = $request->file('photo')->store('public/cv_photos');
        }

        // use the fill method to update the CV instance with validated data
        $cv->fill($validatedData);

        // save the changes to the database and redirect with a success or error message
        if ($cv->save()) {
            return redirect()->route('editCv')->with('success', 'CV updated successfully!');
        } else {
            return redirect()->route('editCv')->with('error', 'Error updating CV.');
        }
    }

    public function view(Cv $cv)
    {
        // You might want to add some additional logic here, like checking if the user has permission to view this CV.

        return view('recruiter.applicants.showCV', compact('cv'));
    }

    public function delete()
    {
        // user auth
        $user = auth()->user();
        // get cv
        $cv = $user->cv;
        // if not cv then error
        if (!$cv) {
            abort(403, 'CV not found for the authenticated user.');
        }

        $cv->delete();

        return redirect()->route('createCv')->with('deleteCvSuccess', 'CV deleted successfully.');
    }




    // constructor method to apply authentication middleware to the controller
    public function __construct()
    {
        $this->middleware('auth');
    }
}
