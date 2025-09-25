@foreach($questions as $index => $question)
    <div class="col-12 mb-3 p-3 border rounded shadow-sm question-item">
        <div class="form-check mb-2">
            <input type="checkbox"
                   class="form-check-input question-checkbox"
                   id="q{{ $question->id }}"
                   value="{{ $question->id }}"
                   {{ in_array($question->id, $selectedIds) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="q{{ $question->id }}">
                {{ ($questions->currentPage()-1) * $questions->perPage() + $index + 1 }}. {{ $question->question_text }}
            </label>
        </div>

        <div class="ms-4">
            @foreach($question->options as $optionIndex => $option)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="q{{ $question->id }}_option{{ $optionIndex }}" value="{{ $option->id }}">
                    <label class="form-check-label" for="q{{ $question->id }}_option{{ $optionIndex }}">
                        {{ chr(65 + $optionIndex) }}. {{ $option->option_text }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

<!-- Pagination links -->
<div class="col-12 mt-3">
    {{ $questions->links() }}
</div>
