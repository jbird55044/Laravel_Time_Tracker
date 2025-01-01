<?php

// /app/Http/Controllers/Api/ApproverController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ApproverController extends Controller
{
    public function eligibleApprovers(Request $request)
    {
        $userId = $request->query('user_id');

        // Fetch the user by ID
        $user = User::find($userId);

        // Logic to fetch eligible approvers (all users except the current user)
        $eligibleApprovers = User::where('id', '!=', $userId)->get();

        // Fetch the currently selected approvers (assuming you have a relationship setup for this)
        $selectedApprovers = $user->approvers; // This now uses the new 'approver_user' pivot table

        return response()->json([
            'approvers' => $eligibleApprovers,        // List of all eligible approvers
            'selectedApprovers' => $selectedApprovers // List of currently selected approvers for the user
        ]);
    }

    public function updateApprovers(Request $request)
    {
        // Find the user by user_id
        $user = User::find($request->user_id);

        // Sync the approvers with the selected approvers (assuming you use a pivot table)
        $user->approvers()->sync($request->approvers);

        return response()->json(['message' => 'Approvers updated successfully!']);
    }
}
