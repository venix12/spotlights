@extends('layouts.app', [
    'title' => 'Manage application form'
])

@section('content')
<div class="container">
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage application form']
    ])
        <form action="{{ route('admin.app.store-question') }}" method="POST">
            @csrf

            <div class="dark-form">
                <div class="dark-form__el">
                    <div class="dark-form__label">question</div>
                    <input name="question" type="text" class="dark-form__input dark-form__input--long" autocomplete="off" required>
                </div>

                <div class="dark-form__el">
                    <div class="dark-form__label">characters</div>
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

                <div class="dark-form__el dark-form__el--offset">
                    <button type="submit" class="dark-form__button">
                        <i class="fa fa-check"></i> Create
                    </button>
                </div>
            </div>
        </form>

        <h5>Active questions</h5>
        <div class="dark-section">
            @foreach($questionsActive as $question)
                {{$question->question}}

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

        <h5>Deleted questions</h5>
        <div class="dark-section">
            @foreach($questionsDeleted as $question)
                {{$question->question}}

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
    @endcomponent
@endsection
