<div class="card">

    @php
        if($vote->value == -1)
        {
            $color = "#fa3703";
        }
        elseif($vote->value == 1)
        {
            $vote->value = "+1";
            $color = "#6eac0a";
        }
        else
        {
            $color = "#000000";
        }
    @endphp

    @if($vote->user_id === $nomination->user_id)
        <div class="card-header bg-dark text-white">
    @else
        <div class="card-header">
    @endif
        <div class="row">
            @if($users->find($vote->user_id)->active === 1)
                <a style="margin-left: 5px;" href={{route('user.profile', ['id' => $vote->user_id])}}>{{$users->find($vote->user_id)->username}}</a>
            @else
                <span style="margin-left: 5px; color: #757575;">{{\App\User::find($vote->user_id)->username}}</span>
            @endif
                
            @if($vote->user_id != $nomination->user_id)
                @if($vote->value < 2)
                    &nbsp;(<div style="color:{{$color}}">{{$vote->value}}</div>)
                @else
                    &nbsp;(contributor)
                @endif
            @else
                &nbsp;(nominator)
            @endif
        </div>
    </div>

    @if($vote->user_id === $nomination->user_id)
        <div class="card-body bg-gray text-white">
    @else
        <div class="card-body">
    @endif
        <p class="card-text">{{$vote->comment}}</p>
        <div style="text-gray" class="small-font">{{$vote->created_at}}</div>
        @if($vote->comment_updated_at)
            <div style="text-gray" class="small-font float-left">(edited on {{$vote->updated_at}})</div>
        @endif
        @if(Auth::user()->isAdmin())
            <form action={{route('admin.removeComment')}} method="POST">
                @csrf
                <input type="hidden" id="voteID" name="voteID" value="{{$vote->id}}">
                <input onclick="return confirm('Are you sure you want to remove this comment?')" class="btn btn-danger btn-sm float-right" type="submit" value="Remove">
            </form>
        @endif
    </div>
</div>




