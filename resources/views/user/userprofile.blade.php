@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home ≫ Users ≫ {{$user->username}}</div>
                <div class="card-body">
                    <div style="width: 100px;">
                        <img src="https://a.ppy.sh/{{$user->osu_user_id}}" width="100%" height="100%" class="float-left margin-img">
                    </div> <br />
                    @if($user->active == 1)
                        <h4><div style="color: {{\App\User::GROUP_COLOURS[$user->group_id]}}; margin-bottom: 0;">{{$user->username}}</div></h4>
                    @else
                        <h4><div style="color: #a6a6a6; margin-bottom: 0;">{{$user->username}}</div></h4>
                    @endif

                    @if($user->group_id != 0)
                        <b>{{\App\User::GROUPS[$user->group_id]}}</b><br /><br />
                    @else
                        <br /><br />
                    @endif
                    <div class="medium-font">Joined at {{$user->created_at}}</div>
                    @if($user->osu_user_id != null)
                        <a href="https://osu.ppy.sh/u/{{$user->osu_user_id}}"> osu! Profile</a>
                    @endif
                    <hr>
                    <h4>Statistics</h4>
                    Nominatinated maps: {{count($nominations->where('user_id', $user->id))}} <br />
                    Votes casted: {{count($votes->where('user_id', $user->id))}}
                    <hr>
                    @if(count($spotlightsParticipated) > 0)
                        <h4>Spotlights ({{count($spotlightsParticipated)}})</h4>
                        <p class="medium-font"><b>The user participated in following spotlights:</b></p>
                        <ul>
                            @foreach($spotlightsParticipated as $spotlight)
                                <li>{{$spotlight}} <br />
                            @endforeach
                        </ul>
                    @else
                        <h4>Spotlights</h4>
                        This user hasn't participated in any spotlights yet!
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection