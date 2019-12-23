@extends('layouts.app', [
    'title' => $spotlights->title.' - results'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'size' => 11,
        'sections' => ['home', 'spotlights results', $spotlights->title],
    ])
        <a href="{{ route('spotlights-results') }}" class="title-section__previous">go to spotlights results listing</a> <br>

        <div class="space-between">
            <div class="title-section__info">Threshold: {{$spotlights->threshold}}</div>
            <div class="title-section__info">Released at {{ substr($spotlights->released_at, 0, -9) }}</div>
        </div>

        <div class="title-section__header">{{$spotlights->title}}</div>
        <div class="space-between">
            <div class="medium-font">{{$spotlights->description}}</div>
            @if($spotlights->threshold)

            @endif
        </div>

        <hr style="border-color: white">

        <div class="mapset-cards">
            @foreach($nominations as $nomination)
                @include('components.mapset-card_compact', [
                    'beatmap_id' => $nomination->beatmap_id,
                    'criticizers' => count($votes->where('nomination_id', $nomination->id)->where('value', '===', -1)),
                    'creator' => $nomination->beatmap_creator,
                    'creator_id' => $nomination->beatmap_creator_osu_id,
                    'metadata' => $nomination->beatmap_artist.' - '.$nomination->beatmap_title,
                    'nominator' => $users->find($nomination->user_id)->username,
                    'nominator_osu_id' => $users->find($nomination->user_id)->osu_user_id,
                    'participants' => count($votes->where('nomination_id', $nomination->id)) + 1,
                    'score' => $nomination->score,
                    'score_color' => $nomination->getScoreColor(),
                    'spotlighted' => $spotlights->threshold ? $nomination->score >= $spotlights->threshold : false,
                    'supporters' => count($votes->where('nomination_id', $nomination->id)->where('value', '===', 1)),
                ])
            @endforeach
        </div>
    @endcomponent
@endsection
