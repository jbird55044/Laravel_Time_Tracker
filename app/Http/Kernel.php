<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
   
    /**
     * The application's route middleware.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'admin' => \App\Http\Middleware\AdminMiddleware::class, // Your custom middleware
        'approver' => \App\Http\Middleware\ApproverMiddleware::class, // Your custom middleware
    ];
}
