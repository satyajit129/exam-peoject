@extends('backend.global.master')

@section('title', 'Work Schedule ' . ($work_schedule->id ? 'Update' : 'Create'))
@section('heading', 'Work Schedule ' . ($work_schedule->id ? 'Update' : 'Create'))


@section('backend_custom_style')
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Work Schedule {{ $work_schedule->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('workScheduleList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('workScheduleSave', $work_schedule->id ?? '') }}" method="POST">
                @csrf
                <!-- Date -->
                <div class="form-group">
                    <label for="work_date">Date</label>
                    <input type="text" class="form-control @error('work_date') is-invalid @enderror" id="work_date"
                        name="work_date"
                        value="{{ old('work_date', $work_schedule->work_date ?? \Carbon\Carbon::now()->format('d-m-Y')) }}"
                        autocomplete="off"
                        placeholder="Select Date">
                    @error('work_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Start Time -->
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                        name="start_time" value="{{ old('start_time', $work_schedule->start_time ?? '') }}">
                    @error('start_time')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- End Time -->
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time"
                        name="end_time" value="{{ old('end_time', $work_schedule->end_time ?? '') }}">
                    @error('end_time')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Task -->
                <div class="form-group">
                    <label for="task">Task</label>
                    <textarea class="form-control @error('task') is-invalid @enderror" id="task" name="task"
                        placeholder="Enter Task" rows="4">{{ old('task', $work_schedule->task ?? '') }}</textarea>
                    @error('task')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>


                <button type="submit" class="btn btn-outline-primary btn-sm">
                    {{ isset($work_schedule->id) ? 'Update' : 'Submit' }}
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
            $("#work_date").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                showAnim: "slideDown",
                defaultDate: new Date()
            });
        });
    </script>

@endsection
