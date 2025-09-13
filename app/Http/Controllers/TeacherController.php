<?php

namespace App\Http\Controllers;

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
}
