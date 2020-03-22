@extends('layouts.app', [
    'title' => 'Manage users'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage users']
    ])
        @include('components._header-v2', [
            'icon' => 'user',
            'title' => 'Manage Users',
        ])

        <table class="table table-dark">
            <thead class="thead-light">
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
                        <td>
                            <a href={{route('user.profile', ['id' => $user->id])}} style="color: {{$user->color}}">
                                {{$user->username}}
                            </a>
                        </td>
                        <td>{{$user->id}}</td>
                        <td>{{$user->highestGroup()->identifier ?? ''}}</td>
                        <td>
                            <div class="row">

                                @php
                                    $activeValue = $user->active ? 'deactivate' : 'activate';
                                @endphp

                                <form action={{route("admin.{$activeValue}User")}} method="POST">
                                    @csrf

                                    <input type="hidden" id="userID" name="userID" value="{{$user->id}}">

                                    <button type="submit" class="dark-form__button" onclick="return confirm('Are you sure you want to {{$activeValue}} {{$user->username}}?')">
                                        <i class="fa fa-user"></i> {{ studly_case($activeValue) }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endcomponent
@endsection
