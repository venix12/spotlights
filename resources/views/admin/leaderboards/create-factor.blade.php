@extends('layouts.app', [
    'title' => 'Create factor'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Create factor'],
    ])
        @include('components._header-v2', [
            'icon' => 'random',
            'title' => 'Create factor',
        ])

        <div class="dark-section dark-section--4">
            <form action="{{ route('admin.factors.store', $id) }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">factor</div>
                        <input name="factor" type="text" class="dark-form__input" autocomplete="off" required>
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
