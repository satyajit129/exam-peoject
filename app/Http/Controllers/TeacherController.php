<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionCategory;
use App\Services\TeacherAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\BatchService;
use App\Services\QuestionCategoryService;
use App\Services\QuestionService;

class TeacherController extends Controller
{
    protected TeacherAuthService $teacherAuthService;
    protected BatchService $batchService;
    protected QuestionCategoryService $categoryService;
    protected QuestionService $questionService;

    public function __construct(TeacherAuthService $teacherAuthService, BatchService $batchService, QuestionCategoryService $categoryService, QuestionService $questionService)
    {
        $this->teacherAuthService = $teacherAuthService;
        $this->batchService = $batchService;
        $this->categoryService = $categoryService;
        $this->questionService = $questionService;
    }

    // Show login form
    public function teacherLogin(): View
    {
        return view('teacher.pages.login');
    }

    // Handle login request
    public function teacherLoginRequest(Request $request)
    {
        return $this->teacherAuthService->handleLoginRequest($request);
    }

    // Show register form
    public function teacherRegister()
    {
        return view('teacher.pages.register');
    }

    // Handle register request
    public function teacherRegisterRequest(Request $request)
    {
        return $this->teacherAuthService->handleRegister($request);
    }

    // Show dashboard
    public function teacherDashboard()
    {
        return view('teacher.pages.dashboard');
    }
    // Logout
    public function teacherLogout()
    {
        $this->teacherAuthService->logout();
        return redirect()->route('teacherLogin')->with('success', 'Logged out successfully!');
    }
    public function batchList()
    {
        return $this->batchService->renderBatches();
    }
    public function batchForm($id = null)
    {
        return $this->batchService->renderBatchForm($id);
    }
    public function batchSave(Request $request, $id = null)
    {
        return $this->batchService->handleBatchSave($request, $id);
    }
    public function batchDelete($id)
    {
        return $this->batchService->handleBatchDelete($id);
    }
    // Question Category
    public function questionCategoryList()
    {
        return $this->categoryService->renderCategoryList();
    }
    public function questionCategoryForm($id = null)
    {
        return $this->categoryService->renderCategoryForm($id);
    }
    public function questionCategorySave(Request $request, $id = null)
    {
        return $this->categoryService->handleCategorySave($request, $id);
    }
    public function questionCategoryDelete($id)
    {
        return $this->categoryService->handleCategoryDelete($id);
    }

    // Question
    public function questionList()
    {
        return $this->questionService->renderQuestions();
    }
    public function questionForm($id = null)
    {
        return $this->questionService->renderQuestionForm($id);
    }
    public function questionSave(Request $request, $id = null)
    {
        return $this->questionService->handleQuestionSave($request, $id);
    }
    public function questionDelete($id)
    {
        return $this->questionService->handleQuestionDelete($id);
    }
    public function questionExcel()
    {
        return $this->questionService->renderQuestionExcel();
    }
    public function questionUploadExcel(Request $request)
    {
        return $this->questionService->handleQuestionUploadExcel($request);
    }
    // Fetch questions by category (AJAX request)
    public function getQuestionsByCategory(Request $request)
    {
        $category = QuestionCategory::findOrFail($request->category_id);
        $categoryIds = $this->getAllCategoryIds($category);

        $questions = Question::whereIn('category_id', $categoryIds)
            ->with('options')
            ->paginate(10);

        // Receive previously selected question IDs
        $selectedIds = $request->selected_ids ?? [];

        // Return partial view
        return view('teacher.pages.partials.questions_list', compact('questions', 'selectedIds'))->render();
    }
    public function viewSelectedQuestions(Request $request)
    {
        $ids = explode(',', $request->ids ?? []);
        $questions = Question::whereIn('id', $ids)->with(['options', 'correctOption'])->get();

        return view('teacher.pages.selected_questions', compact('questions'));
    }




    // Recursive function to get category and all children
    private function getAllCategoryIds($category)
    {
        $ids = [$category->id];

        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getAllCategoryIds($child));
        }

        return $ids;
    }



    public function questionBuilder()
    {
        return $this->questionService->renderQuestionBuilder();
    }

    public function questionBuilderForm($id = null)
    {
        return $this->questionService->renderQuestionForm($id);
    }

    public function questionBuilderSave(Request $request, $id = null)
    {
        return $this->questionService->handleQuestionSave($request, $id);
    }

    public function questionBuilderDelete($id)
    {
        return $this->questionService->handleQuestionDelete($id);
    }
}
