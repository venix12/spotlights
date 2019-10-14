@extends('layouts.app', [
    'title' => 'Users list'
])

@section('content')
    @component('components.card', [
        'sections' => ['Home', 'Users', 'List']
    ])
        <p><b>Administrators:</b></p>
        <ul>
            @foreach(App\User::MODES as $mode)
                @foreach($leaders->where($mode, true) as $leader)
                        <li><div><a style="color: {{\App\User::GROUP_COLOURS[$leader->group_id]}};" href={{route('user.profile', ['id' => $leader->id])}}>{{$leader->username}}</a> <span class="text-muted">({{App\User::MODES_NAMES[$mode]}})</li>
                @endforeach
                @foreach($admins->where($mode, true) as $admin)
                        <li><a style="color: {{\App\User::GROUP_COLOURS[$admin->group_id]}};" href={{route('user.profile', ['id' => $admin->id])}}>{{$admin->username}}</a> <span class="text-muted">({{App\User::MODES_NAMES[$mode]}})</li>
                @endforeach
            @endforeach
        </ul>
        <p><b>Managers:</b></p>
        <ul>
        @foreach(App\User::MODES as $mode)
            @foreach($managers->where($mode, true) as $manager)
                <li><a style="color: {{\App\User::GROUP_COLOURS[$manager->group_id]}};" href={{route('user.profile', ['id' => $manager->id])}}>{{$manager->username}}</a> <span class="text-muted">({{App\User::MODES_NAMES[$mode]}})</span></li>
            @endforeach
        @endforeach
        </ul>
        <p><b>Members:</b></p>
        <ul>
        @foreach(App\User::MODES as $mode)
            @foreach($members->where($mode, true) as $member)
                <li><a href={{route('user.profile', ['id' => $member->id])}}>{{$member->username}}</a> <span class="text-muted">({{App\User::MODES_NAMES[$mode]}})</span></li>
            @endforeach
        @endforeach
        </ul>
        @if(Auth::user()->isAdmin() || Auth::user()->isManager())
            <hr>
            <p><b>Inactive users:</b></p>
            @foreach($inactives as $inactive)
                <ul class="list-small-distance">
                    <li><a class="text-muted" href={{route('user.profile', ['id' => $inactive->id])}}>{{$inactive->username}}</a></li>
                </ul>
            @endforeach
            <p><b>Users that haven't logged in yet:</b></p>
            @foreach($usersNotLogged as $userNotLogged)
                <ul class="list-small-distance">
                    <li><a style="color: {{\App\User::GROUP_COLOURS[$userNotLogged->group_id]}};" href={{route('user.profile', ['id' => $userNotLogged->id])}}>{{$userNotLogged->username}}</a></li>
                </ul>
            @endforeach
        @endif
    @endcomponent
@endsection
