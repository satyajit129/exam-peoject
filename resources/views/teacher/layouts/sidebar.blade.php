<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <div class="app-brand">
            <a href='#' title="Dashboard">
                {{-- <span class="brand-name text-truncate">{{ $settings->website_short_name }}</span> --}}
            </a>
        </div>
        <div class="sidebar-scrollbar">
            <ul class="nav sidebar-inner" id="sidebar-menu">
                <!-- Dashboard -->
                <li class="{{ Route::is('teacherDashboard') ? 'active' : '' }}">
                    <a href="{{ route('teacherDashboard') }}" class="sidenav-item-link">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span class="nav-text">ড্যাশবোর্ড</span>
                    </a>
                </li>

                <!-- Batches -->
                <li class="{{ Route::is('batchList', 'batchForm') ? 'active' : '' }}">
                    <a href="{{ route('batchList') }}" class="sidenav-item-link">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span class="nav-text">ব্যাচসমূহ</span>
                    </a>
                </li>

                <!-- Question Categories -->
                <li class="{{ Route::is('questionCategoryList', 'questionCategoryForm') ? 'active' : '' }}">
                    <a href="{{ route('questionCategoryList') }}" class="sidenav-item-link">
                        <i class="mdi mdi-folder-outline"></i>
                        <span class="nav-text">প্রশ্নপত্রের ক্যাটাগরি</span>
                    </a>
                </li>

                <!-- Questions -->
                <li class="{{ Route::is('questionList', 'questionForm') ? 'active' : '' }}">
                    <a href="{{ route('questionList') }}" class="sidenav-item-link">
                        <i class="mdi mdi-file-document-outline"></i>
                        <span class="nav-text">প্রশ্নসমূহ</span>
                    </a>
                </li>

                <!-- Questions -->
                <li class="{{ Route::is('questionBuilder', 'questionBuilderForm') ? 'active' : '' }}">
                    <a href="{{ route('questionBuilder') }}" class="sidenav-item-link">
                        <i class="mdi mdi-file-document-outline"></i>
                        <span class="nav-text">প্রশ্ন তৈরি</span>
                    </a>
                </li>
            </ul>
        </div>


    </div>
</aside>
