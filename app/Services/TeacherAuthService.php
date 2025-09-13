<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class TeacherAuthService
{
    public function handleRegister($request)
    {
        try {
            $request->validate(
                [
                    'name'     => 'required',
                    'email'    => 'required|email|unique:teachers,email',
                    'password' => 'required|min:6|confirmed',
                ],
                [
                    'name.required'      => 'আপনার নাম অবশ্যই দিতে হবে।',
                    'email.required'     => 'ইমেইল ঠিকানা অবশ্যই দিতে হবে।',
                    'email.unique'       => 'এই ইমেইল ঠিকানা ইতিমধ্যে ব্যবহৃত হয়েছে।',
                    'email.email'        => 'দয়া করে একটি বৈধ ইমেইল ঠিকানা লিখুন।',
                    'password.required'  => 'পাসওয়ার্ড অবশ্যই দিতে হবে।',
                    'password.min'       => 'পাসওয়ার্ড অবশ্যই অন্তত ৬ অক্ষরের হতে হবে।',
                    'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
                ]
            );
            $teacher = new Teacher();
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->password = Hash::make($request->password);
            $teacher->save();

            return redirect()->route('teacherLogin')->with('success', 'রেজিস্ট্রেশন সফল হয়েছে! অনুগ্রহ করে লগইন করুন।');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', 'রেজিস্ট্রেশন ব্যর্থ হয়েছে! ' . $th->getMessage())->withInput();
        }
    }
    public function handleLoginRequest($request)
    {
        try {
            $request->validate(
                [
                    'email'    => 'required|email',
                    'password' => 'required',
                ],
                [
                    'email.required'    => 'ইমেইল ঠিকানা অবশ্যই দিতে হবে।',
                    'email.email'       => 'দয়া করে একটি বৈধ ইমেইল ঠিকানা লিখুন।',
                    'password.required' => 'পাসওয়ার্ড অবশ্যই দিতে হবে।',
                ]
            );
            
            $credentials = $request->only('email', 'password');

            if (Auth::guard('teacher')->attempt($credentials)) {
                return redirect()->route('teacherDashboard')->with('success', 'সফলভাবে লগইন হয়েছে!');
            } else {
                return redirect()->back()->with('error', 'ইমেইল অথবা পাসওয়ার্ড ভুল হয়েছে।')->withInput();
            }
        } catch (Throwable $th) {
            return redirect()->back()->with('error', 'লগইন ব্যর্থ হয়েছে! ' . $th->getMessage())->withInput();
        }
    }
    public function logout(): void
    {
        Auth::guard('teacher')->logout();
    }
}
