@extends('layouts.app', [
    'title' => 'Create app cycle'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Application evaluation', 'Create app cycle'],
    ])
        @include('components._header', [
            'modifiers' => ['previous' => [
                'route' => 'admin.app-eval',
                'section' => 'application evaluation',
                ],
            ],
            'title' => 'Create app cycle',
        ])

        <form action="{{ route('admin.app-eval.store') }}" method="POST">
            @csrf

            <div class="dark-form">
                <div class="dark-form__el">
                    <div class="dark-form__label">name</div>
                    <input name="name" type="text" class="dark-form__input dark-form__input--long" autocomplete="off" required>
                </div>

                <div class="dark-form__el">
                    <div class="dark-form__label">deadline!</div>
                    <input name="deadline" type="text" class="dark-form__input" autocomplete="off" required>
                </div>

                <div class="dark-form__el dark-form__el--offset">
                    <button type="submit" class="dark-form__button">
                        <i class="fa fa-check"></i> Create
                    </button>
                </div>
            </div>
        </form>
    @endcomponent
@endsection
