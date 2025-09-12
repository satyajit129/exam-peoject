<header class="main-header" id="header">
    <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
        <!-- Sidebar toggle button -->
        <button id="sidebar-toggler" class="sidebar-toggle">
            <span class="sr-only">Toggle navigation</span>
        </button>

        <span class="page-title">@yield('heading')</span>

        <div class="navbar-right d-flex align-items-center" style="gap: 15px;">
            <ul class="nav navbar-nav d-flex align-items-center" style="gap: 10px; margin-bottom: 0;">
                <!-- Teacher Login -->
                <li class="nav-item">
                    <a href="{{ route('teacherLogin') }}" class="btn btn-outline-primary btn-sm">
                        শিক্ষক লগইন
                    </a>
                </li>

                <!-- Student Login -->
                <li class="nav-item">
                    <a href="" class="btn btn-outline-success btn-sm">
                        শিক্ষার্থী লগইন
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
