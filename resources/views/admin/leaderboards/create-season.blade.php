@extends('layouts.app', [
    'title' => 'Create season'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage leaderboards' ,'Create season'],
    ])
        @include('components._header-v2', [
            'icon' => 'random',
            'title' => 'Create season',
        ])

        <div class="dark-section dark-section--4">
            <form action="{{ route('admin.seasons.store') }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">name</div>
                        <input name="name" type="text" class="dark-form__input dark-form__input--long" autocomplete="off" required>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">prefix</div>
                        <input name="prefix" type="text" class="dark-form__input dark-form__input--long" autocomplete="off" required>
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
