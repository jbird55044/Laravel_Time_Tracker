@extends('layouts.default')
@section('title', 'Home')
@section('content') 

<div class="selector-box">
    <h2>Welcome to the time tracker, {{ isset(Auth::user()->name) ? Auth::user()->name : 
        @'Looks like you are not logged in.   Please login. . .'}}</h2>

    @unless (Auth::check())
        <button type="button" onclick="location.href='/login'">LOGIN</button>
    @endunless
</div>

<div class="selector-box">
    <p></p>
    <p>This is a sample time tracking app, with secure login, using hashed passwords
    <p>and authenticated user approvals based on a pivot table which allows for a many</p>
    <p>to many matrix of card approvers.  Yes, it tracks time   :)</p>

    <h3>Tech Stack:</h3>
    <ul>
        <li>Laravel Framework on PHP</li>
        <li>some Vue peppered in there</li>
        <li>PostgreSQL database on the backend</li>
        <li>Basic API calls for pivot table management</li>
    </ul>
</div>
@endsection