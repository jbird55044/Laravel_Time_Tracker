<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ApproverController extends Controller
{
    /**
     * Fetch eligible approvers and currently selected approvers for a user.
     */
    public function eligibleApprovers(Request $request)
    {
        $userId = $request->query('user_id');

        // Fetch the user by ID
        $user = User::find($userId);

        // Logic to fetch eligible approvers (all users except the current user)
        $eligibleApprovers = User::where('id', '!=', $userId)->get();

        // Fetch the currently selected approvers (users who can approve this user)
        $selectedApprovers = $user->approvers; 

        return response()->json([
            'approvers' => $eligibleApprovers,
            'selectedApprovers' => $selectedApprovers
        ]);
    }

    /**
     * Update the approvers for a user.
     * Check for duplicates from both sides of pivot
     */
    public function updateApprovers(Request $request)
{
    $user = User::find($request->user_id);

    // Check for conflicts
    $conflictingIds = array_intersect(
        $user->approvals->pluck('id')->toArray(),
        $request->approvers
    );

    if (!empty($conflictingIds)) {
        return response()->json([
            'error' => 'Conflict detected: A user cannot be both an approver and approved by the same user.'
        ], 400);
    }

    $user->approvers()->sync($request->approvers);

    return response()->json(['message' => 'Approvers updated successfully!']);
}

    /**
     * Fetch users this user can approve and all eligible users.
     */
    public function approvedUsers(Request $request)
    {
        $userId = $request->query('user_id');

        // Fetch the user by ID
        $user = User::find($userId);

        // Fetch all eligible users (all users except the current user)
        $eligibleUsers = User::where('id', '!=', $userId)->get();

        // Fetch the users this user can approve (selected users)
        $selectedApprovedUsers = $user->approvals;

        return response()->json([
            'approvedUsers' => $eligibleUsers,
            'selectedApprovedUsers' => $selectedApprovedUsers
        ]);
    }

    /**
     * Update the users this user can approve.
     */
    public function updateApprovedUsers(Request $request)
    {
        $user = User::find($request->user_id);

        // Check for conflicts
        $conflictingIds = array_intersect(
            $user->approvers->pluck('id')->toArray(),
            $request->approvedUsers
        );

        if (!empty($conflictingIds)) {
            return response()->json([
                'error' => 'Conflict detected: A user cannot be both an approver and approved by the same user.'
            ], 400);
        }

        $user->approvals()->sync($request->approvedUsers);

        return response()->json(['message' => 'Approved users updated successfully!']);
    }
}
