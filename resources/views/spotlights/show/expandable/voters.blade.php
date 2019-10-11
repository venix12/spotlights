<div class="form-row">
    <div class="text-success">Supporters ({{count($votes->where('nomination_id', $nomination->id)->where('value', 1))}}):&nbsp;</div>

    @foreach($votes as $vote)
        @if($vote->value === 1)
            @if($vote->nomination_id === $nomination->id)
                @if($users->find($vote->user_id)->active)
                    <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{$users->find($vote->user_id)->username}}</a>, &nbsp;
                @else
                    <div class="text-gray">{{$users->find($nomination->user_id)->username}},</div>
                @endif
            @endif
        @endif
    @endforeach
</div>

<div class="form-row">
    <div class="text-danger">Criticizers ({{count($votes->where('nomination_id', $nomination->id)->where('value', -1))}}):&nbsp;</div>

    @foreach($votes as $vote)
        @if($vote->value === -1)
            @if($vote->nomination_id === $nomination->id)
                @if($users->find($vote->user_id)->active)
                    <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{$users->find($vote->user_id)->username}}</a>, &nbsp;
                @else
                    <div class="text-gray">{{$users->find($nomination->user_id)->username}},</div>
                @endif
            @endif
        @endif
    @endforeach
</div>

<div class="form-row">
    Neutral ({{count($votes->where('nomination_id', $nomination->id)->where('value','===', 0))}}):&nbsp;

    @foreach($votes as $vote)
        @if($vote->value === 0)
            @if($vote->nomination_id === $nomination->id)
                @if($users->find($vote->user_id)->active)
                    <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{$users->find($vote->user_id)->username}}</a>, &nbsp;
                @else
                    <div class="text-gray">{{$users->find($nomination->user_id)->username}},</div>
                @endif
            @endif
        @endif
    @endforeach
</div>

<div class="form-row">
    Contributors ({{count($votes->where('nomination_id', $nomination->id)->where('value', 2))}}):&nbsp;

    @foreach($votes as $vote)
        @if($vote->value === 2)
            @if($vote->nomination_id === $nomination->id)
                @if($users->find($vote->user_id)->active)
                    <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{$users->find($vote->user_id)->username}}</a>, &nbsp;
                @else
                    <div class="text-gray">{{$users->find($nomination->user_id)->username}},</div>
                @endif
            @endif
        @endif
    @endforeach
</div>
