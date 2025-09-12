@extends('backend.global.master')

@section('title', 'Adjust Holiday - ' . $holiday->holiday_name)
@section('heading', 'Adjust Holiday - ' . $holiday->holiday_name)

@section('backend_custom_style')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Adjust Holiday: {{ $holiday->holiday_name }}</h2>
            <a href="{{ route('holidayList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To List</a>
        </div>
        <div class="card-body">
            <!-- Current Holiday Info -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <h5><strong>Current Holiday Details:</strong></h5>
                        <p><strong>Holiday Type:</strong> {{ $holiday->holidayType->name }}</p>
                        <p><strong>Duration:</strong> {{ $holiday->start_date->format('d-m-Y') }} to
                            {{ $holiday->end_date->format('d-m-Y') }}</p>
                        <p><strong>Total Days:</strong> {{ $holiday->total_days }}
                            {{ $holiday->total_days == 1 ? 'Day' : 'Days' }}</p>
                        @if ($holiday->description)
                            <p><strong>Description:</strong> {{ $holiday->description }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <form action="{{ route('holidayAdjustSave', $holiday->id) }}" method="post">
                @csrf

                <div class="mb-3">
                    <label>Select Holidays to Adjust With <span class="text-muted">(Multiple Selection)</span></label>
                    <select name="adjust_holiday_ids[]" class="form-control select2-multiple" multiple>
                        @foreach ($availableHolidays as $availableHoliday)
                            <option value="{{ $availableHoliday->id }}"
                                {{ in_array($availableHoliday->id, $holiday->adjust_holiday_ids ?? []) ? 'selected' : '' }}>
                                {{ $availableHoliday->holiday_name }}
                                ({{ $availableHoliday->start_date->format('d-m-Y') }} to
                                {{ $availableHoliday->end_date->format('d-m-Y') }})
                                - {{ $availableHoliday->total_days }}
                                {{ $availableHoliday->total_days == 1 ? 'Day' : 'Days' }}
                            </option>
                        @endforeach
                    </select>
                    @error('adjust_holiday_ids')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Select multiple holidays that will be used to adjust this holiday.
                        Only adjustable holidays are shown in the list.
                    </div>
                </div>

                <!-- Current Adjustment Display -->
                @if ($holiday->adjust_holiday_ids && count($holiday->adjust_holiday_ids) > 0)
                    <div class="mb-3">
                        <label>Current Adjustments:</label>
                        <div class="alert alert-warning">
                            @foreach ($holiday->adjustedHolidays() as $adjustedHoliday)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>
                                        <strong>{{ $adjustedHoliday->holiday_name }}</strong>
                                        ({{ $adjustedHoliday->start_date->format('d-m-Y') }} to
                                        {{ $adjustedHoliday->end_date->format('d-m-Y') }})
                                    </span>
                                    <span class="badge badge-primary">{{ $adjustedHoliday->total_days }}
                                        {{ $adjustedHoliday->total_days == 1 ? 'Day' : 'Days' }}</span>
                                </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Total Adjusted Days:</strong>
                                <span class="badge badge-success">{{ $holiday->adjusted_days }}
                                    {{ $holiday->adjusted_days == 1 ? 'Day' : 'Days' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Remaining Days:</strong>
                                <span class="badge badge-info">{{ $holiday->remaining_days }}
                                    {{ $holiday->remaining_days == 1 ? 'Day' : 'Days' }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <button type="submit" class="btn btn-outline-primary btn-sm">
                    Save Adjustments
                </button>
                <a href="{{ route('holidayList') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@section('backend_custom_js')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 with multiple selection
            $('.select2-multiple').select2({
                placeholder: 'Select holidays to adjust with...',
                width: '100%',
                allowClear: true
            });

            // Update adjustment display when selection changes
            $('.select2-multiple').on('change', function() {
                updateAdjustmentDisplay();
            });

            function updateAdjustmentDisplay() {
                var selectedOptions = $('.select2-multiple option:selected');
                var totalAdjustedDays = 0;
                var adjustmentText = '';

                selectedOptions.each(function() {
                    var optionText = $(this).text();
                    var daysMatch = optionText.match(/(\d+)\s+Days?$/);
                    if (daysMatch) {
                        totalAdjustedDays += parseInt(daysMatch[1]);
                    }
                    adjustmentText += '<div class="d-flex justify-content-between align-items-center">';
                    adjustmentText += '<span>' + optionText.replace(/\s+-\s+\d+\s+Days?$/, '') + '</span>';
                    adjustmentText += '<span class="badge badge-primary">' + daysMatch[0] + '</span>';
                    adjustmentText += '</div>';
                });

                // Update or create adjustment display
                if (totalAdjustedDays > 0) {
                    var displayHtml = '<div class="alert alert-warning">';
                    displayHtml += '<label>Preview Adjustments:</label>';
                    displayHtml += adjustmentText;
                    displayHtml += '<hr>';
                    displayHtml += '<div class="d-flex justify-content-between align-items-center">';
                    displayHtml += '<strong>Total Adjusted Days:</strong>';
                    displayHtml += '<span class="badge badge-success">' + totalAdjustedDays + ' ' + (
                        totalAdjustedDays == 1 ? 'Day' : 'Days') + '</span>';
                    displayHtml += '</div>';
                    displayHtml += '<div class="d-flex justify-content-between align-items-center">';
                    displayHtml += '<strong>Remaining Days:</strong>';
                    displayHtml += '<span class="badge badge-info">' + ({{ $holiday->total_days }} -
                        totalAdjustedDays) + ' ' + ({{ $holiday->total_days }} - totalAdjustedDays == 1 ?
                        'Day' : 'Days') + '</span>';
                    displayHtml += '</div>';
                    displayHtml += '</div>';

                    if ($('#previewAdjustments').length) {
                        $('#previewAdjustments').html(displayHtml);
                    } else {
                        $('.select2-multiple').after('<div id="previewAdjustments">' + displayHtml + '</div>');
                    }
                } else {
                    $('#previewAdjustments').remove();
                }
            }

            // Initial calculation
            updateAdjustmentDisplay();
        });
    </script>
@endsection
