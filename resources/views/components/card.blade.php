@php
    if(!isset($dark))
    {
        $dark = false;
    }

    if(!isset($size))
    {
        $size = 8;
    }

    $dark ? $headerClass = 'bg-dark text-white' : $headerClass = '';
    $dark ? $bodyClass = 'bg-gray text-white' : $bodyClass = '';
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-{{$size}}">
            <div class="card">
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

