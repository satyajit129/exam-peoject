@extends('backend.global.master')

@section('title', 'Holiday Type ' . ($holidayType->id ? 'Update' : 'Create'))
@section('heading', 'Holiday Type ' . ($holidayType->id ? 'Update' : 'Create'))

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>{{ $holidayType->id ? 'Update' : 'Create' }} Holiday Type</h2>
            <a href="{{ route('holidayTypeList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To List</a>
        </div>
        <div class="card-body">
            <form action="{{ route('holidayTypeSave', $holidayType->id ?? '') }}" method="post">
                @csrf

                <div class="mb-3">
                    <label>Holiday Type Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="Enter Holiday Type Name"
                        value="{{ old('name', $holidayType->name ?? '') }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-outline-primary btn-sm">
                    {{ $holidayType->id ? 'Update' : 'Submit' }}
                </button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
