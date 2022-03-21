<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="userID" content="{{ Auth::user()->id}}">
    <meta name="userName" content="{{ Auth::user()->name}}">
    <meta name="userEmail" content="{{ Auth::user()->email}}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
   
    <div id="reserved-area">

    </div>

    @guest
        <script>
            window.loggedIn = false
        </script>
    @else
        <script>
            window.loggedIn = true
        </script>
    @endguest

    <script src="{{asset('js/back.js')}}"></script>

</body>
</html>