@extends('layouts.app', [
    'title' => 'Manage spotlights'
])

@section('content')
    @component('components.card', [
        'dark' => true,
        'sections' => ['Home', 'Manage', 'Manage spotlights'],
    ])
        @include('components._header-v2', [
            'icon' => 'star',
            'title' => 'Manage Spotlights',
        ])

        <table class="table table-dark">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Creation date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($spotlights as $spotlight)
                    <tr>
                        <td>
                            <a href={{route('spotlights.show', ['id' => $spotlight->id])}}>
                                {{$spotlight->title}}
                            </a>
                        </td>
                        <td>{{$spotlight->created_at}}</td>
                        <td>
                            <div class="row">

                                @php
                                    $activeValue = $spotlight->active ? 'deactivate' : 'activate';
                                @endphp

                                <form action={{route("admin.{$activeValue}Spotlights")}} method="POST">
                                    @csrf

                                    <input type="hidden" id="spotlightsID" name="spotlightsID" value="{{$spotlight->id}}">

                                    <button
                                        type="submit"
                                        class="dark-form__button"
                                        onclick="return confirm('Are you sure you want to {{$activeValue}} {{$spotlight->title}}?')"
                                    >
                                        <i class="fa fa-lock"></i> {{ studly_case($activeValue) }}
                                    </button>

                                    @if(Auth::user()->isAdmin() && $spotlight->released !== true)
                                        <button
                                            type="submit"
                                            class="dark-form__button"
                                            formaction="{{route('spotlights.release')}}"
                                            onclick="return confirm('Are you sure you want to mark {{$spotlight->title}} as released?')"
                                        >
                                            <i class="fa fa-star"></i> Release
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endcomponent
@endsection
