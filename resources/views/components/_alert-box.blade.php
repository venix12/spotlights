<div class="alert-box alert-box--{{ $type }}">
    <div class="alert-box__icon">
        <i class="fa fa-warning"></i>
    </div>

    <div class="alert-box__content">{{ $slot }}</div>

    @if (isset($close) && $close === true)
        <div class="alert-box__close">×</div>
    @endif
</div>
