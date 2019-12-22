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
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">

        <style>
            html, body {
                background-color: #fff;
                height: 100vh;
                margin: 0;
                font-family: 'Nunito';
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .osu-button {
                background-color: #ff70b8;
                color: white !important;
            }
        </style>
    </head>
    <body class="d-flex flex-column bg-light">
        @include('layouts.session')
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                        @if (Auth::user()->isAdmin())
                            <a href={{route('admin.manage')}}>Manage</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="container text-center">
                    <h1 class="display-3">osu! Spotlights Team</h1> <br>

                    <div>
                        <a href="https://osu.spotlights.team" class="btn btn-success"><i class="fa fa-user"></i> Apply now!</a><br>
                        <hr>
                        @auth
                            <span class="text-muted">you are already logged in!</span>
                        @else
                            <span class="text-muted" style="font-size: 0.85rem;">or if you are already a member</span> <br>
                            <a href={{route('login')}} class="btn osu-button"><i class="fa fa-sign-in"></i> Login with osu! account</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </body>
</html>
