<title>Spotlights | osu! Spotlights Team</title>

@extends('layouts.app')

@section('content')
    <h1>Spotlights</h1>
    @if(count($spotlights) > 0)
        @foreach($spotlights as $spotlight)
            <div class="card bg-light">
                <div class="card-body">
                    <h3><a href={{route('spotlights.show', ['id' => $spotlight->id])}}>{{$spotlight->title}}</a></h3>
                    <div class="medium-font float-left">{{$spotlight->description}}</div>
                    @if($spotlight->deadline != '')
                        <br />
                        <div class="medium-font float-left" style="color: #757575;">Deadline: {{substr($spotlight->deadline, 0, -9)}} ({{now()->diffInDays($spotlight->deadline)}} days remaining)</div>
                    @endif
                    <div class="medium-font float-right" style="color: #757575;">Created on {{$spotlight->created_at}}</div>
                </div>
            </div><br />
        @endforeach
    @else
        <p>no spotlights found...</p>
    @endif
@endsection