@extends('layouts.app', [
    'title' => "{$user->username}'s profile"
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Users', $user->username],
    ])
        <div class="dark-section dark-section--5">
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

            <div class="user-profile__info-container">
                <div class="user-profile__info user-profile__info--join" title="{{ $user->created_at }}">
                    Joined {{ $user->created_at->diffForHumans() }}
                </div>

                <div class="user-profile__info user-profile__info--osu">
                    <a href="https://osu.ppy.sh/u/{{ $user->osu_user_id }}">osu! Profile</a>
                </div>
            </div>
        </div>

        <div class="dark-section dark-section--4">
            <div class="info-panel">
                <div class="info-panel__header">Statistics</div>
                Nominatinated maps: {{ count($nominations->where('user_id', $user->id)) }} <br>
                Votes casted: {{ count($votes->where('user_id', $user->id)) }}
            </div>

            @if (count($spotlightsParticipated) > 0)
                <div class="info-panel">
                    <div class="info-panel__header">Spotlights ({{ count($spotlightsParticipated) }})</div>

                    <ul class="list">
                        @foreach($spotlightsParticipated as $spotlight)
                            <li>
                                <a href="{{ route('spotlights.show', $spotlight->id) }}">
                                    {{ $spotlight->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="info-panel">
                    <div class="info-panel__header">Spotlights</div>
                    This user hasn't participated in any spotlights yet!
                </div>
            @endif
        </div>

        <div class="dark-section dark-section--4">
            @if (Auth::user()->isAdminOrManager())
                @php
                    $activeValue = $user->active ? 'deactivate' : 'activate';
                @endphp

                <form action={{ route('admin.'.$activeValue.'User') }} method="POST">
                    @csrf
                    <input type="hidden" id="userID" name="userID" value="{{$user->id}}">
                    <input
                        onclick="return confirm('Are you sure you want to {{$activeValue}} {{$user->username}}?')"
                        class="btn btn-dark btn-sm"
                        type="submit"
                        value={{ucfirst($activeValue)}}
                        style="margin-bottom: 5px"
                    >
                </form>

                @if(!$user->has_logged_in)
                    <span class="text-lightgray medium-font">This user hasn't logged in yet!</span>
                @endif
            @endif

            @if (Auth::user()->isAdmin() && $user->groups->count() > 0)
                <div class="medium-font">
                    this user belongs to usergroups: <br>
                    @foreach ($user->groups as $group)
                        - <a href="{{ route('admin.user-groups.show', $group->id)}}">{{ $group->identifier }}</a><br>
                    @endforeach
                </div>
            @endif
        </div>
    @endcomponent
@endsection
