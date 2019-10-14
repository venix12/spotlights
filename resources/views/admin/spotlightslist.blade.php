@extends('layouts.app', [
    'title' => 'Manage spotlights'
])

@section('content')
    @component('components.card', [
        'sections' => ['Home', 'Manage', 'Manage spotlights']
    ])
        @include('layouts.session')
        <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Creation date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spotlights as $spotlight)
                <tr>
                    <td><a href={{route('spotlights.show', ['id' => $spotlight->id])}}>{{$spotlight->title}}</a></td>
                    <td>{{$spotlight->created_at}}</td>
                    <td>
                        <div class="row">
                            @php

                                if ($spotlight->active == 1)
                                {
                                    $activeValue = "deactivate";
                                } else {
                                    $activeValue = "activate";
                                }

                            @endphp
                            <form action={{route('admin.'.$activeValue.'Spotlights')}} method="POST">
                            @csrf
                            <input type="hidden" id="spotlightsID" name="spotlightsID" value="{{$spotlight->id}}">
                            <input onclick="return confirm('Are you sure you want to {{$activeValue}} {{$spotlight->title}}?')" class="btn btn-dark btn-sm" type="submit" value={{ucfirst($activeValue)}}>
                            </form>&nbsp;&nbsp;
                            @if(Auth::user()->isAdmin())
                                <form action={{route('admin.removeSpotlights')}} method="POST">
                                    @csrf
                                    <input type="hidden" id="spotlightsID" name="spotlightsID" value="{{$spotlight->id}}">
                                    <input onclick="return confirm('Are you sure you want to remove {{$spotlight->title}}?')" class="btn btn-danger btn-sm" type="submit" value="Remove">
                                    @if($spotlight->released == 0)
                                        &nbsp;<button onclick="return confirm('Are you sure you want to mark {{$spotlight->title}} as released?')" type="submit" formaction={{route('spotlights.release')}} class="btn btn-warning btn-sm" type="submit">Release</button>
                                    @endif
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    @endcomponent
@endsection