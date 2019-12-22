<form method="POST" action={{ route('spotlights.setThreshold') }} style="margin-bottom:0">
    @csrf
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-2">
                    <input name="SpotlightsId" type="hidden" value="{{$spotlights->id}}">
                    <input id="threshold" autocomplete="off" type="text" class="form-control @error('threshold') is-invalid @enderror" name="threshold" required>
                </div>

                <button type="submit" class="btn btn-primary">
                        {{ __('Set threshold!') }}
                </button>
            </div>
        </div>
    </form>
