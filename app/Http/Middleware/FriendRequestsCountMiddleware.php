<?php

namespace App\Http\Middleware;

use App\Models\FriendRequests;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FriendRequestsCountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Count friend requests to be processed
        $requestsToBeFriends = FriendRequests::with('sender')
            ->where('receiver_id', Auth::id())
            ->get();
        
            $requestsCount =$requestsToBeFriends->count();
        view()->share('requestsCount', $requestsCount);

        return $next($request);
    }
}
