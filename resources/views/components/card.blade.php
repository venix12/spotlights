@php
    if(!isset($size))
    {
        $size = 8;
    }
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-{{$size}} col-main">
            <div class="card-layout">
                <div class="card-layout__header">
                    <div class="sections-header">
                        @foreach($sections as $section)
                            <span class="sections-header__el">
                                {{$section}} {!! $loop->last ? '' : '<span class="sections-header__arrow"></span>' !!}
                            </span>
                        @endforeach
                    </div>
                </div>
                <div class="card-layout__content">
                    @include('layouts.session')

                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
</div>

