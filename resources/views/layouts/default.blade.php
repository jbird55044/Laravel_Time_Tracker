<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Time Tracker - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>
<body>
    <header> 
        @include('components/nav')
        <h1>Time Tracker - @yield('title') </h1>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        &copy; {{  date('Y')  }} all rights reserved.
    </footer>
   
    
</body>
</html>