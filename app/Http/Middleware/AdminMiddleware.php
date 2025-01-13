<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Log user details for debugging  (check:  tail ./storage/logs/laravel.log)
        logger()->info('AdminMiddleware: Checking user', [
            'user_id' => $user->id ?? null,
            'is_admin' => $user->user_infos->admin ?? null
        ]);

        // Check if the user is authenticated and is an admin
        if ($user && $user->user_infos && $user->user_infos->admin) {
            return $next($request); // Allow the request to proceed
        }

        // Redirect if the user is not authorized
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
