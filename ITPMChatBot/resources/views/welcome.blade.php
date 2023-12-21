<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col md-12" style="padding: 15px; text-align: right;">
                <a class="btn btn-light btn-lg" href="{{ route('/') }}">Home</a>
                <a class="btn btn-light btn-lg" href="{{ route('aboutus') }}">About Us</a>
            </div>
            <div class="col-md-12" style="text-align: center;">
                <img src="{{asset('images')}}/chatbot.png" alt="" class="img-fluid" width="200" style="margin-left: auto; margin-right: auto;">
                <p style="font-size: 50px;">Welcome to ChatterBot</p>
            </div>
            <div class="col md-12" style="padding: 15px; text-align: center;">
                @if (Route::has('login'))
                    <a class="btn btn-success btn-lg" href="{{ route('login') }}" style="margin-right: 5%;">Log In</a>
                @endif
                @if (Route::has('register'))
                    <a class="btn btn-primary btn-lg" href="{{ route('register') }}">Sign Up</a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
