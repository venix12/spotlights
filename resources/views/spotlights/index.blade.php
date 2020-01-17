@extends('layouts.app', [
    'title' => 'Spotlights'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'size' => 12,
        'sections' => ['Home', 'Spotlights']
    ])
        <h1>Spotlights</h1>
        @if(count($spotlights) > 0)
            @foreach($spotlights as $spotlight)
                <div class="card bg-dark">
                    <div class="card-body">
                        <h3>
                            <a href="{{ route('spotlights.show', ['id' => $spotlight->id]) }}">
                                {{ $spotlight->title }}
                            </a>
                        </h3>

                        <div class="medium-font">{{ $spotlight->description }}</div>

                        <div class="space-between">
                            <div class="title-section__info">
                                Deadline: {{ format_date($spotlight->deadline) }}
                                ({{ $spotlight->deadline > now() ? '' : '-' . now()->diffInDays($spotlight->deadline) }} days remaining)
                            </div>

                            <div class="title-section__info">Created on {{ format_date($spotlight->created_at) }}</div>
                        </div>
                    </div>
                </div>

                <br />
            @endforeach
        @endif
    @endcomponent
@endsection
