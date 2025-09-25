@extends('teacher.global.master')

@section('teacher_custom_style')
    <!-- Select2 CSS -->
    <style>
        .cke_chrome {
            width: 100% !important;
        }
    </style>
@endsection

@section('teacher_content')
    <div class="card card-default shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">প্রশ্নপত্র তৈরি করো </h2>
        </div>

        <div class="card-body">
            <!-- Subject Selection -->
            <div class="row mb-4">
                <!-- Subject Selection -->
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for="subject" class="form-label fw-bold">বিষয় নির্বাচন</label>
                        <select id="subject" name="subject" class="form-control select2">
                            <option value="">-- বিষয় নির্বাচন করুন --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>



            <!-- Top Controls -->
            <div class="row mb-3 align-items-center bg-light p-3 rounded shadow-sm">
                <!-- Select All -->
                <div class="col-md-4 mb-2 mb-md-0">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                        <label class="form-check-label fw-semibold" for="selectAll">
                            সব প্রশ্ন নির্বাচন করুন
                        </label>
                    </div>
                </div>

                <!-- Total Questions -->
                <div class="col-md-4 text-center mb-2 mb-md-0">
                    <span id="total-questions" class="fw-semibold text-secondary">০ টি প্রশ্ন</span>
                </div>

                <!-- Selected Questions -->
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-outline-primary w-100 w-md-auto" id="view-selected">
                        <span id="selected-count">নির্বাচিত প্রশ্ন দেখুন (মোট ০টি)</span>
                    </button>
                </div>
            </div>

            <!-- Questions List -->
            <div id="questions-list" class="row g-3 mt-2"></div>
        </div>
    </div>
@endsection

@section('teacher_custom_js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "নির্বাচন করুন",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            // Array to store selected question IDs
            let selectedQuestionIds = [];

            // Initialize Select2
            $('.select2').select2({
                placeholder: "নির্বাচন করুন",
                allowClear: true
            });

            // ===============================
            // Load questions when category changes
            // ===============================
            $('#subject').on('change', function() {
                let categoryId = $(this).val();
                loadQuestions(categoryId);
            });

            // ===============================
            // Function to load questions via AJAX
            // ===============================
            function loadQuestions(categoryId, pageUrl = null) {
                if (!categoryId) {
                    $("#questions-list").html("");
                    $('#selectAll').prop('checked', false);
                    selectedQuestionIds = [];
                    updateSelectedCount();
                    return;
                }

                let url = pageUrl ? pageUrl : "{{ route('getQuestionsByCategory') }}";

                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        category_id: categoryId,
                        selected_ids: selectedQuestionIds
                    },
                    beforeSend: function() {
                        $("#questions-list").html("<p>লোড হচ্ছে...</p>");
                    },
                    success: function(html) {
                        $("#questions-list").html(html);
                        restoreSelections();
                    },
                    error: function() {
                        $("#questions-list").html("<p class='text-danger'>প্রশ্ন লোড করা যায়নি!</p>");
                    }
                });
            }

            // ===============================
            // Restore previously selected checkboxes
            // ===============================
            function restoreSelections() {
                selectedQuestionIds.forEach(function(id) {
                    $('#q' + id).prop('checked', true);
                });

                updateSelectAllCheckbox();
                updateSelectedCount();
            }

            // ===============================
            // Individual question checkbox change
            // ===============================
            $(document).on('change', '.question-checkbox', function() {
                let id = $(this).val();

                if ($(this).is(':checked')) {
                    if (!selectedQuestionIds.includes(id)) selectedQuestionIds.push(id);
                } else {
                    selectedQuestionIds = selectedQuestionIds.filter(e => e != id);
                }

                updateSelectAllCheckbox();
                updateSelectedCount();
            });

            // ===============================
            // Select All checkbox change
            // ===============================
            $(document).on('change', '#selectAll', function() {
                let checked = $(this).is(':checked');

                $(".question-checkbox").prop('checked', checked);

                $(".question-checkbox").each(function() {
                    let id = $(this).val();
                    if (checked) {
                        if (!selectedQuestionIds.includes(id)) selectedQuestionIds.push(id);
                    } else {
                        selectedQuestionIds = selectedQuestionIds.filter(e => e != id);
                    }
                });

                updateSelectedCount();
            });

            // ===============================
            // Pagination link click (AJAX)
            // ===============================
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let categoryId = $('#subject').val();

                if (!categoryId) return;

                loadQuestions(categoryId, url);
            });

            // ===============================
            // Update selected count display
            // ===============================
            function updateSelectedCount() {
                $('#selected-count').text("নির্বাচিত প্রশ্ন দেখুন (মোট " + selectedQuestionIds.length + "টি)");
                $('#total-questions').text($(".question-checkbox").length + " টি প্রশ্ন");
            }

            // ===============================
            // Update Select All checkbox state
            // ===============================
            function updateSelectAllCheckbox() {
                if ($(".question-checkbox").length > 0 &&
                    $(".question-checkbox:checked").length === $(".question-checkbox").length) {
                    $('#selectAll').prop('checked', true);
                } else {
                    $('#selectAll').prop('checked', false);
                }
            }

            // ===============================
            // On page load, restore any pre-checked questions
            // ===============================
            $(".question-checkbox:checked").each(function() {
                let id = $(this).val();
                if (!selectedQuestionIds.includes(id)) selectedQuestionIds.push(id);
            });
            updateSelectAllCheckbox();
            updateSelectedCount();

            $('#view-selected').on('click', function() {
                if(selectedQuestionIds.length === 0) {
                    alert("কোনো প্রশ্ন নির্বাচন করা হয়নি!");
                    return;
                }

                // Send selected IDs as query parameters
                let url = "{{ route('viewSelectedQuestions') }}?ids=" + selectedQuestionIds.join(',');
                window.open(url, '_blank'); // opens in new tab
            });

        });
    </script>
@endsection
