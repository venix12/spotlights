<div
    class="card card-mapset bg-test {{ $spotlighted === true ? 'card-spotlight' : '' }}"
    style="
        background-image: url('{{ asset('images/triangle-card.png') }}'), url('https://assets.ppy.sh/beatmaps/{{$beatmap_id}}/covers/cover.jpg');
        background-position: -40%, 150%;
        background-color: #FFFFFF;
        background-repeat: no-repeat;
    "
>
    <div class="container row no-gutters align-items-center" style="padding: 0.5em">
        <div class="col-score" style="font-size: 2rem; margin-right: 10px">
            <i class="fa fa-w fa-chevron-circle-right accordion-toggle text-white" id="collapse{{$id}}" data-target="#details{{$id}}" data-toggle="collapse" onclick="openOrClose(this.id)"></i>

            <span class="badge" style="background: {{$scoreColor}}">{{$score}}</span>
        </div>

        <div class="col medium-font">
            <span class="section-badge" style="margin-bottom: 1%"><a href="https://osu.ppy.sh/beatmapsets/{{$beatmap_id}}">{{$metadata}}</a></span> <br>

            <div class="section-badge">
                <i class="fa fa-user fa-fw"></i> <b>Mapped by</b> <a href="https://osu.ppy.sh/users/{{$creator_id}}">{{$creator}}</a> <br>
                <i class="fa fa-user fa-fw text-primary"></i> <b>Nominated by</b> <a href={{ route('user.profile', [$id => $nominator_id]) }} >{{$nominator}}</a>
            </div>

        </div>

        @if($state && $stateColor)
            <div class="col-2">
                <span class="badge" style="background: {{$stateColor}}; font-size: 1rem;">{{$state}}</span>
            </div>
        @endif

        <div class="col-1">
            <div class="float-right">
                <div class="section-badge">
                    <i class="fa fa-user fa-fw"></i> {{$participants}} <br>
                    <i class="fa fa-thumbs-up text-success fa-fw"></i> {{$supporters}} <br>
                    <i class="fa fa-thumbs-down text-danger fa-fw"></i> {{$criticizers}}
                </div>
            </div>
        </div>
    </div>
</div>
