<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>osu! Spotlights Team</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <style>
            html, body {
                background: #39454f !important;
                color: white;
                margin: 0;
                font-family: 'Nunito';
            }

            .main {
                position: relative;
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .links > a {
                color: #99c9f0;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
            }
        </style>
    </head>

    <body class="d-flex flex-column">
        @include('layouts.session')

        <div class="main">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        @foreach (navbar_welcome_sections() as $section => $route)
                            <a href="{{ route($route) }}">{{ $section }}</a>
                        @endforeach
                    @endauth
                </div>
            @endif

            <h1 class="display-3">osu! Spotlights Team</h1> <br>

            <div>
                @auth
                    <a href="{{ route('app-form') }}" class="dark-form__button">
                        <i class="fa fa-user"></i> Apply now!
                    </a>
                @else
                    <span class="text-lightgray">to access public parts of the website, such as application form or spotlights results, log in below!</span>
                @endauth

                <hr>

                @auth
                    <span class="text-lightgray">you are already logged in!</span>
                @else
                    <a href={{ route('login') }} class="dark-form__button">
                        <i class="fa fa-sign-in"></i> Login with osu! account
                    </a>
                @endauth
            </div>
        </div>

        @include('layouts.footer')
    </body>
</html>
