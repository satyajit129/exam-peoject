@extends('backend.global.master')

@section('title', 'Work Location')
@section('heading', 'Work Location')

@section('backend_custom_style')
<style>
        .employee-count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #007bff;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            width: 24px;
            height: 24px;
            border-radius: 40%;
        }
    </style>
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Work Location List</h2>
            <a href="{{ route('workLocationCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Work Location</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Work Location</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th># of Employee</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($work_locations as $work_location)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $work_location->name }}</td>
                            <td>{{ $work_location->address }}</td>
                            <td>{{ $work_location->contact_no }}</td>
                            <th>
                                 @if ($work_location->employees_count > 0)
                                    <span class="employee-count-badge employees" data-work_location-id="{{ $work_location->id }}"
                                        style="cursor: pointer;">{{ $work_location->employees_count }}</span>
                                @endif
                            </th>
                            <td>
                                <a class="btn btn-sm btn-outline-warning ml-2 " title="Edit"
                                    href="{{ route('workLocationCreateOrEdit', $work_location->id) }}">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="javascript:void(0);"
                                    data-url="{{ route('workLocationDelete', ['id' => $work_location->id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete"
                                    class="btn btn-outline-danger btn-sm delete-btn"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">No data Found! PLease add data from <a
                                    href="{{ route('workLocationCreateOrEdit') }}">here</a> </td>
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
                var workLocationId = $(this).data('work_location-id');
                $.ajax({
                    url: "{{ route('workLocationEmployee') }}",
                    type: 'GET',
                    data: {
                        work_location: workLocationId
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
