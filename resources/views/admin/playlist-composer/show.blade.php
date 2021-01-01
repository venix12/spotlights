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
            'title' => 'Playlist composer',
            'description' => $season->name,
        ])

        <div class="dark-section dark-section--3">
            <form action="{{ route('admin.playlist-composer.entries.store') }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">beatmap id</div>
                        <input name="beatmapset_id" type="text" class="dark-form__input" autocomplete="off" placeholder="not beatmapset id" required>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">mod</div>
                        <input name="mod" type="text" class="dark-form__input" autocomplete="off" placeholder="XX format, empty if none">
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">playlist</div>
                        <select name="playlist_id" class="dark-form__select">
                            @foreach ($season->modePlaylists(Auth::user()->playlistComposerGamemodes()) as $playlist)
                                <option value="{{ $playlist->id }}">{{ $playlist->name }} - {{ gamemode($playlist->mode) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">difficulty</div>
                        <select name="difficulty" class="dark-form__select">
                            <option>hard</option>
                            <option>insane</option>
                            <option>expert</option>
                        </select>
                    </div>

                    <div class="dark-form__el dark-form__el--offset" style="margin-bottom: 0">
                        <button type="submit" class="dark-form__button">
                            <i class="fa fa-check"></i> Add
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="dark-section dark-section--4">
            @foreach (App\Models\User::MODES as $mode)

                <h4>{{ gamemode($mode) }}</h4>

                @if (array_key_exists($mode, $validationErrors))
                    @component('components._alert-box', [
                        'type' => 'error',
                    ])
                        <b>The validation detected errors ({{ count($validationErrors[$mode]) }}):</b>
                        @foreach($validationErrors[$mode] as $error)
                            <ul>
                                <li>{!! $error !!}</li>
                            </ul>
                        @endforeach
                    @endcomponent
                @endif

                @foreach ($season->modePlaylists([$mode]) as $playlist)
                    <div class="info-panel">
                        <div class="info-panel__header">{{ $playlist->name }}</div>

                        @foreach ($playlist->entriesSortedForListing() as $entry)
                            <div class="d-inline-flex">
                                <a href="https://osu.ppy.sh/b/{{ $entry->osu_beatmap_id }}">
                                    {{ $entry->metadataForDisplay() }}
                                </a>

                                <form action="{{ route('admin.playlist-composer.entries.remove', $entry->id) }}" method="POST">
                                    @csrf

                                    <button type="submit" class="button-invisible" title="remove entry">
                                        <a class="fa fa-trash"></a>
                                    </button>
                                </form>
                            </div>

                            <ul>
                                <li>
                                    <span class="text-lightgray">
                                        difficulty: {{ $entry->difficulty }}
                                    </span>
                                </li>
                                <li>
                                    <span class="text-lightgray">
                                        creator: <a href="https://osu.ppy.sh/users/{{ $entry->creator_osu_id }}">{{ $entry->creator }}</a>
                                    </span>
                                </li>
                                @if ($entry->mod !== null)
                                    <li>
                                        <span class="text-lightgray">
                                            mod: {{ $entry->mod }}
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        @endforeach
                    </div>
                @endforeach
            @endforeach
        </div>

        @if (Auth::user()->isAdmin())
            <div class="dark-section dark-section--3">
                <form action="{{ route('admin.playlist-composer.playlists.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="season_id" value="{{ $season->id }}">
                    <input class="dark-form__input dark-from__input--long dark-form__input--inline" type="text" name="name" autocomplete="off">

                    <select name="mode" class="dark-form__select dark-form-input--inline">
                        @foreach (App\Models\User::MODES as $mode)
                            <option value="{{ $mode }}">{{ gamemode($mode) }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="dark-form__button dark-form__button--left dark-form__button--small dark-form__button--radius-square dark-form__button--top" onclick="return confirm('are you sure?')">
                        <i class="fa fa-plus"></i> Add playlist
                    </button>
                </form>
            </div>
        @endif
    @endcomponent
@endsection
