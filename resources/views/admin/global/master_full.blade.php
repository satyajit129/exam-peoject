@php
    $settings = App\Models\Setting::first();
@endphp
<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('backend.global.css_support', $settings)
    @yield('backend_custom_style')
</head>

<body class="navbar-fixed" id="body">

    <div class="wrapper">
        <div class="page-wrapper" style="margin-left: 0; width: 100%;">

            <!-- Content without header but with footer -->
            <div class="content-wrapper" style="padding-top: 0;">
                <div class="content" style="padding: 0;">
                    @yield('backend_content')
                </div>
            </div>

            <!-- Footer -->
            @include('backend.layouts.footer', $settings)
        </div>
    </div>
    @include('backend.global.js_support', $settings)
    @yield('backend_custom_js')
</body>

</html>
