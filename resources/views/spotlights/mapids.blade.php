<title>Nominated Beatmaps | osu! Spotlights Team</title>

@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Home ≫ Spotlights ≫ {{$spotlights->title}} ≫ Nominated Beatmaps</div>
            <div class="card-body">
                Threshold set: {{$threshold}} <br /> <br />

                @if(count($nominations) > 0)
                    <b>Beatmaps:</b> <br />
                    @foreach($nominations as $nomination)
                        - {{$nomination->beatmap_artist}} - {{$nomination->beatmap_title}} by {{$nomination->beatmap_creator}}<br />
                    @endforeach <br />

                    <b>Beatmaps IDs:</b> <br />
                    <div id="IDs" class="container row">
                        @foreach($nominations as $nomination)
                            {{$nomination->beatmap_id}}{{ $loop->last ? '' : ', ' }}
                        @endforeach
                    </div>
                    <button class="btn btn-primary btn-sm" onclick="copy('IDs')">Copy!  </button>

                @else
                    There aren't any beatmapsets meeting selected criteria.
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        function copy(id) {
            var textToCopy = document.getElementById(id);

            var range = document.createRange();
            range.selectNode(textToCopy);
            window.getSelection().addRange(range);

            document.execCommand("copy");
            
            window.getSelection().removeRange(range);
        }
    </script>
@endsection