@extends('backend.global.master')

@section('title', 'Payroll ' . ($payroll->id ? 'Update' : 'Create'))
@section('heading', 'Payroll ' . ($payroll->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Payroll{{ $payroll->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('payrollList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('payrollSave', $payroll->id ?? '') }}" method="POST">
                @csrf
                <!-- Read-only fields -->
                <div class="form-group mb-2">
                    <label>Month</label>
                    <input type="text" class="form-control" value="{{ $payroll->month_name }}" readonly>
                </div>

                <div class="form-group mb-2">
                    <label>Year</label>
                    <input type="text" class="form-control" value="{{ $payroll->year }}" readonly>
                </div>

                <div class="form-group mb-2">
                    <label>Employee</label>
                    <input type="text" class="form-control" value="{{ $payroll->user->name ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group mb-2">
                    <label>Total Allowances</label>
                    <input type="number" step="0.01" class="form-control" id="total_allowances"
                        value="{{ $payroll->total_allowances }}" readonly>
                </div>

                <div class="form-group mb-2">
                    <label>Total Payable</label>
                    <input type="number" step="0.01" class="form-control" id="total_payable"
                        value="{{ $payroll->total_payable }}" readonly>
                </div>

                <!-- Editable fields -->
                <div class="form-group mb-2">
                    <label>Total Deduction</label>
                    <input type="number" step="0.01" name="total_deduction" class="form-control" id="total_deduction"
                        value="{{ old('total_deduction', $payroll->total_deduction) }}">
                </div>

                <div class="form-group mb-3">
                    <label>Deduction Reason</label>
                    <textarea name="deduction_reason" class="form-control" rows="3">{{ old('deduction_reason', $payroll->deduction_reason) }}</textarea>
                </div>

                <button type="submit" class="btn btn-outline-primary">
                    {{ $payroll->id ? 'Update Payroll' : 'Submit' }}
                </button>
            </form>
        </div>

    </div>
@endsection

@section('backend_custom_js')

    <script>
        $(document).ready(function() {
            $('#total_deduction').on('input', function() {
                var totalAllowances = parseFloat($('#total_allowances').val()) || 0;
                var deduction = parseFloat($(this).val()) || 0;
                var totalPayable = totalAllowances - deduction;
                $('#total_payable').val(totalPayable.toFixed(2));
            });
        });
    </script>
@endsection
