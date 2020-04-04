@extends('layouts.app', [
    'title' => 'Manage application form'
])

@section('content')
<div class="container">
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage application form']
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
                        <div class="dark-form__label">char limit</div>
                        <input name="char_limit" type="text" class="dark-form__input dark-form__input--short" autocomplete="off" required>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">type</div>
                        <select name="type" class="dark-form__select">
                            <option>textarea</option>
                            <option>checkbox</option>
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
            <div class="info-panel">
                <div class="info-panel__header">Active questions</div>
                @foreach($questionsActive as $question)
                    {{$question->question}}
                    <form action="{{ route('admin.app.delete-revert-question') }}" method="POST" style="display: inline-flex">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <button type="submit" class="dark-form__button dark-form__button--left dark-form__button--tiny">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>

                    <ul>
                        <li>
                            <span class="text-lightgray">
                                type: {{$question->type}}
                            </span>
                        </li>

                        <li>
                            <span class="text-lightgray">
                                required: {{ $question->required ? 'true' : 'false' }}
                            </span>
                        </li>

                        <li>
                            <span class="text-lightgray">
                                character limit: {{$question->char_limit}}
                            </span>
                        </li>
                    </ul>
                @endforeach
            </div>

            <div class="info-panel">
                <div class="info-panel__header">Deleted questions</div>
                @foreach($questionsDeleted as $question)
                    {{$question->question}}
                    <form action="{{ route('admin.app.delete-revert-question') }}" method="POST" style="display: inline-flex">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <button type="submit" class="dark-form__button dark-form__button--left dark-form__button--tiny">
                            <i class="fa fa-refresh"></i> Revert
                        </button>
                    </form>

                    <ul>
                        <li>
                            <span class="text-lightgray">
                                required: {{ $question->required ? 'true' : 'false' }}
                            </span>
                        </li>

                        <li>
                            <span class="text-lightgray">
                                character limit: {{$question->char_limit}}
                            </span>
                        </li>
                    </ul>
                @endforeach
            </div>
        </div>
    @endcomponent
@endsection
