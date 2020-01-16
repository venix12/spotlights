@extends('layouts.app', [
    'title' => 'Users list'
])

@section('content')
    @component('components.card', [
        'sections' => ['Home', 'Users', 'List']
    ])
        @include('components._userlist', ['membersArray' => $membersArray])

        <hr>

        @if(Auth::user()->isAdminOrManager())
            @include('components._userlist', ['membersArray' => $moderationArray])
        @endif
    @endcomponent
@endsection
