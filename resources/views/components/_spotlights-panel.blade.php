{{--
    props: $spotlight: Spotlights, $listing: ['results', 'spotlights']
    modidifers: 'deadline'
--}}

@php
    $additionalClass = '';
    $infoArray = [];
    $route = $listing === 'spotlights' ? 'spotlights.show' : 'spotlights-results.show';

    if ($listing === 'spotlights') {
        $additionalClass = $spotlight->active ? 'spotlights-panel--green' : 'spotlights-panel--red';
        $infoArray['created'] = format_date($spotlight->created_at);
        $infoArray['deadline'] = format_date($spotlight->deadline);
    } else {
        $infoArray['released'] = format_date($spotlight->released_at);
    }

    if (isset($spotlight->threshold)) {
        $infoArray['threshold'] = $spotlight->threshold;
    }
@endphp


<a href="{{ route($route, $spotlight->id) }}" class="spotlights-panel {{ $additionalClass }}">
    <div class="spotlights-panel__header">
        {{ $spotlight->title }}
    </div>

    <div class="spotlights-panel__bottom">
        <div class="spotlights-panel__description">
            {{ $spotlight->description }}
        </div>

        <div class="spotlights-panel__info-container">
            @foreach ($infoArray as $name => $info)
                <div class="spotlights-panel__info spotlights-panel__info--{{ $name }}">
                    {{ $name }}: {{ $info }}
                </div>
            @endforeach
        </div>
    </div>
</a>
