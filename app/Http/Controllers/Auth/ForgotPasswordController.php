<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
    }

    $token = Password::createToken($user);

    try {
        $user->notify(new PasswordResetNotification($token));
        return back()->with(['status' => __('A password reset link has been sent to your email address.')]);
    } catch (\Exception $e) {
       dd( $e->getMessage());
        return back()->withErrors(['email' => __('There was an error sending the password reset email. Please try again later.')]);
    }
}

}
