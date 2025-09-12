@extends('backend.global.master')

@section('title', 'Season ' . ($season->id ? 'Update' : 'Create'))
@section('heading', 'Season ' . ($season->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Season {{ $season->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('seasonList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('seasonSave', $season->id ?? '') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="season_name">Season Name</label>
                    <input type="text" class="form-control" placeholder="Enter Season Name" name="season_name"
                        value="{{ old('season_name', $season->season_name ?? '') }}">
                </div>
                <div class="form-group mt-3">
                    <label for="status">Status</label>
                    <select class="form-control" name="status">
                        <option value="1" {{ old('status', $season->status ?? '') == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ old('status', $season->status ?? '') == 0 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm mt-3">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
