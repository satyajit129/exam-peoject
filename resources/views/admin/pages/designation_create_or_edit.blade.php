@extends('backend.global.master')

@section('title', 'Designation ' . ($designation->id ? 'Update' : 'Create'))
@section('heading', 'Designation' . ($designation->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Designation {{ $designation->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('designationList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('designationSave', $designation->id?? '') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Designation <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" placeholder="Enter Designation" name="designation" value="{{ old('designation', $designation->designation ?? '') }}"> 
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
