@extends('backend.global.master')

@section('title', 'Attendance ' . ($attendance->id ? 'Update' : 'Create'))
@section('heading', 'Attendance ' . ($attendance->id ? 'Update' : 'Create'))


@section('backend_custom_style')
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2> {{ $attendance->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('attendanceList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('attendanceSave', $attendance->id ?? '') }}" method="post">
                @csrf

                <div class="mb-3">
                    <label>Employee <span class="text-danger">*</span> </label>
                    <select name="user_id" class="form-control select2" required>
                        <option value="">Select Employee</option>
                        @foreach ($employees as $emp)
                            <option value="{{ $emp->id }}"
                                {{ isset($attendance) && $attendance->user_id == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }} ({{ $emp->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Date <span class="text-danger">*</span> </label>
                    <input type="text" name="date" class="form-control date" required placeholder="Enter Date"
                        value="{{ old('date', isset($attendance->id) ? \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') : '') }}">
                </div>

                <div class="mb-3">
                    <label>Status <span class="text-danger">*</span> </label>
                    <select name="status" class="form-control select2" required>
                        <option value="" disabled {{ !isset($attendance) ? 'selected' : '' }}>Select Status</option>
                        <option value="1" {{ isset($attendance) && $attendance->status == 1 ? 'selected' : '' }}>
                            Present</option>
                        <option value="2" {{ isset($attendance) && $attendance->status == 2 ? 'selected' : '' }}>Half
                            Day</option>
                        <option value="3" {{ isset($attendance) && $attendance->status == 3 ? 'selected' : '' }}>
                            Exceptional</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Check In <span class="text-danger">*</span> </label>
                    <input type="time" name="check_in" class="form-control"
                        value="{{ old('check_in', isset($attendance) ? $attendance->check_in : '') }}">
                </div>

                <div class="mb-3">
                    <label>Check Out</label>
                    <input type="time" name="check_out" class="form-control"
                        value="{{ old('check_out', isset($attendance) ? $attendance->check_out : '') }}">
                </div>

                <button type="submit" class="btn btn-outline-primary btn-sm">
                    {{ isset($attendance) ? 'Update' : 'Submit' }}
                </button>
            </form>
        </div>

    </div>
@endsection

@section('backend_custom_js')
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
        });
    </script>

    <script>
        $('.select2').select2({
            placeholder: 'Select an option',
        });
    </script>
@endsection
