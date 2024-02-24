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
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email', //unique email
            'password' => 'required|min:5|confirmed',
            'role' => 'nullable|in:admin,recruiter,user', // user roles
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password); // hash the password
            $user->role = $request->input('role', 'user');

            $user->save();

            return redirect()->route('signIn')->with('success', 'User created successfully');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1062) { // MySQL error code for duplicate entry
                return redirect()->back()->with('warning', 'Email address already exists. Please choose a different one.');
            } else { // other exceptions
                return redirect()->back()->with('error', 'Error creating user');
            }
        }
    }

    public function signInUser(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // successfull auth
            $user = Auth::user();
            return $this->redirectToRoleSpecificPage($user);
        } else {
            // e-mail exists, but password is incorrect
            throw ValidationException::withMessages(['password' => 'Incorrect password. Please try again.']);
        }
    }

    private function redirectToRoleSpecificPage($user)
    {
        switch ($user->role) { // user type authentication
            case 'admin':
                return redirect()->route('signedInAdmin', ['user' => $user->name]);
            case 'recruiter':
                return redirect()->route('signedInRecruiter', ['user' => $user->name]);
            case 'user':
                return redirect()->route('indexStudent', ['user' => $user->name]);
            default:
                // handle unexpected roles exception
                return redirect()->route('index');
        }
    }

    public function signOutUser()
    {
        Auth::logout(); // authenticate usert before sign out 
        return redirect()->route('index')->with('success', 'Successfully logged out');
    }
}
