@extends('backend.global.master')

@section('title', 'Leave')
@section('heading', 'Leave')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Leave List</h2>
            <a href="{{ route('leaveCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Leave</a>
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
                        <th>Status</th>
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
                                @if ($leave->status == '1')
                                    <span class="badge bg-warning" style="color: black">Pending</span>
                                @elseif($leave->status == '2')
                                    <span class="badge bg-success" style="color: black">Approved</span>
                                @else
                                    <span class="badge bg-danger" style="color: black">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-warning" title="Edit"
                                    href="{{ route('leaveCreateOrEdit', $leave->id) }}">Edit</a>
                                <a href="javascript:void(0);" data-url="{{ route('leaveDelete', ['id' => $leave->id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete"
                                    class="btn btn-outline-danger btn-sm delete-btn">Delete</a>
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

    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var deleteUrl = $(this).data('url');
                $('#confirmDeleteBtn').attr('href', deleteUrl);
            });
        });
    </script>
@endsection
