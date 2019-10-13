@extends('layouts.app', [
    'title' => 'Manage'
])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home ≫ Manage</div>
                <div class="card-body">
                    @if(Auth::user()->isAdmin())
                        <label class="col-form-label text-md-right"><a href="{{route('register')}}">Add user</a></label> <br />
                        <label class="col-form-label text-md-right"><a href="{{route('admin.newSpotlights')}}">Create new spotlights</a></label> <br />
                        <label class="col-form-label text-md-right"><a href="{{route('admin.resetpassword')}}">Reset password</a></label> <br />
                    @endif
                    <label class="col-form-label text-md-right"><a href="{{route('admin.spotlist')}}">Manage spotlights</a></label> <br />
                    <label class="col-form-label text-md-right"><a href="{{route('admin.userlist')}}">Registered Users</a></label> <br />
                    <label class="col-form-label text-md-right"><a href="{{route('admin.log')}}">Log</a></label>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
