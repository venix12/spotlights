@extends('layouts.app', [
    'title' => $spotlights->title.' - results'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'size' => 11,
        'sections' => ['home', 'spotlights results', $spotlights->title],
    ])
        @include('components._header', [
            'title' => $spotlights->title,
            'description' => $spotlights->description,
            'modifiers' => [
                'marker',
                'previous' => [
                    'route' => 'spotlights-results',
                    'section' => 'spotlights results listing',
                ],
                'tags' => [
                    "Threshold: {$spotlights->threshold}",
                    'Released at ' . format_date($spotlights->released_at),
                ],
            ]
        ])

        <div class="mapset-cards">
            @foreach($nominations as $nomination)
                @include('components.mapset-card_compact', [
                    'beatmap_id' => $nomination->beatmap_id,
                    'criticizers' => count($nomination->votes->where('value', '===', -1)),
                    'creator' => $nomination->beatmap_creator,
                    'creator_id' => $nomination->beatmap_creator_osu_id,
                    'metadata' => $nomination->getMetadata(),
                    'nominator' => $users->find($nomination->user_id)->username,
                    'nominator_osu_id' => $users->find($nomination->user_id)->osu_user_id,
                    'participants' => count($nomination->votes) + 1,
                    'score' => $nomination->score,
                    'score_color' => $nomination->getScoreColor(),
                    'spotlighted' => $spotlights->threshold ? $nomination->score >= $spotlights->threshold : false,
                    'supporters' => count($nomination->votes->where('value', '===', 1)),
                ])
            @endforeach
        </div>
    @endcomponent
@endsection
