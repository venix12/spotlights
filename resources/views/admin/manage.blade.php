@extends('layouts.app', [
    'title' => 'Manage'
])

@section('content')
    @component('components.card', [
        'sections' => ['Home', 'Manage']
    ])
        @if(Auth::user()->isAdmin())
            <label class="col-form-label text-md-right"><a href="{{route('register')}}">Add user</a></label> <br />
            <label class="col-form-label text-md-right"><a href="{{route('admin.newSpotlights')}}">Create new spotlights</a></label> <br />
            <label class="col-form-label text-md-right"><a href="{{route('admin.resetpassword')}}">Reset password</a></label> <br />
            <label class="col-form-label text-md-right"><a href="{{route('admin.app')}}">Manage Applications Form</a></label> <br />
        @endif
        <label class="col-form-label text-md-right"><a href="{{route('admin.spotlist')}}">Manage spotlights</a></label> <br />
        <label class="col-form-label text-md-right"><a href="{{route('admin.userlist')}}">Registered Users</a></label> <br />
        <label class="col-form-label text-md-right"><a href="{{route('admin.log')}}">Log</a></label>
    @endcomponent
@endsection
