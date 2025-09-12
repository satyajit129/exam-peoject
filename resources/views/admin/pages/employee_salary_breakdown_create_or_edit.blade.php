@extends('backend.global.master')

@section('title', $salaryBreakdown->id ? 'Edit Employee Salary Breakdown' : 'Create Employee Salary Breakdown')

@section('backend_custom_style')
    <style>
        .allowance-input-group {
            margin-bottom: 15px;
        }

        .loading {
            background-color: #f8f9fa !important;
            border-color: #007bff !important;
        }

        .form-control[readonly] {
            background-color: #e9ecef;
        }
    </style>
@endsection

@section('backend_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="mdi {{ $salaryBreakdown->id ? 'mdi-pencil' : 'mdi-plus-circle' }}"></i>
                            {{ $salaryBreakdown->id ? 'Edit' : 'Create' }} Employee Salary Breakdown
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('employeeSalaryBreakdownList') }}" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('employeeSalaryBreakdownSave', $salaryBreakdown->id) }}" method="POST"
                        id="salaryForm">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">Employee <span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('user_id') is-invalid @enderror"
                                            id="user_id" name="user_id" required>
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('user_id', $salaryBreakdown->user_id) == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gross_salary">Gross Salary <span class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('gross_salary') is-invalid @enderror"
                                            id="gross_salary" name="gross_salary"
                                            value="{{ old('gross_salary', $salaryBreakdown->gross_salary) }}" step="0.01"
                                            min="0" placeholder="Enter gross salary" required
                                            data-original-value="{{ $salaryBreakdown->gross_salary ?? 0 }}">
                                        <small class="form-text text-muted">
                                            <i class="mdi mdi-information-outline"></i>
                                            Enter gross salary to auto-calculate basic salary and percentage-based
                                            allowances.
                                            Other allowances can be added and will auto-adjust the basic salary.
                                        </small>
                                        @error('gross_salary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Salary Breakdown Summary -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="mdi mdi-calculator"></i>
                                        Salary Breakdown Summary
                                    </h5>
                                    <p class="text-muted mb-3">
                                        Enter gross salary to auto-calculate basic salary and house rent (45% of basic).
                                        Add other allowances as needed - the system will automatically adjust basic salary
                                        to maintain balance.
                                    </p>
                                    <div class="row">
                                        @foreach ($payrollAllowances as $index => $allowance)
                                            @php
                                                $existingAllowance = $salaryBreakdown->id
                                                    ? $salaryBreakdown->salaryAllowances
                                                        ->where('payroll_allowance_id', $allowance->id)
                                                        ->first()
                                                    : null;
                                                $existingAmount = $existingAllowance
                                                    ? $existingAllowance->calculated_amount
                                                    : 0;
                                                Log::info(
                                                    "Allowance: {$allowance->name}, Type: {$allowance->type->value}, Existing Amount: {$existingAmount}",
                                                );

                                            @endphp
                                            <div class="col-md-3 mb-3">
                                                <label>{{ $allowance->name }}
                                                    @if ($allowance->type->value === 'fixed')
                                                        (Fixed)
                                                    @else
                                                        ({{ $allowance->allowance }}% of Basic)
                                                    @endif
                                                </label>
                                                <input type="text" class="form-control allowance-input"
                                                    id="allowance_{{ $allowance->id }}"
                                                    name="allowances[{{ $allowance->id }}][amount]"
                                                    value="{{ $existingAmount > 0 ? $existingAmount : $allowance->allowance }}"
                                                    placeholder="0.00" data-allowance-id="{{ $allowance->id }}"
                                                    data-allowance-type="{{ $allowance->type }}"
                                                    data-allowance-initialallowance="{{ $allowance->allowance }}"
                                                    data-allowance-value="{{ $allowance->allowance }}"
                                                    data-parent-id="{{ $allowance->parent_allowance_id }}">
                                                <input type="hidden" name="allowances[{{ $allowance->id }}][name]"
                                                    value="{{ $allowance->name }}">
                                                <input type="hidden" name="allowances[{{ $allowance->id }}][type]"
                                                    value="{{ $allowance->type }}">
                                                <input type="hidden" name="allowances[{{ $allowance->id }}][value]"
                                                    value="{{ $allowance->allowance }}">
                                                <input type="hidden" name="allowances[{{ $allowance->id }}][parent_id]"
                                                    value="{{ $allowance->parent_allowance_id }}">
                                            </div>
                                        @endforeach

                                        <!-- Additional calculated fields -->
                                        <div class="col-md-3">
                                            <label>Total Allowances</label>
                                            <div class="form-control" id="total_allowances_display">
                                                ৳{{ number_format($salaryBreakdown->total_allowances ?? 0, 2) }}</div>
                                        </div>
                                        {{-- <div class="col-md-3">
                                            <label>Remaining Amount</label>
                                            <div class="form-control" id="remaining_amount_display">
                                                ৳{{ number_format(($salaryBreakdown->gross_salary ?? 0) - ($salaryBreakdown->total_allowances ?? 0), 2) }}
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> {{ $salaryBreakdown->id ? 'Update' : 'Create' }}
                                    Salary Breakdown
                                </button>
                                <a href="{{ route('employeeSalaryBreakdownList') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-close"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('backend_custom_js')

    <script>
        $(document).ready(function() {
            function recalcAllowances() {
                let grossSalary = parseFloat($("#gross_salary").val()) || 0;
                if (grossSalary <= 0) return;

                let fixedTotal = 0;
                let percentageAllowances = [];
                let basicField = null;
                $(".allowance-input").each(function() {
                    let type = $(this).data("allowance-type");
                    let allowanceName = $(this).siblings("input[name$='[name]']").val().toLowerCase();
                    let currentVal = $(this).val().trim();
                    let initialAllowance = $(this).data("allowance-initialallowance"); // get initial value

                    if (allowanceName === "basic") basicField = $(this);

                    // Only add to fixedTotal if type=fixed AND initialAllowance has a value
                    if (type === "fixed" && initialAllowance !== null && initialAllowance !== '' && !isNaN(
                            currentVal)) {
                        fixedTotal += parseFloat(currentVal);
                    } else if (type === "percentage") {
                        let percentValue = parseFloat($(this).data("allowance-value")) || 0;
                        percentageAllowances.push({
                            el: $(this),
                            percent: percentValue
                        });
                    }
                });


                // Step 3: Remaining amount for Basic + percentage allowances
                let remaining = grossSalary - fixedTotal;
                if (remaining < 0) remaining = 0;

                // Step 4: Total percentage weight = 100 (Basic) + sum of percentage allowances
                let totalPercent = 100;
                percentageAllowances.forEach(item => totalPercent += item.percent);

                // Step 5: Calculate Basic
                let basicAmount = (100 / totalPercent) * remaining;
                if (basicField) {
                    basicField.val(basicAmount.toFixed(2));
                }

                // Step 6: Calculate percentage allowances
                percentageAllowances.forEach(item => {
                    let allowanceAmount = (item.percent / totalPercent) * remaining;
                    item.el.val(allowanceAmount.toFixed(2));
                });

                // Step 7: Sum all allowances
                let totalAllowances = 0;
                $(".allowance-input").each(function() {
                    totalAllowances += parseFloat($(this).val()) || 0;
                });

                // Step 8: Adjust small rounding errors by modifying Basic
                let roundingDiff = grossSalary - totalAllowances;
                if (basicField && Math.abs(roundingDiff) > 0.01) {
                    let correctedBasic = parseFloat(basicField.val()) + roundingDiff;
                    basicField.val(correctedBasic.toFixed(2));
                    totalAllowances = grossSalary;
                }

                // Step 9: Display total allowances
                $("#total_allowances_display").text("৳" + totalAllowances.toFixed(2));
            }

            // Trigger calculation on gross salary change
            $("#gross_salary").on("input", recalcAllowances);

            // Trigger recalculation if any fixed allowance manually changed
            $(".allowance-input").on("input", function() {
                let type = $(this).data("allowance-type");
                if (type === "fixed") recalcAllowances();
            });

            // Run once on page load
            if ($("#gross_salary").val()) recalcAllowances();
        });
    </script>





    <script>
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select an option',
        });
    </script>
@endsection
