<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\JobListing;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    // get user (applicant) messages
    public function index()
    {
        try {
            // get sent/received messages
            $incomingMessages = auth()->user()->receivedMessages()->latest()->paginate(4);
            $outgoingMessages = auth()->user()->sentMessages()->latest()->get();

            // Retrieve the job applications for the authenticated user
            $jobApplications = auth()->user()->jobApplications;

            // Retrieve the recruiter IDs associated with the job applications
            $recruiterIds = $jobApplications->pluck('recruiter_id')->filter()->unique()->values()->all();

            // Retrieve the recruiters based on the IDs
            $recruiters = User::whereIn('id', $recruiterIds)->get();

            return view('students.messages.messagesIndex', compact('incomingMessages', 'outgoingMessages', 'recruiters'));
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('students.messages.messagesIndex')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


    // get recruiter messages
    public function recruiterIndex()
    {
        try {
            // verify that the authenticated user is a recruiter
            if (!auth()->user()->isRecruiter()) {
                // unauthorized access, abort with 403 error
                abort(403, 'unauthorized access.');
            }

            // retrieve paginated messages for the authenticated recruiter
            $incomingMessages = auth()->user()->receivedMessages()->latest()->paginate(4);
            $outgoingMessages = auth()->user()->sentMessages()->latest()->get();

            // retrieve the job listings for the authenticated recruiter
            $jobListings = auth()->user()->jobListings;

            // retrieve the job applications associated with the job listings
            $jobApplications = JobApplication::whereIn('job_listing_id', $jobListings->pluck('id'))->get();

            // retrieve the unique user IDs from the job applications
            $userIds = $jobApplications->pluck('user_id')->unique()->values()->all();

            // retrieve the users (applicants) based on the IDs
            $applicants = User::whereIn('id', $userIds)->get();

            return view('recruiter.messages.messagesIndexRecruiter', compact('incomingMessages', 'outgoingMessages', 'jobListings', 'applicants'));
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->route('recruiter.messages.messagesIndexRecruiter')->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function send(Request $request)
    {
        try {
            // validation
            $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'message' => 'required|string',
            ]);

            // create a new message
            $message = Message::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->input('receiver_id'),
                'message' => $request->input('message'),
            ]);

            // catch errors
            return redirect()->back()->with('success', trans('messages.messages.success'));
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->back()->with('error', trans('messages.messages.error'));
        }
    }

    // mark messages to hide notifications
    public function markAsRead()
    {
        try {
            // mark unread messages as read for the authenticated user
            Auth::user()->receivedMessages()->update(['read' => 1]);
            // redirect back to the messages index or any other route
            return redirect()->route('messages.index')->with('messagesClicked', true);
        } catch (\Exception $e) {
            // handle unexpected exceptions, redirect to an error view or log the error
            return redirect()->back()->with('error', 'Failed to mark messages as read');
        }
    }

    // get the new messages of the signed in (user/recruiter) to show notifications
    public function getNewMessagesCount()
    {
        try {
            // get the count of unread messages for the authenticated user
            $unreadCount = Message::where('receiver_id', auth()->user()->id)
                ->where('read', 0)
                ->count();

            return response()->json(['unreadCount' => $unreadCount]);
        } catch (\Exception $e) {
            // handle unexpected exceptions, return an error response or log the error
            return response()->json(['error' => 'Failed to retrieve new messages count']);
        }
    }

    // soft delete a user selected message (not entirely)
    public function softDestroy($id)
    {
        try {

            $message = Message::findOrFail($id);
            $message->delete();

            return redirect()->back()->with('deleteSuccess', trans('messages.messages.delete_success'));
        } catch (QueryException $e) {
            // handle the query exception
            return redirect()->back()->with('deleteError', trans('messages.messages.delete_error'));
        }
    }

}
