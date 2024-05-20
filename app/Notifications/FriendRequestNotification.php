<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $friendRequest;

    public function __construct($friendRequest)
    {
        $this->friendRequest = $friendRequest;
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have received a new friend request from ' . $this->friendRequest)
            ->action('View Friend Request', url('/friend-requests'))
            ->line('Thank you for using our application!');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'sender_id' => "11111111111111111",
            'sender_name' => "111111111111",
            'message' => 'You have received a friend request from ',
        ]);
    }
}
