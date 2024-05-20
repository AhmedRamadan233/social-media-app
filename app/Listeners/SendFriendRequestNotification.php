<?php

namespace App\Listeners;

use App\Events\FriendRequest;
use App\Notifications\FriendRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFriendRequestNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FriendRequest $event)
    {
        $event->receiver->notify(new FriendRequestNotification($event->sender));
    }
}
