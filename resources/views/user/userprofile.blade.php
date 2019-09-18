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
                    <h4><div style="color: {{\App\UserGroup::GROUP_COLOURS[$user->group_id]}}; margin-bottom: 0;">{{$user->username}}</div></h4>
                    @if($user->group_id != 0)
                        <b>{{\App\UserGroup::GROUPS[$user->group_id]}}</b><br /><br />
                    @else
                        <br /><br />
                    @endif
                    Joined at {{$user->created_at}} <br />
                    @if($user->osu_user_id != null)
                        <a href="https://osu.ppy.sh/u/{{$user->osu_user_id}}"> osu! Profile</a>
                    @endif
                    <hr>
                    <h4>Statistics</h4>
                    Nominatinated maps: {{count($nominations->where('user_id', $user->id))}} <br />
                    Votes casted: {{count($votes->where('user_id', $user->id))}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection