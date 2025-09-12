<?php

namespace App\Http\Controllers;

use App\Services\TeacherAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    protected TeacherAuthService $teacherAuthService;

    
    public function __construct(TeacherAuthService $teacherAuthService)
    {
        $this->teacherAuthService = $teacherAuthService;
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
        return redirect()->route('teacher.login')->with('success', 'Logged out successfully!');
    }
}
