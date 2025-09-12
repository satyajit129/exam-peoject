@extends('backend.global.master')

@section('title', 'User ' . ($user->id ? 'Update' : 'Create'))
@section('heading', 'User ' . ($user->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>User {{ $user->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('userList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('userSave', $user->id ?? '') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="Enter Name"
                        value="{{ old('name', isset($user) ? $user->name : '') }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="Enter Email"
                        value="{{ old('email', isset($user) ? $user->email : '') }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control select2" required>
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ isset($user) && $user->role == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-outline-primary btn-sm">
                    {{ isset($admin->id) ? 'Update' : 'Submit' }}
                </button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
<script>
        $('.select2').select2({
            placeholder: 'Select an option',
        });
    </script>
@endsection
