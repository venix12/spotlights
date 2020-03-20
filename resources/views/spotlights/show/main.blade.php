@extends('layouts.app', [
    'title' => $spotlights->title
])

@php
    $d = 0;

    foreach ($spotlights->nominations as $nomination)
    {
        $d += count($nomination->votes);
    }

    $stats = [
        ['name' => 'deadline', 'value' => format_date($spotlights->deadline)],
        ['name' => 'nominations', 'value' => count($spotlights->nominations)],
        ['name' => 'votes casted', 'value' => $d],
        ['name' => 'your activity', 'value' => Auth::user()->spotlightsActivity($spotlights->id) . ' / ' . count($spotlights->nominations)],
    ];

    if ($spotlights->threshold !== null) {
        $stats[] = ['name' => 'threshold', 'value' => $spotlights->threshold];
    }
@endphp

@section('content')
    @component('components.card', [
        'dark' => true,
        'size' => 11,
        'sections' => ['Home', 'Spotlights', $spotlights->title],
    ])
        @include('components._header-v2', [
            'colour' => $spotlights->active ? 'green' : 'red',
            'description' => $spotlights->description,
            'icon' => 'star',
            'title' => $spotlights->title,
        ])

        <div id="react--spotlights-main"></div>

        @if (Auth::user()->isAdmin())
            @include('spotlights.show.mapids')
            @include('spotlights.show.threshold')
        @endif

        @if (Auth::user()->isAdminOrManager())
            <h5>Activity</h5>
            <div class="card-body bg-dark">
                @foreach (App\Group::byIdentifier('member')->members->where($spotlights->gamemode(), true) as $user)
                    {{ $user->username }}: {{ $user->spotlightsActivity($spotlights->id) }} / {{ count($spotlights->nominations) }} <br>
                @endforeach
            </div>
        @endif
    @endcomponent
@endsection

@section('script')
    <script id="json-spotlights">
        {!! json_encode($spotlightsCollection) !!}
    </script>

    <script id="json-statistics">
        {!!
            json_encode($stats);
        !!}
    </script>
@endsection
