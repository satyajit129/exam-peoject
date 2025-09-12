@extends('backend.global.master')

@section('title', 'Employee ' . ($employee->id ? 'Update' : 'Create'))
@section('heading', 'Employee ' . ($employee->id ? 'Update' : 'Create'))


@section('backend_custom_style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

@endsection

@section('backend_content')
    @if ($employee->id)
        <div class="py-3">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Left Column: Picture & Name -->
                        <div class="col-lg-3 text-center border-end">
                            <img src="{{ app()->environment('local') ? asset('images/placeholder-image.jpg') : ($employee->picture ? asset('images/' . $employee->picture) : asset('images/placeholder-image.jpg')) }}"
                                alt="Employee Picture" class="img-fluid rounded-circle mb-3"
                                style="height: 180px; width: 180px; object-fit: cover;">
                            <h4 class="fw-bold">{{ $employee->name }}</h4>
                            <p class="text-muted mb-1">
                                <i class="mdi mdi-briefcase-outline me-1"></i>
                                {{ $employee->employeeRunningDesigntion->designation->designation ?? '-' }}
                            </p>
                            <p class="text-muted mb-1">
                                <i class="mdi mdi-office-building me-1"></i>
                                {{ $employee->jobInfo->department->department ?? '-' }}
                            </p>
                            <p class="text-muted mb-1">
                                <i class="mdi mdi-email-outline me-1"></i>
                                {{ $employee->email ?? '-' }}
                            </p>
                            <p class="text-muted mb-0">
                                <i class="mdi mdi-phone me-1"></i>
                                {{ $employee->phone ?? '-' }}
                            </p>
                        </div>

                        <!-- Right Column: Details -->
                        <div class="col-lg-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-primary text-white fw-bold">
                                    Personal Info
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><i class="mdi mdi-gender-male-female mr-1"></i>Gender:
                                        {{ $employee->gender ?? '-' }}</p>
                                    <p class="mb-2"><i class="mdi mdi-calendar mr-1"></i>Date of Birth:
                                        {{ $employee->dob ?? '-' }}</p>
                                    <p class="mb-2"><i class="mdi mdi-earth mr-1"></i>Religion:
                                        {{ $employee->religion ?? '-' }}</p>
                                    <p class="mb-2"><i class="mdi mdi-water mr-1"></i>Blood Group:
                                        {{ $employee->blood_group ?? '-' }}</p>
                                    <p class="mb-2"><i class="mdi mdi-phone-classic mr-1"></i>Office Phone:
                                        {{ $employee->office_phone ?? '-' }}</p>
                                    <p class="mb-0"><i class="mdi mdi-account-card-details mr-1"></i>NID:
                                        {{ $employee->nid ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-success text-white fw-bold">
                                    Job Info
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><i class="mdi mdi-briefcase-outline mr-1"></i>Designation:
                                        {{ $employee->employeeRunningDesigntion->designation->designation ?? '-' }}</p>
                                    <p class="mb-2"><i class="mdi mdi-office-building mr-1"></i>Department:
                                        {{ $employee->jobInfo->department->department ?? '-' }}</p>
                                    <p class="mb-2"><i class="mdi mdi-clipboard-text-outline mr-1"></i>Job Nature:
                                        {{ $employee->jobInfo->jobNature->name ?? '-' }}</p>
                                    <p class="mb-2"><i class="mdi mdi-map-marker-outline mr-1"></i>Work Location:
                                        {{ $employee->jobInfo->workLocation->name ?? '-' }}</p>
                                    <p class="mb-2"><i class="mdi mdi-calendar-check mr-1"></i>Joining Date:
                                        {{ $employee->jobInfo->joining_date ?? '-' }}</p>
                                    <p class="mb-0"><i class="mdi mdi-home-outline mr-1"></i>Address:
                                        {{ $employee->jobInfo->address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-warning text-dark fw-bold">
                                    Bank Info
                                </div>
                                <div class="card-body">
                                    <p class="mb-2 me-4"><i class="mdi mdi-bank mr-2"></i>Bank:
                                        {{ $employee->bankInfo->bank->name ?? '-' }}</p>
                                    <p class="mb-2 me-4"><i class="mdi mdi-account mr-2"></i>Account Holder:
                                        {{ $employee->bankInfo->account_holder ?? '-' }}</p>
                                    <p class="mb-2 me-4"><i class="mdi mdi-credit-card mr-2"></i>Account Number:
                                        {{ $employee->bankInfo->bank_account ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif




    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Employee {{ $employee->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('employeeList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Left Menu -->
                <div class="col-lg-3">
                    <div class="card card-default">
                        <div class="card-header">
                            <h2>Employee Settings</h2>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="nav nav-settings flex-column" id="employeeTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ request('tab', 'info') == 'info' ? 'active' : '' }}"
                                        href="?tab=info" role="tab">
                                        <i class="mdi mdi-account-outline mr-1"></i> Employee Info
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request('tab') == 'job' ? 'active' : '' }}" href="?tab=job"
                                        role="tab">
                                        <i class="mdi mdi-briefcase-outline mr-1"></i> Job Info
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request('tab') == 'designation' ? 'active' : '' }}"
                                        href="?tab=designation" role="tab">
                                        <i class="mdi mdi-account-tie mr-1"></i> Designation
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request('tab') == 'bank' ? 'active' : '' }}" href="?tab=bank"
                                        role="tab">
                                        <i class="mdi mdi-bank mr-1"></i> Bank Info
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request('tab') == 'social' ? 'active' : '' }}"
                                        href="?tab=social" role="tab">
                                        <i class="mdi mdi-share-variant mr-1"></i> Social Info
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request('tab') == 'documents' ? 'active' : '' }}"
                                        href="?tab=documents" role="tab">
                                        <i class="mdi mdi-file-document-outline mr-1"></i> Documents
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <!-- Right Content -->
                <div class="col-lg-9">
                    <div class="tab-content" id="employeeTabContent">
                        <!-- Employee Info -->
                        <div class="tab-pane fade {{ request('tab', 'info') == 'info' ? 'show active' : '' }}"
                            id="info" role="tabpanel">
                            <form action="{{ route('employeeSave', $employee->id ?? '') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- Hidden input to specify which tab is being submitted --}}
                                <input type="hidden" name="tab" value="info">

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h2>Employee Info</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            {{-- Name --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="mdi mdi-account"></i></span></div>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ old('name', $employee->name ?? '') }}">
                                                </div>
                                            </div>

                                            {{-- Email --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="email">Email</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="mdi mdi-email"></i></span></div>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ old('email', $employee->email ?? '') }}">
                                                </div>
                                            </div>

                                            {{-- Phone --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="phone">Phone <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="mdi mdi-phone"></i></span></div>
                                                    <input type="text" class="form-control" id="phone"
                                                        name="phone" placeholder="Enter phone number"
                                                        value="{{ old('phone', $employee->phone ?? '') }}">
                                                </div>
                                            </div>
                                            {{-- NID Number --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="nid">NID Number <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="mdi mdi-card-text-outline"></i></span></div>
                                                    <input type="text" class="form-control" id="nid"
                                                        name="nid" placeholder="Enter NID Number"
                                                        value="{{ old('nid', $employee->nid ?? '') }}">
                                                </div>
                                            </div>

                                            {{-- Password --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="password">Password</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="mdi mdi-lock"></i></span></div>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Enter password"
                                                        autocomplete="new-password">
                                                </div>
                                            </div>

                                            {{-- Confirm Password --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="mdi mdi-lock"></i></span></div>
                                                    <input type="password" class="form-control"
                                                        id="password_confirmation" name="password_confirmation"
                                                        placeholder="Confirm password">
                                                </div>
                                            </div>

                                            {{-- Gender --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="gender">Gender</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="mdi mdi-gender-male-female"></i></span></div>
                                                    <select class="form-control" id="gender" name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male"
                                                            {{ old('gender', $employee->gender ?? '') == 'Male' ? 'selected' : '' }}>
                                                            Male</option>
                                                        <option value="Female"
                                                            {{ old('gender', $employee->gender ?? '') == 'Female' ? 'selected' : '' }}>
                                                            Female</option>
                                                        <option value="Other"
                                                            {{ old('gender', $employee->gender ?? '') == 'Other' ? 'selected' : '' }}>
                                                            Other</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Date of Birth --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="dob">Date of Birth</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datepicker_custom"
                                                        id="dob" name="dob" placeholder="Enter Date Of Birth"
                                                        value="{{ old('dob', $employee->dob ? \Carbon\Carbon::parse($employee->dob)->format('d-m-Y') : '') }}">
                                                </div>
                                            </div>
                                            {{-- Religion --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="religion">Religion</label>
                                                <div class="input-group">

                                                    <select class="form-control select2" id="religion" name="religion">
                                                        <option value="">Select Religion</option>
                                                        <option value="Islam"
                                                            {{ old('religion', $employee->religion ?? '') == 'Islam' ? 'selected' : '' }}>
                                                            Islam</option>
                                                        <option value="Hinduism"
                                                            {{ old('religion', $employee->religion ?? '') == 'Hinduism' ? 'selected' : '' }}>
                                                            Hinduism</option>
                                                        <option value="Christianity"
                                                            {{ old('religion', $employee->religion ?? '') == 'Christianity' ? 'selected' : '' }}>
                                                            Christianity</option>
                                                        <option value="Buddhism"
                                                            {{ old('religion', $employee->religion ?? '') == 'Buddhism' ? 'selected' : '' }}>
                                                            Buddhism</option>
                                                        <option value="Other"
                                                            {{ old('religion', $employee->religion ?? '') == 'Other' ? 'selected' : '' }}>
                                                            Other</option>
                                                    </select>
                                                </div>
                                            </div>


                                            {{-- Blood Group --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="blood_group">Blood Group</label>
                                                <div class="input-group">

                                                    <select class="form-control select2" id="blood_group"
                                                        name="blood_group">
                                                        <option value="">Select Blood Group</option>
                                                        @php
                                                            $bloodGroups = [
                                                                'A+',
                                                                'A-',
                                                                'B+',
                                                                'B-',
                                                                'AB+',
                                                                'AB-',
                                                                'O+',
                                                                'O-',
                                                            ];
                                                        @endphp
                                                        @foreach ($bloodGroups as $group)
                                                            <option value="{{ $group }}"
                                                                {{ old('blood_group', $employee->blood_group ?? '') == $group ? 'selected' : '' }}>
                                                                {{ $group }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            {{-- Employee ID --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="employee_id">Employee ID <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="fas fa-id-card"></i></span></div>
                                                    <input type="number" class="form-control" id="employee_id"
                                                        name="employee_id" placeholder="Enter Employee ID"
                                                        value="{{ old('employee_id', $employee->employee_id ?? '') }}">
                                                </div>
                                            </div>

                                            {{-- Office Phone --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="office_phone">Office Phone</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="mdi mdi-phone-classic"></i></span></div>
                                                    <input type="text" class="form-control" id="office_phone"
                                                        name="office_phone" placeholder="Enter Office Phone"
                                                        value="{{ old('office_phone', $employee->office_phone ?? '') }}">
                                                </div>
                                            </div>



                                            {{-- Profile Picture --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="picture">Profile Picture</label>
                                                <input type="file" class="form-control image-input"
                                                    data-target="#cropProfileModal" id="picture" name="picture">

                                                {{-- Show existing picture + delete button --}}
                                                @if (!empty($employee->picture))
                                                    <div class="mt-2">
                                                        <img src="{{ asset('images/' . $employee->picture) }}"
                                                            class="img-fluid me-2" alt="Profile Picture"
                                                            style="max-height: 100px; width: 100px; border:1px solid #ddd; padding:2px; border-radius:4px; display: block;">

                                                        <a href="javascript:void(0);"
                                                            data-url="{{ route('employeePictureDelete', $employee->id) }}"
                                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                            title="Delete" class="text-danger delete-img-btn">
                                                            Delete
                                                        </a>
                                                    </div>
                                                @endif

                                                {{-- Crop Modal --}}
                                                <div class="modal fade" id="cropProfileModal" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Crop Profile Picture</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close">X</button>
                                                            </div>
                                                            <div class="modal-body text-center" style="padding: 0;">
                                                                <img id="cropperProfileImage" class="img-fluid">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" id="cropProfileBtn"
                                                                    class="btn btn-primary">Crop & Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            {{-- ID Card --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="id_card">ID Card Photo</label>
                                                <input type="file" class="form-control image-input"
                                                    data-target="#cropIdCardModal" id="id_card" name="id_card">
                                                {{-- Show existing picture + delete button --}}
                                                @if (!empty($employee->id_card))
                                                    <div class="mt-2">
                                                        <img src="{{ asset('images/' . $employee->id_card) }}"
                                                            class="img-fluid me-2" alt="ID Card Photo"
                                                            style="max-height: 100px; width: 100px; border:1px solid #ddd; padding:2px; border-radius:4px; display: block;">
                                                        <a href="javascript:void(0);"
                                                            data-url="{{ route('employeeNIDDelete', $employee->id) }}"
                                                            data-bs-toggle="modal" data-bs-target="#nidDeleteModal"
                                                            title="Delete" class="text-danger delete-nid-btn">Delete</a>

                                                    </div>
                                                @endif

                                                {{-- Crop Modal --}}
                                                <div class="modal fade" id="cropIdCardModal" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Crop ID Card</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close">X</button>
                                                            </div>
                                                            <div class="modal-body text-center" style="padding: 0;">
                                                                <img id="cropperIdCardImage" class="img-fluid">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" id="cropIdCardBtn"
                                                                    class="btn btn-primary">Crop & Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Hidden inputs to hold cropped images --}}
                                            <input type="hidden" name="cropped_profile" id="cropped_profile">
                                            <input type="hidden" name="cropped_id_card" id="cropped_id_card">

                                        </div>
                                        <button type="submit" class="btn btn-primary" style="float: inline-end;">Save
                                            Employee Info</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- Job Info -->
                        <div class="tab-pane fade {{ request('tab') == 'job' ? 'show active' : '' }}" id="job"
                            role="tabpanel">
                            <form action="{{ route('employeeSave', $employee->id ?? '') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tab" value="job">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h2>Job Info</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                            {{-- Department --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="department">Department <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">

                                                    <select class="form-control select2" id="department"
                                                        name="department_id">
                                                        <option value="">Select Department</option>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}"
                                                                {{ old('department_id', $employee->jobInfo->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                                                {{ $department->department }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            {{-- Job Nature --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="job_nature">Job Nature <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                                                    </div>
                                                    <select class="form-control " id="job_nature" name="job_nature">
                                                        <option value="">Select Job Nature</option>
                                                        @foreach ($job_natures as $job_nature)
                                                            <option value="{{ $job_nature->id }}"
                                                                {{ old('job_nature', $employee->jobInfo->job_nature ?? '') == $job_nature->id ? 'selected' : '' }}>
                                                                {{ $job_nature->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Work Location --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="work_location">Work Location <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <select class="form-control " id="work_location"
                                                        name="work_location">
                                                        <option value="">Select Work Location</option>
                                                        @foreach ($work_locations as $location)
                                                            <option value="{{ $location->id }}"
                                                                {{ old('work_location', $employee->jobInfo->work_location ?? '') == $location->id ? 'selected' : '' }}>
                                                                {{ $location->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Shift ID --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="shift_id">Shift ID </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar-check"></i></span>
                                                    </div>
                                                    <select class="form-control " id="shift_id" name="shift_id">
                                                        <option disabled selected>Select Shift</option>
                                                        @foreach ($shifts as $shift)
                                                            <option value="{{ $shift->id }}"
                                                                {{ old('shift_id', $employee->jobInfo->shift_id ?? '') == $shift->id ? 'selected' : '' }}>
                                                                {{ $shift->shift_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Joining Date --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="joining_date">Joining Date </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar-check"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datepicker_custom"
                                                        id="joining_date" name="joining_date"
                                                        placeholder="Enter Joining date"
                                                        value="{{ old('joining_date', $employee->jobInfo && $employee->jobInfo->joining_date ? \Carbon\Carbon::parse($employee->jobInfo->joining_date)->format('d-m-Y') : '') }}">
                                                </div>
                                            </div>

                                            {{-- Release Date --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="release_date">Release Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar-times"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control datepicker_custom"
                                                        id="release_date" name="release_date"
                                                        placeholder="Enter Release date"
                                                        value="{{ old('release_date', $employee->jobInfo && $employee->jobInfo->release_date ? \Carbon\Carbon::parse($employee->jobInfo->release_date)->format('d-m-Y') : '') }}">
                                                </div>
                                            </div>

                                        </div>
                                        {{-- Address --}}
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="address">Address</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                                    </div>
                                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address">{{ old('address', $employee->jobInfo->address ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="float: inline-end;">Save
                                            Job Info</button>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <!-- Designation -->
                        <div class="tab-pane fade {{ request('tab') == 'designation' ? 'show active' : '' }}"
                            id="designation" role="tabpanel">
                            <form action="{{ route('employeeSave', $employee->id ?? '') }}" method="POST"
                                id="designationForm">
                                @csrf
                                <input type="hidden" name="tab" value="designation">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h2>Designation History</h2>
                                        <a href="{{ route('employeeDesignationCreateOrEdit', ['employee_id' => $employee->id, 'tab' => request('tab')]) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="mdi mdi-plus mr-1"></i> Add Designation
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">

                                        
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Designation</th>
                                                    <th>Age</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($employee->employeeDesignations as $designation)
                                                    @php
                                                        $employee_id = $employee->id;
                                                        // dd($employee_id, $designation->designation_id);
                                                        $salary = \App\Models\EmployeeSalaryBreakdown::where(
                                                            'user_id',
                                                            $employee_id,
                                                        )
                                                            ->where('designation_id', $designation->designation_id)
                                                            ->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $designation->designation->designation }}
                                                            <p>
                                                                <span class="badge badge-square badge-outline-primary">{{ isset($salary->gross_salary) ? $salary->gross_salary : 0 }} BDT </span>
                                                            </p>
                                                        </td>
                                                        @php
                                                            $start = \Carbon\Carbon::parse($designation->start_date);
                                                            $end = $designation->end_date
                                                                ? \Carbon\Carbon::parse($designation->end_date)
                                                                : \Carbon\Carbon::now();

                                                            $diff = $start->diff($end); // DateInterval
                                                            $isRed = $diff->y >= 1;
                                                        @endphp

                                                        <td class="{{ $isRed ? 'text-danger' : '' }}">
                                                            @if ($diff->y > 0)
                                                                {{ $diff->y }}y
                                                                {{ $diff->m }}m
                                                                {{ $diff->d }}day{{ $diff->d > 1 ? 's' : '' }}
                                                            @elseif($diff->m > 0)
                                                                {{ $diff->m }}m
                                                                {{ $diff->d }}day{{ $diff->d > 1 ? 's' : '' }}
                                                            @else
                                                                {{ $diff->d }}day{{ $diff->d > 1 ? 's' : '' }}
                                                            @endif
                                                        </td>


                                                        <td>{{ \Carbon\Carbon::parse($designation->start_date)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            {{ $designation->end_date ? \Carbon\Carbon::parse($designation->end_date)->format('d-m-Y') : '--' }}
                                                        </td>

                                                        <td>
                                                            <a href="{{ route('employeeDesignationCreateOrEdit', ['employee_id' => $employee->id, 'tab' => request('tab'), 'id' => $designation->id]) }}"
                                                                class="btn btn-sm btn-outline-warning">
                                                               <i class="mdi mdi-pencil"></i></a>
                                                            </a>
                                                            <a onclick="return confirm('Are you Sure ? Want to delete this ??')" href="{{ route('employeeDesignationDelete',[ 'id' => $designation->id , 'tab' => request('tab')]) }}" class="btn btn-sm btn-outline-danger">
                                                                <i class="mdi mdi-delete"></i></a>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">No designation history
                                                            found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Bank Info -->
                        <div class="tab-pane fade {{ request('tab') == 'bank' ? 'show active' : '' }}" id="bank"
                            role="tabpanel">
                            <form action="{{ route('employeeSave', $employee->id ?? '') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tab" value="bank">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h2>Bank Info</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            {{-- Bank Name --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="bank_name">Bank Name <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="mdi mdi-bank"></i></span></div>
                                                    <select name="bank_id" class="form-control ">
                                                        <option value="">Select Bank</option>
                                                        @foreach ($banks as $bank)
                                                            <option value="{{ $bank->id }}"
                                                                {{ old('bank_id', $employee->bankInfo->bank_id ?? '') == $bank->id ? 'selected' : '' }}>
                                                                {{ $bank->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Account Holder Name --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="account_holder">Account Holder Name <span
                                                        class="text-danger">*</span> </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="account_holder"
                                                        name="account_holder" placeholder="Enter Account Holder Name"
                                                        value="{{ old('account_holder', $employee->bankInfo->account_holder ?? '') }}">
                                                </div>
                                            </div>

                                            {{-- Bank Account Number --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="bank_account">Bank Account Number <span
                                                        class="text-danger">*</span> </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-credit-card"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="bank_account"
                                                        name="bank_account" placeholder="Enter Bank Account Number"
                                                        value="{{ old('bank_account', $employee->bankInfo->bank_account ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="float: inline-end;">Save
                                            Bank Info</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Social Info -->
                        <div class="tab-pane fade {{ request('tab') == 'social' ? 'show active' : '' }}" id="social"
                            role="tabpanel">
                            <form action="{{ route('employeeSave', $employee->id ?? '') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tab" value="social">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h2>Social Info</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            {{-- Facebook --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="facebook">Facebook</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="fab fa-facebook"></i></span></div>
                                                    <input type="text" class="form-control" name="facebook"
                                                        value="{{ old('facebook', $employee->socialInfo->facebook ?? '') }}">
                                                </div>
                                            </div>
                                            {{-- LinkedIn --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="linkedin">LinkedIn</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-linkedin-in"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="linkedin"
                                                        name="linkedin" placeholder="Enter LinkedIn URL"
                                                        value="{{ old('linkedin', $employee->socialInfo->linkedin ?? '') }}">
                                                </div>
                                            </div>

                                            {{-- Twitter --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="twitter">Twitter</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-twitter"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="twitter"
                                                        name="twitter" placeholder="Enter Twitter URL"
                                                        value="{{ old('twitter', $employee->socialInfo->twitter ?? '') }}">
                                                </div>
                                            </div>

                                            {{-- YouTube --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="youtube">YouTube</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-youtube"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="youtube"
                                                        name="youtube" placeholder="Enter YouTube URL"
                                                        value="{{ old('youtube', $employee->socialInfo->youtube ?? '') }}">
                                                </div>
                                            </div>

                                            {{-- Instagram --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="instagram">Instagram</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-instagram"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="instagram"
                                                        name="instagram" placeholder="Enter Instagram URL"
                                                        value="{{ old('instagram', $employee->socialInfo->instagram ?? '') }}">
                                                </div>
                                            </div>

                                            {{-- Pinterest --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="pinterest">Pinterest</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-pinterest-p"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="pinterest"
                                                        name="pinterest" placeholder="Enter Pinterest URL"
                                                        value="{{ old('pinterest', $employee->socialInfo->pinterest ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="float: inline-end;">Save
                                            Social Info</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Documents Info -->

                        <div class="tab-pane fade {{ request('tab') == 'documents' ? 'show active' : '' }}"
                            id="documents" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h2>Documents</h2>
                                    <a data-employee-id="{{ $employee->id }}"
                                        class="btn btn-outline-primary btn-sm float-end document">Add Document</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Document Name</th>
                                                    <th>Attachment</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($employee->documents as $document)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $document->document_name }}</td>
                                                        <td>
                                                            @if ($document->document)
                                                                @php
                                                                    $ext = pathinfo(
                                                                        $document->document,
                                                                        PATHINFO_EXTENSION,
                                                                    );
                                                                @endphp

                                                                @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                                    <img src="{{ asset('images/' . $document->document) }}"
                                                                        alt="Document"
                                                                        style="max-width: 100px; max-height: 100px;">
                                                                @elseif (strtolower($ext) === 'pdf')
                                                                    <a href="{{ asset('images/' . $document->document) }}"
                                                                        target="_blank" class="btn btn-sm btn-primary">
                                                                        View PDF
                                                                    </a>
                                                                @else
                                                                    <a href="{{ asset('images/' . $document->document) }}"
                                                                        target="_blank" class="btn btn-sm btn-secondary">
                                                                        Download File
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <span class="text-muted">No Attachment</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-outline-primary btn-sm document"
                                                                data-employee-id="{{ $employee->id }}"
                                                                data-id ="{{ $document->id }}">Edit</a>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger delete-doc-btn"
                                                                data-url="{{ route('employeeDocumentDelete', $document->id) }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#documentDeleteModal">
                                                                Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No documents found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="nidDeleteModal" tabindex="-1" aria-labelledby="nidDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nidDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger btn-sm" id="confirmNIDDeleteBtn">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Document Modal -->
    <!-- Document Modal -->
    <div class="modal fade" id="documentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="documentModalContent">
                <!-- Form content will be loaded here via jQuery -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="documentDeleteModal" tabindex="-1" aria-labelledby="documentDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to Delete this document?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger btn-sm" id="confirmDocumentDeleteBtn">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('backend_custom_js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- Select2 JS -->
    <script>
        $(document).ready(function() {
            $(".datepicker_custom").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                showAnim: "slideDown"
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.delete-img-btn').on('click', function() {
                var deleteUrl = $(this).data('url');
                console.log(deleteUrl); // For debugging
                $('#confirmDeleteBtn').attr('href', deleteUrl);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.delete-nid-btn').on('click', function() {
                var deleteUrl = $(this).data('url');
                console.log(deleteUrl);
                $('#confirmNIDDeleteBtn').attr('href', deleteUrl);
            });
        });
    </script>

    <script>
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select an option',
        });
    </script>

    <script>
        let cropper;
        document.querySelectorAll('.image-input').forEach(input => {
            input.addEventListener('change', function(e) {
                let modalTarget = this.dataset.target;
                let modal = document.querySelector(modalTarget);
                let image = modal.querySelector("img");

                let file = e.target.files[0];
                if (!file) return;

                let reader = new FileReader();
                reader.onload = function(event) {
                    image.src = event.target.result;
                    $(modalTarget).modal('show');
                }
                reader.readAsDataURL(file);

                $(modalTarget).on('shown.bs.modal', function() {
                    cropper = new Cropper(image, {
                        aspectRatio: modalTarget.includes("Profile") ? 1 :
                        NaN, // square for profile, free for ID
                        viewMode: 1,
                        preview: '.preview'
                    });
                }).on('hidden.bs.modal', function() {
                    cropper.destroy();
                    cropper = null;
                });
            });
        });

        // Handle cropping
        document.getElementById('cropProfileBtn').addEventListener('click', function() {
            let canvas = cropper.getCroppedCanvas({
                width: 450,
                height: 500
            });
            canvas.toBlob(function(blob) {
                let reader = new FileReader();
                reader.onloadend = function() {
                    document.getElementById("cropped_profile").value = reader.result;
                }
                reader.readAsDataURL(blob);
            });
            $('#cropProfileModal').modal('hide');
        });

        document.getElementById('cropIdCardBtn').addEventListener('click', function() {
            let canvas = cropper.getCroppedCanvas();
            canvas.toBlob(function(blob) {
                let reader = new FileReader();
                reader.onloadend = function() {
                    document.getElementById("cropped_id_card").value = reader.result;
                }
                reader.readAsDataURL(blob);
            });
            $('#cropIdCardModal').modal('hide');
        });
    </script>

    <!-- Designation Append Fields JavaScript -->
    <script>
        $(document).ready(function() {
            let designationFieldCount = 0;

            // Load existing designation data if editing
            @if ($employee->id && $employee->employeeDesignations->count() > 0)
                @foreach ($employee->employeeDesignations as $index => $empDesignation)
                    addDesignationField(
                        {{ $empDesignation->designation_id }},
                        '{{ $empDesignation->start_date ? \Carbon\Carbon::parse($empDesignation->start_date)->format('d-m-Y') : '' }}',
                        '{{ $empDesignation->end_date ? \Carbon\Carbon::parse($empDesignation->end_date)->format('d-m-Y') : '' }}'
                    );
                @endforeach
            @endif

            // Add Designation Field
            $('#addDesignationBtn').click(function() {
                addDesignationField();
            });

            // Remove Designation Field
            $(document).on('click', '.removeDesignationBtn', function() {
                $(this).closest('.designationField').remove();
                updateFieldNames();
            });

            function addDesignationField(designationId = '', startDate = '', endDate = '') {
                designationFieldCount++;
                const fieldHtml = `
                    <div class="designationField card mb-3" data-field-index="${designationFieldCount}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Designation ${designationFieldCount}</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm removeDesignationBtn">
                                <i class="mdi mdi-delete mr-1"></i> Remove
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Designation <span class="text-danger">*</span></label>
                                    <select class="form-control designationSelect2 select2" name="designations[${designationFieldCount}][designation_id]" required>
                                        <option value="">Select Designation</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control designationDatepicker" name="designations[${designationFieldCount}][start_date]" placeholder="Select Start Date" required value="${startDate}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>End Date</label>
                                    <input type="text" class="form-control designationDatepicker" name="designations[${designationFieldCount}][end_date]" placeholder="Select End Date" value="${endDate}">
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                const $newField = $(fieldHtml);
                $('#designationFields').append($newField);

                // Initialize Select2 for new field
                $newField.find('.designationSelect2').select2({
                    placeholder: 'Select Designation',
                    width: '100%'
                });

                // Set selected designation if provided
                if (designationId) {
                    $newField.find('.designationSelect2').val(designationId).trigger('change');
                }

                // Initialize DatePicker for new fields
                $newField.find('.designationDatepicker').datepicker({
                    dateFormat: "dd-mm-yy",
                    changeMonth: true,
                    changeYear: true,
                    showAnim: "slideDown"
                });
            }

            function updateFieldNames() {
                $('.designationField').each(function(index) {
                    const newIndex = index + 1;
                    $(this).attr('data-field-index', newIndex);
                    $(this).find('.card-header h5').text(`Designation ${newIndex}`);

                    // Update field names
                    $(this).find('select[name*="[designation_id]"]').attr('name',
                        `designations[${newIndex}][designation_id]`);
                    $(this).find('input[name*="[start_date]"]').attr('name',
                        `designations[${newIndex}][start_date]`);
                    $(this).find('input[name*="[end_date]"]').attr('name',
                        `designations[${newIndex}][end_date]`);
                });
            }

            // Form validation
            $('#designationForm').submit(function(e) {
                const designationFields = $('.designationField');

                if (designationFields.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one designation.');
                    return false;
                }

                // Validate each field
                let isValid = true;
                designationFields.each(function() {
                    const designationSelect = $(this).find('select[name*="[designation_id]"]');
                    const startDateInput = $(this).find('input[name*="[start_date]"]');

                    if (!designationSelect.val()) {
                        designationSelect.addClass('is-invalid');
                        isValid = false;
                    } else {
                        designationSelect.removeClass('is-invalid');
                    }

                    if (!startDateInput.val()) {
                        startDateInput.addClass('is-invalid');
                        isValid = false;
                    } else {
                        startDateInput.removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                    return false;
                }
            });

            // Initialize Select2 for existing fields
            $('.designationSelect2').select2({
                placeholder: 'Select Designation',
                width: '100%'
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.document').on(('click'), function(e) {
                e.preventDefault();
                var employeeID = $(this).data('employee-id');
                var ID = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('employeeDocumentForm') }}",
                    data: {
                        employee_id: employeeID,
                        id: ID,
                    },
                    success: function(response) {
                        $('#documentModalContent').html(response);
                        $('#documentModal').modal('show');
                    }
                });
            })
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.delete-doc-btn').on('click', function() {
                var deleteUrl = $(this).data('url');
                console.log(deleteUrl);
                $('#confirmDocumentDeleteBtn').attr('href', deleteUrl);
            });
        });
    </script>

@endsection
