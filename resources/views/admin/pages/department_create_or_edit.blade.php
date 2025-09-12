@extends('backend.global.master')

@section('title', 'Department ' . ($department->id ? 'Update' : 'Create'))
@section('heading', 'Department ' . ($department->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Department {{ $department->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('departmentList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('departmentSave', $department->id?? '') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Designation<span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" placeholder="Enter Department" name="department" value="{{ old('department', $department->department ?? '') }}"> 
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
