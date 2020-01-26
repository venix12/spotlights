@extends('layouts.app', [
    'title' => 'Create usergroup'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Create usergroup'],
    ])
        @include('components._header', [
            'modifiers' => ['previous' => [
                'route' => 'admin.user-groups',
                'section' => 'manage usergroups',
                ],
            ],
            'title' => 'Create usergroup',
        ])

        <form action="{{ route('admin.user-groups.store') }}" method="POST">
            @csrf

            <div class="dark-form">
                <div class="dark-form__el">
                    <div class="dark-form__label">identifier</div>
                    <input name="identifier" type="text" class="dark-form__input" autocomplete="off" required>
                </div>

                <div class="dark-form__el">
                    <div class="dark-form__label">name</div>
                    <input name="name" type="text" class="dark-form__input" autocomplete="off" required>
                </div>

                <div class="dark-form__el">
                    <div class="dark-form__label">permissions</div>
                    <input name="perm_set" type="text" class="dark-form__input" autocomplete="off" required>
                </div>

                <div class="dark-form__el">
                    <div class="dark-form__label">hierarchy</div>
                    <input name="hierarchy" type="text" class="dark-form__input" autocomplete="off">
                </div>

                <div class="dark-form__el">
                    <div class="dark-form__label">title?</div>
                    <input name="title" type="text" class="dark-form__input" autocomplete="off">
                </div>

                <div class="dark-form__el">
                    <div class="dark-form__label">color?</div>
                    <input name="color" type="text" class="dark-form__input" autocomplete="off">
                </div>

                <div class="dark-form__el dark-form__el--offset">
                    <input type="checkbox" name="hidden" value="true"> hidden?
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
