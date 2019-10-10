<title>{{$spotlights->title}} | osu! Spotlights Team</title>

@extends('layouts.app')

@section('content')
    @include('layouts.session')

    <h1>{{$spotlights->title}}</h1>
    <div class="medium-font">{{$spotlights->description}}</div>

    <hr>
    @include('spotlights.show.nominate')

    @if(count($nominations) > 0)
        <table class="table table-striped" id="nominationsTable">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Score</th>
                    <th scope="col">Beatmap</th>
                    <th scope="col">Mapper</th>
                    <th scope="col">Nominator</th>
                    <th scope="col">Participants</th>
                    <th scope="col">State</th>
                    @if(Auth::User()->isAdmin())
                        <th scope="col">Actions</th>
                    @endif
                </tr>
            </thead>

            @foreach($nominations as $nomination)

                @php
                    $score = $nomination->score;

                    if($score == 0 || $score < 3)
                    {
                        $scoreColor = "#000000";
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

                    $onclick = 
                        "if(!className.includes('open')) {
                            if(className.includes('closed')) {
                                classList.replace('closed', 'open');  
                            } else {
                                classList.toggle('open');
                            }
                        } else {
                            classList.replace('open', 'closed');
                        }";
                @endphp

                <tbody>
                    <tr>
                        <td>
                            <i id="toggle{{$nomination->id}}" style="font-size: 2rem" data-toggle="collapse" data-target="#details{{$nomination->id}}" class="accordion-toggle fa fa-2x fa-angle-right" onclick="{{$onclick}}"></i>
                        </td>
                        <td class="td-align"><div style="color:{{$scoreColor}}">{{$score}}</div></td>
                        <td class="td-align"><a href= "https://osu.ppy.sh/beatmapsets/{{$nomination->beatmap_id}}">{{$nomination->beatmap_artist}} - {{$nomination->beatmap_title}}</a></td>
                        <td class="td-align"><a href="https://osu.ppy.sh/users/{{$nomination->beatmap_creator_osu_id}}">{{$nomination->beatmap_creator}}</a></td>
                        <td class="td-align">
                            @if($users->find($nomination->user_id)->active)
                                <a href={{route('user.profile', ['id' => $nomination->user_id])}}>{{$users->find($nomination->user_id)->username}}</a>
                            @else
                                <div style="color: #757575;">{{$users->find($nomination->user_id)->username}}</div>
                            @endif
                        </td>
                        <td class="td-align">{{count($votes->where('nomination_id', $nomination->id)->where('value', '!==', null))+1}}</td>
                        <td class="td-align">
                            @if($nomination->user_id == Auth::id())
                                <div class="text-primary">Nominated</div>
                            @elseif(count($votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())) === 0)
                                <div class="text-danger">Awaiting vote</div>
                            @else
                                <div class="text-success">Participated</div>
                            @endif
                        </td>
                        <td class="td-align">
                            @if(Auth::User()->isAdmin())
                                <form action={{route('spotlights.removeNomination')}} method="POST">
                                    @csrf
                                    <input type="hidden" id="nominationID" name="nominationID" value="{{$nomination->id}}">
                                    <input onclick="return confirm('Are you sure you want to remove {{$nomination->beatmap_artist}} - {{$nomination->beatmap_title}}?')" class="btn btn-danger btn-sm" type="submit" value="Remove">
                                </form>
                            @endif
                        </td>
                    </tr>
                    
                    @include('spotlights.show.expandable.main')

                </tbody>
            @endforeach
        </table>
        @if(Auth::user()->isAdmin())
            @include('spotlights.show.mapids')
        @endif
    @else
        Seems like there aren't any nominations for this spotlights...
    @endif
@endsection