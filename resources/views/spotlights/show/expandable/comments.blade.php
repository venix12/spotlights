@if(count($votes->where('nomination_id', $nomination->id)) > 0 && count($votes->where('nomination_id', $nomination->id)->where('comment','!=', null)) > 0)
    <label for="comments">Comments ({{count($votes->where('nomination_id', $nomination->id)->where('comment', '!=', null))}})</label>
    <div name="comments" class="scrollable">
        @foreach($votes as $vote)
            @if($vote->nomination_id === $nomination->id && $vote->user_id === $nomination->user_id)

                @include('spotlights.show.expandable.comment') <br>

            @endif
        @endforeach

        @foreach($votes->where('nomination_id', '===', $nomination->id)->where('user_id', '!==', $nomination->user_id)->where('comment', '!==', null) as $vote)

                @include('spotlights.show.expandable.comment')

                {!!$loop->last ? '' : '<br>'!!}

        @endforeach
    </div>
@else
    Seems like there are no comments for this nomination...
@endif
