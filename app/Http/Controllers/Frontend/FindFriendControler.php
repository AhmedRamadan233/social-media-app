<?php

namespace App\Http\Controllers\Frontend;

use App\Events\FriendRequest;
use App\Http\Controllers\Controller;
use App\Models\FriendRequests;
use App\Models\User;
use App\Notifications\FriendRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class FindFriendControler extends Controller
{
    public function index()
    {
        $users = User::with(['profile', 'friendRequestsReceived', 'friendRequestsSent', 'friends'])->get();

        $senderIds = [];
        $receiverIds = [];
        $friendsIds = [];

        foreach ($users as $user) {
            foreach ($user->friendRequestsReceived as $requestReceived) {
                $senderId = $requestReceived->pivot->sender_id;
                $senderIds[] = $senderId;
            }

            foreach ($user->friendRequestsSent as $requestSent) {
                $receiverId = $requestSent->pivot->receiver_id;
                $receiverIds[] = $receiverId;
            }

            foreach ($user->friends as $friend) {
                $friendId = $friend->pivot->friend_id;
                $friendsIds[] = $friendId;
            }
        }

        $excludedIds = array_merge($senderIds, $receiverIds, $friendsIds);

        $users = User::with('profile')
            ->where('id', '<>', Auth::id())
            ->whereNotIn('id', $excludedIds)
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
            $friendRequest = $user->sendFriendRequest($friend);
            $friend->notify(new FriendRequestNotification($friendRequest));
            // dd($friend);
            
            Notification::sendNow($friend, new FriendRequestNotification($friendRequest));
            // event(new FriendRequest($user, $friend));
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
        $requestsToBeFriends = FriendRequests::with('sender')->where('receiver_id', Auth::id())->get();

        return view('dashboard.pages.users.requests-to-be-friend', compact('requestsToBeFriends'));
    }
}
