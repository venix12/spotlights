@extends('layouts.app', [
    'title' => 'Added user'
])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$value}}</div>
                <div class="card-body">
                    @if($registeredUsername && $token)
                        Username: {{$registeredUsername}} <br /> <br />
                        Token (password): {{$token}} <br />
                    @else
                        No register data found in the session.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
