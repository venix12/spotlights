@extends('layouts.app', [
    'title' => 'Manage users'
])

@section('content')
    @component('components.card', [
        'sections' => ['Home', 'Manage', 'Manage users']
    ])
        @include('layouts.session')
        <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">User ID</th>
                <th scope="col">Usergroup</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href={{route('user.profile', ['id' => $user->id])}}>{{$user->username}}</a></td>
                    <td>{{$user->id}}</td>
                    <td>{{\App\User::GROUPS[$user->group_id]}}</td>
                    <td>
                        <div class="row">
                            @php
                                $activeValue = $user->active ? 'deactivate' : 'activate';
                            @endphp
                            <form action={{route('admin.'.$activeValue.'User')}} method="POST">
                                @csrf
                                <input type="hidden" id="userID" name="userID" value="{{$user->id}}">
                                <input onclick="return confirm('Are you sure you want to {{$activeValue}} {{$user->username}}?')" class="btn btn-dark btn-sm" type="submit" value={{ucfirst($activeValue)}}>
                            </form> &nbsp;&nbsp;
                            @if(Auth::user()->isAdmin())
                                <form action={{route('admin.removeUser')}} method="POST">
                                    @csrf
                                    <input type="hidden" id="userID" name="userID" value="{{$user->id}}">
                                    <input onclick="return confirm('Are you sure you want to remove {{$user->username}}?')" class="btn btn-danger btn-sm" type="submit" value="Remove">
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    @endcomponent
@endsection
