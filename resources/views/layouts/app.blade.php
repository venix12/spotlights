<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">

    <style>
        .scrollable{
            height: 385px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .card-text{
            white-space: pre-wrap;
        }

        .bg-gray {
            background-color: #39454f;
        }

        .margin-img {
            margin-right: 5px;
        }

        .medium-font {
            font-size: 0.85rem;
        }

        .small-font {
            font-size: 0.6rem;
        }

        .list-small-distance {
            line-height: 0.5em;
        }

        .open {
            transform: rotate(90deg);
            transition: transform 0.2s ease-out;
        }

        .closed {
            transform: rotate(0deg);
            transition: transform 0.2s ease-out;
        }

        .icon-list {
            padding-left: 0.6em;
            font-size: 0.8rem;
        }

        .text-gray {
            color: #757575;
        }

        .td-align {
            vertical-align: inherit !important;
        }

        form {
            margin: 0;
        }

        #app {
        flex: 1 0 auto;
        }

        #footer {
        flex-shrink: none;
        }
    </style>
</head>
<body class="d-flex flex-column">
    <div id="app">
        @include('layouts.navbar')
        
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
    @include('layouts.footer')
@yield('script')
</body>
</html>
