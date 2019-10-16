<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | osu! Spotlights Team</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset ('css/styles.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        function countChars(obj, length) {
            document.getElementById(obj + '-counter').innerHTML = length;
        }

        function openOrClose(id) {
        
            var element = document.getElementById(id);

            if(!element.className.includes('open')) {
                if(element.className.includes('closed')) {
                    element.classList.replace('closed', 'open');  
                } else {
                    element.classList.toggle('open');
                }
            } else {
                element.classList.replace('open', 'closed');
            }
        }

    </script>
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
