@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home ≫ Users ≫ List</div>
                <div class="card-body">
                <p><b>Administrators:</b></p>
                <ul>
                    @foreach($leaders as $leader)
                            <li><div style="color: {{\App\User::GROUP_COLOURS[$leader->group_id]}};"><a href={{route('user.profile', ['id' => $leader->id])}}>{{$leader->username}}</div></a>
                    @endforeach
                    @foreach($admins as $admin)
                            <li><div style="color: {{\App\User::GROUP_COLOURS[$admin->group_id]}};"><a href={{route('user.profile', ['id' => $admin->id])}}>{{$admin->username}}</div></a>
                    @endforeach
                </ul>
                <p><b>Managers:</b></p>
                @foreach($managers as $manager)
                    <ul class="list-small-distance">
                        <li><div style="color: {{\App\User::GROUP_COLOURS[$manager->group_id]}};"><a href={{route('user.profile', ['id' => $manager->id])}}>{{$manager->username}}</div></a>
                    </ul>
                @endforeach
                <p><b>Members:</b></p>
                @foreach($members as $member)
                    <ul class="list-small-distance">
                        <li><a href={{route('user.profile', ['id' => $member->id])}}>{{$member->username}}</a>
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection