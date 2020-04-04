@php
    /*
    * modifiers: marker, previous => [route, section], tags => [tag1, tag2]
    */

    if (!isset($modifiers)) {
        $modifiers = [];
    }

    $headerClass = 'title-section__header';

    if (in_array('marker', $modifiers)) {
        $headerClass .= ' title-section__header--marker';
    }

    if (in_array('marker-red', $modifiers)) {
        $headerClass .= ' title-section__header--marker title-section__header--marker--red';
    }
@endphp

@if(array_key_exists('previous', $modifiers))
    <a
        href="{{ route($modifiers['previous']['route']) }}"
        class="title-section__previous"
    >
        go to {{ $modifiers['previous']['section'] }}
    </a>

    <br>
@endif

@if(array_key_exists('tags', $modifiers))
    <div class="space-between">
        @foreach($modifiers['tags'] as $tag)
            @if($tag)
                <div class="title-section__info">{{ $tag }}</div>
            @endif
        @endforeach
    </div>
@endif

<div class="{{ $headerClass }}">{{ $title }}</div>

@if(isset($description))
    <div class="medium-font">{{ $description }}</div>
@endif

<hr style="border-color: white">
