<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class FriendPostsScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
    {
        $currentUserId = Auth::id();

        // Apply a query to fetch posts of the authenticated user or their friends
        $builder->where(function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId)
                  ->orWhereHas('user', function ($query) use ($currentUserId) {
                      $query->whereHas('friends', function ($query) use ($currentUserId) {
                          $query->where(function ($query) use ($currentUserId) {
                              $query->where('user_id', $currentUserId)
                                    ->orWhere('friend_id', $currentUserId);
                          });
                      });
                  });
        });
    }
}
