@extends('layouts.app', [
    'title' => 'Spotlights'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'size' => 12,
        'sections' => ['Home', 'Spotlights']
    ])
        @include('components._header-v2', [
            'icon' => 'star',
            'title' => 'Spotlights',
        ])

        <div class="dark-section dark-section--4 spotlights-listing">
            @foreach($spotlights as $spotlight)
                @include('components._spotlights-panel', [
                    'listing' => 'spotlights',
                    'spotlight' => $spotlight,
                ])
            @endforeach
        </div>
    @endcomponent
@endsection
