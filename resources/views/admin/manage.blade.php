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

        <div class="dark-section dark-section--4">
            @if (Auth::user()->isAdmin())
                <div class="info-panel">
                    <div class="info-panel__header">Admin sections</div>
                    @foreach($adminSections as $section)
                        <a href="{{ route($section['route']) }}">{{$section['title']}}</a> <br>
                    @endforeach
                </div>
            @endif

            @if (Auth::user()->isAdminOrManager())
                <div class="info-panel">
                    <div class="info-panel__header">Manager sections</div>
                    @foreach($managerSections as $section)
                        <a href="{{ route($section['route']) }}">{{$section['title']}}</a> <br>
                    @endforeach
                </div>
            @endif

            <div class="info-panel">
                <div class="info-panel__header">Team Leader sections</div>
                @foreach($sections as $section)
                    <a href="{{ route($section['route']) }}">{{$section['title']}}</a> <br>
                @endforeach
            </div>
        </div>
    @endcomponent
@endsection
