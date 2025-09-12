@php
    use App\Models\GeneralSetting;
    $settings = GeneralSetting::getSetting();
@endphp

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Pass $settings to included CSS --}}
    @include('teacher.global.css_support', ['settings' => $settings])
    @yield('teacher_custom_style')
</head>

<body class="navbar-fixed sidebar-fixed" id="body">
    <div class="wrapper">
        @if (!Route::is('teacherLogin', 'teacherRegister'))
             @include('teacher.layouts.sidebar', ['settings' => $settings])
        @endif
       
        <div class="page-wrapper">
            {{-- Header --}}
            @include('teacher.layouts.header', ['settings' => $settings])

            <div class="content-wrapper">
                <div class="content">
                    @yield('teacher_content')
                </div>
            </div>

            {{-- Footer --}}
            @include('teacher.layouts.footer', ['settings' => $settings])
        </div>
    </div>

    {{-- JS --}}
    @include('teacher.global.js_support', ['settings' => $settings])
    @yield('general_custom_js')
</body>

</html>

