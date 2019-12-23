<div
    class="mapset-card__card {{ $spotlighted === true ? 'card-spotlight' : 'mapset-card__border' }}"
    style="background-image: url('https://assets.ppy.sh/beatmaps/{{$beatmap_id}}/covers/cover.jpg')"
>
    <div class="mapset-card__metadata" style="margin-bottom: 8px">
        <div class="mapset-card__badge mapset-card__badge--score" style="background-color: {{ $score_color }}" title="Score">
            {{{$score}}}
        </div>

        <div class="mapset-card__badge mapset-card__badge--metadata">
            <a class="mapset-card__link" href="https://osu.ppy.sh/beatmapsets/{{$beatmap_id}}">
                {{$metadata}}
            </a>
        </div>
    </div>

    <div class="mapset-card__info">
        <div class="mapset-card__badge mapset-card__badge--info">
            <span class="mapset-card__info-el">
                <i class="fa fa-user fa-fw"></i> <b>Mapped by</b> <a class="mapset-card__link" href="https://osu.ppy.sh/users/{{$creator_id}}">{{$creator}}</a>
            </span>

            <br>

            <span class="mapset-card__info-el">
                <i class="fa fa-user fa-fw text-primary"></i> <b>Nominated by</b>
                <a class="mapset-card__link" href="https://osu.ppy.sh/users/{{$nominator_osu_id}}">{{$nominator}}</a>
            </span>
        </div>

        <div class="mapset-card__badge">
            <i class="fa fa-user fa-fw" data-placement="left" title="Participants"></i> {{$participants}} <br>
            <i class="fa fa-thumbs-up text-success fa-fw" data-placement="bottom" title="Supporters"></i> {{$supporters}}
            <i class="fa fa-thumbs-down text-danger fa-fw" data-placement="bottom" title="Criticizers"></i> {{$criticizers}}
        </div>
    </div>
</div>
