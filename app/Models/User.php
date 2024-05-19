<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens , HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }





    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')
            ->withDefault();
    }




    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }

    public function friendRequestsSent()
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'sender_id', 'receiver_id');
    }

    public function friendRequestsReceived()
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'receiver_id', 'sender_id');
    }

    public function sendFriendRequest(User $user): void
    {
        $this->friendRequestsSent()->attach($user->id);
    }

    public function acceptFriendRequest(User $user): void
    {
        $this->friendRequestsReceived()->detach($user->id);
        $this->friends()->attach($user->id);
        $user->friends()->attach($this->id);
    }

    public function declineFriendRequest(User $user): void
    {
        $this->friendRequestsReceived()->detach($user->id);
    }

    public function removeFriend(User $user): void
    {
        $this->friends()->detach($user->id);
        $user->friends()->detach($this->id);
    }


    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    public function isFriendsWith($userId)
    {
        $currentUserId = Auth::id();

        // Check if there is a mutual friendship
        return Friend::where(function ($query) use ($currentUserId, $userId) {
            $query->where('user_id', $currentUserId)
                  ->where('friend_id', $userId);
        })->orWhere(function ($query) use ($currentUserId, $userId) {
            $query->where('user_id', $userId)
                  ->where('friend_id', $currentUserId);
        })->exists();
    }
}
