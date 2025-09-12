@extends('backend.global.master')

@section('title', 'Holiday Type')
@section('heading', 'Holiday Type')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Holiday Type List</h2>
            <a href="{{ route('holidayTypeCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Holiday Type</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Holiday Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($holidayTypes as $holidayType)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $holidayType->name }}</td>
                            <td>
                                <a class="btn btn-sm btn-outline-warning ml-2" title="Edit"
                                    href="{{ route('holidayTypeCreateOrEdit', $holidayType->id) }}">Edit</a>
                                <a href="javascript:void(0);"
                                    data-url="{{ route('holidayTypeDelete', ['id' => $holidayType->id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete"
                                    class="btn btn-outline-danger btn-sm delete-btn">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="3">No data Found! Please add data from <a
                                    href="{{ route('holidayTypeCreateOrEdit') }}">here</a></td>
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
