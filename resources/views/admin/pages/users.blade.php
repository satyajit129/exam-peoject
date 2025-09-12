@extends('backend.global.master')

@section('title', 'User List')
@section('heading', 'User List')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>User List</h2>
            {{-- <a href="{{ route('userCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New User</a> --}}
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{  $users->firstItem() + $loop->index  }}</td>
                            <td>
                                <h5>{{ $user->name }}</h5>
                                <p class="text-primary">{{ $user->email }}</p>
                            </td>
                            <td><span class="badge badge-info">{{ $user->adminRole->name }}</span></td>
                            <td>
                                <a class="btn btn-sm btn-outline-warning ml-2 " title="Edit"
                                    href="{{ route('userCreateOrEdit', $user->id) }}">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="3">No data Found! PLease add data from <a
                                    href="{{ route('userCreateOrEdit') }}">here</a> </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->appends(request()->all())->links() }}
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
