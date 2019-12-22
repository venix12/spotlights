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
                    'participants' => count($votes->where('nomination_id', $nomination->id)) + 1,
                    'score' => $nomination->score,
                    'scoreColor' => $nomination->getScoreColor(),
                    'spotlighted' => $spotlights->threshold ? $nomination->score >= $spotlights->threshold : false,
                    'state' => $state,
                    'stateColor' => $stateColor,
                    'supporters' => count($votes->where('nomination_id', $nomination->id)->where('value', '===', 1)),
                ])

                <br>

                @include('spotlights.show.expandable.main')

            @endforeach

            @if(Auth::user()->isAdmin())
                @include('spotlights.show.mapids')
                @include('spotlights.show.threshold')
            @endif

        @else
            Seems like there aren't any nominations for this spotlights...
        @endif

        @if(Auth::user()->isAdmin() || Auth::user()->isManager())
            @foreach ($users->where($spotlights->gamemode(), true) as $user)
                {{ $user->username }}: {{ count($votes->where('spots_id', $spotlights->id)->where('user_id', $user->id)) }} / {{ count($nominations) }} <br>
            @endforeach
        @endif

    @endcomponent
@endsection
