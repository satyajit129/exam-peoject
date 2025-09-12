@extends('backend.global.master')

@section('title', 'Leave Type ' . ($leave_type->id ? 'Update' : 'Create'))
@section('heading', 'Leave Type ' . ($leave_type->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Leave Type {{ $leave_type->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('leaveTypeList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('leaveTypeSave', $leave_type->id?? '') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Leave Type</label>
                    <input type="text" class="form-control" placeholder="Enter Leave Type" name="name" value="{{ old('name', $leave_type->name ?? '') }}"> 
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
