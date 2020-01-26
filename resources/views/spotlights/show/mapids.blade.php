<form method="POST" action={{ route('spotlights.mapids', ['id' => $spotlights->id]) }} style="margin-bottom:0">
@csrf
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-2">
                <input
                    id="threshold"
                    autocomplete="off"
                    type="text"
                    class="dark-form__input dark-form__input--col @error('threshold') is-invalid @enderror"
                    name="threshold"
                    required
                >
            </div>

            <button type="submit" class="dark-form__button">
                    Get beatmaps!
            </button>
        </div>
    </div>
</form>
