@extends('backend.global.master')

@section('title', 'Employees')
@section('heading', 'Employees')

@section('backend_custom_style')

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .employee-photo {
            padding: 8px;
            border: 1px solid #ddd;
            /* border around the cell */
            text-align: center;
        }

        .employee-img {
            border: 2px solid #0d6efd;
            /* border around the image */
            padding: 2px;
            /* adds a nice frame */
        }
    </style>
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Filter</h2>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('employeeList') }}" class="mb-3">
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ request('name') }}" placeholder="Name">
                    </div>

                    <!-- Email -->
                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" name="email" class="form-control"
                            value="{{ request('email') }}" placeholder="Email">
                    </div>

                    <!-- Phone -->
                    <div class="col-md-4 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            value="{{ request('phone') }}" placeholder="Phone">
                    </div>

                    <!-- Designation Dropdown -->
                    <div class="col-md-4 mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <select id="designation" name="designation" class="form-control select2">
                            <option value="">-- Select --</option>
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}"
                                    {{ request('designation') == $designation->id ? 'selected' : '' }}>
                                    {{ $designation->designation }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Department Dropdown -->
                    <div class="col-md-4 mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select id="department" name="department" class="form-control select2">
                            <option value="">-- Select --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ request('department') == $department->id ? 'selected' : '' }}>
                                    {{ $department->department }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Joining Date Range -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Joining Date</label>
                        <input type="text" id="joining_date_range" name="joining_date_range" class="form-control"
                            value="{{ request('joining_date_range') }}" placeholder="Select Date Range">
                    </div>

                </div>

                <!-- Buttons (now inside the form) -->
                <div class="row mt-2">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="{{ route('employeeList') }}" class="btn btn-secondary btn-sm">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Employee List</h2>
            <div>
                <a class="btn btn-outline-danger btn-sm removed_employees">
                    <i class="mdi mdi-restore"></i> Removed Employee
                </a>
                <a href="{{ route('employeeCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">
                    <i class="mdi mdi-account-plus-outline"></i> Add New Employee
                </a>
            </div>


        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 20px;">#</th>
                        <th style="width: 35px;">Emp Id</th>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Contact</th>
                        <th>Department</th>
                        <th>Age</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr>
                            <td>{{ $employees->firstItem() + $loop->index }}</td>
                            <td>{{ $employee->employee_id }}</td>
                            {{-- Picture --}}
                            <td class="employee-photo">
                                @if ($employee->picture)
                                    <img src="{{ asset('images/' . $employee->picture) }}" alt="Employee" width="50"
                                        height="50" class="rounded-circle employee-img">
                                @else
                                    <img src="{{ asset('images/placeholder-image.jpg') }}" alt="No Picture" width="50"
                                        height="50" class="rounded-circle employee-img">
                                @endif
                            </td>


                            {{-- Name --}}
                            <td>{{ $employee->name }}
                                @isset($employee->employeeRunningDesigntion->designation->designation)
                                    <p>
                                        <span
                                            class="badge badge-outline-info">{{ $employee->employeeRunningDesigntion->designation->designation }}</span>
                                    </p>
                                @endisset
                            </td>
                            <td>{{ $employee->adminRole->name ?? '-' }}</td>
                            <td>
                                {{ $employee->email }}
                                <p>{{ $employee->phone ?? '---' }}</p>
                            </td>

                            {{-- Department --}}
                            <td>{{ $employee->jobInfo->department->department ?? '-' }}</td>

                            {{-- Joining Date --}}
                            <td>
                                @if ($employee->jobInfo && $employee->jobInfo->joining_date)
                                    @php
                                        $start = \Carbon\Carbon::parse($employee->jobInfo->joining_date);
                                        $end = \Carbon\Carbon::now();
                                        $diff = $start->diff($end);
                                    @endphp

                                    @if ($diff->y > 0)
                                        {{ $diff->y }}y
                                        {{ $diff->m }}m
                                        {{ $diff->d }} day{{ $diff->d > 1 ? 's' : '' }}
                                    @elseif($diff->m > 0)
                                        {{ $diff->m }}m
                                        {{ $diff->d }}day{{ $diff->d > 1 ? 's' : '' }}
                                    @else
                                        {{ $diff->d }}day{{ $diff->d > 1 ? 's' : '' }}
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            {{-- Action --}}
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Edit, View, Delete Buttons --}}
                                    <a class="mr-1 btn btn-sm btn-outline-warning" title="Edit"
                                        href="{{ route('employeeCreateOrEdit', $employee->id) }}"><i
                                            class="mdi mdi-pencil"></i></a>

                                    {{-- <a class="mr-1 btn btn-sm btn-outline-primary" title="View"
                                        href="{{ route('employeeView', $employee->id) }}"><i class="mdi mdi-eye"></i></a> --}}

                                    <a href="javascript:void(0);"
                                        data-url="{{ route('employeeDelete', ['id' => $employee->id]) }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete"
                                        class=" btn btn-sm btn-outline-danger delete-btn"><i
                                            class="mdi mdi-delete"></i></a>
                                </div>


                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">
                                No data found! Please add data from
                                <a href="{{ route('employeeCreateOrEdit') }}">here</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $employees->appends(request()->all())->links() }}
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
    <div class="modal fade" id="removedEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" id="removedEmployeeModalContent">
                <!-- Form content will be loaded here via jQuery -->
            </div>
        </div>
    </div>
@endsection

@section('backend_custom_js')
    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var deleteUrl = $(this).data('url');
                $('#confirmDeleteBtn').attr('href', deleteUrl);
            });
        });
    </script>
    <script>
        $(function() {
            $('#joining_date_range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD-MM-YYYY',
                    cancelLabel: 'Clear'
                }
            });

            // Auto-fill input on apply
            $('#joining_date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format(
                    'DD-MM-YYYY'));
            });

            // Clear input on cancel
            $('#joining_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
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
    $(document).ready(function () {
        $('.removed_employees').on('click', function(e){
            e.preventDefault(); // Fixed capitalization

            $.ajax({
                type: "GET",
                url: "{{ route('employeeRemove') }}",
                success: function (response) {
                    $('#removedEmployeeModalContent').html(response);
                    $('#removedEmployeeModal').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection
