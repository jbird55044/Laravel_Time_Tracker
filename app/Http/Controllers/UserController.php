<?php

/**
 * @return \Illuminate\Http\RedirectResponse
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function update(Request $request) {  //used for non-admin user update
        
        $request->validate([
            'name' => 'required|filled',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
        ]);

        /** @var \App\Models\User $user */     //used to solve IDE issue
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        try {
            $user->save();
        } catch (\Throwable $th) {
            return back()
                ->withErrors(['Settings could not be modified.']);
        }

        return back()
            ->withSuccess('Setting saved successfuly.');
                   
    }

    public function add(Request $request) {    //admin function only

        $request->validate([
            'name' => 'required|filled|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|filled|min:8',
        ]);

        DB::beginTransaction();   //start roll-back point
             
        try {
            // Create and save the user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            // Always create a UserInfo record
            $info = $user->info ?? new UserInfo();
            $info->user_id = $user->id; // Ensure relationship is set
            $info->admin = $request->has('admin'); // Set admin flag based on request
            $info->save();
            
        } catch (\Throwable $th) {
            DB::rollback();     // if error, roll back to start point
            return back()
                ->withErrors(['User or User Admin Flag could not be added']);
        }

        DB::commit();    // commit point

        return redirect('/admin')
            ->withSuccess('User has been added.');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'name' => [
                'required',
                'filled',
                Rule::unique('users', 'name')->ignore($request->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($request->id),
            ],
            'password' => 'nullable|min:8',
        ]);

        $user = User::find($request->id);
        $isAuthenticatedUser = Auth::id() === $user->id;

        // Prevent changes to the authenticated user's own admin status
        if ($isAuthenticatedUser) {
            $request->merge(['admin' => $user->info->admin]);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $info = $user->info;
        $info->admin = $request->has('admin');

        DB::beginTransaction();

        try {
            $user->save();
            $info->save();
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['User could not be modified.']);
        }

        DB::commit();

        return redirect('/admin')->withSuccess('User has been modified.');
    }

    public function delete(Request $request) {   //admin function only
        
        $request->validate([
            'id' => 'required|integer',
        ]);

        if (Auth::id() == $request->id) {
            return back()
                ->withErrors(['You cannot delete the currently authenticated account.']);
        }

        $user = User::find($request->id);

        DB::beginTransaction();   //start roll-back point
        try {
            $user->info->delete();
            $user->delete();
        } catch (\Throwable $th) {
            DB::rollback();     // if error, roll back to start point
            return back()
                -> withErrors(['user could not be deleted, rolling back.']);
        }
        DB::commit();    // commit point
    
        return back()
            ->withSuccess('User have been deleted.');
    }

}
