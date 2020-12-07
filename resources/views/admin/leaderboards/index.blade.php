@extends('layouts.app', [
    'title' => 'Manage leaderboards'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage leaderboards']
    ])
        @include('components._header-v2', [
            'icon' => 'random',
            'title' => 'Manage leaderboards'
        ])

        <div class="dark-section dark-section--4">
            @foreach ($seasons as $season)
                <div class="info-panel">
                    <div class="space-between">
                        <span>{{ $season->name }} ({{ $season->id }})</span>
                        <div>
                            <a href="{{ route('admin.seasons.show', ['id' => $season->id]) }}" class="dark-form__button" style="margin-left: 10px">
                                <i class="fa fa-cog"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <a href="{{ route('admin.seasons.create') }}"class="dark-form__button dark-form__button--top dark-form__button--radius-square dark-form__button--small">
                <i class="fa fa-plus"></i> Add season
            </a>
        </div>
    @endcomponent
@endsection
