@extends('layouts.app', [
    'title' => 'Home'
])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Welcome to the spotlights, {{Auth::user()->username}}</h3>
                    there's nothing here at the moment...
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
