@extends('backend.global.master')

@section('title', 'Leave Allocation')
@section('heading', 'Leave Allocation')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Filter</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('leaveAllocationList') }}" method="GET">
                @csrf
                <div class="row g-3">
                    <!-- Employee -->
                    <div class="col-lg-12 col-12">
                        <label for="employee" class="form-label">Employee</label>
                        <select name="employee" id="employee" class="form-control select2">
                            <option value="">Select Employee</option>
                            @foreach ($users as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row g-3 mt-3">
                    <!-- Buttons -->
                    <div class="col-lg-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary mr-2 btn-sm" >
                            <i class="bi bi-search"></i> Submit
                        </button>
                        <a href="{{ route('leaveAllocationList') }}" class="btn btn-outline-secondary btn-sm"
                            >
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Leave Allocation List</h2>
            <a href="{{ route('leaveAllocationCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Leave
                Allocation</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Leave Taken</th>
                        <th>Leave Available</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>

                            {{-- Leave Taken --}}
                            <td>
                                @forelse($user->leaveAllocations as $allocation)
                                    <div>
                                        {{ $allocation->leaveType->name ?? 'N/A' }} Taken -
                                        {{ $allocation->total_taken ?? 0 }}
                                    </div>
                                @empty
                                    <span class="text-muted">No allocations</span>
                                @endforelse
                            </td>

                            {{-- Leave Available --}}
                            <td>
                                @forelse($user->leaveAllocations as $allocation)
                                    <div>
                                        {{ $allocation->leaveType->name ?? 'N/A' }} Available -
                                        {{ $allocation->total_leave - $allocation->total_taken }}
                                    </div>
                                @empty
                                    <span class="text-muted">No allocations</span>
                                @endforelse
                            </td>

                            {{-- Action --}}
                            <td>
                                <a class="btn btn-sm btn-outline-warning"
                                    href="{{ route('leaveAllocationCreateOrEdit', $user->id) }}">
                                     <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="javascript:void(0);"
                                    data-url="{{ route('leaveAllocationDelete', ['id' => $user->id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    class="btn btn-outline-danger btn-sm delete-btn">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No data found! Please add data from
                                <a href="{{ route('leaveAllocationCreateOrEdit') }}">here</a>
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

    <script>
        $('.select2').select2({
            placeholder: 'Select an option',
        });
    </script>
@endsection
