<title>{{$spotlights->title}} | osu! Spotlights Team</title>

@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{session('error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <h1>{{$spotlights->title}}</h1>
    <div class="medium-font">{{$spotlights->description}}</div>
    <hr>
    @if($spotlights->active == 1)
        <form method="POST" action={{route('spotlights.nominate', ['id' => $spotlights->id])}}>
            @csrf
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="beatmap_id" class="col-form-label text-md-right">Beatmapset ID</label>

                    <div class="col-md-4">
                        <input id="beatmap_id" type="text" class="form-control" name="beatmap_id" required>
                        
                    </div>
                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-primary">
                            {{ __('Nominate!') }}
                    </button>
                </div>
            </div>
        </form> 
    @else
        <p>The nominating stage for this spotlights has already ended!</p>
    @endif

    @if(count($nominations->where('spots_id', $spotlights->id)) > 0)
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
            @foreach($nominations->where('spots_id', $spotlights->id) as $nomination)
                @if(count($nominations) > 0 && $spotlights->id == $nomination->spots_id)
                    <tbody>
                        <tr>
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
                            <td>
                                <input id="toggleId" type="hidden" value={{$nomination->id}}>
                                <i id="toggle{{$nomination->id}}" style="font-size: 2rem" data-toggle="collapse" data-target="#details{{$nomination->id}}" class="accordion-toggle fa fa-2x fa-angle-right" onclick="{{$onclick}}"></i>
                            </td>
                            <td style="vertical-align: inherit"><div style="color:{{$scoreColor}}">{{$score}}</div></td>
                            <td style="vertical-align: inherit"><a href= "https://osu.ppy.sh/beatmapsets/{{$nomination->beatmap_id}}">{{$nomination->beatmap_artist}} - {{$nomination->beatmap_title}}</a></td>
                            <td style="vertical-align: inherit"><a href="https://osu.ppy.sh/users/{{$nomination->beatmap_creator_osu_id}}">{{$nomination->beatmap_creator}}</a></td>
                            <td style="vertical-align: inherit">
                                @if(\App\User::find($nomination->user_id)->active == 1)
                                    <a href={{route('user.profile', ['id' => $nomination->user_id])}}>{{\App\User::find($nomination->user_id)->username}}</a>
                                @else
                                    <div style="color: #757575;">{{\App\User::find($nomination->user_id)->username}}</div>
                                @endif
                            </td>
                            <td style="vertical-align: inherit">{{count($votes->where('nomination_id', $nomination->id))+1}}</td>
                            <td style="vertical-align: inherit">
                                @if($nomination->user_id == Auth::id())
                                    <div style="color: #03bafc">Nominated</div>
                                @elseif(count($votes->where('user_id', Auth::id())->where('nomination_id', $nomination->id)) == 0)
                                    <div style="color: #ff0000">Awaiting vote</div>
                                @else
                                    <div style="color: #12b012">Participated</div>
                                @endif
                            </td>
                            <td style="vertical-align: inherit">
                                @if(Auth::User()->isAdmin())
                                    <form action={{route('spotlights.removeNomination')}} method="POST">
                                        @csrf
                                        <input type="hidden" id="nominationID" name="nominationID" value="{{$nomination->id}}">
                                        <input onclick="return confirm('Are you sure you want to remove {{$nomination->beatmap_artist}} - {{$nomination->beatmap_title}}?')" class="btn btn-danger btn-sm" type="submit" value="Remove">
                                    </form>
                                @endif
                            </td>
                        <tr>
                            <td colspan="6" class="hiddenRow"><div id="details{{$nomination->id}}" class="accordian-body collapse">
                                <div class="modal-body row">
                                    <div class="col-md-6">
                                        @if($nomination->user_id != Auth::id())
                                            @if(count($votes->where('user_id', Auth::id())->where('nomination_id', $nomination->id)) == 0)
                                                <form action={{route('spotlights.vote')}} method="POST">
                                                    @csrf
                                                    <label for="commentField">Put your comment here!</label>
                                                    <textarea class="form-control" id="commentField" name="commentField" rows="4"></textarea> <br />
                                            @else
                                                <form action={{route('spotlights.updateVote')}} method="POST">
                                                    @csrf
                                                    <label for="commentField">Put your comment here!</label>
                                                    <textarea class="form-control" id="commentField" name="commentField" rows="4">{{$votes->where('user_id', Auth::id())->where('nomination_id', $nomination->id)->first()->comment}}</textarea> <br />
                                            @endif
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optionsRadios" id="option1" value="voteFor" required>
                                                        Support the nomination (+1)
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optionsRadios" id="option2" value="voteNeutral">
                                                        Vote for neutral (0)
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optionsRadios" id="option3" value="voteAgainst">
                                                        Vote against the nomination (-1)
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optionsRadios" id="option4" value="voteContributed">
                                                        I contributed to this map!
                                                    </label>
                                                </div> <br />
                                                <input type="hidden" id="nominationID" name="nominationID" value="{{$nomination->id}}">
                                                <input type="hidden" id="spotlightsID" name="spotlightsID" value="{{$spotlights->id}}">
                                                @if(count($votes->where('user_id', Auth::id())->where('nomination_id', $nomination->id)) == 0)
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Vote!">
                                                @else
                                                    <input type="hidden" id="voteID" name="voteID" value={{$votes->where('user_id', Auth::id())->where('nomination_id', $nomination->id)->first()->id}}>
                                                    <input class="btn btn-primary btn-sm" type="submit" value="Update!">
                                                @endif
                                            </form> <br />
                                        @else
                                            <p>You can't vote on the map you nominated!</p>
                                        @endif
                                        <div class="form-row">
                                            <div style="color:#6eac0a">Supporters ({{count($votes->where('nomination_id', $nomination->id)->where('value', 1))}}):&nbsp;</div>
                                            @foreach($votes as $vote)
                                                @if($vote->nomination_id == $nomination->id)
                                                    @if($vote->value == 1)
                                                        @if(\App\User::find($vote->user_id)->active == 1)
                                                            <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{\App\User::find($vote->user_id)->username}}</a>,
                                                        @else
                                                            <div style="color: #757575;">{{\App\User::find($nomination->user_id)->username}},</div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="form-row">
                                            <div style="color:#fa3703">Criticizers ({{count($votes->where('nomination_id', $nomination->id)->where('value', -1))}}):&nbsp;</div>
                                            @foreach($votes as $vote)
                                                @if($vote->nomination_id == $nomination->id)
                                                    @if($vote->value == -1)
                                                        @if(\App\User::find($vote->user_id)->active == 1)
                                                            <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{\App\User::find($vote->user_id)->username}}</a>,
                                                        @else
                                                            <div style="color: #757575;">{{\App\User::find($nomination->user_id)->username}},</div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="form-row">
                                            Neutral ({{count($votes->where('nomination_id', $nomination->id)->where('value', 0))}}):&nbsp; 
                                            @foreach($votes as $vote)
                                                @if($vote->nomination_id == $nomination->id)
                                                    @if($vote->value == 0)
                                                        @if(\App\User::find($vote->user_id)->active == 1)
                                                            <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{\App\User::find($vote->user_id)->username}}</a>,
                                                        @else
                                                            <div style="color: #757575;">{{\App\User::find($nomination->user_id)->username}},</div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="form-row">
                                            Contributors ({{count($votes->where('nomination_id', $nomination->id)->where('value', 2))}}):&nbsp; 
                                            @foreach($votes as $vote)
                                                @if($vote->nomination_id == $nomination->id)
                                                    @if($vote->value == 2)
                                                        @if(\App\User::find($vote->user_id)->active == 1)
                                                            <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{\App\User::find($vote->user_id)->username}}</a>,
                                                        @else
                                                            <div style="color: #757575;">{{\App\User::find($nomination->user_id)->username}},</div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if(count($votes->where('nomination_id', $nomination->id)) > 0 && count($votes->where('nomination_id', $nomination->id)->where('comment','!=', null)) > 0)
                                            <label for="comments">Comments ({{count($votes->where('nomination_id', $nomination->id)->where('comment', '!=', null))}})</label>
                                            <div class="scrollable" name="comments">
                                                @foreach($votes as $vote)
                                                    @if($vote->nomination_id == $nomination->id)
                                                        @if($vote->comment != null)
                                                            <div class="card">
                                                                @php
                                                                    if($vote->value == -1){
                                                                        $color = "#fa3703";
                                                                    }
                                                                    elseif($vote->value == 1){
                                                                        $vote->value = "+1";
                                                                        $color = "#6eac0a";
                                                                    }
                                                                    else{
                                                                        $color = "#000000";
                                                                    }
                                                                @endphp
                                                                <div class="card-header">
                                                                    <div class="row">
                                                                        @if(\App\User::find($vote->user_id)->active == 1)
                                                                            <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{\App\User::find($vote->user_id)->username}}</a>
                                                                        @else
                                                                            <div style="color: #757575;">{{\App\User::find($vote->user_id)->username}}</div>
                                                                        @endif

                                                                        @if($vote->value < 2)
                                                                            &nbsp;(<div style="color:{{$color}}">{{$vote->value}}</div>)
                                                                        @else
                                                                            &nbsp;(contributor)
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p class="card-text">{{$vote->comment}}</p>
                                                                    <div style="color: #757575;" class="small-font">{{$vote->created_at}}</div>
                                                                    @if($vote->comment_updated_at)
                                                                        <div style="color: #757575;" class="small-font float-left">(edited on {{$vote->updated_at}})</div>
                                                                    @endif
                                                                    @if(Auth::user()->isAdmin())
                                                                        <form action={{route('admin.removeComment')}} method="POST">
                                                                            @csrf
                                                                            <input type="hidden" id="voteID" name="voteID" value="{{$vote->id}}">
                                                                            <input onclick="return confirm('Are you sure you want to remove this comment?')" class="btn btn-danger btn-sm float-right" type="submit" value="Remove">
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </div> <br />
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        Seems like there are no comments for this nomination...
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                @endif
                {{$nomination->id}}
            @endforeach
        </table>
    @else
        Seems like there aren't any nominations for this spotlights...
    @endif
@endsection