@extends('layouts.app', [
    'title' => 'Reset password'
])

@section('content')
    @component('components.card', [
        'sections' => ['Home', 'Manage', 'Reset password']
    ])

        <form method="POST" action="{{route('password.reset')}}">
        @csrf
            <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                <div class="col-md-5">
                    <input id="username" name="username" type="text" class="form-control" required autofocus>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary">
                        Reset
                    </button>
                </div>
            </div> 
        </form>
    @endcomponent
@endsection