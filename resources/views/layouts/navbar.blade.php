<nav class="navbar navbar-dark bg-dark navbar-expand-md shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            osu! Spotlights Team
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href={{route('home')}}>{{ __('Home') }}</a>
                    </li>
                @endauth

                <li class="nav-item">
                    <a class="nav-link" href={{ route('spotlights-results') }}>Spotlights Results</a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href={{route('spotlights')}}>{{ __('Spotlights') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href={{route('user.list')}}>{{ __('Users List') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->username }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href={{route('user.profile', ['id' => Auth::id()])}}>
                                {{ __('User profile') }}
                            </a>
                            @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                                <a class="dropdown-item" href="{{ route('admin.manage') }}">
                                    {{ __('Manage') }}
                                </a>
                            @endif

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
