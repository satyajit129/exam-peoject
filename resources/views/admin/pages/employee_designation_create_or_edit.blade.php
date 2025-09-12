@extends('backend.global.master')

@section('title', 'Employee Designation ' . ($employee_designation->id ? 'Update' : 'Create'))
@section('heading', 'Employee Designation ' . ($employee_designation->id ? 'Update' : 'Create'))


@section('backend_custom_style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Employee Designation {{ $employee_designation->id ? 'Update' : 'Create' }}</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('employeeDesignationSave', $employee_designation->id) }}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{ $employee->id }}">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="row">
                    <!-- Designation -->
                    <div class="col-md-6 mb-3">
                        <label>Designation <span class="text-danger">*</span></label>
                        <select name="designation_id" class="form-control select2" required>
                            <option value="">Select an Option</option>
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}"
                                    {{ $employee_designation->designation_id == $designation->id ? 'selected' : '' }}>
                                    {{ $designation->designation }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-6 mb-3">
                        <label>Start Date <span class="text-danger">*</span></label>
                        <input type="text" class="form-control designationDatepicker" name="start_date"
                            placeholder="Select Start Date" required
                            value="{{ old('start_date', $employee_designation->start_date ? \Carbon\Carbon::parse($employee_designation->start_date)->format('d-m-Y') : '') }}">
                    </div>

                    <!-- End Date -->
                    <div class="col-md-6 mb-3">
                        <label>End Date</label>
                        <input type="text" class="form-control designationDatepicker" name="end_date"
                            placeholder="Select End Date"
                            value="{{ old('end_date', $employee_designation->end_date ? \Carbon\Carbon::parse($employee_designation->end_date)->format('d-m-Y') : '') }}">
                    </div>

                    <!-- Gross Salary -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gross_salary">Gross Salary <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('gross_salary') is-invalid @enderror"
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
                <h5 class="text-primary mt-4 mb-2">
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
                            $existingAmount = 0;
                            if ($existingAllowance) {
                                $existingAmount =
                                    $existingAllowance->allowance_type === 'percentage'
                                        ? 0
                                        : $existingAllowance->calculated_amount;
                            }
                            // Log::info( $existingAmount->allowance);
                        @endphp
                        <div class="col-md-3 mb-3">
                            <label>{{ $allowance->name }}
                                @if ($allowance->type->value === 'fixed')
                                    (Fixed)
                                @else
                                    ({{ $allowance->allowance }}% of Basic)
                                @endif
                            </label>
                            <input type="text" class="form-control allowance-input" id="allowance_{{ $allowance->id }}"
                                name="allowances[{{ $allowance->id }}][amount]"
                                value="{{ $existingAmount > 0 ? $existingAmount : ($allowance->type->value === 'fixed' ? $allowance->allowance : 0) }}"
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
                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary btn-pill " style="float: inline-end;">
                            {{ $employee_designation->id ? 'Update' : 'Create' }} Designation
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('backend_custom_js')

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- Select2 JS -->
    <script>
        $(document).ready(function() {
            $(".designationDatepicker").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                showAnim: "slideDown"
            });
        });
    </script>

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
