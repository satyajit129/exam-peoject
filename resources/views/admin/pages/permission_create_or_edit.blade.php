@extends('backend.global.master')

@section('title', 'Permission ' . ($permission->id ? 'Update' : 'Create'))
@section('heading', 'Permission ' . ($permission->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Permission {{ $permission->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('permissionList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('permissionSave', $permission->id ?? '') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Permission <span style="color: red;">Ex: (manage_custom_exam_type)</span></label>
                    <input type="text" class="form-control" placeholder="Enter Permission" name="name" value="{{ old('name', $permission->name ?? '') }}"> 
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Bangla Text</label>
                    <input type="text" class="form-control" placeholder="Enter Permission" name="bangla_code" value="{{ old('bangla_code', $permission->bangla_code ?? '') }}"> 
                </div>


                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
