@extends('layouts.app', [
    'title' => 'Users list'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Users', 'List']
    ])
        @include('components._header-v2', [
            'icon' => 'user',
            'title' => 'User List',
        ])

        <div class="dark-section dark-section--4">
            @include('user._list', $membersArray)
        </div>

        @if(Auth::user()->isAdminOrManager())
            <div class="dark-section dark-section--4">
                @include('user._list', ['membersArray' => $moderationArray])
            </div>
        @endif
    @endcomponent
@endsection
