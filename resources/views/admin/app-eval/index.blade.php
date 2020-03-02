@extends('layouts.app', [
    'title' => 'Application evaluation'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Application evaluation']
    ])
        @include('components._header', [
            'title' => 'Application evaluation'
        ])

        @foreach($cycles as $cycle)
            <div class="dark-section">
                <div class="space-between">
                    <span>{{ $cycle->name }}</span>
                    <div>
                        Applicants: {{ count($cycle->applications) }}
                        <a href="{{ route('admin.app-eval.show', ['id' => $cycle->id]) }}" class="dark-form__button dark-form__button--left">
                            <i class="fa fa-cog"></i> Evaluation panel
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        @if(Auth::user()->isAdmin())
            <div class="space-between">
                <a href="{{ route('admin.app-eval.create-cycle') }}" class="dark-form__button">
                    <i class="fa fa-plus"></i> Create new app cycle
                </a>

                @if (App\AppCycle::isActive())
                    <a href="{{ route('admin.app-eval.deactivate-current-cycle') }}" class="dark-form__button">
                        <i class="fa fa-trash"></i> Close current app cycle
                    </a>
                @endif
            </div>
        @endif

    @endcomponent
@endsection
