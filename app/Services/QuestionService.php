<?php

namespace App\Services;

use App\Models\PreviousExam;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Database\Eloquent\Concerns\PreventsCircularRecursion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuestionService
{
    // ----------------------
    // Question Methods
    // ----------------------
    public function renderQuestions()
{
    $questions = Question::with(['category', 'description', 'options', 'previousExams'])->latest()->get();
    return view('teacher.pages.question_list', compact('questions'));
}


    public function renderQuestionForm($id = null)
    {
        $question = $id
            ? Question::with(['options', 'description', 'previousExams'])->findOrFail($id)
            : null;

        $categories = QuestionCategory::where('status', 'active')->get();
        $exams = PreviousExam::all(); // for previous exams multi-select

        return view('teacher.pages.question_form', compact('question', 'categories', 'exams'));
    }


public function handleQuestionSave(Request $request, $id = null)
{
    $validated = $request->validate([
        'category_id'       => 'required|exists:question_categories,id',
        'question_text'     => 'required|string',
        'description'       => 'nullable|string',
        'options'           => 'required|array|size:4',
        'options.*'         => 'required|string',
        'correct_option'    => 'required|integer|min:0|max:3',
        'previous_exam_ids' => 'nullable|array',
        'status'            => 'required|in:active,inactive',
    ]);

    DB::beginTransaction();

    try {
        // Question create/update
        $question = $id ? Question::findOrFail($id) : new Question();
        $question->category_id   = $validated['category_id'];
        $question->question_text = $validated['question_text'];
        $question->status        = $validated['status'];
        $question->save();

        // Description
        if ($request->filled('description')) {
            $question->description()->updateOrCreate(
                ['question_id' => $question->id],
                ['description' => $validated['description']]
            );
        }

        // Options (update only, delete না)
        foreach ($validated['options'] as $index => $optionText) {
            $option = $question->options()->skip($index)->first(); // পুরোনো option নাও
            if ($option) {
                $option->update([
                    'option_text' => $optionText,
                    'is_correct'  => $index == $validated['correct_option'],
                ]);
            } else {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct'  => $index == $validated['correct_option'],
                ]);
            }
        }

        // Previous exams
        $examIds = [];
        foreach ($request->input('previous_exam_ids', []) as $item) {
            if (is_numeric($item) && PreviousExam::where('id', $item)->exists()) {
                $examIds[] = (int) $item;
            } else {
                $exam = PreviousExam::firstOrCreate(['name' => $item]);
                $examIds[] = $exam->id;
            }
        }
        $question->previousExams()->sync($examIds);

        DB::commit();
        return redirect()->route('questionList')->with('success', 'প্রশ্ন সফলভাবে সংরক্ষণ করা হয়েছে।');

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Question Save Error: ' . $e->getMessage());
        return back()->withInput()->with('error', 'কিছু ভুল হয়েছে: ' . $e->getMessage());
    }
}





    public function handleQuestionDelete($id)
    {
        Question::findOrFail($id)->delete();
        return redirect()->route('questionList')->with('success', 'Question deleted successfully.');
    }
}
