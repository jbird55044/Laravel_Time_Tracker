<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User\isAdmin;

class AdminMiddleware

{
    public function handle($request, Closure $next)
    {        
        //dd(Auth::user());   //troubleshooting syntax
        
        // $user = Auth::user()->load('user_infos');  //Eager Load the Relationship  
        // if ($user && $user->isAdmin()) {           //isAdmin not visable in his middleware
        //     return $next($request);
        // }

        // Ensure the user is logged in and is an admin
        if (Auth::check() && Auth::user()->user_infos->admin) {
            return $next($request);
        }

        // Redirect or return error if not admin
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
