@extends('backend.global.master')

@section('title', 'Bank ' . ($bank->id ? 'Update' : 'Create'))
@section('heading', 'Bank ' . ($bank->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Bank {{ $bank->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('bankList') }}" class="btn btn-outline-primary btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('bankSave', $bank->id ?? '') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Bank Name</label>
                    <input type="text" class="form-control" placeholder="Enter Bank Name" name="name"
                        value="{{ old('name', $bank->name ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Account No <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" placeholder="Enter Account No" name="acc_no"
                        value="{{ old('acc_no', $bank->acc_no ?? '') }}">
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
