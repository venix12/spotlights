<div class="mapset-card">
    <img
        src="https://assets.ppy.sh/beatmaps/{{ $nomination->beatmap_id }}/covers/cover.jpg"
        class="mapset-card__background"
    >
    <div class="mapset-card__background-shadow"></div>


    <div class="mapset-card__info-container">
        <div class="mapset-card__score {{ $nomination->isSpotlighted() ? 'mapset-card__score--spotlighted' : '' }}">
            {{ $nomination->score }}
        </div>

        <div class="mapset-card__info-row">
            <div class="mapset-card__info mapset-card__info--metadata">
                <div class="text-ellipsis">{{ $nomination->metadata() }}</div>
            </div>

            <div class="mapset-card__info-second-row">
                <div class="mapset-card__info">
                    <i class="fa fa-user" title="creator"></i> {{ $nomination->beatmap_creator }}
                </div>
                <div class="mapset-card__info mapset-card__info--nominator">
                    <i class="fa fa-thumbs-up" title="nominator"></i> {{ $nomination->user->username }}
                </div>
            </div>
        </div>
    </div>

    <div class="mapset-card__vote-info-container">
        <div class="mapset-card__vote-info mapset-card__vote-info--supporters">
            <div class="mapset-card__vote-icon" title="supporters">
                <i class="fa fa-thumbs-up"></i>
            </div>
            {{ $nomination->votes->where('value', '1')->count() }}
        </div>
        <div class="mapset-card__vote-info mapset-card__vote-info--criticizers">
            <div class="mapset-card__vote-icon" title="criticizers">
                <i class="fa fa-thumbs-down"></i>
            </div>
            {{ $nomination->votes->where('value', '-1')->count() }}
        </div>
        <div class="mapset-card__vote-info mapset-card__vote-info--participants">
            <div class="mapset-card__vote-icon" title="participants">
                <i class="fa fa-user"></i>
            </div>
            {{ $nomination->votes->count() }}
        </div>
    </div>
</div>
