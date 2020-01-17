@php
    if(!isset($dark))
    {
        $dark = false;
    }

    if(!isset($size))
    {
        $size = 8;
    }

    $dark ? $bodyClass = 'bg-gray text-white' : $bodyClass = '';
    $dark ? $borderStyle = 'border: none' : $borderStyle = '';
    $dark ? $headerClass = 'bg-dark text-white' : $headerClass = '';
@endphp

@if($dark === true)
    <style>
    a, a:hover, a:focus {
        color: white;
    }
    </style>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-{{$size}}">
            <div class="card" style="{{$borderStyle}}">
                <div class="card-header {{$headerClass}}">
                    <div class="sections-header">
                        @foreach($sections as $section)
                            <span class="sections-header__el">
                                {{$section}} {!! $loop->last ? '' : '<span class="sections-header__arrow"></span>' !!}
                            </span>
                        @endforeach
                    </div>
                </div>
                <div class="card-body {{$bodyClass}}">
                    @include('layouts.session')

                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
</div>

