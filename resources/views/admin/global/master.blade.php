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


<body class="navbar-fixed sidebar-fixed" id="body">

    <div class="wrapper">
        @include('backend.layouts.sidebar', $settings)
        <div class="page-wrapper">

            <!-- Header -->
            @include('backend.layouts.header', $settings)
            <div class="content-wrapper">
                <div class="content">
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
