<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.2/trix.css">
    <script>
        window.App = {!!json_encode([
            'csrf_token'=>csrf_token(),
            'user'=> Auth::user(),
            'signedIn'=> Auth::check()
        ]) !!};
    </script>
    <style>
        body {
            padding-bottom: 100px;
        }

        .level {
            display: flex;
            align-items: center;
        }

        .flex {
            flex: 1
        }
        .mr-1{
            margin-right: 1em!important;
        }
        [v-cloak]{
            display: none;
        }
    </style>

    @yield('head')
</head>
<body>
<div id="app">
    @include('layouts.nav')
    <main class="py-4">
        @yield('content')

        <flash message="{{ session('flash') }}"></flash>
    </main>

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
