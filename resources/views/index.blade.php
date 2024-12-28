@extends('layouts.default')
@section('title', 'Home')
@section('content') 

<p>Welcome to the time tracker, {{ Auth::user()->name }} </p>

<p>Yes, this is indeed an app that tracks time   :)</p>
<p>Aliquip esse voluptate aliquip et ea voluptate do cillum officia elit nostrud culpa tempor duis. Anim consectetur nostrud sunt velit occaecat Lorem aute. Nulla laboris ut commodo commodo.</p>
<p>Lorem est magna quis aliquip sint aliqua irure officia ex fugiat dolore. Dolore eu ut in </p>
@endsection