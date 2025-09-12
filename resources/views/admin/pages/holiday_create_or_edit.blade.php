@extends('backend.global.master')

@section('title', 'Holiday ' . ($holiday->id ? 'Update' : 'Create'))
@section('heading', 'Holiday ' . ($holiday->id ? 'Update' : 'Create'))

@section('backend_custom_style')
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>{{ $holiday->id ? 'Update' : 'Create' }} Holiday</h2>
            <a href="{{ route('holidayList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To List</a>
        </div>
        <div class="card-body">
            <form action="{{ route('holidaySave', $holiday->id ?? '') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Holiday Type <span class="text-danger">*</span></label>
                            <select name="holiday_type_id" class="form-control select2" required>
                                <option value="">Select Holiday Type</option>
                                @foreach ($holidayTypes as $holidayType)
                                    <option value="{{ $holidayType->id }}"
                                        {{ old('holiday_type_id', $holiday->holiday_type_id ?? '') == $holidayType->id ? 'selected' : '' }}>
                                        {{ $holidayType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('holiday_type_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Holiday Name <span class="text-danger">*</span></label>
                            <input type="text" name="holiday_name" class="form-control" required
                                placeholder="Enter Holiday Name"
                                value="{{ old('holiday_name', $holiday->holiday_name ?? '') }}">
                            @error('holiday_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Start Date <span class="text-danger">*</span></label>
                            <input type="text" name="start_date" class="form-control datepicker" required
                                placeholder="Select Start Date"
                                value="{{ old('start_date', $holiday->start_date ? $holiday->start_date->format('d-m-Y') : '') }}">
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>End Date <span class="text-danger">*</span></label>
                            <input type="text" name="end_date" class="form-control datepicker" required
                                placeholder="Select End Date"
                                value="{{ old('end_date', $holiday->end_date ? $holiday->end_date->format('d-m-Y') : '') }}">
                            @error('end_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Enter holiday description (optional)">{{ old('description', $holiday->description ?? '') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Is Adjustable <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_adjustable" id="adjustable_yes"
                            value="1" {{ old('is_adjustable', $holiday->is_adjustable ?? '') == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="adjustable_yes">
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_adjustable" id="adjustable_no"
                            value="0" {{ old('is_adjustable', $holiday->is_adjustable ?? '') == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="adjustable_no">
                            No
                        </label>
                    </div>
                    @error('is_adjustable')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-outline-primary btn-sm">
                    {{ $holiday->id ? 'Update' : 'Submit' }}
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
            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Select an option',
                width: '100%'
            });

            // Initialize DatePicker
            $('.datepicker').datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                showAnim: "slideDown",
                yearRange: "2020:2030"
            });

            // Auto-calculate total days when dates change
            $('.datepicker').on('change', function() {
                calculateTotalDays();
            });

            function calculateTotalDays() {
                var startDate = $('input[name="start_date"]').val();
                var endDate = $('input[name="end_date"]').val();

                if (startDate && endDate) {
                    var start = new Date(startDate.split('-').reverse().join('-'));
                    var end = new Date(endDate.split('-').reverse().join('-'));

                    if (end >= start) {
                        var timeDiff = end.getTime() - start.getTime();
                        var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

                        // Show total days info
                        if (!$('#totalDaysInfo').length) {
                            $('input[name="end_date"]').after(
                                '<div id="totalDaysInfo" class="form-text text-info"></div>');
                        }
                        $('#totalDaysInfo').text('Total Days: ' + daysDiff + (daysDiff == 1 ? ' Day' : ' Days'));
                    }
                }
            }

            // Calculate on page load if dates are already filled
            calculateTotalDays();
        });
    </script>
@endsection
