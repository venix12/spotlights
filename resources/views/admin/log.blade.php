@extends('layouts.app', [
    'title' => 'Log'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Log']
    ])

        @include('components._header', [
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
            <tbody>
                @foreach($events as $event)
                    <tr id={{$event->id}}>
                        <td class="medium-font">{{ format_date($event->created_at, true) }}</td>
                        <td class="medium-font">
                            <a href={{route('user.profile', ['id' => $event->user_id])}} style="color: {{ $event->user->color }}">
                                {{ $event->user->username }}
                            </a>
                        </td>
                        <td class="medium-font">{{ $event->action }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endcomponent
@endsection
