@extends('layouts.app', [
    'title' => $spotlights->title
])

@section('content')
    @component('components.card', [
        'size' => 11,
        'sections' => ['Home', 'Spotlights', $spotlights->title]
    ])

        <h1>{{$spotlights->title}}</h1>
        <div class="medium-font">{{$spotlights->description}}</div>

        <hr>
        @include('spotlights.show.nominate')

        @if(count($nominations) > 0)

            @foreach($nominations as $nomination)

                @php
                    $score = $nomination->score;

                    if($score == 0 || $score < 3)
                    {
                        $scoreColor = "#757575";
                    }

                    if($score < -4)
                    {
                        $scoreColor = "#ff0000";
                    }

                    if($score < 0 && $score > -5)
                    {
                        $scoreColor = "#ff7373";
                    }

                    if($score > 2 && $score < 5)
                    {
                        $scoreColor = "#577557";
                    }

                    if($score > 4)
                    {
                        $scoreColor = "#12b012";
                    }

                    if($nomination->user_id === Auth::id())
                    {
                        $state = 'NOMINATED';
                        $stateColor = "#00b7ff";
                    }

                    else if (count($votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())) > 0)
                    {
                        $state = 'PARTICIPATED';
                        $stateColor = '#12b012';
                    }

                    else
                    {
                        $state = 'AWAITING VOTE';
                        $stateColor = '#ff0000';
                    }
                @endphp

                @include('components.mapset-card', [
                    'beatmap_id' => $nomination->beatmap_id,
                    'creator' => $nomination->beatmap_creator,
                    'creator_id' => $nomination->beatmap_creator_osu_id,
                    'criticizers' => count($votes->where('nomination_id', $nomination->id)->where('value', '===', -1)),
                    'id' => $nomination->id,
                    'metadata' => $nomination->beatmap_artist.' - '.$nomination->beatmap_title,
                    'nominator' => $users->find($nomination->user_id)->username,
                    'nominator_id' => $nomination->user_id,
                    'participants' => count($votes->where('nomination_id', $nomination->id))+1,
                    'score' => $nomination->score,
                    'scoreColor' => $scoreColor,
                    'state' => $state,
                    'stateColor' => $stateColor,
                    'supporters' => count($votes->where('nomination_id', $nomination->id)->where('value', '===', 1)),
                ])

                <br>

                @include('spotlights.show.expandable.main')
                
            @endforeach

            @if(Auth::user()->isAdmin())
                @include('spotlights.show.mapids')
            @endif
        @else
            Seems like there aren't any nominations for this spotlights...
        @endif
    @endcomponent
@endsection
