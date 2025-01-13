<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApproverMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     public function handle($request, Closure $next)
    {
        /** @var User|null $authUser */
        $authUser = Auth::user(); // Ensure we have a valid User instance

        // Get the target user ID from the query string (matching your URL)
        $targetUserId = $request->query('user') ?? $request->route('id');

        if ($authUser instanceof User && $authUser->isAdmin()) {
            return $next($request); // Admins bypass approval checks, pass GO collect $200
        }
        // Debugging
        //dd($targetUserId);

        // Ensure both the authenticated user and the target user ID exist
        if (!$authUser || !$targetUserId) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        // Check if the authenticated user can approve the target user
        $isAuthorized = $authUser->approvals()
            ->where('users.id', $targetUserId) // Explicit column to avoid ambiguity
            ->exists();

        if ($isAuthorized) {
            return $next($request); // Authorized: proceed to the next middleware/request
        }

        // Unauthorized access: redirect to home
        return redirect()->route('home')->with('error', 'Unauthorized approval access.');
    }
}