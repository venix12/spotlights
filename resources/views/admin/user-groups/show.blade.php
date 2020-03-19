@extends('layouts.app', [
    'title' => 'Manage usergroups'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage usergroups', $group->identifier]
    ])
        @include('components._header', [
            'modifiers' => ['previous' => [
                'route' => 'admin.user-groups',
                'section' => 'manage usergroups',
                ],
            ],
            'title' => "{$group->identifier} usergroup",
        ])

        <div class="info-panel">
            <div class="info-panel__header">Info</div>
            <div>Identifier: {{ $group->identifier }}</div>
            <div>Name: {{ $group->name }}</div>
            <div>Permissions: {{ $group->perm_set }}</div>
            <div>
                Color:
                <span style="color: {{ $group->group_color }}">
                    {{ $group->group_color ?? 'no color...' }}
                </span>
            </div>
            <div>Title: {{ $group->title ?? 'no title...' }}</div>
            <div>Visible: {{ $group->hidden ? 'false' : 'true'}}</div>
            <div>Hierarchy: {{ $group->hierarchy }}</div>
        </div>

        <div class="info-panel">
            <div class="info-panel__header">Members</div>
            @foreach($group->members as $member)
                <div>
                    <form
                        class="d-inline"
                        action="{{ route('admin.user-groups.remove-member', ['id' => $group->id]) }}"
                        method="POST"
                    >
                        @csrf

                        <input name="user_id" type="hidden" value="{{ $member->id }}">

                        <button
                            class="button-invisible"
                            title="remove from the usergroup"
                            onclick="return confirm('are you sure?')"
                        >
                            &times;
                        </button>
                    </form>
                    <a href="{{ route('user.profile', $member->id)}}">{{ $member->username }}</a>
                </div>
            @endforeach
        </div>

        <form action="{{ route('admin.user-groups.add-member', ['id' => $group->id]) }}" method="POST">
            @csrf

            <input class="dark-form__input dark-form__input--inline" type="text" name="username" autocomplete="off">

            <button type="submit" class="dark-form__button dark-form__button--left dark-form__button--small dark-form__button--radius-square" onclick="return confirm('are you sure?')">
                <i class="fa fa-plus"></i> Add user
            </button>
        </form>

    @endcomponent
@endsection
