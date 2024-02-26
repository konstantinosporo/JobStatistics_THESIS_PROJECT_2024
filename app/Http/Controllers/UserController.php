<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // create a new user
    public function createUser(Request $request)
    {
        // validate user creation request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email', // unique email
            'password' => 'required|min:5|confirmed',
            'role' => 'nullable|in:admin,recruiter,user', // user roles
        ]);

        try {
            // create a new user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password); // hash the password
            $user->role = $request->input('role', 'user');

            $user->save();

            // redirect to sign-in with success message
            return redirect()->route('signIn')->with('success', 'User created successfully');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1062) { // MySQL error code for duplicate entry
                // redirect back with a warning message
                return redirect()->back()->with('warning', 'Email address already exists. Please choose a different one.');
            } else {
                // handle other exceptions, redirect back with an error message
                return redirect()->back()->with('error', 'Error creating user');
            }
        }
    }

    // sign in user
    public function signInUser(Request $request)
    {
        try {
            // validate user sign-in request
            $request->validate([
                'email' => 'required|exists:users,email',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // successful authentication
                $user = Auth::user();
                return $this->redirectToRoleSpecificPage($user);
            } else {
                // email exists, but password is incorrect
                throw ValidationException::withMessages(['password' => 'Incorrect password. Please try again.']);
            }
        } catch (\Exception $e) {
            // handle other exceptions, redirect back with an error message
            return redirect()->back()->with('error', 'Error signing in. Please try again.');
        }
    }

    // after authentication, redirect depending on the user type
    private function redirectToRoleSpecificPage($user)
    {
        try {
            // perform role-specific redirection based on the user's role
            switch ($user->role) {
                case 'admin':
                    // redirect to the signed-in admin page
                    return redirect()->route('signedInAdmin', ['user' => $user->name]);

                case 'recruiter':
                    // redirect to the signed-in recruiter page
                    return redirect()->route('signedInRecruiter', ['user' => $user->name]);

                case 'user':
                    // redirect to the index student page
                    return redirect()->route('indexStudent', ['user' => $user->name]);

                default:
                    // handle unexpected roles by redirecting to the default index page
                    return redirect()->route('index');
            }
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('login')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


    // sign out Auth user
    public function signOutUser()
    {
        Auth::logout(); // log out the authenticated user
        return redirect()->route('index')->with('success', 'Successfully logged out');
    }

}
