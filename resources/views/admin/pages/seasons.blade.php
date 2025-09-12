@extends('backend.global.master')

@section('title', 'Season')
@section('heading', 'Season')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Season List</h2>
            <a href="{{ route('seasonCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Season</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Season Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($seasons as $season)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $season->season_name }}</td>
                            <td>
                                @if ($season->status)
                                    <span class="badge bg-success text-white">
                                        <i class="mdi mdi-check-circle"></i> Active (Current)
                                    </span>
                                @else
                                    <span class="badge bg-danger text-white">
                                        <i class="mdi mdi-close-circle"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-warning ml-2 " title="Edit"
                                    href="{{ route('seasonCreateOrEdit', $season->id) }}">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="javascript:void(0);" data-url="{{ route('seasonDelete', ['id' => $season->id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete"
                                    class="btn btn-outline-danger btn-sm delete-btn"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="4">No data Found! Please add data from <a
                                    href="{{ route('seasonCreateOrEdit') }}">here</a> </td>
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
                    Are you sure you want to delete this season?
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
