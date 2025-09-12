@extends('backend.global.master')

@section('title', 'Season Shift Form')
@section('heading', 'Season Shift Form')

@section('backend_custom_style')
    <style>
        .time-input-group {
            display: flex;
            gap: 10px;
        }
    </style>
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Season Shift Form</h2>
            <a href="{{ route('shiftList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
       <div class="card-body">
    <form action="{{ route('seasonShiftSave',['season_id' => $season_shift->season_id ?? '' , 'shift_id' => $season_shift->shift_id ?? '']) }}" method="post" id="shiftForm">
        @csrf

        <!-- Basic Shift Information -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="season_id">Season <span class="text-danger">*</span></label>
                    <select class="form-control " name="season_id" id="season_id" required>
                        <option value="">Select Season</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season->id }}"
                                {{ old('season_id', $season_shift->season_id ?? '') == $season->id ? 'selected' : '' }}>
                                {{ $season->season_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('season_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="shift_id">Shift Name <span class="text-danger">*</span></label>
                    <select name="shift_id" id="shift_id" class="form-control " required>
                        <option value="">Select Shift</option>
                        @foreach ($shifts as $shiftItem)
                            <option value="{{ $shiftItem->id }}"
                                {{ old('shift_id', $season_shift->shift_id ?? '') == $shiftItem->id ? 'selected' : '' }}>
                                {{ $shiftItem->shift_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('shift_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Weekdays Configuration -->
        <div class="weekday-section">
            <div class="weekday-header mb-5">
                <h5 class="mb-0">Weekdays Configuration</h5>
                <small class="text-muted">Select weekdays and set shift times. Unchecked days will be treated as weekends.</small>

                <!-- Copy Time Button -->
                <div class="mt-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="copyTimeBtn">
                        <i class="mdi mdi-content-copy"></i> Copy Time to Selected Days
                    </button>
                    <small class="text-muted ms-2">Fill Saturday's time first, then select other days and click copy</small>
                </div>
            </div>

            @php
                $rearrangedWeekdays = [
                    'sat' => 'Saturday',
                    'sun' => 'Sunday',
                    'mon' => 'Monday',
                    'tue' => 'Tuesday',
                    'wed' => 'Wednesday',
                    'thu' => 'Thursday',
                    'fri' => 'Friday',
                ];
            @endphp

            @foreach ($rearrangedWeekdays as $key => $name)
                @php
                    $detail = $season_shift_details[$key] ?? null;
                    $is_weekend = $season_shift_details[$key]->is_weekend ?? 0;
                    $start_time = $season_shift_details[$key]->shift_start_time ?? '';
                    $end_time = $season_shift_details[$key]->shift_end_time ?? '';
                    $entry_allow_start_time = $season_shift_details[$key]->entry_allow_start_time ?? '';
                    $entry_allow_end_time = $season_shift_details[$key]->entry_allow_end_time ?? '';
                    Log::info('Detail for ' . $key . ': ' . json_encode($detail));
                @endphp
                <div class="row mb-3">
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input weekday-checkbox" type="checkbox"
                                   name="weekdays[]" id="weekday_{{ $key }}" value="{{ $key }}"
                                   {{ (!$is_weekend) ? 'checked' : '' }}>
                            <label class="form-check-label" for="weekday_{{ $key }}">
                                <strong>{{ $name }}</strong>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="shift_start_time_{{ $key }}">Start Time</label>
                                    <input type="time" class="form-control shift-time-input"
                                           name="shift_start_times[{{ $key }}]"
                                           id="shift_start_time_{{ $key }}"
                                           value="{{ old('shift_start_times.'.$key, $start_time ?? '') }}">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="shift_end_time_{{ $key }}">End Time</label>
                                    <input type="time" class="form-control shift-time-input"
                                           name="shift_end_times[{{ $key }}]"
                                           id="shift_end_time_{{ $key }}"
                                           value="{{ old('shift_end_times.'.$key, $detail->shift_end_time ?? '') }}">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="entry_allow_start_time_{{ $key }}">Entry Allowance Start Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control"
                                           name="entry_allow_start_time[{{ $key }}]"
                                           id="entry_allow_start_time_{{ $key }}"
                                           value="{{ old('entry_allow_start_time.'.$key, $detail->entry_allow_start_time ?? '') }}">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="entry_allow_end_time_{{ $key }}">Entry Allowance End Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control"
                                           name="entry_allow_end_time[{{ $key }}]"
                                           id="entry_allow_end_time_{{ $key }}"
                                           value="{{ old('entry_allow_end_time.'.$key, $detail->entry_allow_end_time ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden input to always submit weekday -->
                <input type="hidden" name="all_weekdays[]" value="{{ $key }}">
            @endforeach
        </div>

        <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
    </form>
</div>

    </div>
@endsection


@section('backend_custom_js')
    <script>
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select an option',
        });
    </script>
<script>
    $(document).ready(function () {
        // Handle weekday checkbox changes
        $('.weekday-checkbox').on('change', function () {
            var weekday = $(this).val();
            var isChecked = $(this).is(':checked');

            // Enable/disable all time inputs based on checkbox
            $('#shift_start_time_' + weekday +
              ', #shift_end_time_' + weekday +
              ', #entry_allow_start_time_' + weekday +
              ', #entry_allow_end_time_' + weekday
            ).prop('disabled', !isChecked);

            // Clear time values if unchecked
            if (!isChecked) {
                $('#shift_start_time_' + weekday +
                  ', #shift_end_time_' + weekday +
                  ', #entry_allow_start_time_' + weekday +
                  ', #entry_allow_end_time_' + weekday
                ).val('');
            }
        });

        // Form validation
        $('#shiftForm').on('submit', function (e) {
            var checkedWeekdays = $('.weekday-checkbox:checked');

            if (checkedWeekdays.length === 0) {
                e.preventDefault();
                alert('Please select at least one weekday for the shift.');
                return false;
            }

            var isValid = true;

            checkedWeekdays.each(function () {
                var weekday = $(this).val();
                var startTime = $('#shift_start_time_' + weekday).val();
                var endTime = $('#shift_end_time_' + weekday).val();
                var entryStart = $('#entry_allow_start_time_' + weekday).val();
                var entryEnd = $('#entry_allow_end_time_' + weekday).val();

                // Check required fields
                if (!startTime || !endTime || !entryStart || !entryEnd) {
                    isValid = false;
                    return false;
                }

                // Validate ordering
                if (startTime >= endTime) {
                    isValid = false;
                    return false;
                }
                if (entryStart >= entryEnd) {
                    isValid = false;
                    return false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please provide valid times for all selected weekdays. ' +
                    'Shift end time must be after start time, ' +
                    'and entry allowance end time must be after entry allowance start time.');
                return false;
            }
        });

        // Copy time functionality (Saturday → others)
        $('#copyTimeBtn').on('click', function () {
            var satStartTime = $('#shift_start_time_sat').val();
            var satEndTime = $('#shift_end_time_sat').val();
            var satEntryStart = $('#entry_allow_start_time_sat').val();
            var satEntryEnd = $('#entry_allow_end_time_sat').val();

            if (!satStartTime || !satEndTime || !satEntryStart || !satEntryEnd) {
                alert('Please fill Saturday\'s start/end and entry allowance times first before copying.');
                return;
            }

            // Copy to all checked weekdays except Saturday
            var checkedWeekdays = $('.weekday-checkbox:checked').not('#weekday_sat');

            if (checkedWeekdays.length === 0) {
                alert('Please select other weekdays (excluding Saturday) to copy the times to.');
                return;
            }

            checkedWeekdays.each(function () {
                var weekday = $(this).val();
                $('#shift_start_time_' + weekday).val(satStartTime);
                $('#shift_end_time_' + weekday).val(satEndTime);
                $('#entry_allow_start_time_' + weekday).val(satEntryStart);
                $('#entry_allow_end_time_' + weekday).val(satEntryEnd);
            });

            alert('Times copied successfully to ' + checkedWeekdays.length + ' selected day(s)!');
        });

        // Trigger change on page load to set initial state
        $('.weekday-checkbox').trigger('change');
    });
</script>

@endsection
