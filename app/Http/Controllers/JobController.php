<?php

namespace App\Http\Controllers;

use App\Models\JobCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    public function add(Request $request) {
        $request->validate([
            'name' => 'required|filled|max:50|unique:job_codes',
            'billing_code' => 'required|filled|max:20|unique:job_codes',
        ]);
        $job = new JobCode();
        // dd($job);

        $job->name = $request->name;
        $job->billing_code = $request->billing_code;

        try {
            $job->save();
        } catch (\Throwable $th) {
            //throw $th;
            return back()
                ->withErrors(['Job code could not be added']);
        }
        return redirect ('/admin')
            ->withSuccess ('Job Code Added');
    }

    public function edit(Request $request) {
        $request->validate([
            'id' => 'required|integer|filled|',
            'name' => [ 
                'required', 
                'filled',
                'max:50',
                Rule::unique('job_codes')->ignore($request->id), //exclude current record from uniqueness 
            ],
                'billing_code' => [
                 'required',
                 'filled',
                 'max:20',
                 Rule::unique('job_codes')->ignore($request->id), //exclude current record from uniqueness 
                ],
        ]);
        
        $job = JobCode::find($request->id);

        $job->name = $request->name;
        $job->billing_code = $request->billing_code;

        try {
            $job->save();
        } catch (\Throwable $th) {
            //throw $th;
            return back()
                ->withErrors(['Job code could not be modified']);
        }

        return redirect ('/admin')
            ->withSuccess ('Job Code modified');
    }
    
    public function delete(Request $request) {
        $request->validate([
            'id' => 'required|integer|filled|',
        ]);
        $job = JobCode::Find($request->id);

        try {
            $job->delete();
        } catch (\Throwable $th) {
            //throw $th;
            return back()
                ->withErrors(['Job code could not be deleted, might be associated to records']);
        }
        return redirect ('/admin')
            ->withSuccess ('Job Code D0eleted');
    }
        
}
