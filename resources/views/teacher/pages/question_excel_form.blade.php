@extends('teacher.global.master')

@section('teacher_content')
<div class="card card-default">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">এক্সেল ফাইল আপলোড করুন </h2>
    </div>
    <div class="card-body">
        <form action="{{ route('questionUploadExcel') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="category_id">ক্যাটাগরি</label>
        <select name="category_id" id="category_id" class="form-control select2" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="excel_file">Excel File</label>
        <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx,.xls" required>
    </div>

    <button type="submit" class="btn btn-primary">Upload Questions</button>
</form>

    </div>
</div>
@endsection
@section('teacher_custom_js')

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "প্রশ্ন লিখুন ",
            });
        });
    </script>
@endsection
