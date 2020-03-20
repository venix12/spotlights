<div class="header-v2 {{ isset($colour) ? 'header-v2--' . $colour : '' }}">
    <div class="header-v2__title">
        <i class="fa fa-{{ $icon }}"></i> {{ $title }}
    </div>

    @if (isset($description))
        <div class="header-v2__description">{{ $description }}</div>
    @endif
</div>
