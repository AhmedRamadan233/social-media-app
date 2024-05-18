<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
}
