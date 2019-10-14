<div class="form-row">
    <div class="text-success">Supporters ({{count($votes->where('nomination_id', $nomination->id)->where('value', 1))}}):&nbsp;</div>

    @foreach($votes->where('nomination_id', $nomination->id)->where('value', '===', 1) as $vote)
        @if($users->find($vote->user_id)->active)
            <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{$users->find($vote->user_id)->username}}</a> {!!$loop->last ? '' : ',&nbsp;'!!}
        @else
            <div class="text-gray">{{$users->find($nomination->user_id)->username}} {!!$loop->last ? '' : ',&nbsp;'!!}</div>
        @endif
    @endforeach
</div>

<div class="form-row">
    <div class="text-danger">Criticizers ({{count($votes->where('nomination_id', $nomination->id)->where('value', -1))}}):&nbsp;</div>

    @foreach($votes->where('nomination_id', $nomination->id)->where('value', '===', -1) as $vote)
        @if($users->find($vote->user_id)->active)
            <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{$users->find($vote->user_id)->username}}</a> {!!$loop->last ? '' : ',&nbsp;'!!}
        @else
            <div class="text-gray">{{$users->find($nomination->user_id)->username}} {!!$loop->last ? '' : ',&nbsp;'!!}</div>
        @endif
    @endforeach
</div>

<div class="form-row">
    Neutral ({{count($votes->where('nomination_id', $nomination->id)->where('value','===', 0))}}):&nbsp;

    @foreach($votes->where('nomination_id', $nomination->id)->where('value', '===', 0) as $vote)
        @if($users->find($vote->user_id)->active)
            <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{$users->find($vote->user_id)->username}}</a> {!!$loop->last ? '' : ',&nbsp;'!!}
        @else
            <div class="text-gray">{{$users->find($nomination->user_id)->username}} {!!$loop->last ? '' : ',&nbsp;'!!}</div>
        @endif
    @endforeach
</div>

<div class="form-row">
    Contributors ({{count($votes->where('nomination_id', $nomination->id)->where('value', 2))}}):&nbsp;

    @foreach($votes->where('nomination_id', $nomination->id)->where('value', '===', 2) as $vote)
        @if($users->find($vote->user_id)->active)
            <a href={{route('user.profile', ['id' => $vote->user_id])}}>{{$users->find($vote->user_id)->username}}</a> {!!$loop->last ? '' : ',&nbsp;'!!}
        @else
            <div class="text-gray">{{$users->find($nomination->user_id)->username}} {!!$loop->last ? '' : ',&nbsp;'!!}</div>
        @endif
    @endforeach
</div>
