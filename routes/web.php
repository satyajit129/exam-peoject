<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\TeacherController;
use App\Models\Teacher;
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


    Route::prefix('batch')->group(function(){
        Route::get('/',[TeacherController::class,'batchList'])->name('batchList');
        Route::get('/form/{id?}',[TeacherController::class,'batchForm'])->name('batchForm');
        Route::post('/save/{id?}',[TeacherController::class,'batchSave'])->name('batchSave');
        Route::get('/delete/{id}',[TeacherController::class,'batchDelete'])->name('batchDelete');
    });
    Route::prefix('question-category')->group(function(){
        Route::get('/',[TeacherController::class,'questionCategoryList'])->name('questionCategoryList');
        Route::get('/form/{id?}',[TeacherController::class,'questionCategoryForm'])->name('questionCategoryForm');
        Route::post('/save/{id?}',[TeacherController::class,'questionCategorySave'])->name('questionCategorySave');
        Route::get('/delete/{id}',[TeacherController::class,'questionCategoryDelete'])->name('questionCategoryDelete');
    });
    Route::prefix('question')->group(function(){
        Route::get('/',[TeacherController::class,'questionList'])->name('questionList');
        Route::get('/form/{id?}',[TeacherController::class,'questionForm'])->name('questionForm');
        Route::post('/save/{id?}',[TeacherController::class,'questionSave'])->name('questionSave');
        Route::get('/delete/{id}',[TeacherController::class,'questionDelete'])->name('questionDelete');
    });

    Route::prefix('question-builder')->group(function(){
        Route::get('/',[TeacherController::class,'questionBuilderIndex'])->name('questionBuilderIndex');
        Route::get('/form/{id?}',[TeacherController::class,'questionBuilderForm'])->name('questionBuilderForm');
        Route::post('/save/{id?}',[TeacherController::class,'questionBuilderSave'])->name('questionBuilderSave');
        Route::get('/delete/{id}',[TeacherController::class,'questionBuilderDelete'])->name('questionBuilderDelete');
    });
});
