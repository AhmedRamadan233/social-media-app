<?php

namespace App\Models;

use App\Models\Scopes\FriendPostsScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
    ];

      // Post belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Post has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
  
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new FriendPostsScope);
    }


}
