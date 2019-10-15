@extends('layouts.app', [
    'title' => 'Create spotlights'
])

@section('content')
    @component('components.card', [
        'sections' => ['Home', 'Manage', 'Create new spotlights']
    ])
        <form action={{route('admin.createSpotlights')}} method="POST">
            @csrf
            <div class="form-group row">
                <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

                <div class="col-md-6">
                    <input id="title" type="text" class="form-control" name="title" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                <div class="col-md-6">
                    <input id="description" type="text" class="form-control" name="description" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="deadline" class="col-md-4 col-form-label text-md-right">Deadline (YYYY-MM-DD)</label>

                <div class="col-md-6">
                    <input id="deadline" type="text" class="form-control @error('deadline') is-invalid @enderror" name="deadline" required>

                    @error('deadline')
                        <span class="invalid-feedback" role="alert">
                            <strong>Deadline format is invalid!</strong>
                        </span>
                    @enderror

                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="osu" id="osu" >
                        <label class="form-check-label" for="osu">
                            osu
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="taiko" id="taiko" >
                        <label class="form-check-label" for="osu">
                            taiko
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="catch" id="catch" >
                        <label class="form-check-label" for="osu">
                            catch
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="mania" id="mania" >
                        <label class="form-check-label" for="osu">
                            mania
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-4 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create!') }}
                    </button>
                </div>
            </div>
        </form>
    @endcomponent
@endsection