<?php

namespace App\Http\Controllers;

use App\Models\CV;
use Illuminate\Http\Request;

class CVController extends Controller
{
    // method to show off the CV creation form
    public function create()
    {
        try {
            // grab the authenticated user
            $user = auth()->user();

            // snag the user's CV or set it to null
            $cv = $user->cv ?? null;

            // show the view with the CV data (if any)
            return view('students.CV.createCV', compact('cv'));
        } catch (\Exception $e) {
            // handle unexpected exceptions, log the error, or return an error response
            return view('students.CV.createCV', ['cv' => null]);
        }
    }

    // method to stash a new CV in the database
    public function store(Request $request)
    {
        // get the authenticated user
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
        try {
            // grab the authenticated user
            $user = auth()->user();

            // snag the user's CV or set it to null
            $cv = $user->cv ?? null;

            // show the view with the CV data (if any)
            return view('students.CV.createCV', compact('cv'));
        } catch (\Exception $e) {
            // handle unexpected exceptions, log the error, or return an error response
            return view('students.CV.createCV', ['cv' => null]);
        }
    }

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

    // return to the view with the cv
    public function view(Cv $cv)
    {
        try {
            // try to get the cv
            return view('recruiter.applicants.showCV', compact('cv'));
        } catch (\Exception $e) {
            // else return with an error
            return redirect()->back()->with('error', trans('messages.cv.view_error'));
        }
    }

    // delete signed in users cv
    public function delete()
    {
        try {
            // Authenticate user
            $user = auth()->user();
            // Get CV
            $cv = $user->cv;
            // If no CV found, throw error
            if (!$cv) {
                abort(403, trans('messages.cv.delete_not_found'));
            }

            $cv->delete();

            return redirect()->route('createCv')->with('deleteCvSuccess', trans('messages.cv.delete_success'));
        } catch (\Exception $e) {
            // Handle unexpected exceptions, log the error, or return an error response
            return redirect()->back()->with('error', trans('messages.cv.delete_error'));
        }
    }

    // constructor method to apply authentication middleware to the controller
    public function __construct()
    {
        $this->middleware('auth');
    }
}
