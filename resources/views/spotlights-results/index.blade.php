@extends('layouts.app', [
    'title' => 'Spotlights results'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'size' => 11,
        'sections' => ['Home', 'Spotlights results'],
    ])
        @include('components._header-v2', [
            'icon' => 'star',
            'title' => 'Spotlights Results',
        ])

        <div class="dark-section dark-section--4 spotlights-listing">
            @foreach($spotlights as $spotlight)
                @include('components._spotlights-panel', [
                    'listing' => 'results',
                    'spotlight' => $spotlight,
                ])
            @endforeach
        </div>
    @endcomponent
@endsection
