<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', __('app.title'))</title>

        <!-- Styles -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="{{ url('css/app.css') }}" rel='stylesheet' type='text/css'>
        @stack('styles')
    </head>
    <body>
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('products.index') }}">
                        <img src="http://placehold.it/60x20&text=Logo">
                    </a>
                </div>
            </div>
        </nav>
        <div class="container padding-top">
            @yield('body')
        </div>
        <!-- Scripts -->
        <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
        <script src="{{ url('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
