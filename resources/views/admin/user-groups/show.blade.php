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

        <h5>Info</h5>
        <div class="card-body bg-dark">
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

        <br>

        <h5>Members</h5>
        <div class="card-body bg-dark">
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
                    {{ $member->username }}
                </div>
            @endforeach
        </div>

        <br>

        <form action="{{ route('admin.user-groups.add-member', ['id' => $group->id]) }}" method="POST">
            @csrf

            <input class="dark-form__input dark-form__input--inline" type="text" name="username" autocomplete="off">

            <button type="submit" class="dark-form__button" onclick="return confirm('are you sure?')">
                <i class="fa fa-plus"></i> Add user
            </button>
        </form>

    @endcomponent
@endsection
