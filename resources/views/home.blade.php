@extends('layouts.app', [
    'title' => 'Home'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home']
    ])
        <div class="dark-section dark-section--header-section">
            <h3>Welcome to the spotlights, {{Auth::user()->username}}</h3>
            there's nothing here at the moment...
        </div>
    @endcomponent
@endsection
