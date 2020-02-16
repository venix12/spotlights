@extends('layouts.app', [
    'title' => 'Application form',
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Application form'],
    ])
        @include('components._header', [
            'title' => 'Application to the osu! Spotlights Team'
        ])

        <form action="{{ route('app.store') }}" method="POST">
            @csrf

            @foreach($questions as $question)

                @php
                    $rowCount = round($question->char_limit / 100) + 2;
                @endphp

                <div class="card-body bg-dark">
                    <h4>{{$question->question}} {!! $question->required ? '' : '<span class="text-muted">(optional)</span>' !!}</h4>

                    <div class="textarea-border">
                        <textarea class="textarea-invisible"
                            id="{{$question->id}}"
                            name="{{$question->id}}"
                            oninput="countChars(this.id, this.value.length);"
                            maxlength={{$question->char_limit}}
                            rows={{$rowCount}}
                            {!! $question->required ? 'required' : '' !!}
                        ></textarea>

                        <div class="d-flex justify-content-end">
                            <div class="title-section__info">
                                <span id="{{$question->id}}-counter">0</span>
                                <span>&nbsp;/ {{$question->char_limit}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {!! $loop->last ? '' : '<br>' !!}
            @endforeach
            <hr>

            <div class="text-center">
                @if(Auth::check() && !Auth::user()->isMember())
                    gamemode <select name="gamemode" class="dark-form__select">
                        <option value="osu">osu!</option>
                        <option value="taiko">osu!taiko</option>
                        <option value="mania">osu!mania</option>
                        <option value="catch">osu!catch</option>
                    </select> <br>

                    <button type="submit" class="dark-form__button dark-form__button--top-rem flex-centre">
                        <i class="fa fa-user"></i> Apply now!
                    </button>
                @else
                    <span class="text-muted">you are already a member!</span>
                @endif <br>
            </div>
        </form>
    @endcomponent
@endsection

