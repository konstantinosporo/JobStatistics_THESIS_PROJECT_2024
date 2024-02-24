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

    public function index()
    {
        // get sent/received msgs
        $incomingMessages = auth()->user()->receivedMessages()->latest()->paginate(4);

        $outgoingMessages = auth()->user()->sentMessages()->latest()->get();

        // Retrieve the job applications for the authenticated user
        $jobApplications = auth()->user()->jobApplications;

        // Retrieve the recruiter IDs associated with the job applications
        $recruiterIds = $jobApplications->pluck('recruiter_id')->filter()->unique()->values()->all();


        // Retrieve the recruiters based on the IDs
        $recruiters = User::whereIn('id', $recruiterIds)->get();

        return view('students.messages.messagesIndex', compact('incomingMessages', 'outgoingMessages', 'recruiters'));
    }

    // Add this method for recruiters
    public function recruiterIndex()
    {
        // Verify that the authenticated user is a recruiter
        if (!auth()->user()->isRecruiter()) {
            abort(403, 'Unauthorized access.');
        }

        // Retrieve paginated messages for the authenticated recruiter
        $incomingMessages = auth()->user()->receivedMessages()->latest()->paginate(4);

        $outgoingMessages = auth()->user()->sentMessages()->latest()->get();

        // Retrieve the job listings for the authenticated recruiter
        $jobListings = auth()->user()->jobListings;

        // Retrieve the job applications associated with the job listings
        $jobApplications = JobApplication::whereIn('job_listing_id', $jobListings->pluck('id'))->get();

        // Retrieve the unique user IDs from the job applications
        $userIds = $jobApplications->pluck('user_id')->unique()->values()->all();

        // Retrieve the users (applicants) based on the IDs
        $applicants = User::whereIn('id', $userIds)->get();

        return view('recruiter.messages.messagesIndexRecruiter', compact('incomingMessages', 'outgoingMessages', 'jobListings', 'applicants'));
    }



    public function send(Request $request)
    {
        try {
            // validation
            // Create a new message
            $message = Message::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->input('receiver_id'),
                'message' => $request->input('message'),
            ]);

            //catch erros
            return redirect()->back()->with('success', trans('messages.messages.success'));
        } catch (QueryException $e) {
            // handle the query exception
            return redirect()->back()->with('error', trans('messages.messages.error'));
        }
    }

    public function markAsRead()
    {
        // Mark unread messages as read for the authenticated user
        Auth::user()->receivedMessages()->update(['read' => 1]);
        // Redirect back to the messages index or any other route
        return redirect()->route('messages.index')->with('messagesClicked', true);
    }
    public function getNewMessagesCount()
    {
        $unreadCount = Message::where('receiver_id', auth()->user()->id)
            ->where('read', 0)
            ->count();

        return response()->json(['unreadCount' => $unreadCount]);
    }

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
