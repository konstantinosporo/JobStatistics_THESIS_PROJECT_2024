<?php

namespace App\Http\Controllers;

use App\Models\UserPreferences;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserPreferencesController extends Controller
{

    // store new user preferences
    public function store(Request $request)
    {
        try {
            // validate the fillable data
            $validatedData = $request->validate([
                'job_category_id' => 'nullable|exists:job_categories,id',
                'location' => 'nullable|string',
                'job_title' => 'nullable|string',
            ]);

            // auth and save the new preferences
            auth()->user()->userPreferences()->create($validatedData);


            return redirect()->route('indexStudent')->with('createSuccess', trans('messages.messages.preferences_saved_successfully'));
        } catch (QueryException $e) {
            // Handle the error (e.g., log it)
            \Log::error('Error creating user preferences: ' . $e->getMessage());

            return redirect()->route('indexStudent')->with('createError', trans('messages.messages.error_creating_user_preferences'));
        }
    }

    // show editing form for userPreferences (if preferences exist)
    public function edit()
    {
        try {
            $user = auth()->user();

            $userPreferences = $user->userPreferences ?? null;
            return view('students.includes.partials.userPreferences', compact('userPreferences'));
        } catch (\Exception $e) {
            return view('students.includes.partials.userPreferences', ['userPreferences' => null]);

        }
    }

    // update existing userPreferences
    public function update(Request $request)
    {
        $user = auth()->user();

        $userPreferences = $user->userPreferences;

        //dd($request->input('job_category_id'));

        $validatedData = $request->validate([
            'job_category_id' => 'nullable|exists:job_categories,id',
            'location' => 'nullable|string',
            'job_title' => 'nullable|string',
        ]);

        $userPreferences->fill($validatedData);

        if ($userPreferences->save()) {
            return redirect()->route('indexStudent')->with('updateSuccess', trans('messages.messages.preferences_updated_successfully'));
        } else {
            return redirect()->route('indexStudent')->with('updateError', trans('messages.messages.error_updating_user_preferences'));
        }
    }

    public function delete()
    {
        try {
            // authenticate user
            $user = auth()->user();
            // get userPreferences
            $userPreferences = $user->userPreferences;
            // If no CV found, throw error
            if (!$userPreferences) {
                abort(403, trans('messages.cv.delete_not_found'));
            }

            $userPreferences->delete();

            return redirect()->route('indexStudent')->with('deleteSuccess', trans('messages.messages.success_deleting_user_preferences'));
        } catch (\Exception $e) {
            // Handle unexpected exceptions, log the error, or return an error response
            return redirect()->back()->with('deleteError', trans('messages.messages.error_deleting_user_preferences'));
        }
    }


}

