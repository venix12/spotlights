<td colspan="8" class="hiddenRow">
    <div id="details{{$nomination->id}}" class="accordian-body collapse">
        <div class="modal-body row">
            <div class="col-md-6">

                @include('spotlights.show.expandable.vote')

                @include('spotlights.show.expandable.voters')

            </div>

            <div class="col-md-6">

                @include('spotlights.show.expandable.comments')

            </div>
        </div>
    </div>
</td>