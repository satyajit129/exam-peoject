@extends('backend.global.master')

@section('title', 'Manage Leave')
@section('heading', 'Manage Leave')

@section('backend_custom_style')
    <!-- Date Range Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Filter</h2>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('manageLeaveList') }}" class="row g-2 mb-3">

                <div class="col-md-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control select2">
                        <option value="">-- Select Employee --</option>
                        @foreach ($employees as $emp)
                            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="leave_type_id" class="form-label">Leave Type</label>
                    <select name="leave_type_id" id="leave_type_id" class="form-control select2">
                        <option value="">-- Select Leave Type --</option>
                        @foreach ($leave_types as $type)
                            <option value="{{ $type->id }}"
                                {{ request('leave_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="created_at" class="form-label">Application Date</label>
                    <input type="text" name="created_at" value="{{ request('created_at') }}" class="form-control"
                        id="application_date" placeholder="Application Date">
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control select2">
                        <option value="">-- Select Status --</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Pending</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Approved</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="{{ route('manageLeaveList') }}" class="btn btn-secondary btn-sm">Reset</a>
                </div>

            </form>
        </div>
    </div>


    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Manage Leave List</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Leave Type</th>
                        <th>Application Date</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($leaves as $leave)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $leave->user->name ?? 'N/A' }}</td>
                            <td>{{ $leave->leaveType->name ?? 'N/A' }}</td>
                            <td>{{ $leave->created_at->format('d-m-Y') }}</td>
                           <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d-m-Y') }}</td>
<td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d-m-Y') }}</td>

                            <td>
                                <form action="{{ route('manageLeaveUpdateStatus') }}" method="GET">
                                    <input type="hidden" name="leave_id" value="{{ $leave->id }}">
                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                        <option value="1" {{ $leave->status == '1' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="2" {{ $leave->status == '2' ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="3" {{ $leave->status == '3' ? 'selected' : '' }}>Rejected
                                        </option>
                                    </select>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">
                                No data found! Please add data from <a href="{{ route('leaveCreateOrEdit') }}">here</a>
                            </td>
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
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select an option',
        });
    </script>
    <script>
        $(function() {
            $('#application_date').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD-MM-YYYY',
                    cancelLabel: 'Clear'
                }
            });

            // Auto-fill input on apply
            $('#application_date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format(
                    'DD-MM-YYYY'));
            });

            // Clear input on cancel
            $('#application_date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endsection
