@extends('layouts.app', [
    'title' => 'Spotlights results'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'size' => 11,
        'sections' => ['Home', 'Spotlights results'],
    ])
        <h1>Spotlights results</h1>

        @foreach($spotlights as $spotlight)
            <div class="spotlights-listing__card spotlights-listing__card--dark">
                <a class="spotlights-listing__header" href="{{ route('spotlights-results.show', [$id = $spotlight->id]) }}" >
                    {{$spotlight->title}}
                </a> <br>
                <div class="space-between">
                    <div class="title-section__info">threshold: {{$spotlight->threshold}}</div>
                    <span class="title-section__info">released at {{ substr($spotlight->released_at, 0, -9) }}</span>
                </div>
            </div>
        @endforeach
    @endcomponent
@endsection
