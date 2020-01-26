@if(count($votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())) === 0)
    <form action={{route('spotlights.vote')}} method="POST">
        @csrf
        <label for="comment{{$nomination->id}}">Put your comment here!</label>
        <div class="textarea-border">
            <textarea id="comment{{$nomination->id}}" name="commentField" rows="4" maxlength="2000" oninput="countChars(this.id, this.value.length);"></textarea>

            <div class="d-flex justify-content-end">
                <div class="title-section__info">
                    <span id="comment{{$nomination->id}}-counter">0</span>
                    <span>&nbsp;/ 2000</span>
                </div>
            </div>
        </div>
@else
    <form action={{route('spotlights.updateVote')}} method="POST">
        @csrf
        <label for="comment{{$nomination->id}}">Put your comment here!</label>
        <div class="textarea-border">
            <textarea id="comment{{$nomination->id}}" name="commentField" rows="4" maxlength="2000" oninput="countChars(this.id, this.value.length);">{{
                $votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())->first()->comment
            }}</textarea>

            <div class="d-flex justify-content-end">
                <div class="title-section__info">
                    <span id="comment{{$nomination->id}}-counter">0</span>
                    <span>&nbsp;/ 2000</span>
                </div>
            </div>
        </div>
@endif

@if($nomination->user_id != Auth::id())

    <br> @include('spotlights.show.expandable.voteoptions')

@else
    <br>
@endif
    <input type="hidden" id="nominationID" name="nominationID" value="{{$nomination->id}}">
    <input type="hidden" id="spotlightsID" name="spotlightsID" value="{{$spotlights->id}}">

    @if(count($votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())) === 0)
        <button class="dark-form__button" type="submit">
            <i class="fa fa-check"></i> Vote!
        </button>
    @else
        <input type="hidden" id="voteID" name="voteID" value={{$votes->where('nomination_id', $nomination->id)->where('user_id', Auth::id())->first()->id}}>
        <button class="dark-form__button" type="submit">
            <i class="fa fa-pencil"></i> Update!
        </button>
    @endif
</form> <br>
