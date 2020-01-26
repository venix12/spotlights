@php
    switch($vote->value) {
        case -1:
            $color = '#fa3703';
            break;

        case 1:
            $vote->value = '+1';
            $color = '#6eac0a';
            break;

        default:
            $color = '#ffffff';
            break;
    }
@endphp

<div class="comment-card {{$vote->user_id === $nomination->user_id ? 'comment-card--gold' : ''}}">
    <div class="comment-card__header">
        <a href="{{ route('user.profile', ['id' => $vote->user_id]) }}">
            {{$vote->user->username}}
        </a>

        @if($vote->user_id !== $nomination->user_id)
            @if($vote->value < 2)
                <span style="color: {{$color}}"> ({{$vote->value}})</span>
            @else
                <span> (contributor)</span>
            @endif
        @else
            <span> (nominator)</span>
        @endif
    </div>

    <div class="comment-card__body">
        {{$vote->comment}}

        <div class="space-between">
            <div class="comment-card__body__info">
                <div>created at {{ format_date($vote->created_at, true) }}</div>

                @if($vote->updated_at)
                    <div>updated at {{ format_date($vote->updated_at, true) }}</div>
                @endif
            </div>

            @if(Auth::user()->isAdmin())
                <form action={{ route('admin.removeComment') }} method="POST">
                    @csrf

                    <input type="hidden" id="voteID" name="voteID" value="{{ $vote->id }}">

                    <button onclick="return confirm('Are you sure you want to remove this comment?')" class="dark-form__button" type="submit">
                        <i class="fa fa-trash"></i> Remove
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
