@extends('backend.global.master')

@section('title', 'Role Access')
@section('heading', 'Role Access')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Role Access List</h2>
            <a href="{{ route('roleAccessCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Role Access</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Default</th>
                        <th>Role Name</th>
                        <th>Assign Permission</th>
                        {{-- new column --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="custom-control custom-radio radio-outline-primary d-inline-block">
                                    <input type="radio" 
                                        id="defaultRole{{ $role->id }}" 
                                        name="default_role"
                                        class="custom-control-input default-role-radio"
                                        data-role-id="{{ $role->id }}"
                                        {{ $role->is_default ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="defaultRole{{ $role->id }}"></label>
                                </div>
                            </td>

                            <td>{{ $role->name }}</td>
                            <td>
                                <ul>
                                    @foreach ($role->permissions as $permission)
                                        <li>{{ $permission->bangla_code }}</li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                <a href="{{ route('roleAccessCreateOrEdit', $role->id) }}"
                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                    Edit
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger delete-btn"
                                    data-url="{{ route('roleAccessDelete', ['id' => $role->id]) }}" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" title="Delete">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No Data found</td>
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
    $(document).ready(function() {
        $('.default-role-radio').on('change', function() {
            var roleId = $(this).data('role-id');

            $.ajax({
                url: "{{ route('roleAccessSetDefault') }}",
                method: "GET",
                data: {
                    role_id: roleId
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success('Default role updated successfully!');
                    } else {
                        toastr.error('Something went wrong.');
                    }
                },
                error: function(xhr) {
                    toastr.error('Error occurred!');
                }
            });
        });
    });
    </script>

@endsection
