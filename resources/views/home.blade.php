@extends('layouts.app', [
    'title' => 'Home'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home']
    ])

        <h3>Welcome to the spotlights, {{Auth::user()->username}}</h3>
        there's nothing here at the moment...
    @endcomponent
@endsection
