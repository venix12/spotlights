<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | osu! Spotlights Team</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ mix('js/dependencies.js') }}"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/load-awesome@1.1.0/css/ball-clip-rotate.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

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
            <div class="container container-main">
                @yield('content')
            </div>
        </main>
    </div>

    @include('layouts.footer')
    @yield('script')

    <script>
        $(function () {
            $('[title]').tooltip()
        })
    </script>

    <script>
        var authUser = {!! Auth::check() ? json_encode(Auth::user()->authUserResponse()) : '{}' !!}
    </script>
</body>
</html>
