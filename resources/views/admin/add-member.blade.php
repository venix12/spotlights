@extends('layouts.app', [
    'title' => 'Add member'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Add member'],
    ])
        @include('components._header-v2', [
            'icon' => 'user',
            'title' => 'add new members',
        ])

        <div class="dark-section dark-section--4">
            <form action="{{ route('admin.add-member.store') }}" method="POST">
                @csrf

                <div class="dark-form">
                    <div class="dark-form__el">
                        <div class="dark-form__label">username</div>
                        <input name="username" type="text" class="dark-form__input" autocomplete="off" required>
                    </div>

                    <div class="dark-form__el">
                        <div class="dark-form__label">gamemode</div>
                        <select name="gamemode" class="dark-form__select">
                            <option>osu</option>
                            <option>mania</option>
                            <option>taiko</option>
                            <option>catch</option>
                        </select>
                    </div>

                    <div class="dark-form__el dark-form__el--offset">
                        <button type="submit" class="dark-form__button">
                            <i class="fa fa-check"></i> Add member!
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endcomponent
@endsection
