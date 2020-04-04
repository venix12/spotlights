@extends('layouts.app', [
    'title' => $spotlights->title.' - results'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'size' => 11,
        'sections' => ['home', 'spotlights results', $spotlights->title],
    ])
        @include('components._header-v2', [
            'description' => $spotlights->description,
            'icon' => 'star',
            'title' => "{$spotlights->title}: results",
        ])

        <div class="dark-section dark-section--4 mapset-cards">
            @foreach($nominations as $nomination)
                @include('spotlights-results._card', $nomination)
            @endforeach
        </div>
    @endcomponent
@endsection
