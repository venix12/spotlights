@extends('layouts.app', [
    'title' => 'Create division'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Create division'],
    ])
        @include('components._header-v2', [
            'icon' => 'random',
            'title' => 'Create division',
        ])

        <div class="dark-section dark-section--4">
            <form action="{{ route('admin.divisions.store', $id) }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">name</div>
                        <input name="name" type="text" class="dark-form__input" autocomplete="off" required>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">threshold (%)</div>
                        <input name="threshold" type="text" class="dark-form__input" autocomplete="off" required>
                    </div>

                    <div class="dark-form__el dark-form__el--offset">
                        <input type="checkbox" name="absolute"> absolute?
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
