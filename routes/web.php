<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;



// General Routes

Route::get('/',[GeneralController::class,'index'])->name('index');

// Teacher Routes

Route::get('/teacher-login',[TeacherController::class,'teacherLogin'])->name('teacherLogin');
Route::post('/teacher-login-request',[TeacherController::class,'teacherLoginRequest'])->name('teacherLoginRequest');
Route::get('/teacher-register',[TeacherController::class,'teacherRegister'])->name('teacherRegister');
Route::post('/teacher-register-request',[TeacherController::class,'teacherRegisterRequest'])->name('teacherRegisterRequest');

Route::prefix('teacher')->group(function(){
    Route::get('/dashboard',[TeacherController::class,'teacherDashboard'])->name('teacherDashboard');
    Route::get('/logout',[TeacherController::class,'teacherLogout'])->name('teacherLogout');
});
