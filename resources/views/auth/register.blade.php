@extends('layouts.app', [
    'title' => 'Add user'
])

@section('content')
    @component('components.card', [
        'sections' => ['Home', 'Manage', 'Add user']
    ])
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
                <label for="osu_user_id" class="col-md-4 col-form-label text-md-right">{{ __('User ID') }}</label>

                <div class="col-md-6">
                    <input id="osu_user_id" type="text" class="form-control @error('osu_user_id') is-invalid @enderror" name="osu_user_id" value="{{ old('osu_user_id') }}" required autofocus>

                    @error('osu_user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            @php
                session(['passwordToken' => bin2hex(random_bytes(15))]);
            @endphp

            <div class="form-group row">
                <label for="mode" class="col-md-4 col-form-label text-md-right">{{ __('Gamemode') }}</label>

                <div class="col-md-3">
                    <select class="custom-select mr-sm-2" id="mode" name="mode" required>
                        <option selected value="">Choose...</option>
                        <option value="osu">osu!</option>
                        <option value="taiko">osu!taiko</option>
                        <option value="catch">osu!catch</option>
                        <option value="mania">osu!mania</option>
                    </select>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Add User') }}
                    </button>
                </div>
            </div>
        </form>
    @endcomponent
@endsection
