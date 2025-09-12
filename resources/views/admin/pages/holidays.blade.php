@extends('backend.global.master')

@section('title', 'Holidays')
@section('heading', 'Holidays')

@section('backend_custom_style')
<style>
    .expired-row {
    background-color: #f0f0f0; /* light gray */
    color: #6c757d; /* muted text */
}
</style>
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Holiday List</h2>
            <a href="{{ route('holidayCreateOrEdit') }}" class="btn btn-outline-primary btn-sm">Add New Holiday</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <strong>Total Holiday Days:</strong> {{ $totalHolidayDays }} days
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Holiday Type</th>
                        <th>Holiday Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Days Count</th>
                        <th>Is Adjustable</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($holidays as $holiday)
                       <tr class="@if ($holiday->end_date < now()) expired-row @endif">
                            <td>{{ $holidays->firstItem() + $loop->index }}</td>
                            <td>{{ $holiday->holidayType->name }}</td>
                            <td>{{ $holiday->holiday_name }}</td>
                            <td>{{ $holiday->start_date->format('d-m-Y') }}</td>
                            <td>{{ $holiday->end_date->format('d-m-Y') }}</td>
                            <td>
                                @if ($holiday->adjust_holiday_ids && count($holiday->adjust_holiday_ids) > 0)
                                    <div class="d-flex flex-column">
                                        <span class="badge badge-primary mb-1">{{ $holiday->remaining_days }}
                                            {{ $holiday->remaining_days == 1 ? 'Day' : 'Days' }}</span>
                                        <small class="text-muted">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-html="true"
                                                title="{{ $holiday->adjusted_holidays_text }}" class="text-info">
                                                + {{ $holiday->adjusted_days }}
                                                {{ $holiday->adjusted_days == 1 ? 'Day' : 'Days' }}
                                            </a>
                                        </small>
                                        <span class="badge badge-primary mb-1">{{ $holiday->total_days }}
                                            {{ $holiday->total_days == 1 ? 'Day' : 'Days' }}</span>
                                    </div>
                                @else
                                    <span class="badge badge-primary">{{ $holiday->total_days }}
                                        {{ $holiday->total_days == 1 ? 'Day' : 'Days' }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($holiday->is_adjustable)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-warning ml-2" title="Edit"
                                    href="{{ route('holidayCreateOrEdit', $holiday->id) }}">Edit</a>
                                @if ($holiday->is_adjustable)
                                    <a class="btn btn-sm btn-outline-info ml-2" title="Adjust Holiday"
                                        href="{{ route('holidayAdjust', $holiday->id) }}">Adjust</a>
                                @endif
                                <a href="javascript:void(0);"
                                    data-url="{{ route('holidayDelete', ['id' => $holiday->id]) }}" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" title="Delete"
                                    class="btn btn-outline-danger btn-sm delete-btn">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">No data Found! Please add data from <a
                                    href="{{ route('holidayCreateOrEdit') }}">here</a></td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        {{ $holidays->links() }}
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

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
