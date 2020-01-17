@extends('layouts.app', [
    'title' => 'Manage'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage']
    ])
        @if(Auth::user()->isAdmin())
            @foreach($adminSections as $section)
                <a href="{{ route($section['route']) }}">{{$section['title']}}</a> <br>
            @endforeach

            <hr>
        @endif

        @foreach($sections as $section)
            <a href="{{ route($section['route']) }}">{{$section['title']}}</a> <br>
        @endforeach
    @endcomponent
@endsection
