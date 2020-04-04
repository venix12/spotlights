@extends('layouts.app', [
    'title' => 'Application evaluation'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Application Evaluation', $cycle->name],
        'size' => 12,
    ])
        @include('components._header-v2', [
            'icon' => 'check',
            'title' => 'Application Evaluation'
        ])

        <div id="react--app-eval"></div>
    @endcomponent
@endsection

@section('script')
    <script id="json-apps">
        {!! json_encode($appsCollection) !!}
    </script>
@endsection
