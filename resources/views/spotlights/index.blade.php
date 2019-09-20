@extends('layouts.app')

@section('content')
    <h1>Spotlights</h1>
    @if(count($spotlights) > 0)
        @foreach($spotlights as $spotlight)
            <div class="card bg-light p-3">
                <h3><a href={{route('spotlights.show', ['id' => $spotlight->id])}}>{{$spotlight->title}}</a></h3>
                <small>{{$spotlight->description}}</small>
            </div>
        @endforeach
    @else
        <p>no spotlights found...</p>
    @endif
@endsection