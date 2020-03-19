@extends('layouts.app', [
    'title' => 'Manage usergroups'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage usergroups']
    ])
        @include('components._header', [
            'title' => 'Manage usergroups'
        ])

        @foreach($groups as $group)
            <div class="dark-section">
                <div class="space-between">
                    <span style="color: {{ $group->group_color }}">{{ $group->identifier }}</span>
                    <div>
                        Members: {{ $group->membersCount() }}
                        <a href="{{ route('admin.user-groups.show', ['id' => $group->id]) }}" class="dark-form__button" style="margin-left: 10px">
                            <i class="fa fa-cog"></i> Manage
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        <a href="{{ route('admin.user-groups.create') }}"class="dark-form__button dark-form__button--radius-square dark-form__button--small">
            <i class="fa fa-plus"></i> Add usergroup
        </a>

    @endcomponent
@endsection
