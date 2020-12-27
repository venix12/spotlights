@extends('layouts.app', [
    'title' => 'Application form',
])

@section('content')
    @component('components.card', [
        'sections' => ['Home', 'Application form'],
        'size' => 9,
    ])
        @include('components._header-v2', [
            'icon' => 'users',
            'title' => 'Application to the osu! Spotlights Team'
        ])

        @if(App\Models\AppCycle::isActive() || Auth::user()->isAdmin())
            @if (!App\Models\AppCycle::isActive() && Auth::user()->isAdmin())
                <div class="dark-section dark-section--2 d-flex justify-content-center text-lightgray">
                    there's no active app cycle at the moment - only admins can see this
                </div>
            @endif

            <div id="react--app-form"></div>
        @else
            <div class="dark-section dark-section--3 d-flex justify-content-center text-lightgray">
                there's no active application cycle at the moment!
            </div>
        @endif
    @endcomponent
@endsection

@section('script')
    <script id="json-modes">
        {!! json_encode($availableModes) !!}
    </script>

    <script id="json-questions">
        {!! json_encode($questionsCollection) !!}
    </script>
@endsection
