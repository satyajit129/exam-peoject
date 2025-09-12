@extends('backend.global.master')

@section('title', 'Season')
@section('heading', 'Season')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Season List</h2>
            <a href="{{ route('seasonShiftCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Season</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 10%;">Season</th>
                        <th style="width: 10%;">Shift</th>
                        <th style="width: 60%;">Week Time</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($season_shifts as $season_shift)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $season_shift->season->season_name }}</td>
                            <td>{{ $season_shift->shift->shift_name }}</td>
                            @php
                                $weekdays = \App\Models\SeasonShiftDetail::where('season_id', $season_shift->season_id)
                                    ->where('shift_id', $season_shift->shift_id)
                                    ->where('is_weekend', 0)
                                    ->get();
                            @endphp
                            <td>
                                <div class="d-flex flex-wrap" style="gap: 5px;">
                                    @foreach ($weekdays as $weekday)
                                        <div class="badge badge-primary text-center" style="min-width: 30%;">
                                            {{ $weekday->weekday }}:
                                            {{ \Carbon\Carbon::parse($weekday->shift_start_time)->format('g:i A') }} -
                                            {{ \Carbon\Carbon::parse($weekday->shift_end_time)->format('g:i A') }}
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <!-- Action buttons go here -->
                                <a href="{{ route('seasonShiftCreateOrEdit', ['season_id' => $season_shift->season_id, 'shift_id' => $season_shift->shift_id]) }}"
                                    class="btn btn-sm btn-outline-warning">
                                    Edit
                                </a>

                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger delete-btn"
                                    data-url="{{ route('seasonShiftDelete', ['season_id' => $season_shift->season_id, 'shift_id' => $season_shift->shift_id]) }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
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
                    Are you sure you want to delete this data?
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
