@extends('layouts.app', [
    'title' => $user->username."'s profile"
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Users', $user->username],
    ])

        <div class="user-profile__top">
            <img
                src="https://a.ppy.sh/{{$user->osu_user_id}}"
                class="user-profile__avatar {{ $user->color ? 'user-profile__avatar--border' : '' }}"
                style="{{ $user->color ? "border-color: {$user->color}" : ''}}"
            >

            <div class="user-profile__username-section">
                <h4 style="color: {{$user->color}};">{{$user->username}}</h4>
                {{$user->title}}
            </div>
        </div>

        <div class="medium-font row">
            <div class="col-md-8">
                Joined at {{$user->created_at}} // <a href="https://osu.ppy.sh/u/{{$user->osu_user_id}}">osu! Profile</a>
            </div>
        </div>

        <hr>

        <h5>Statistics</h5>
        <div class="card-body bg-dark">
            Nominatinated maps: {{ count($nominations->where('user_id', $user->id)) }} <br>
            Votes casted: {{ count($votes->where('user_id', $user->id)) }}
        </div> <br>

        @if(count($spotlightsParticipated) > 0)
            <h5>Spotlights ({{count($spotlightsParticipated)}})</h5>
            <div class="card-body bg-dark">
                <p class="medium-font">the user participated in following spotlights:</p>

                <ul>
                    @foreach($spotlightsParticipated as $spotlight)
                        <li>{{$spotlight}} <br>
                    @endforeach
                </ul>
            </div>
        @else
            <h5>Spotlights</h5>
            <div class="card-body bg-dark">
                This user hasn't participated in any spotlights yet!
            </div>
        @endif

        @if(Auth::user()->isAdminOrManager())
            <hr>

            @php
                $activeValue = $user->active ? 'deactivate' : 'activate';
            @endphp

            <form action={{route('admin.'.$activeValue.'User')}} method="POST">
                @csrf
                <input type="hidden" id="userID" name="userID" value="{{$user->id}}">
                <input
                    onclick="return confirm('Are you sure you want to {{$activeValue}} {{$user->username}}?')"
                    class="btn btn-dark btn-sm"
                    type="submit"
                    value={{ucfirst($activeValue)}}
                >
            </form><br>

            @if(!$user->has_logged_in)
                <span class="text-muted medium-font">This user hasn't logged in yet!</span>
            @endif
        @endif
    @endcomponent
@endsection
