<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Entry;

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

        // Get the target user ID from the query string or the route
        $targetUserId = $request->query('user');
        $entryId = $request->route('id'); // This is the entry ID from the form action

        // Allow admins to bypass approval checks
        if ($authUser instanceof User && $authUser->isAdmin()) {
            return $next($request); // Admins are always authorized
        }

        // Debugging: Check which parameters are being passed
        // \Log::info('Middleware Check', [
        //     'authUserId' => $authUser->id ?? null,
        //     'targetUserId' => $targetUserId,
        //     'entryId' => $entryId,
        // ]);

        // Note, logic is a tad complex as this middleware is used for both page protection
        // as well as row protection, thus needs to determine what is being passed.  If row, 
        // then needs to determine if user is authorized to approve that person's time entry.


        // If the target user ID is provided, check authorization directly
        if ($targetUserId) {
            $isAuthorized = $authUser->approvals()
                ->where('users.id', $targetUserId) // Explicit column to avoid ambiguity
                ->exists();

            if ($isAuthorized) {
                return $next($request); // Authorized: proceed
            }
        }

        // If the entry ID is provided, find the owner of the entry and check authorization
        if ($entryId) {
            $entry = \App\Models\Entry::find($entryId); // Fetch the entry

            if ($entry && $authUser->approvals()
                ->where('users.id', $entry->user_id) // Check approval access for the entry's owner
                ->exists()) {
                return $next($request); // Authorized: proceed
            }
        }

        // Unauthorized access: redirect to home
        return redirect()->route('home')->with('error', 'Unauthorized approval access.');
    }
}