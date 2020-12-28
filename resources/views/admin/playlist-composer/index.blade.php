@extends('layouts.app', [
    'title' => 'Playlist composer'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Playlist composer']
    ])
        @include('components._header-v2', [
            'icon' => 'random',
            'title' => 'Playlist composer'
        ])

        <div class="dark-section dark-section--4">
            @foreach ($seasons as $season)
                <div class="info-panel">
                    <div class="space-between">
                        <span>{{ $season->name }}</span>
                        <div>
                            <a href="{{ route('admin.playlist-composer.seasons.show', $season->id) }}" class="dark-form__button" style="margin-left: 10px">
                                <i class="fa fa-cog"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            @if (Auth::user()->isAdmin())
                <form action="{{ route('admin.playlist-composer.seasons.store') }}" method="POST">
                    @csrf

                    <input class="dark-form__input dark-from__input--long dark-form__input--inline" type="text" name="name" autocomplete="off">

                    <button type="submit" class="dark-form__button dark-form__button--left dark-form__button--small dark-form__button--radius-square dark-form__button--top" onclick="return confirm('are you sure?')">
                        <i class="fa fa-plus"></i> Add season
                    </button>
                </form>
            @endif
        </div>
    @endcomponent
@endsection
