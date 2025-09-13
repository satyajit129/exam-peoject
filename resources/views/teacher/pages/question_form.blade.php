@extends('teacher.global.master')

@section('teacher_custom_style')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('teacher_content')
<div class="card card-default">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">{{ isset($question) ? 'প্রশ্ন সম্পাদনা করুন' : 'নতুন প্রশ্ন যোগ করুন' }}</h2>
        <a href="{{ route('questionList') }}" class="btn btn-primary btn-sm">ফিরে যান</a>
    </div>
    <div class="card-body">
        <form action="{{ isset($question) ? route('questionSave', $question->id) : route('questionSave') }}"
              method="POST">
            @csrf

            <!-- Question Category -->
            <div class="mb-3">
                <label for="category_id" class="form-label">ক্যাটাগরি</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- ক্যাটাগরি নির্বাচন করুন --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $question->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Question Text -->
            <div class="mb-3">
                <label for="question_text" class="form-label">প্রশ্ন</label>
                <textarea name="question_text" class="form-control" rows="3" required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
            </div>

            <!-- Options -->
            <div class="mb-3">
                <label class="form-label">উত্তরের বিকল্পসমূহ (৪টি)</label>
                @for ($i = 0; $i < 4; $i++)
                    <div class="input-group mb-2">
                        <span class="input-group-text">
                            <input type="radio" name="correct_option" value="{{ $i }}"
                                {{ isset($question->options[$i]) && $question->options[$i]->is_correct ? 'checked' : '' }}>
                        </span>
                        <input type="text" name="options[]" class="form-control"
                            placeholder="উত্তর {{ $i + 1 }}"
                            value="{{ old('options.' . $i, $question->options[$i]->option_text ?? '') }}" required>
                    </div>
                @endfor
                <small class="text-muted">সঠিক উত্তর নির্বাচন করতে রেডিও বাটন ব্যবহার করুন</small>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">বর্ণনা (ঐচ্ছিক)</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $question->description->description ?? '') }}</textarea>
            </div>

            <!-- Previous Exams -->
            <div class="mb-3">
                <label for="previous_exam_ids" class="form-label">পূর্ববর্তী পরীক্ষাসমূহ (ঐচ্ছিক)</label>
                @php
    $selectedExams = old('previous_exam_ids', []);
    if(isset($question)) {
        $selectedExams = old('previous_exam_ids', $question->previousExams->pluck('id')->toArray());
    }
@endphp

<select name="previous_exam_ids[]" class="form-control select2" multiple>
    @foreach ($exams as $exam)
        <option value="{{ $exam->id }}" 
            {{ in_array($exam->id, $selectedExams) ? 'selected' : '' }}>
            {{ $exam->name }}
        </option>
    @endforeach
</select>


            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">অবস্থা</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', $question->status ?? '') == 'active' ? 'selected' : '' }}>
                        সক্রিয়
                    </option>
                    <option value="inactive" {{ old('status', $question->status ?? '') == 'inactive' ? 'selected' : '' }}>
                        নিষ্ক্রিয়
                    </option>
                </select>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">{{ isset($question) ? 'আপডেট করুন' : 'সংরক্ষণ করুন' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('teacher_custom_js')
    <!-- jQuery & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "পরীক্ষা নির্বাচন করুন অথবা নতুন লিখুন",
                tags: true, // allow new exam creation
                allowClear: true
            });
        });
    </script>
@endsection
