@extends('layouts.app', [
    'title' => 'Manage season'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage leaderboards']
    ])
        @include('components._header-v2', [
            'description' => $season->name,
            'icon' => 'random',
            'title' => 'Manage leaderboards'
        ])

        <div class="dark-section dark-section--4">
            @foreach ($season->playlists as $playlist)
                <div class="info-panel">
                    <div class="space-between">
                        <span>{{ $playlist->osu_room_name }} ({{ $playlist->osu_room_id }})</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="dark-section dark-section--3">
            Divisions: <br>

            @foreach ($season->divisionsThresholds() as $key => $value)
                {{ $key }}: top{{ $value }} <br>
            @endforeach

        </div>

        <div class="dark-section dark-section--4">
            <a href="{{ route('admin.playlists.create', $season->id) }}"class="dark-form__button dark-form__button--radius-square dark-form__button--small">
                <i class="fa fa-plus"></i> Add playlist
            </a>

            <a href="{{ route('admin.divisions.create', $season->id) }}"class="dark-form__button dark-form__button--radius-square dark-form__button--small">
                <i class="fa fa-plus"></i> Add division
            </a>
        </div>
    @endcomponent
@endsection
