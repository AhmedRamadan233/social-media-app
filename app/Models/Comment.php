<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Comment belongs to a post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Comment has many likes (morph)
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
