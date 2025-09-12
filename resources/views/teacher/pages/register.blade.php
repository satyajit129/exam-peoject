@extends('teacher.global.master')


@section('teacher_custom_style')
    @if (!Route::is('teacher.login', 'teacher.register'))
        <style>
            @media (min-width: 768px) {

                .sidebar-fixed-offcanvas .main-header,
                .sidebar-fixed .main-header {
                    padding-left: 0;
                }
            }

            @media (min-width: 768px) {

                .sidebar-fixed-offcanvas .page-wrapper,
                .sidebar-fixed .page-wrapper {
                    padding-left: 0;
                }
            }

            .content {
                height: 100%;
                display: flex;
                justify-content: center;
            }
        </style>
    @endif
@endsection


@section('teacher_content')
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card shadow-lg" style="max-width: 500px; width: 100%;">
            <div class="card-body">
                <h4 class="text-center mb-4">শিক্ষক রেজিস্ট্রেশন</h4>

               <form action="{{ route('teacherRegisterRequest') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">পূর্ণ নাম</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="পূর্ণ নাম লিখুন" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">ইমেইল ঠিকানা</label>
                        <input type="email" class="form-control" id="email" name="email" 
                            placeholder="ইমেইল লিখুন" value="{{ old('email') }}" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">পাসওয়ার্ড</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="পাসওয়ার্ড তৈরি করুন" required autocomplete="new-password">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">পাসওয়ার্ড নিশ্চিত করুন</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="পাসওয়ার্ড নিশ্চিত করুন" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">রেজিস্ট্রেশন</button>
                </form>


                <p class="text-center mt-3">
                    ইতিমধ্যেই একটি একাউন্ট আছে?
                    <a href="{{ route('teacherLogin') }}">লগইন করুন</a>
                </p>
            </div>
        </div>

    </div>
@endsection
