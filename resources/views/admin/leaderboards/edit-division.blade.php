@extends('layouts.app', [
    'title' => 'Edit division'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Edit division'],
    ])
        @include('components._header-v2', [
            'icon' => 'random',
            'title' => 'Edit division',
        ])

        <div class="dark-section dark-section--4">
            <form action="{{ route('admin.divisions.update', $division->id) }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">name</div>
                        <input name="name" type="text" class="dark-form__input dark-form__input--long" autocomplete="off" value="{{ $division->name }}" required>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">threshold</div>
                        <input name="threshold" type="text" class="dark-form__input" autocomplete="off" value="{{ $division->threshold }}" required>
                    </div>

                    <div class="dark-form__el dark-form__el--offset">
                        <input type="checkbox" name="absolute" {!! $division->absolute ? 'checked' : '' !!}> absolute?
                    </div>

                    <div class="dark-form__el dark-form__el--offset">
                        <button type="submit" class="dark-form__button">
                            <i class="fa fa-check"></i> Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endcomponent
@endsection
