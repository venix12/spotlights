@extends('layouts.app', [
    'title' => 'Added user'
])

@section('content')
    @component('components.card', [
        'sections' => [$value]
    ])
        @if($registeredUsername && $token)
            Username: {{$registeredUsername}} <br /> <br />
            Token (password): {{$token}} <br />
        @else
            No register data found in the session.
        @endif
    @endcomponent
@endsection
