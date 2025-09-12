@extends('backend.global.master')

@section('title', 'Attendance')
@section('heading', 'Attendance')

@section('backend_custom_style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Filter</h2>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('attendanceList') }}" class="mb-3">
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-3 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <select name="user_id" id="" class="form-control select2">
                            <option value="">-- Select User --</option>
                            @foreach ($employees as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="dateRange" class="form-label">Work Date Range</label>
                        <input type="text" name="date" id="date" class="form-control"
                            placeholder="Select Date Range" value="{{ request('date') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="name" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control select2">
                            <option value="">-- Select Status --</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Present</option>
                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Half Day</option>
                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Exceptional</option>
                        </select>
                    </div>
                    @php
                        $remarkOptions = App\Enums\AttendanceRemarkEnum::cases();
                    @endphp

                    <div class="col-md-3 mb-3">
                        <label for="remark" class="form-label">Remark</label>
                        <select name="remark" id="remark" class="form-control select2">
                            <option value="">-- Select Remark --</option>
                            @foreach ($remarkOptions as $option)
                                <option value="{{ $option->value }}"
                                    {{ request('remark') == $option->value ? 'selected' : '' }}>
                                    {{ $option->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- Buttons (now inside the form) -->
                <div class="row mt-2">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="{{ route('attendanceList') }}" class="btn btn-secondary btn-sm">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Attendance List</h2>
            <div class="d-flex">
                <a href="{{ route('attendanceCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">
                    Add New Attendance
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th> {{-- For plus/minus icon --}}
                        <th>#</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        {{-- Main row --}}
                        <tr data-bs-toggle="collapse" data-bs-target="#attendance-{{ $attendance->id }}"
                            aria-expanded="false" style="cursor:pointer;">
                            <td class="text-center">
                                <i class="bi bi-plus-lg toggle-icon"></i>
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $attendance->employee->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}</td>
                            <td>
                                @if ($attendance->status == '1')
                                    <span class="badge badge-success">Present</span>
                                @elseif($attendance->status == '2')
                                    <span class="badge badge-primary">Half Day</span>
                                @elseif($attendance->status == '3')
                                    <span class="badge badge-warning">Exceptional</span>
                                @endif
                            </td>
                            <td>
                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'Not yet' }}
                            </td>
                            <td>
                                {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : 'Not yet' }}
                            </td>
                            <td>
                                @php
                                    $remarkEnum = App\Enums\AttendanceRemarkEnum::tryFrom($attendance->remarks);
                                    $badgeClass = match ($remarkEnum) {
                                        App\Enums\AttendanceRemarkEnum::ON_TIME => 'badge badge-success',
                                        App\Enums\AttendanceRemarkEnum::LATE_CHECKIN => 'badge badge-warning',
                                        App\Enums\AttendanceRemarkEnum::EARLY_CHECKOUT => 'badge badge-info',
                                        App\Enums\AttendanceRemarkEnum::BOTH => 'badge badge-danger',
                                        default => 'badge badge-secondary',
                                    };
                                @endphp
                                <span class="{{ $badgeClass }}">
                                    {{ $remarkEnum ? $remarkEnum->label() : 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-warning ml-2" title="Edit"
                                    href="{{ route('attendanceCreateOrEdit', $attendance->id) }}">Edit</a>
                                <a href="javascript:void(0);"
                                    data-url="{{ route('attendanceDelete', ['id' => $attendance->id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete"
                                    class="btn btn-outline-danger btn-sm delete-btn">Delete</a>
                            </td>
                        </tr>

                        {{-- Collapsible row --}}
                        <tr class="collapse" id="attendance-{{ $attendance->id }}">
                            <td colspan="9">
                                {{-- Here you can display expanded attendance details --}}
                                <div class="p-3 bg-light">
                                    <strong>Additional Info:</strong><br>
                                    Employee ID: {{ $attendance->employee->id }}<br>
                                    Total Seconds: {{ $attendance->total_seconds }}<br>
                                    Given By: {{ $attendance->given_by }}<br>
                                    {{-- Add more details as needed --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="9">No data Found! Please add data from <a
                                    href="{{ route('attendanceCreateOrEdit') }}">Here</a> </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('backend_custom_js')

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
        $('.select2').select2({
            placeholder: 'Select an option',
        });
    </script>

    <script>
        $(function() {
            $('#date').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD-MM-YYYY',
                    cancelLabel: 'Clear'
                }
            });

            // Auto-fill input on apply
            $('#date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format(
                    'DD-MM-YYYY'));
            });

            // Clear input on cancel
            $('#date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>

    <script>
        document.querySelectorAll('tr[data-bs-toggle="collapse"]').forEach(function(row) {
            row.addEventListener('click', function() {
                const icon = row.querySelector('.toggle-icon');
                const target = document.querySelector(row.dataset.bsTarget);
                if (target.classList.contains('show')) {
                    icon.classList.remove('bi-dash-lg');
                    icon.classList.add('bi-plus-lg');
                } else {
                    icon.classList.remove('bi-plus-lg');
                    icon.classList.add('bi-dash-lg');
                }
            });
        });
    </script>
@endsection
