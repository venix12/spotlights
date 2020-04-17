@extends('layouts.app', [
    'title' => 'Edit Question'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage application form', 'Edit question'],
    ])
        @include('components._header-v2', [
            'icon' => 'check',
            'title' => 'Edit Question',
        ])
        <div class="dark-section dark-section--4">
            <form action="{{ route('admin.app.update-question', $question->id) }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">question</div>
                        <input
                            name="question"
                            type="text"
                            class="dark-form__input dark-form__input--long"
                            autocomplete="off"
                            value="{{ $question->question }}"
                            required
                        >
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">description</div>
                        <input
                            name="description"
                            type="text"
                            class="dark-form__input dark-form__input--long"
                            autocomplete="off"
                            value="{{ $question->description }}"
                        >
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">char limit</div>
                        <input
                            name="char_limit"
                            type="text"
                            class="dark-form__input dark-form__input--short"
                            autocomplete="off"
                            value="{{ $question->char_limit }}"
                            required
                        >
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">parent id</div>
                        <input
                            name="parent_id"
                            type="text"
                            class="dark-form__input dark-form__input--short"
                            autocomplete="off"
                            value="{{ $question->parent_id }}"
                        >
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">type</div>
                        <select name="type" class="dark-form__select">
                            <option {!! $question->type === 'textarea' ? 'selected' : '' !!}>textarea</option>
                            <option {!! $question->type === 'checkbox' ? 'selected' : '' !!}>checkbox</option>
                            <option {!! $question->type === 'section' ? 'selected' : '' !!}>section</option>
                            <option {!! $question->type === 'input' ? 'selected' : '' !!}>input</option>
                        </select>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">relation</div>
                        <select name="relation" class="dark-form__select">
                            <option value="0" {!! $question->relation_type === 0 ? 'selected' : '' !!}>alone</option>
                            <option value="1" {!! $question->relation_type === 1 ? 'selected' : '' !!}>parent</option>
                            <option value="2" {!! $question->relation_type === 2 ? 'selected' : '' !!}>child</option>
                        </select>
                    </div>

                    <div class="dark-form__el dark-form__el--offset">
                        <button type="submit" class="dark-form__button dark-form__button--small">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endcomponent
@endsection
