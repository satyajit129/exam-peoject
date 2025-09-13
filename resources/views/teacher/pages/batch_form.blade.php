@extends('teacher.global.master')

@section('teacher_custom_style')
    <!-- Bootstrap Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
@endsection

@section('teacher_content')
    <div class="card card-default">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">ফর্ম পূরণ করুন </h2>
            <a href="{{ route('batchList') }}" class="btn btn-primary btn-sm">
                পূর্বের মেনুতে ফিরে যান
            </a>
        </div>
        <div class="card-body">
            <form action="{{ isset($batch) ? route('batchSave', $batch->id) : route('batchSave') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">ব্যাচের নাম</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $batch->name ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="max_students" class="form-label">সর্বোচ্চ শিক্ষার্থী সংখ্যা</label>
                    <input type="number" class="form-control" id="max_students" name="max_students"
                        value="{{ old('max_students', $batch->max_students ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">শুরুর তারিখ</label>
                    <input type="text" class="form-control datepicker" id="start_date" name="start_date"
                        value="{{ old('start_date', isset($batch) ? $batch->start_date : '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">শেষ তারিখ</label>
                    <input type="text" class="form-control datepicker" id="end_date" name="end_date"
                        value="{{ old('end_date', isset($batch) ? $batch->end_date : '') }}">
                </div>


                <div class="mb-3">
                    <label for="status" class="form-label">স্ট্যাটাস</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" {{ old('status', $batch->status ?? '') == 'active' ? 'selected' : '' }}>
                            সক্রিয়</option>
                        <option value="inactive" {{ old('status', $batch->status ?? '') == 'inactive' ? 'selected' : '' }}>
                            নিষ্ক্রিয়</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        {{ isset($batch) ? 'আপডেট করুন' : 'সংরক্ষণ করুন' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('teacher_custom_js')
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd', // match DB format
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
    
@endsection
