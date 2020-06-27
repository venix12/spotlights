<div class="dark-section dark-section--header-section">
    <div class="header-v2">
        <div class="header-v2__icon-container">
            <div class="header-v2__icon">
                <i class="fa fa-{{ $icon }}"></i>
            </div>
        </div>

        <div class="header-v2__title-container">
            <div class="header-v2__title">
                {{ $title }}
            </div>

            @if (isset($description))
                <div class="header-v2__description">{{ $description }}</div>
            @endif
        </div>
    </div>
</div>
<div class="dark-section-divider"></div>
