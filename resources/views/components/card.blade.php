@php
    if(!isset($dark))
    {
        $dark = false;
    }

    if(!isset($size))
    {
        $size = 8;
    }

    $dark ? $cardClass = 'border-dark' : $cardClass = '';
    $dark ? $headerClass = 'bg-dark text-white' : $headerClass = '';
    $dark ? $bodyClass = 'bg-gray text-white' : $bodyClass = '';
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-{{$size}}">
            <div class="card {{$cardClass}}">
                <div class="card-header {{$headerClass}}">
                    <div class="container row">
                        @foreach($sections as $section)

                            {{$section}} {{ $loop->last ? '' : ' ≫ ' }}

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

