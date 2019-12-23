<form method="POST" action={{ route('spotlights.mapids', ['id' => $spotlights->id]) }} style="margin-bottom:0">
@csrf
    <div class="col-md-6">
        <div class="form-group row">

            <div class="col-md-2">
                <input id="threshold" autocomplete="off" type="text" class="form-control @error('threshold') is-invalid @enderror" name="threshold" required>
            </div>

            <button type="submit" class="btn btn-primary">
                    {{ __('Get beatmaps!') }}
            </button>
        </div>
    </div>
</form>
