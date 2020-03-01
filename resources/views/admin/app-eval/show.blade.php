@extends('layouts.app', [
    'title' => 'Application evaluation'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Application Evaluation', $cycle->name],
        'size' => 12,
    ])
        @include('components._header', [
            'description' => $cycle->name,
            'modifiers' => [
                $cycle->active ? 'marker' : 'marker-red',
                'previous' => [
                    'route' => 'admin.app-eval',
                    'section' => 'application evaluation',
                ],
            ],
            'title' => 'Application Cycle',
        ])

        <div id="react--app-eval"></div>
    @endcomponent
@endsection

@section('script')
    <script id="json-apps">
        {!! json_encode($appsCollection) !!}
    </script>
@endsection
