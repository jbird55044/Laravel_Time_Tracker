<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Api\ApproverController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth'])->group(function() {
    Route::view('/', 'index')->name('home');

    Route::view('/entries', 'entries')->name('entries');

    Route::view('/entry', 'entry')->name('entry');
    Route::post('/entry/add', [EntryController::class, 'add']);
    Route::post('/entry/edit', [EntryController::class, 'edit']);
    Route::get('/entry/delete', [EntryController::class, 'delete']);

    Route::view('/approval', 'approval')->name('approval');

    Route::view('/settings', 'settings')->name('settings');
    Route::post('/settings', [UserController::class, 'update']);
    
    Route::get('/logout', [AuthController::class, 'logout']);
});


Route::middleware(['auth', 'admin'])->group(function() {
    Route::view('/admin', 'admin')->name('admin');
    Route::view('/admin/job', '/admin/job')->name('admin-job');
    Route::post('/admin/job/add', [JobController::class, 'add']);
    Route::post('/admin/job/edit', [JobController::class, 'edit']);
    Route::get('/admin/job/delete', [JobController::class, 'delete']);

    Route::view('/admin/user', '/admin/user')->name('admin-user');
    Route::post('/admin/user/add', [UserController::class, 'add']);
    Route::post('/admin/user/edit', [UserController::class, 'edit']);
    Route::get('/admin/user/delete', [UserController::class, 'delete']);

    Route::view('/admin/approvers', '/admin/approvers')->name('admin-approvers');
    
    Route::view('/admin/entries', '/admin/entries')->name('admin-entries');
    Route::put('/entries/{id}/toggle-approve', [EntryController::class, 'toggleApprove'])->name('entries.toggleApprove');

});


// Route::get('/', function () {
//     return view('index')->name('home');
// });

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginHandler']);

