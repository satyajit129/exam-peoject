@php
    use App\Models\GeneralSetting;
    $settings = GeneralSetting::getSetting();
@endphp

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Pass $settings to included CSS --}}
    @include('general.global.css_support', ['settings' => $settings])
    @yield('general_custom_style')
</head>

<body class="navbar-fixed sidebar-fixed" id="body">
    <div class="wrapper">
        <div class="page-wrapper">
            {{-- Header --}}
            @include('general.layouts.header', ['settings' => $settings])

            <div class="content-wrapper">
                <div class="content">
                    @yield('general_content')
                </div>
            </div>

            {{-- Footer --}}
            @include('general.layouts.footer', ['settings' => $settings])
        </div>
    </div>

    {{-- JS --}}
    @include('general.global.js_support', ['settings' => $settings])
    @yield('general_custom_js')
</body>

</html>
