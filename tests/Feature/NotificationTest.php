<?php

namespace Tests\Feature;

use App\Notifications\FriendRequestNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Messages\MailMessage;
use Mockery;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_toMail_constructs_mail_message_correctly()
    {
        // Mock the notifiable entity
        $notifiable = Mockery::mock();

        // Create a mock friend request string
        $friendRequest = 'John Doe';

        // Create an instance of the notification
        $notification = new FriendRequestNotification($friendRequest);

        // Call the toMail method
        $mailMessage = $notification->toMail($notifiable);

        // Assert that the returned object is an instance of MailMessage
        $this->assertInstanceOf(MailMessage::class, $mailMessage);

        // Assert the message lines are correctly set
        $this->assertEquals('You have received a new friend request from John Doe', $mailMessage->introLines[0]);
        $this->assertEquals('View Friend Request', $mailMessage->actionText);
        $this->assertEquals(url('/friend-requests'), $mailMessage->actionUrl);
        $this->assertEquals('Thank you for using our application!', $mailMessage->outroLines[0]);
    }
}
