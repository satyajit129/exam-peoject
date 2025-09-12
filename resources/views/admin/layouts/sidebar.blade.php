<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <div class="app-brand">
            <a href="{{ route('adminDashboard') }}" title="Dashboard">
                <span class="brand-name text-truncate">{{ $settings->website_short_name }}</span>
            </a>
        </div>
        @php
            $user = auth()->user();
            $canManageDashboard = $user->hasPermission('manage_dashboard');
            $canManageDesignation = $user->hasPermission('manage_designation');
            $canManageDepartment = $user->hasPermission('manage_department');
            $canManageEmployee = $user->hasPermission('manage_employee');
            $canManagePermission = $user->hasPermission('manage_permission');
            $canManageRoleAccess = $user->hasPermission('manage_role_access');
            $canManageSetting = $user->hasPermission('manage_settings');
            $canManageJobNature = $user->hasPermission('manage_job_nature');
            $canManageBank = $user->hasPermission('manage_bank');
            $canManageWorkLocation = $user->hasPermission('manage_work_location');
            $canManageWorkSchudule = $user->hasPermission('manage_work_schedule');
            $canManageTimeTracking = $user->hasPermission('manage_tts');
            $canManageSeason = $user->hasPermission('manage_season');
            $canManageShift = $user->hasPermission('manage_shift');
            $canManageLeaveType = $user->hasPermission('manage_leave_type');
            $canManageLeaveAllocation = $user->hasPermission('leave_allocation');
            $canManageLeave = $user->hasPermission('leave_manage');
            $canManageAttendance = $user->hasPermission('manage_attendance');
            $canManageHolidayType = $user->hasPermission('manage_holiday_type');
            $canManageHoliday = $user->hasPermission('manage_holiday');
            $canManageLeavePosting = $user->hasPermission('leave_posting');
            $canManageUserRoleControl = $user->hasPermission('user_role_control');
            $canManageSeasonShift = $user->hasPermission('manage_season_shift');
            $canManagePayrollAllowances = $user->hasPermission('manage_payroll_allowances');
            $canManagePayrollDeductions = $user->hasPermission('manage_payroll_deductions');
            $canManageEmployeeSalaryBreakdown = $user->hasPermission('manage_employee_salary_breakdown');
            $canManagePayrollReport = $user->hasPermission('manage_payroll_report');
        @endphp
        <div class="sidebar-scrollbar">
            <ul class="nav sidebar-inner" id="sidebar-menu">
                @if ($canManageDashboard)
                    <!-- Dashboard -->
                    <li class="{{ Route::is('adminDashboard') ? 'active' : '' }}">
                        <a class="sidenav-item-link" href="{{ route('adminDashboard') }}">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                @endif

                @php
                    // All routes under System Setup
                    $companyStructureRoutes = [
                        'departmentList',
                        'departmentCreateOrEdit',
                        'designationList',
                        'designationCreateOrEdit',
                        'jobNatureList',
                        'jobNatureCreateOrEdit',
                        'bankList',
                        'bankCreateOrEdit',
                        'seasonList',
                        'seasonCreateOrEdit',
                        'shiftList',
                        'shiftCreateOrEdit',
                        'seasonShiftList',
                        'seasonShiftCreateOrEdit',
                        'workLocationList',
                        'workLocationCreateOrEdit',
                        'leaveTypeList',
                        'leaveTypeCreateOrEdit',
                    ];

                    $isCompanyStructureActive = Route::is($companyStructureRoutes);
                @endphp

                @if (
                    $canManageDepartment ||
                        $canManageDesignation ||
                        $canManageJobNature ||
                        $canManageBank ||
                        $canManageSeason ||
                        $canManageShift ||
                        $canManageWorkLocation ||
                        $canManageLeaveType)
                    <li class="has-sub {{ $isCompanyStructureActive ? 'active' : '' }}">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse"
                            data-target="#companyStructure"
                            aria-expanded="{{ $isCompanyStructureActive ? 'true' : 'false' }}"
                            aria-controls="companyStructure">
                            <i class="mdi mdi-tools"></i>
                            <span class="nav-text">System Setup</span> <b class="caret"></b>
                        </a>

                        <ul class="collapse {{ $isCompanyStructureActive ? 'show' : '' }}" id="companyStructure"
                            data-parent="#sidebar-menu">
                            <div class="sub-menu">

                                @if ($canManageDepartment)
                                    <li
                                        class="{{ Route::is('departmentList', 'departmentCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('departmentList') }}">
                                            <i class="mdi mdi-office-building mr-1"></i>
                                            <span class="nav-text">Department</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageDesignation)
                                    <li
                                        class="{{ Route::is('designationList', 'designationCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('designationList') }}">
                                            <i class="mdi mdi-account-tie mr-1"></i>
                                            <span class="nav-text">Designation</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageJobNature)
                                    <li
                                        class="{{ Route::is('jobNatureList', 'jobNatureCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('jobNatureList') }}">
                                            <i class="mdi mdi-briefcase-outline mr-1"></i>
                                            <span class="nav-text">Job Nature</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageBank)
                                    <li class="{{ Route::is('bankList', 'bankCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('bankList') }}">
                                            <i class="mdi mdi-bank mr-1"></i>
                                            <span class="nav-text">Bank</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageSeason)
                                    <li class="{{ Route::is('seasonList', 'seasonCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('seasonList') }}">
                                            <i class="mdi mdi-weather-sunny mr-1"></i>
                                            <span class="nav-text">Season</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageShift)
                                    <li class="{{ Route::is('shiftList', 'shiftCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('shiftList') }}">
                                            <i class="mdi mdi-clock-outline mr-1"></i>
                                            <span class="nav-text">Shift</span>
                                        </a>
                                    </li>
                                @endif

                                @if ($canManageSeasonShift)
                                    <li
                                        class="{{ Route::is('seasonShiftList', 'seasonShiftCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('seasonShiftList') }}">
                                            <i class="mdi mdi-clock-outline mr-1"></i>
                                            <span class="nav-text">Season-Shift</span>
                                        </a>
                                    </li>
                                @endif

                                @if ($canManageWorkLocation)
                                    <li
                                        class="{{ Route::is('workLocationList', 'workLocationCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('workLocationList') }}">
                                            <i class="mdi mdi-map-marker mr-1"></i>
                                            <span class="nav-text">Work Location</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageLeaveType)
                                    <li
                                        class="{{ Route::is('leaveTypeList', 'leaveTypeCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('leaveTypeList') }}">
                                            <i class="mdi mdi-calendar-remove mr-1"></i>
                                            <span class="nav-text">Leave Type</span>
                                        </a>
                                    </li>
                                @endif
                            </div>
                        </ul>
                    </li>

                @endif


                @php
                    $employeeRoutes = [
                        'employeeList',
                        'employeeCreateOrEdit',
                        'employeeView',
                        'workScheduleList',
                        'workScheduleCreateOrEdit',
                        'employeeSalaryBreakdownList',
                        'employeeSalaryBreakdownCreateOrEdit',
                        'employeeDesignationCreateOrEdit',
                    ];

                    $isEmployeeActive = Route::is($employeeRoutes);
                @endphp

                @if ($canManageEmployee || $canManageWorkSchudule || $canManageEmployeeSalaryBreakdown)
                    <li class="has-sub {{ $isEmployeeActive ? 'active' : '' }}">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse"
                            data-target="#employeeMenu" aria-expanded="{{ $isEmployeeActive ? 'true' : 'false' }}"
                            aria-controls="employeeMenu">
                            <i class="mdi mdi-account-multiple-outline"></i>
                            <span class="nav-text">Employee Setup</span> <b class="caret"></b>
                        </a>

                        <ul class="collapse {{ $isEmployeeActive ? 'show' : '' }}" id="employeeMenu"
                            data-parent="#sidebar-menu">
                            <div class="sub-menu">
                                @if ($canManageEmployee)
                                    <li
                                        class="{{ Route::is('employeeList', 'employeeCreateOrEdit', 'employeeView', 'employeeDesignationCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('employeeList') }}">
                                            <i class="mdi mdi-account-multiple mr-1"></i>
                                            <span class="nav-text">Employees</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageWorkSchudule)
                                    <li
                                        class="{{ Route::is('workScheduleList', 'workScheduleCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('workScheduleList') }}">
                                            <i class="mdi mdi-calendar-clock-outline mr-1"></i>
                                            <span class="nav-text">Work Schedule</span>
                                        </a>
                                    </li>
                                @endif
                                {{-- @if ($canManageEmployeeSalaryBreakdown)
                                    <li
                                        class="{{ Route::is('employeeSalaryBreakdownList', 'employeeSalaryBreakdownCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link"
                                            href="{{ route('employeeSalaryBreakdownList') }}">
                                            <i class="mdi mdi-cash mr-1"></i>
                                            <span class="nav-text">Salary Breakdown</span>
                                        </a>
                                    </li>
                                @endif --}}
                            </div>
                        </ul>
                    </li>
                @endif

                @php
                    $managementRoutes = [
                        'timeTrackingList',
                        'leaveAllocationList',
                        'leaveAllocationCreateOrEdit',
                        'manageLeaveList',
                        'attendanceList',
                        'attendanceCreateOrEdit',
                        'holidayTypeList',
                        'holidayTypeCreateOrEdit',
                        'holidayList',
                        'holidayCreateOrEdit',
                    ];

                    $isManagementActive = Route::is($managementRoutes);
                @endphp

                @if (
                    $canManageTimeTracking ||
                        $canManageLeaveAllocation ||
                        $canManageLeave ||
                        $canManageAttendance ||
                        $canManageHolidayType ||
                        $canManageHoliday)
                    <li class="has-sub {{ $isManagementActive ? 'active' : '' }}">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse"
                            data-target="#managementMenu"
                            aria-expanded="{{ $isManagementActive ? 'true' : 'false' }}"
                            aria-controls="managementMenu">
                            <i class="mdi mdi-briefcase-outline"></i>
                            <span class="nav-text">Management</span> <b class="caret"></b>
                        </a>

                        <ul class="collapse {{ $isManagementActive ? 'show' : '' }}" id="managementMenu"
                            data-parent="#sidebar-menu">
                            <div class="sub-menu">

                                @if ($canManageTimeTracking)
                                    <li class="{{ Route::is('timeTrackingList') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('timeTrackingList') }}">
                                            <i class="mdi mdi-timer-sand mr-1"></i>
                                            <span class="nav-text">TTS</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageLeaveAllocation)
                                    <li
                                        class="{{ Route::is('leaveAllocationList', 'leaveAllocationCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('leaveAllocationList') }}">
                                            <i class="mdi mdi-calendar-star mr-1"></i>
                                            <span class="nav-text">Leave Allocation</span>
                                        </a>
                                    </li>
                                @endif

                                @if ($canManageLeave)
                                    <li class="{{ Route::is('manageLeaveList') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('manageLeaveList') }}">
                                            <i class="mdi mdi-calendar-check-outline mr-1"></i>
                                            <span class="nav-text">Manage Leave</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageAttendance)
                                    <li
                                        class="{{ Route::is('attendanceList', 'attendanceCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('attendanceList') }}">
                                            <i class="mdi mdi-calendar-check-outline mr-1"></i>
                                            <span class="nav-text">Attendance</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageHolidayType)
                                    <li
                                        class="{{ Route::is('holidayTypeList', 'holidayTypeCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('holidayTypeList') }}">
                                            <i class="mdi mdi-calendar-star mr-1"></i>
                                            <span class="nav-text">Holiday Type</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManageHoliday)
                                    <li class="{{ Route::is('holidayList', 'holidayCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('holidayList') }}">
                                            <i class="mdi mdi-calendar-multiple mr-1"></i>
                                            <span class="nav-text">Holidays</span>
                                        </a>
                                    </li>
                                @endif
                            </div>
                        </ul>
                    </li>
                @endif

                @if ($canManageLeavePosting)
                    <!-- Leave Menu (for employees / general) -->
                    <li class="{{ Route::is('leaveList', 'leaveCreateOrEdit') ? 'active' : '' }}">
                        <a class="sidenav-item-link" href="{{ route('leaveList') }}">
                            <i class="mdi mdi-calendar-plus"></i> <!-- changed icon -->
                            <span class="nav-text">Leave</span>
                        </a>
                    </li>
                @endif

                @php
                    $payrollRoutes = [
                        'payrollAllowanceList',
                        'payrollAllowanceCreateOrEdit',
                        'payrollDeductionList',
                        'payrollDeductionCreateOrEdit',
                        'payrollList',
                        'payrollCreateOrEdit',
                    ];

                    $isPayrollActive = Route::is($payrollRoutes);
                @endphp

                @if ($canManagePayrollAllowances || $canManagePayrollDeductions)
                    <li class="has-sub {{ $isPayrollActive ? 'active' : '' }}">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse"
                            data-target="#payrollMenu" aria-expanded="{{ $isPayrollActive ? 'true' : 'false' }}"
                            aria-controls="payrollMenu">
                            <i class="mdi mdi-calculator"></i>
                            <span class="nav-text">Payroll Settings</span> <b class="caret"></b>
                        </a>

                        <ul class="collapse {{ $isPayrollActive ? 'show' : '' }}" id="payrollMenu"
                            data-parent="#sidebar-menu">
                            <div class="sub-menu">
                                @if ($canManagePayrollAllowances)
                                    <li
                                        class="{{ Route::is('payrollAllowanceList', 'payrollAllowanceCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('payrollAllowanceList') }}">
                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                            <span class="nav-text"> Allowances</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($canManagePayrollDeductions)
                                    <li
                                        class="{{ Route::is('payrollDeductionList', 'payrollDeductionCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('payrollDeductionList') }}">
                                            <i class="mdi mdi-minus-circle mr-1"></i>
                                            <span class="nav-text"> Deductions</span>
                                        </a>
                                    </li>
                                @endif
                                
                                @if ($canManagePayrollReport)
                                    <li class="{{ Route::is('payrollList') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('payrollList') }}">
                                            <i class="mdi mdi-file-document mr-1"></i>
                                            <span class="nav-text"> Reports</span>
                                        </a>
                                    </li>
                                @endif
                            </div>
                        </ul>
                    </li>
                @endif

                @php
                    $securityRoutes = [
                        'permissionList',
                        'permissionCreateOrEdit',
                        'roleAccess',
                        'roleAccessCreateOrEdit',
                        'websiteSettings',
                        'userList',
                        'userCreateOrEdit',
                    ];

                    $isSecurityActive = Route::is($securityRoutes);
                @endphp

                @if ($canManagePermission || $canManageRoleAccess || $canManageSetting)
                    <li class="has-sub {{ $isSecurityActive ? 'active' : '' }}">
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse"
                            data-target="#securityMenu" aria-expanded="{{ $isSecurityActive ? 'true' : 'false' }}"
                            aria-controls="securityMenu">
                            <i class="mdi mdi-shield-lock"></i>
                            <span class="nav-text">Access Control</span> <b class="caret"></b>
                        </a>

                        <ul class="collapse {{ $isSecurityActive ? 'show' : '' }}" id="securityMenu"
                            data-parent="#sidebar-menu">
                            <div class="sub-menu">
                                @if ($canManageUserRoleControl)
                                    <li class="{{ Route::is('userList', 'userCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('userList') }}">
                                            <i class="mdi mdi-account-multiple mr-1"></i>
                                            <span class="nav-text">Users</span>
                                        </a>
                                    </li>
                                @endif


                                @if ($canManagePermission)
                                    <li
                                        class="{{ Route::is('permissionList', 'permissionCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('permissionList') }}">
                                            <i class="mdi mdi-lock mr-1"></i>
                                            <span class="nav-text">Permission</span>
                                        </a>
                                    </li>
                                @endif

                                @if ($canManageRoleAccess)
                                    <li
                                        class="{{ Route::is('roleAccess', 'roleAccessCreateOrEdit') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('roleAccess') }}">
                                            <i class="mdi mdi-shield-account mr-1"></i>
                                            <span class="nav-text">Role</span>
                                        </a>
                                    </li>
                                @endif

                                @if ($canManageSetting)
                                    <li class="{{ Route::is('websiteSettings') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('websiteSettings') }}">
                                            <i class="mdi mdi-cog-outline mr-1"></i>
                                            <span class="nav-text">Settings</span>
                                        </a>
                                    </li>
                                @endif

                            </div>
                        </ul>
                    </li>
                @endif


            </ul>
        </div>

    </div>
</aside>
