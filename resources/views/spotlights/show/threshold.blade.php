<form method="POST" action={{ route('spotlights.setThreshold') }} style="margin-bottom:0">
    @csrf
    <div class="col-md-6">
        <div class="form-group row" style="margin-bottom: 0">
            <div class="col-md-2">
                <input name="SpotlightsId" type="hidden" value="{{$spotlights->id}}">
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
                    Set threshold!
            </button>
        </div>
    </div>
</form>
