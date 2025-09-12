@extends('backend.global.master')

@section('title', 'Profile')
@section('heading', 'Profile')


@section('backend_custom_style')
@endsection


@section('backend_content')
   <div class="card card-default mb-4">
        <div class="card-header">
            <h2>
                Profile Edit
            </h2>
            
        </div>
        <div class="card-body">
        <form action="{{ route('profileUpdate') }}" method="post">
            @csrf
                <div class="form-group">
                    <label for="name">Name <span style="color: red;">*</span> </label>
                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email <span style="color: red;">*</span> </label>
                    <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Mobile Number</label>
                    <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}" >
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" autocomplete="new-password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Old Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-success text-center btn-sm">Update</button>
        </form>
         </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
