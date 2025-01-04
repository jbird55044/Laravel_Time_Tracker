<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApproverController;


Route::get('/approvers/eligible', [ApproverController::class, 'eligibleApprovers']);
Route::post('/approvers/update', [ApproverController::class, 'updateApprovers']);
Route::get('/approvers/approved-users', [ApproverController::class, 'approvedUsers']);
Route::post('/approvers/update-approved-users', [ApproverController::class, 'updateApprovedUsers']);
