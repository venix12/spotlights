<title>Log | osu! Spotlights Team</title>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home ≫ Manage ≫ Log</div>
                <div class="card-body">
                    <table class="table table-sm" style="overflow: auto;">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">User</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr id={{$event->id}}>
                                    <td class="medium-font">{{$event->created_at}}</td>
                                    <td class="medium-font"><a href={{route('user.profile', ['id' => $event->user_id])}} style="color: {{\App\User::GROUP_COLOURS[$users->find($event->user_id)->group_id]}};">{{$users->find($event->user_id)->username}}</a></td>
                                    <td class="medium-font">{{$event->action}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection