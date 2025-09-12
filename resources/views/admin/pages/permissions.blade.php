@extends('backend.global.master')

@section('title', 'Permission')
@section('heading', 'Permission')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Permission List</h2>
            <a href="{{ route('permissionCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Permission</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Permission</th>
                        <th>Bangla Text</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   @forelse ($permissions as $permission)
                        <tr>
                            <td>{{ $permissions->firstItem() + $loop->index }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->bangla_code }}</td>

                            <td>
                                <a href="{{ route('permissionCreateOrEdit', $permission->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    Edit
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger delete-btn"
                                    data-url="{{ route('permissionDelete', ['id' => $permission->id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete">
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
            <div class="mt-3">
            {{ $permissions->links() }}
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

    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var deleteUrl = $(this).data('url');
                $('#confirmDeleteBtn').attr('href', deleteUrl);
            });
        });
    </script>
@endsection
