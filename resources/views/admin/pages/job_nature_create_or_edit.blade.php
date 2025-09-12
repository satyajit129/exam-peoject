@extends('backend.global.master')

@section('title', 'Job Nature ' . ($job_nature->id ? 'Update' : 'Create'))
@section('heading', 'Job Nature ' . ($job_nature->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Job Nature {{ $job_nature->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('jobNatureList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('jobNatureSave', $job_nature->id?? '') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Job Nature <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" placeholder="Enter Job Nature" name="name" value="{{ old('name', $job_nature->name ?? '') }}"> 
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
