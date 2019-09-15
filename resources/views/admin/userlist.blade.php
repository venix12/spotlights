@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registered users list') }}</div>

                <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('error')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
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
                                <td>{{$user->username}}</td>
                                <td>{{$user->id}}</td>
                                <td>{{\App\UserGroup::find($user->group_id)->group_name}}</td>
                                <td>
                                    <div class="row">
                                        <form action={{route('admin.deactivateUser')}} method="POST">
                                            @csrf
                                            <input type="hidden" id="userID" name="userID" value="{{$user->id}}">
                                            <input onclick="return confirm('Are you sure you want to deactivate {{$user->username}}?')" class="btn btn-dark btn-sm" type="submit" value="Deactivate">
                                        </form> &nbsp;&nbsp;
                                        <form action={{route('admin.removeUser')}} method="POST">
                                            @csrf
                                            <input type="hidden" id="userID" name="userID" value="{{$user->id}}">
                                            <input onclick="return confirm('Are you sure you want to remove {{$user->username}}?')" class="btn btn-danger btn-sm" type="submit" value="Remove">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection