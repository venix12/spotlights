@if($spotlights->active == 1)
    <form method="POST" action={{route('spotlights.nominate', ['id' => $spotlights->id])}} style="margin-bottom:0">
        @csrf
        <div class="col-md-6">
            <div class="form-group row">
                <label for="beatmap_id" class="col-form-label text-md-right">Beatmapset ID</label>

                <div class="col-md-4">
                    <input id="beatmap_id" type="text" class="form-control" name="beatmap_id" required>
                </div>
                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-primary">
                        {{ __('Nominate!') }}
                </button>
            </div>
        </div>
    </form>
    <span class="medium-font">Remember to put <b>BeatmapSet ID</b> and not <b>Beatmap ID</b> here!</span><br />
    <span class="icon-list"><i class="text-success icon fa fa-check fa-fw"></i> osu.ppy.sh/beatmapsets/<b>XXXXXXXX</b> <span class="text-gray">or</span> osu.ppy.sh/s/<b>XXXXXXXX</b></span>
    <p class="icon-list"><i class="text-danger icon fa fa-close fa-fw"></i> osu.ppy.sh/beatmapsets/XXXXXXXX#mode/<b>XXXXXXX</b> <span class="text-gray">or</span> osu.ppy.sh/b/<b>XXXXXXX</b></p>
@else
    <p>The nominating stage for this spotlights has already ended!</p>
@endif