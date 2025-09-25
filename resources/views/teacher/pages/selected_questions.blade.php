
@extends('teacher.global.master')

@section('teacher_custom_style')
    <style>
        .question-container {
            position: relative;
            z-index: 1;
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px dashed #ccc;
            display: flex;
            flex-direction: column;
        }

        .option-list {
            margin-left: 20px;
        }
    </style>
@endsection

@section('teacher_content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card p-3 shadow-sm">
                <h5>কাস্টমাইজেশন প্যানেল</h5>
                <hr>
                <div class="border p-1">
                    <p class="text-center mb-3">জেনারেল সেটিংস </p>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <p>টাইটেল</p>
                            <div>
                                <label class="switch switch-text switch-outline-alt-primary form-control-label">
                                    <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>


                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>ঠিকানা</p>
                            <div>
                                <label class="switch switch-text switch-outline-alt-primary form-control-label">
                                    <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>


                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>তারিখ</p>
                            <div>
                                <label class="switch switch-text switch-outline-alt-primary form-control-label">
                                    <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>


                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>বিষয়</p>
                            <div>
                                <label class="switch switch-text switch-outline-alt-primary form-control-label">
                                    <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>


                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>সময়</p>
                            <div>
                                <label class="switch switch-text switch-outline-alt-primary form-control-label">
                                    <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>


                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>পরীক্ষার্থীর তথ্য </p>
                            <div>
                                <label class="switch switch-text switch-outline-alt-primary form-control-label">
                                    <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>


                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>OMR যুক্ত</p>
                            <div>
                                <label class="switch switch-text switch-outline-alt-primary form-control-label">
                                    <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>


                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>জলছাপ </p>
                            <div>
                                <label class="switch switch-text switch-outline-alt-primary form-control-label">
                                    <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p>এডিট করুন</p>
                            <div>
                                <label class="switch switch-text switch-outline-alt-primary form-control-label">
                                    <input type="checkbox" class="switch-input form-check-input" value="on" checked>
                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="border p-1">
                    <p class="text-center mb-3">প্রশ্নপত্র ফরম্যাট সেটিংস </p>
                    <div class="form-group">
                        <div class="d-flex flex-column">
                            <p>কলাম সংখ্যা</p>
                            <div class="w-100">
                                <div class="btn-group w-100" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-outline-primary">1</button>
                                    <button type="button" class="btn btn-outline-primary">2</button>
                                    <button type="button" class="btn btn-outline-primary">3</button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column">
                            <p>অপশন স্টাইল</p>
                            <div class="w-100">
                                <div class="btn-group w-100" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-outline-primary"><i
                                            class="mdi mdi-circle"></i></button>
                                    <button type="button" class="btn btn-outline-primary">"."</button>
                                    <button type="button" class="btn btn-outline-primary">"()"</button>
                                    <button type="button" class="btn btn-outline-primary">")"</button>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="d-flex flex-column">
                            <p>বহুনির্বাচনি লেভেল </p>
                            <div class="w-100">
                                <div class="btn-group w-100" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-outline-primary"> ক , খ , গ </button>
                                    <button type="button" class="btn btn-outline-primary">a,b,c</button>
                                    <button type="button" class="btn btn-outline-primary">1,2,3</button>
                                    <button type="button" class="btn btn-outline-primary">i, ii, iii</button>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="d-flex flex-column">
                            <p>বহুনির্বাচনি কলাম সংখ্যা</p>
                            <div class="w-100">
                                <div class="btn-group w-100" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-outline-primary">1</button>
                                    <button type="button" class="btn btn-outline-primary">2</button>
                                    <button type="button" class="btn btn-outline-primary">3</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <button id="print-btn" class="btn btn-success btn-sm w-100 mt-3">প্রিন্ট করুন</button>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <h3 id="preview-title"></h3>
                    <div id="questions-wrapper" class="d-flex flex-wrap gap-3">
                        @foreach ($questions as $index => $question)
                            <div class="question-container border p-2" style="flex:1 0 100%; position:relative;">
                                <div class="question-text"><strong>{{ $index + 1 }}.
                                        {{ $question->question_text }}</strong></div>

                                <!-- Correct Option on right side -->
                                @if ($question->correctOption)
                                    <div class="correct-option text-success"
                                        style="position:absolute; top:10px; right:10px; font-weight:bold;">
                                        সঠিক: <span class="correct-option-text"
                                            data-number="{{ $question->correctOption->number }}">{{ $question->correctOption->option_text }}</span>
                                    </div>
                                @endif

                                <ul class="option-list">
                                    @foreach ($question->options as $option)
                                        <li class="option-item" data-number="{{ $option->number }}"
                                            data-text="{{ $option->option_text }}">{{ $option->option_text }}</li>
                                    @endforeach
                                </ul>

                                <div class="question-time" style="display:none;">সময়: ১০ মিনিট</div>
                                <div class="question-mark" style="display:none;">মার্ক: ৫</div>
                            </div>
                        @endforeach
                    </div>
                    <div id="watermark" class="watermark" style="display:none;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('teacher_custom_js')
    <script>
        $(document).ready(function() {
            // Option style buttons
            $('.option-style-btn').click(function() {
                let style = $(this).data('style'); // e.g., circle, dot, paren, close_paren
                $('#questions-wrapper .option-item').each(function(index) {
                    let origText = $(this).data('text');
                    let prefix = '';
                    if (style === 'circle') prefix = '○ ';
                    else if (style === 'dot') prefix = '• ';
                    else if (style === 'paren') prefix = '(' + String.fromCharCode(97 + index) +
                        ') ';
                    else if (style === 'close_paren') prefix = String.fromCharCode(97 + index) +
                        ') ';
                    $(this).text(prefix + origText);
                });
            });

            // Answer style buttons (ক, খ / A,B / 1,2 / i, ii)
            $('.answer-style-btn').click(function() {
                let style = $(this).data('style'); // e.g., bangla, latin, numeric, roman
                $('#questions-wrapper .option-item').each(function(index) {
                    let origText = $(this).data('text');
                    let prefix = '';
                    if (style === 'bangla') prefix = ['ক', 'খ', 'গ', 'ঘ'][index] + '. ';
                    else if (style === 'latin') prefix = String.fromCharCode(65 + index) + '. ';
                    else if (style === 'numeric') prefix = (index + 1) + '. ';
                    else if (style === 'roman') prefix = ['i', 'ii', 'iii', 'iv'][index] + '. ';
                    $(this).text(prefix + origText);
                });

                // Update correct option prefix too
                $('#questions-wrapper .correct-option-text').each(function(index) {
                    let number = $(this).data('number');
                    let text = $(this).text();
                    let prefix = '';
                    if (style === 'bangla') prefix = ['ক', 'খ', 'গ', 'ঘ'][number - 1] + '. ';
                    else if (style === 'latin') prefix = String.fromCharCode(64 + number) + '. ';
                    else if (style === 'numeric') prefix = number + '. ';
                    else if (style === 'roman') prefix = ['i', 'ii', 'iii', 'iv'][number - 1] +
                    '. ';
                    $(this).text(prefix + text);
                });
            });

            // Column buttons
            $('.column-btn').click(function() {
                let cols = $(this).data('cols');
                let flexBasis = 100 / cols + '%';
                $('#questions-wrapper .question-container').css('flex', '1 0 ' + flexBasis);
            });

            // Toggles
            $('#show-title-toggle').change(function() {
                $('#preview-title').toggle($(this).is(':checked'));
            });

            $('#title-text').on('input', function() {
                $('#preview-title').text($(this).val());
            });

            $('#show-watermark-toggle').change(function() {
                $('#watermark').toggle($(this).is(':checked'));
            });
            $('#watermark-text').on('input', function() {
                $('#watermark').text($(this).val());
            });

            $('#show-time-toggle').change(function() {
                $('.question-time').toggle($(this).is(':checked'));
            });

            $('#show-mark-toggle').change(function() {
                $('.question-mark').toggle($(this).is(':checked'));
            });

            // Print
            $('#print-btn').click(function() {
                window.print();
            });
        });
    </script>
@endsection
