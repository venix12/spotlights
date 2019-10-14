@extends('layouts.app', [
    'title' => 'Home'
])

@section('content')
    @component('components.card', [
        'sections' => ['Home']
    ])
        @include('layouts.session')

        <h3>Welcome to the spotlights, {{Auth::user()->username}}</h3>
        there's nothing here at the moment...
    @endcomponent
@endsection
