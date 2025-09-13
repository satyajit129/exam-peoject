@extends('teacher.global.master')

@section('teacher_content')
<div class="card card-default">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">{{ isset($category) ? 'ক্যাটাগরি সম্পাদনা করুন' : 'নতুন ক্যাটাগরি যোগ করুন' }}</h2>
        <a href="{{ route('questionCategoryList') }}" class="btn btn-primary btn-sm">ফিরে যান</a>
    </div>
    <div class="card-body">
        <form action="{{ isset($category) ? route('questionCategorySave',$category->id) : route('questionCategorySave') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">ক্যাটাগরির নাম</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$category->name ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">প্যারেন্ট ক্যাটাগরি</label>
                <select name="parent_id" class="form-control">
                    <option value="">-- নেই --</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id',$category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">অবস্থা</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status',$category->status ?? '') == 'active' ? 'selected' : '' }}>সক্রিয়</option>
                    <option value="inactive" {{ old('status',$category->status ?? '') == 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                </select>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">{{ isset($category) ? 'আপডেট করুন' : 'সংরক্ষণ করুন' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
