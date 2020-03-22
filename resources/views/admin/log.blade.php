@extends('layouts.app', [
    'title' => 'Log'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Log']
    ])

        @include('components._header-v2', [
            'description' => 'we see everything',
            'icon' => 'list',
            'title' => 'Log',
        ])

        <table class="table table-dark table-sm">
            <thead class="thead-light">
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="medium-font">
                @foreach($events as $event)
                    <tr id={{$event->id}}>
                        <td>{{ format_date($event->created_at, true) }}</td>
                        <td>
                            <a href={{route('user.profile', ['id' => $event->user_id])}} style="color: {{ $event->user->color }}">
                                {{ $event->user->username }}
                            </a>
                        </td>
                        <td title="{{ strlen($event->action) > 54 ? $event->action : '' }}">{{ truncate_text($event->action, 54) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $events->links() }}
        </div>
    @endcomponent
@endsection
