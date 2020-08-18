@extends('layouts.app', [
    'title' => 'Create playlist'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Create playlist'],
    ])
        @include('components._header-v2', [
            'icon' => '',
            'title' => 'Create playlist',
        ])

        <div class="dark-section dark-section--4">
            <form action="{{ route('admin.playlists.store', $id) }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">room id</div>
                        <input name="room_id" type="text" class="dark-form__input" autocomplete="off" required>
                    </div>

                    <div class="dark-form__el dark-form__el--offset">
                        <button type="submit" class="dark-form__button">
                            <i class="fa fa-check"></i> Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endcomponent
@endsection
