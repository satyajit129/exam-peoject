@extends('backend.global.master')

@section('title', 'Work Location ' . ($work_location->id ? 'Update' : 'Create'))
@section('heading', 'Work Location ' . ($work_location->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Work Location {{ $work_location->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('workLocationList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('workLocationSave', $work_location->id?? '') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Work Location</label>
                    <input type="text" class="form-control" placeholder="Enter Work Location" name="name" value="{{ old('name', $work_location->name ?? '') }}"> 
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Address</label>
                    <input type="text" class="form-control" placeholder="Enter Work Location Address" name="address" value="{{ old('address', $work_location->address ?? '') }}"> 
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Contact No</label>
                    <input type="text" class="form-control" placeholder="Enter Contact No" name="contact_no" value="{{ old('contact_no', $work_location->contact_no ?? '') }}"> 
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
