<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FriendRequests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    
        return response()->json(['new-friend' => $users]);
    }


    public function sendFriendRequest($id)
    {
        $user = User::find(auth()->id());
        $friend = User::findOrFail($id);

        if ($user->id !== $friend->id && !$user->friends()->where('friend_id', $id)->exists()) {
            $user->sendFriendRequest($friend);
            return response()->json('success', 'Friend request sent!');
        }
        return response()->json('Cannot send friend request.');
    }


    public function acceptFriendRequest($id)
    {
        $user = User::find(auth()->id());
        $friend = User::findOrFail($id);
        if ($user->friendRequestsReceived()->where('sender_id', $friend->id)->exists()) {
            $user->acceptFriendRequest($friend);
            return response()->json('success', 'Friend request accepted!');
        }
    
        return response()->json('error', 'Cannot accept friend request.');
    }
    
    
    public function removeFriendRequest($id)
    {
        $user = User::find(auth()->id());
        $requester = User::findOrFail($id);

        if ($user->friendRequestsReceived()->where('sender_id', $requester->id)->exists()) {
            $user->declineFriendRequest($requester);
            return response()->json('success', 'Friend request removed!');
        }

        return response()->json('error', 'Cannot remove friend request.');
    }



    public function allFriend()
    {
        $user = User::find(auth()->id());
        $friends = $user->friends()->with('profile')
            ->where('users.id', '<>', Auth::id()) // Specify the table name for the 'id' column
            ->get();

            return response()->json(["friends"=>$friends]);
    }

    public function requestsToBeFriend()
    {
        $requestsToBeFriends = FriendRequests::with('sender')->where('receiver_id', Auth::id())->get();

        return response()->json(["requestsToBeFriends"=>$requestsToBeFriends]);
    }
}
