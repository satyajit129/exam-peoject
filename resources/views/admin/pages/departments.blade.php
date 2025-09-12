@extends('backend.global.master')

@section('title', 'Department')
@section('heading', 'Department')

@section('backend_custom_style')
<style>
.employee-count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #007bff; /* your color */
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    width: 24px;   /* fixed width */
    height: 24px;  /* fixed height */
    border-radius: 40%; /* perfect circle */
}


</style>
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Department List</h2>
            <a href="{{ route('departmentCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Department</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Department</th>
                        <th># of Employees</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->department }}</td>
                           <td>
                                @if ($department->employees_count > 0)
                                    <span class="employee-count-badge employees" data-department-id="{{ $department->id }}" style="cursor: pointer;">{{ $department->employees_count }}</span>
                                @endif
                            </td>

                            <td>
                                <a class="btn btn-sm btn-outline-warning ml-2 " title="Edit"
                                    href="{{ route('departmentCreateOrEdit', $department->id) }}">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="javascript:void(0);"
                                    data-url="{{ route('departmentDelete', ['id' => $department->id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete"
                                    class="btn btn-outline-danger btn-sm delete-btn"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="3">No data Found! PLease add data from <a
                                    href="{{ route('departmentCreateOrEdit') }}">here</a> </td>
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
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" id="employeeModalContent">
                <!-- Form content will be loaded here via jQuery -->
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
        $(document).ready(function() {
            $('.employees').on('click', function() {
                var departmentId = $(this).data('department-id');
                $.ajax({
                    url: "{{ route('departmentEmployees') }}",
                    type: 'GET',
                    data: {
                        department_id: departmentId
                    },
                    success: function(response) {
                        $('#employeeModalContent').html(response);
                        $('#employeeModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
