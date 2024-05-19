<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FriendRequests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FindFriendControler extends Controller
{
    public function index()
    {
        
        $users = User::with('profile')
            ->where('id', '<>', Auth::id())
            // ->inRandomOrder()
            // ->take(8)
            ->get();

        return view('dashboard.pages.users.index', compact('users'));
    }


    public function sendFriendRequest($id)
    {
        $user = User::find(auth()->id());
        $friend = User::findOrFail($id);

        if ($user->id !== $friend->id && !$user->friends()->where('friend_id', $id)->exists()) {
            $user->sendFriendRequest($friend);
            return redirect()->back()->with('success', 'Friend request sent!');
        }

        return redirect()->back()->with('error', 'Cannot send friend request.');
    }


    public function acceptFriendRequest($id)
    {
        $user = User::find(auth()->id());
        $friend = User::findOrFail($id);

        if ($user->friendRequestsReceived()->where('sender_id', $friend->id)->exists()) {
            $user->acceptFriendRequest($friend);
            return redirect()->back()->with('success', 'Friend request accepted!');
        }

        return redirect()->back()->with('error', 'Cannot accept friend request.');
    }



    public function removeFriendRequest($id)
    {
        $user = User::find(auth()->id());
        $requester = User::findOrFail($id);

        if ($user->friendRequestsReceived()->where('sender_id', $requester->id)->exists()) {
            $user->declineFriendRequest($requester);
            return redirect()->back()->with('success', 'Friend request removed!');
        }

        return redirect()->back()->with('error', 'Cannot remove friend request.');
    }



    public function allFriend()
    {
        $user = User::find(auth()->id());
        $friends = $user->friends()->with('profile')
            ->where('users.id', '<>', Auth::id()) // Specify the table name for the 'id' column
            ->get();

        return view('dashboard.pages.users.all-my-friend', compact('friends'));
    }

    public function requestsToBeFriend()
    {
        // Fetch friend requests along with the sender's information
        $requestsToBeFriends = FriendRequests::with('sender')
            ->where('receiver_id', Auth::id())
            ->get();
        return view('dashboard.pages.users.requests-to-be-friend', compact('requestsToBeFriends'));
    }
}
