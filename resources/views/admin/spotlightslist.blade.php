@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Spotlights list') }}</div>

                <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('error')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
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
                                        <form action={{route('admin.removeSpotlights')}} method="POST">
                                            @csrf
                                            <input type="hidden" id="spotlightsID" name="spotlightsID" value="{{$spotlight->id}}">
                                            <input onclick="return confirm('Are you sure you want to remove {{$spotlight->title}}?')" class="btn btn-danger btn-sm" type="submit" value="Remove">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection