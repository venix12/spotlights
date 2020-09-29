@extends('layouts.app', [
    'title' => 'Edit factor'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Edit factor'],
    ])
        @include('components._header-v2', [
            'icon' => 'random',
            'title' => 'Edit factor',
        ])

        <div class="dark-section dark-section--4">
            <form action="{{ route('admin.factors.update', $factor->id) }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">factor</div>
                        <input name="factor" type="text" class="dark-form__input" autocomplete="off" value="{{ $factor->factor }}" required>
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
