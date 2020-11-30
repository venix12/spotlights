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
                        <span>
                            <a href="https://osu.ppy.sh/multiplayer/rooms/{{ $playlist->osu_room_id }}">
                                {{ $playlist->osu_room_name }} ({{ $playlist->osu_room_id }})
                            </a>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="dark-section dark-section--3">
            Divisions: <br>

            @foreach ($season->divisionsForListing() as $division)
                <div class="d-inline-flex">
                    {{ $division['name'] }}: top{{ $division['threshold'] }}

                    <form action="{{ route('admin.divisions.edit', $division['id']) }}">
                        <button class="button-invisible" type="submit" title="edit">
                            <a class="fa fa-pencil"></a>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.divisions.remove', $division['id']) }}">
                        @csrf

                        <button class="button-invisible" type="submit" title="remove">
                            <a class="fa fa-trash"></a>
                        </button>
                    </form>
                </div>
                <br>
            @endforeach

        </div>

        <div class="dark-section dark-section--3">
            Factors: <br>

            @foreach ($season->factors->sortByDesc('factor') as $factor)
                <div class="d-inline-flex">
                    {{ $factor->factor }}

                    <form action="{{ route('admin.factors.edit', $factor->id) }}">
                        <button class="button-invisible" type="submit" title="edit">
                            <a class="fa fa-pencil"></a>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.factors.remove', $factor->id) }}">
                        @csrf

                        <button class="button-invisible" type="submit" title="remove">
                            <a class="fa fa-trash"></a>
                        </button>
                    </form>
                </div>
                <br>
            @endforeach

            @if ($season->uniquePlaylistsCount() > $season->factors->count())
                <div class="text-danger">There are more unique playlists than factors!</div>
            @endif
        </div>

        <div class="dark-section dark-section--4">
            <a href="{{ route('admin.playlists.create', $season->id) }}"class="dark-form__button dark-form__button--radius-square dark-form__button--small">
                <i class="fa fa-plus"></i> Add playlist
            </a>

            <a href="{{ route('admin.divisions.create', $season->id) }}"class="dark-form__button dark-form__button--radius-square dark-form__button--small">
                <i class="fa fa-plus"></i> Add division
            </a>

            <a href="{{ route('admin.factors.create', $season->id) }}"class="dark-form__button dark-form__button--radius-square dark-form__button--small">
                <i class="fa fa-plus"></i> Add factor
            </a>

            <a href="{{ route('admin.divisions.load-defaults', $season->id) }}"class="dark-form__button dark-form__button--radius-square dark-form__button--small">
                <i class="fa fa-plus"></i> Load default divisions
            </a>
        </div>
    @endcomponent
@endsection
