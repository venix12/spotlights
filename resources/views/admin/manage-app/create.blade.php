@extends('layouts.app', [
    'title' => 'Manage application form'
])

@section('content')
<div class="container">
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage application form'],
    ])
        @include('components._header-v2', [
            'icon' => 'check',
            'title' => 'Manage Application',
        ])
        <div class="dark-section dark-section--3">
            <form action="{{ route('admin.app.store-question') }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">question</div>
                        <input name="question" type="text" class="dark-form__input dark-form__input--long" autocomplete="off" required>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">description</div>
                        <input name="description" type="text" class="dark-form__input dark-form__input--long" autocomplete="off" placeholder="leave empty if no description">
                    </div>

                    <div class="dark-form__el" id="charLimitField">
                        <div class="dark-form__label">char limit</div>
                        <input name="char_limit" type="text" class="dark-form__input dark-form__input--short" autocomplete="off" required>
                    </div>

                    <div class="dark-form__el" id="charLimitField">
                        <div class="dark-form__label" title="position of question, can't be the same for two questions">order</div>
                        <input name="order_value" type="text" class="dark-form__input dark-form__input--short" autocomplete="off" required>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">type</div>
                        <select name="type" id="typeField" class="dark-form__select">
                            <option>textarea</option>
                            <option>checkbox</option>
                            <option>section</option>
                            <option>input</option>
                        </select>
                    </div>

                    <div class="dark-form__el dark-form__el--offset">
                        <input type="checkbox" name="required"> required?
                    </div>

                    <div class="dark-form__el dark-form__el--offset" style="margin-bottom: 0">
                        <button type="submit" class="dark-form__button">
                            <i class="fa fa-check"></i> Create
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="dark-section dark-section--4">
            @include('admin.manage-app._list', [
                'questions' => $questionsActive,
                'section' => 'Active questions',
            ])

        @include('admin.manage-app._list', [
            'questions' => $questionsDeleted,
            'section' => 'Deleted questions',
        ])
    @endcomponent
@endsection
