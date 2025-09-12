@extends('backend.global.master')

@section('title', isset($leave) ? 'Edit Leave' : 'Add Leave')
@section('heading', isset($leave) ? 'Edit Leave' : 'Add Leave')

@section('backend_custom_style')
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>{{ isset($leave) ? 'Edit Leave' : 'Add New Leave' }}</h2>
            <a href="{{ route('leaveList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">

            <!-- Leave Allocation Summary -->
            @if ($leaveAllocations->count() > 0)
                <div class="">
                    <h6 class="alert-heading"><i class="mdi mdi-information"></i> Your Leave Allocation for
                        {{ $currentYear }}</h6>
                    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px;">
                        @foreach ($leaveAllocations as $allocation)
                            <div class="mb-2" style="flex: 1;">
                                <div class="border rounded p-2">
                                    <strong>{{ $allocation->leaveType->name }}</strong><br>
                                    <small class="text-muted">
                                        Total: {{ $allocation->total_leave }} days<br>
                                        Used: {{ $allocation->total_taken }} days<br>
                                        <span class="text-success">Remaining:
                                            {{ $allocation->total_leave - $allocation->total_taken }} days</span>
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert"></i> No leave allocation found for {{ $currentYear }}. Please contact HR.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
                <hr>
            <form action="{{ route('leaveSave', isset($leave) ? $leave->id : '') }}" method="POST" id="leaveForm">
                @csrf
                <div class="mb-3">
                    <label for="leave_type_id" class="form-label">Leave Type <span class="text-danger">*</span></label>
                    <select name="leave_type_id" class="form-control" id="leave_type_id" required>
                        <option value="">-- Select Leave Type --</option>
                        @foreach ($leaveTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ old('leave_type_id', $leave->leave_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="text" name="start_date" class="form-control date"
                        value="{{ old('start_date', $leave->start_date ?? '') }}" required placeholder="Enter Start Date">
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                    <input type="text" name="end_date" class="form-control date" id="end_date"
                        value="{{ old('end_date', $leave->end_date ?? '') }}" required placeholder="Enter End Date">
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea name="reason" class="form-control">{{ old('reason', $leave->reason ?? '') }}</textarea>
                </div>

                <!-- Leave Validation Info -->
                <div id="leaveValidationInfo" class="alert" style="display: none;"></div>

                <button type="submit" class="btn btn-primary" id="submitBtn">
                    {{ isset($leave) ? 'Update Leave' : 'Save Leave' }}
                </button>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".date").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                showAnim: "slideDown",
                defaultDate: new Date()
            });

            // Leave allocation data for validation
            var leaveAllocations = @json($leaveAllocations);

            // Function to calculate days between two dates
            function calculateDays(startDate, endDate) {
                var start = new Date(startDate);
                var end = new Date(endDate);
                var diffTime = Math.abs(end - start);
                var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                return diffDays + 1; // Include both start and end dates
            }

            // Function to validate leave request
            function validateLeaveRequest() {
                var leaveTypeId = $('#leave_type_id').val();
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                if (!leaveTypeId || !startDate || !endDate) {
                    return true; // Let form validation handle required fields
                }

                // Find leave allocation for selected type
                var allocation = leaveAllocations.find(function(item) {
                    return item.leave_type_id == leaveTypeId;
                });

                if (!allocation) {
                    showValidationInfo('No leave allocation found for this leave type.', 'danger');
                    return false;
                }

                // Calculate requested days
                var requestedDays = calculateDays(startDate, endDate);
                var remainingDays = allocation.total_leave - allocation.total_taken;

                if (requestedDays > remainingDays) {
                    showValidationInfo(
                        'Insufficient leaves remaining. You have ' + remainingDays +
                        ' days left, but requesting ' + requestedDays + ' days.',
                        'danger'
                    );
                    return false;
                } else {
                    showValidationInfo(
                        'Leave request valid. You have ' + remainingDays + ' days remaining for ' + allocation
                        .leave_type.name + '.',
                        'success'
                    );
                    return true;
                }
            }

            // Function to show validation info
            function showValidationInfo(message, type) {
                var alertClass = 'alert-' + type;
                $('#leaveValidationInfo')
                    .removeClass()
                    .addClass('alert ' + alertClass)
                    .html('<i class="mdi mdi-' + (type === 'success' ? 'check-circle' : 'alert-circle') +
                        '"></i> ' + message)
                    .show();
            }

            // Validate on form submission
            $('#leaveForm').on('submit', function(e) {
                if (!validateLeaveRequest()) {
                    e.preventDefault();
                    return false;
                }
            });

            // Validate when dates or leave type changes
            $('#leave_type_id, #start_date, #end_date').on('change', function() {
                validateLeaveRequest();
            });

            // Initial validation
            if ($('#leave_type_id').val() && $('#start_date').val() && $('#end_date').val()) {
                validateLeaveRequest();
            }
        });
    </script>
@endsection
