@extends('backend.global.master')

@section('title', 'Time Tracking System')
@section('heading', 'Time Tracking System')

@section('backend_custom_style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('backend_content')
    <div class="card card-default">
        <div class="card-header">
            <h2>Filter</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('timeTrackingList') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label for="user_id" class="form-label">Employee</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">Select Employee</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ request('user_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dateRange" class="form-label">Work Date Range</label>
                        <input type="text" name="date" id="date" class="form-control"
                            placeholder="Select Date Range" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Pending</option>
                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Approved</option>
                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="row mt-4">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="{{ route('timeTrackingList') }}" class="btn btn-secondary btn-sm">Reset</a>
                    </div>
                </div>
            </form>


        </div>
    </div>
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Time Tracking System List</h2>
            <a href="{{ route('workScheduleCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Work
                Schedule</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Work Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($work_schedules as $key => $schedule)
                        <tr>
                            <td>{{ $work_schedules->firstItem() + $loop->iteration }}</td>
                            <td>{{ $schedule->employee->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->work_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                            <td>{{ $schedule->task }}</td>
                            <td>
                                @if ($schedule->status == '1')
                                    <span class="badge bg-warning" style="color: black;">Pending</span>
                                @elseif($schedule->status == '2')
                                    <span class="badge bg-success" style="color: black;">Approved</span>
                                @else
                                    <span class="badge bg-danger" style="color: black;">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('timeTrackingUpdateStatus', $schedule->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="form-control">
                                        <option value="1" {{ $schedule->status == '1' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="2" {{ $schedule->status == '2' ? 'selected' : '' }}>Approve
                                        </option>
                                        <option value="3" {{ $schedule->status == '3' ? 'selected' : '' }}>Reject
                                        </option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No schedules found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $work_schedules->links() }}
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
@endsection
