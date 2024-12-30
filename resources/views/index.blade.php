@extends('layouts.default')
@section('title', 'Home')
@section('content') 

<p>Welcome to the time tracker, {{ Auth::user()->name }} </p>

<p>Yes, this is indeed an app that tracks time   :)</p>


@endsection