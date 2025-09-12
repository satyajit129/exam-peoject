@extends('backend.global.master')

@section('title', 'Shift ' . ($shift->id ? 'Update' : 'Create'))
@section('heading', 'Shift ' . ($shift->id ? 'Update' : 'Create'))

@section('backend_custom_style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <style>
        .weekday-section {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .weekday-header {
            background-color: #f8f9fa;
            padding: 0.5rem;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }

        .time-input-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .weekend-indicator {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 0.5rem;
            border-radius: 0.25rem;
            margin-top: 0.5rem;
        }
    </style>
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Shift {{ $shift->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('shiftList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('shiftSave', $shift->id ?? '') }}" method="post" id="shiftForm">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="shift_name">Shift Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Shift Name" name="shift_name"
                                id="shift_name" value="{{ old('shift_name', $shift->shift_name ?? '') }}" required>
                            @error('shift_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
