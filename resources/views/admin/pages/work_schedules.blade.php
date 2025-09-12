@extends('backend.global.master')

@section('title', 'Work Schedule')
@section('heading', 'Work Schedule')

@section('backend_custom_style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Filter</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('workScheduleList') }}" method="GET" class="mb-4">
                @csrf
                <!--  Date Range -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"> Date</label>
                        <input type="text" id="date" name="date" class="form-control"
                            value="{{ request('date') }}" placeholder="Select Date Range">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option disabled selected>--Select an Option--</option>
                            <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Pending</option>
                            <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Approve</option>
                            <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Reject</option>
                        </select>
                    </div>
                </div>
                <!-- Buttons (now inside the form) -->
                <div class="row mt-2">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="{{ route('workScheduleList') }}" class="btn btn-secondary btn-sm">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Today Schedule List</h2>
            <a href="{{ route('workScheduleCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Work
                Schedule</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Work Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($work_schedules as $key => $work_schedule)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($work_schedule->work_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($work_schedule->start_time)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($work_schedule->end_time)->format('h:i A') }}</td>
                            <td>{{ $work_schedule->task }}</td>
                            <td>
                                @if ($work_schedule->status == '1')
                                    <span class="badge bg-warning" style="color: black;">Pending</span>
                                @elseif($work_schedule->status == '2')
                                    <span class="badge bg-success" style="color: black;">Approved</span>
                                @else
                                    <span class="badge bg-danger" style="color: black;">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('workScheduleCreateOrEdit', $work_schedule->id) }}" class="btn btn-sm btn-outline-warning ml-2 " title="Edit">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="javascript:void(0);"
                                    data-url="{{ route('workScheduleDelete', ['id' => $work_schedule->id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete"
                                    class="btn btn-outline-danger btn-sm delete-btn"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No schedules found.</td>
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
