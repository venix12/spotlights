@if(count($votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())) === 0)
    <form action={{route('spotlights.vote')}} method="POST">
        @csrf
        <label for="commentField">Put your comment here!</label>
        <p><textarea class="form-control"name="commentField" rows="4"></textarea></p>
@else
    <form action={{route('spotlights.updateVote')}} method="POST">
        @csrf
        <label for="commentField">Put your comment here!</label>
        <textarea class="form-control" id="commentField" name="commentField" rows="4">{{$votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())->first()->comment}}</textarea> <br />
@endif

@if($nomination->user_id != Auth::id())

    @include('spotlights.show.expandable.voteoptions')

@endif
    <input type="hidden" id="nominationID" name="nominationID" value="{{$nomination->id}}">
    <input type="hidden" id="spotlightsID" name="spotlightsID" value="{{$spotlights->id}}">
    @if(count($votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())) === 0)
        <input class="btn btn-primary btn-sm" type="submit" value="Vote!">
    @else
        <input type="hidden" id="voteID" name="voteID" value={{$votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())->first()->id}}>
        <input class="btn btn-primary btn-sm" type="submit" value="Update!">
    @endif
</form> <br />