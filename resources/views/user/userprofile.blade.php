<title>{{$user->username}}'s profile  | osu! Spotlights Team</title>

@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home ≫ Users ≫ {{$user->username}}</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session('success')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <img src="https://a.ppy.sh/{{$user->osu_user_id}}" width="100" height="100" class="float-left margin-img">
                    <div style="line-height: 0.5em;">
                        <br /><br /><br /><br />
                        @if($user->active == 1)
                            <h4><div style="color: {{\App\User::GROUP_COLOURS[$user->group_id]}};">{{$user->username}}</div></h4>
                        @else
                            <h4><div style="color: #a6a6a6;">{{$user->username}}</div></h4>
                        @endif

                        @if($user->group_id != 0)
                            <b>{{\App\User::GROUPS[$user->group_id]}}</b><br /><br /><br /><br /><br /><br /><br />
                        @else
                            <br /><br /><br /><br /><br /><br /><br />
                        @endif
                    </div>
                    <div class="medium-font row">
                        <div class="col-md-8">
                            Joined at {{$user->created_at}}
                            @if($user->osu_user_id != null)
                                // <a href="https://osu.ppy.sh/u/{{$user->osu_user_id}}">osu! Profile</a>
                            @endif
                        </div>
                    </div>
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

                    @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                        <hr>
                    @endif

                    @if(Auth::user()->isAdmin())
                        <form method="POST" action={{route('admin.changeUsergroup')}}>
                            @csrf
                            <label for="group_id" class="col-form-label text-md-right">Change Usergroup</label>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <select class="custom-select mr-sm-2" name="group_id" required>
                                        <option selected value="">Choose...</option>
                                        <option value="0">0 - Member</option>
                                        <option value="1">1 - Administrator</option>
                                        <option value="2">2 - Leader</option>
                                        <option value="3">3 - Manager</option>
                                    </select>
                                </div>

                                <input type="hidden" name="userID" value="{{$user->id}}">

                                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-primary">
                                        {{ __('Update!') }}
                                </button>
                            </div>
                        </form>
                    @endif
                    
                    @if(Auth::user()->isAdmin() || Auth::user()->isManager())

                        @php
                            if ($user->active == 1)
                            {
                                $activeValue = "deactivate";
                            } else {
                                $activeValue = "activate";
                            }

                        @endphp

                        <form action={{route('admin.'.$activeValue.'User')}} method="POST">
                            @csrf
                            <input type="hidden" id="userID" name="userID" value="{{$user->id}}">
                            <input onclick="return confirm('Are you sure you want to {{$activeValue}} {{$user->username}}?')" class="btn btn-dark btn-sm" type="submit" value={{ucfirst($activeValue)}}>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection