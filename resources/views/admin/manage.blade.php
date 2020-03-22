@extends('layouts.app', [
    'title' => 'Manage'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage']
    ])
        @include('components._header-v2', [
            'description' => 'do your secret stuff here',
            'icon' => 'wrench',
            'title' => 'Management Panel',
        ])

        @if (Auth::user()->isAdmin())
            <div class="dark-section dark-section--4">
                @foreach($adminSections as $section)
                    <a href="{{ route($section['route']) }}">{{$section['title']}}</a> <br>
                @endforeach
            </div>

            <hr>
        @endif

        <div class="dark-section dark-section--4">
            @foreach($sections as $section)
                <a href="{{ route($section['route']) }}">{{$section['title']}}</a> <br>
            @endforeach
        </div>
    @endcomponent
@endsection
