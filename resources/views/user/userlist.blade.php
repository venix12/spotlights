<title>Users list | osu! Spotlights Team</title>

@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home ≫ Users ≫ List</div>
                <div class="card-body">
                <p><b>Administrators:</b></p>
                <ul>
                    @foreach(App\User::MODES as $mode)
                        @foreach($leaders->where($mode, 1) as $leader)
                                <li><div><a style="color: {{\App\User::GROUP_COLOURS[$leader->group_id]}};" href={{route('user.profile', ['id' => $leader->id])}}>{{$leader->username}}</a> <span class="text-muted">({{App\User::MODES_NAMES[$mode]}})</li>
                        @endforeach
                        @foreach($admins->where($mode, 1) as $admin)
                                <li><a style="color: {{\App\User::GROUP_COLOURS[$admin->group_id]}};" href={{route('user.profile', ['id' => $admin->id])}}>{{$admin->username}}</a> <span class="text-muted">({{App\User::MODES_NAMES[$mode]}})</li>
                        @endforeach
                    @endforeach
                </ul>
                <p><b>Managers:</b></p>
                <ul>
                @foreach(App\User::MODES as $mode)
                    @foreach($managers->where($mode, 1) as $manager)
                        <li><a style="color: {{\App\User::GROUP_COLOURS[$manager->group_id]}};" href={{route('user.profile', ['id' => $manager->id])}}>{{$manager->username}}</a> <span class="text-muted">({{App\User::MODES_NAMES[$mode]}})</span></li>
                    @endforeach
                @endforeach
                </ul>
                <p><b>Members:</b></p>
                <ul>
                @foreach(App\User::MODES as $mode)
                    @foreach($members->where($mode, 1) as $member)
                        <li><a href={{route('user.profile', ['id' => $member->id])}}>{{$member->username}}</a> <span class="text-muted">({{App\User::MODES_NAMES[$mode]}})</span></li>
                    @endforeach
                @endforeach
                </ul>
                @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                    <hr>
                    <p><b>Inactive users:</b></p>
                    @foreach($inactives as $inactive)
                        <ul>
                            <li><a class="text-muted" href={{route('user.profile', ['id' => $inactive->id])}}>{{$inactive->username}}</a></li>
                        </ul>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection