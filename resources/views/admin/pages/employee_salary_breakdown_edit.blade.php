@extends('backend.global.master')

@section('title', 'Edit Employee Salary Breakdown')
@section('backend_custom_style')
    <style>
        .allowance-input-group {
            margin-bottom: 15px;
        }

        .allowance-input-group label {
            font-weight: 600;
            color: #495057;
        }

        .loading {
            background-color: #f8f9fa !important;
            border-color: #007bff !important;
        }

        .allowance-item {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        .allowance-item label {
            font-weight: 600;
            color: #495057;
        }

        .form-control[readonly] {
            background-color: #e9ecef;
        }

        .allowance-input {
            text-align: right;
            font-weight: 600;
            color: #495057;
        }

        .allowance-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endsection

@section('backend_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="mdi mdi-pencil"></i>
                            Edit Employee Salary Breakdown
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
                                        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id"
                                            name="user_id" required>
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('user_id', $salaryBreakdown->user_id) == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name }} ({{ $employee->employee_id }})
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
                                                $existingAllowance = $salaryBreakdown->salaryAllowances
                                                    ->where('payroll_allowance_id', $allowance->id)
                                                    ->first();
                                                $existingAmount = $existingAllowance
                                                    ? $existingAllowance->calculated_amount
                                                    : 0;
                                            @endphp
                                            <div class="col-md-3">
                                                <label>{{ $allowance->name }}
                                                    @if ($allowance->type === 'percentage')
                                                        ({{ $allowance->allowance }}% of Basic)
                                                    @else
                                                        (Fixed)
                                                    @endif
                                                </label>
                                                <input type="text" class="form-control allowance-input"
                                                    id="allowance_{{ $allowance->id }}"
                                                    name="allowances[{{ $allowance->id }}][amount]"
                                                    value="{{ $existingAmount > 0 ? $existingAmount : '' }}"
                                                    placeholder="0.00" data-allowance-id="{{ $allowance->id }}"
                                                    data-allowance-type="{{ $allowance->type }}"
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
                                        <div class="col-md-3">
                                            <label>Remaining Amount</label>
                                            <div class="form-control" id="remaining_amount_display">
                                                ৳{{ number_format(($salaryBreakdown->gross_salary ?? 0) - ($salaryBreakdown->total_allowances ?? 0), 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> Update Salary Breakdown
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
            // Store original values to preserve them
            let originalValues = {};

            // Preserve original values on page load
            function preserveOriginalValues() {
                originalValues = {};
                $('[data-allowance-id]').each(function() {
                    const allowanceId = $(this).data('allowance-id');
                    const amount = parseFloat($(this).val()) || 0;
                    if (amount > 0) {
                        originalValues[allowanceId] = amount;
                    }
                });

                // Also preserve the original gross salary
                const originalGross = parseFloat($('#gross_salary').data('original-value')) || 0;
                originalValues['gross_salary'] = originalGross;

                console.log('Original values preserved:', originalValues);
            }

            // Update display values without recalculating
            function updateDisplayValues() {
                // Prevent double execution with a more robust approach
                if (window.updatingDisplay) {
                    console.log('Display update already in progress, skipping...');
                    return;
                }

                // Set flag immediately
                window.updatingDisplay = true;

                // Use a small delay to ensure the flag is set
                setTimeout(() => {
                    let totalAllowances = 0;

                    $('[data-allowance-id]').each(function() {
                        const allowanceId = $(this).data('allowance-id');
                        // Use current value from the input
                        const amount = parseFloat($(this).val()) || 0;

                        console.log('updateDisplayValues - Allowance ID:', allowanceId, 'Amount:',
                            amount);

                        totalAllowances += amount;
                    });

                    const grossSalary = parseFloat($('#gross_salary').val()) || 0;
                    const remainingAmount = Math.max(0, grossSalary - totalAllowances);

                    $('#total_allowances_display').text('৳' + totalAllowances.toFixed(2));
                    $('#remaining_amount_display').text('৳' + remainingAmount.toFixed(2));

                    console.log('updateDisplayValues - Total Allowances:', totalAllowances, 'Gross Salary:',
                        grossSalary);

                    // Reset flag
                    window.updatingDisplay = false;
                }, 10);
            }

            // Calculate salary breakdown
            function calculateSalaryBreakdown() {
                const grossSalary = parseFloat($('#gross_salary').val()) || 0;
                console.log('calculateSalaryBreakdown called with gross salary:', grossSalary);

                // Show loading indicator
                $('#gross_salary').addClass('loading');

                // Clear original values since we're recalculating
                originalValues = {};

                // Clear all input values first
                $('[data-allowance-id]').val(0);

                // Prevent double execution
                if (window.calculating) {
                    console.log('Calculation already in progress, skipping...');
                    return;
                }
                window.calculating = true;

                let totalAllowances = 0;
                let basicSalary = 0;
                let hasBasicInput = false;

                // Check if basic salary has been manually input
                $('[data-allowance-id]').each(function() {
                    const allowanceId = $(this).data('allowance-id');
                    const parentId = $(this).data('parent-id');
                    const inputAmount = parseFloat($(this).val()) || 0;

                    if (!parentId && inputAmount > 0) {
                        hasBasicInput = true;
                        basicSalary = inputAmount;
                    }
                });

                // Calculate total fixed allowances (excluding basic) and total percentage
                let totalFixedAllowances = 0;
                let totalPercentage = 0;

                $('[data-allowance-id]').each(function() {
                    const allowanceType = $(this).data('allowance-type');
                    const allowanceValue = parseFloat($(this).data('allowance-value')) || 0;
                    const inputAmount = parseFloat($(this).val()) || 0;
                    const parentId = $(this).data('parent-id');
                    const allowanceId = $(this).data('allowance-id');

                    console.log('Processing allowance ID:', allowanceId, 'Type:', allowanceType, 'Value:',
                        allowanceValue, 'Parent ID:', parentId, 'Input Amount:', inputAmount);

                    if (allowanceType === 'fixed' && parentId) {
                        // Fixed allowances that are children (not basic)
                        totalFixedAllowances += inputAmount;
                        console.log('Added to fixed allowances:', inputAmount, 'Total Fixed:',
                            totalFixedAllowances);
                    } else if (allowanceType === 'percentage' && parentId) {
                        totalPercentage += allowanceValue;
                        console.log('Added to percentage:', allowanceValue, 'Total Percentage:',
                            totalPercentage);
                    }
                });

                console.log('Total Fixed Allowances (excluding basic):', totalFixedAllowances, 'Total Percentage:',
                    totalPercentage);

                // If no basic salary input or we need to recalculate, auto-calculate basic
                if (!hasBasicInput && grossSalary > 0) {
                    // Calculate basic salary: (Gross - Fixed Allowances) / (1 + totalPercentage/100)
                    const divisor = 1 + (totalPercentage / 100);
                    basicSalary = (grossSalary - totalFixedAllowances) / divisor;

                    console.log('Auto-calculating basic salary:', basicSalary, 'Divisor:', divisor, 'Total Fixed:',
                        totalFixedAllowances, 'Total Percentage:', totalPercentage);

                    // Find and set the basic salary input field
                    $('[data-allowance-id]').each(function() {
                        const parentId = $(this).data('parent-id');
                        if (!parentId) {
                            $(this).val(basicSalary.toFixed(2));
                        }
                    });
                }

                // Calculate all allowances
                $('[data-allowance-id]').each(function() {
                    const allowanceId = $(this).data('allowance-id');
                    const allowanceType = $(this).data('allowance-type');
                    const allowanceValue = parseFloat($(this).data('allowance-value')) || 0;
                    const inputAmount = parseFloat($(this).val()) || 0;
                    const parentId = $(this).data('parent-id');

                    let calculatedAmount = 0;

                    if (allowanceType === 'fixed') {
                        // For fixed type, use the input amount directly
                        calculatedAmount = inputAmount;

                        // If this is the basic salary (no parent), update basicSalary variable
                        if (!parentId) {
                            basicSalary = calculatedAmount;
                        }
                    } else if (allowanceType === 'percentage' && parentId && basicSalary > 0) {
                        // For percentage type, calculate based on basic salary
                        calculatedAmount = (basicSalary * allowanceValue) / 100;

                        // Auto-fill the input field for percentage allowances
                        $(this).val(calculatedAmount.toFixed(2));
                    }

                    // Round to 2 decimal places to prevent accumulation of rounding errors
                    calculatedAmount = Math.round(calculatedAmount * 100) / 100;

                    console.log('Calculating allowance ID:', allowanceId, 'Type:', allowanceType, 'Value:',
                        allowanceValue, 'Calculated:', calculatedAmount);

                    // Update input field
                    $('#allowance_' + allowanceId).val(calculatedAmount);

                    totalAllowances += calculatedAmount;
                });

                const remainingAmount = grossSalary - totalAllowances;

                // Ensure remaining amount is never negative due to rounding errors
                const adjustedRemainingAmount = Math.max(0, Math.round(remainingAmount * 100) / 100);
                const adjustedTotalAllowances = grossSalary - adjustedRemainingAmount;

                console.log('Total Allowances:', totalAllowances, 'Adjusted Total:', adjustedTotalAllowances,
                    'Gross Salary:', grossSalary);

                // Update summary displays
                $('#remaining_amount_display').text('৳' + adjustedRemainingAmount.toFixed(2));
                $('#total_allowances_display').text('৳' + adjustedTotalAllowances.toFixed(2));

                // Validation: Check if total allowances exceed gross salary (with tolerance for rounding)
                const tolerance = 0.01; // Allow 1 cent tolerance for rounding errors
                const isTyping = grossSalary < 100; // Assume user is still typing if gross salary is very small
                const isAutoAdjusting = Math.abs(adjustedTotalAllowances - grossSalary) <
                    tolerance; // Check if auto-adjustment is working

                if (adjustedTotalAllowances > grossSalary + tolerance && grossSalary > 0 && !isTyping && !
                    isAutoAdjusting) {
                    toastr.error('Total allowances (৳' + adjustedTotalAllowances.toFixed(2) +
                        ') cannot exceed gross salary (৳' + grossSalary.toFixed(2) + ')!', 'Validation Error');

                    // Highlight the total allowances display in red
                    $('#total_allowances_display').addClass('text-danger').css('background-color', '#f8d7da');
                    $('#remaining_amount_display').addClass('text-danger').css('background-color', '#f8d7da');
                } else {
                    // Remove error styling
                    $('#total_allowances_display').removeClass('text-danger').css('background-color', '');
                    $('#remaining_amount_display').removeClass('text-danger').css('background-color', '');
                }

                // Calculate custom allowances
                calculateCustomAllowances(grossSalary);

                // Update the original gross salary value
                $('#gross_salary').data('original-value', grossSalary);
                originalValues['gross_salary'] = grossSalary;

                // Remove loading indicator
                $('#gross_salary').removeClass('loading');

                // Reset calculation flag
                window.calculating = false;
            }

            // Smart adjustment function - adjusts basic salary and all percentage-based allowances when other allowances are added
            function smartAdjustment() {
                const grossSalary = parseFloat($('#gross_salary').val()) || 0;
                if (grossSalary <= 0) return;

                let totalFixedAllowances = 0;
                let totalPercentageAllowances = 0;

                // Calculate total fixed allowances (excluding basic) and total percentage
                $('[data-allowance-id]').each(function() {
                    const allowanceType = $(this).data('allowance-type');
                    const allowanceValue = parseFloat($(this).data('allowance-value')) || 0;
                    const inputAmount = parseFloat($(this).val()) || 0;
                    const parentId = $(this).data('parent-id');

                    if (allowanceType === 'fixed' &&
                        parentId) { // Fixed allowances that are children (not basic)
                        totalFixedAllowances += inputAmount;
                    } else if (allowanceType === 'percentage' && parentId) {
                        totalPercentageAllowances += allowanceValue;
                    }
                });

                // Calculate new basic salary: (Gross - Fixed Allowances) / (1 + totalPercentage/100)
                const divisor = 1 + (totalPercentageAllowances / 100);
                const newBasicSalary = (grossSalary - totalFixedAllowances) / divisor;

                // Update basic salary
                $('[data-allowance-id]').each(function() {
                    const parentId = $(this).data('parent-id');
                    if (!parentId) { // This is the basic salary field
                        $(this).val(newBasicSalary.toFixed(2));
                    }
                });

                // Recalculate all percentage-based allowances based on new basic salary
                $('[data-allowance-id]').each(function() {
                    const allowanceType = $(this).data('allowance-type');
                    const allowanceValue = parseFloat($(this).data('allowance-value')) || 0;
                    const parentId = $(this).data('parent-id');

                    if (allowanceType === 'percentage' && parentId && newBasicSalary > 0) {
                        // Calculate percentage allowance based on new basic salary
                        const calculatedAmount = (newBasicSalary * allowanceValue) / 100;
                        $(this).val(calculatedAmount.toFixed(2));
                    }
                });

                // Update all displays
                updateDisplayValues();
            }

            // Calculate custom allowances
            function calculateCustomAllowances(grossSalary) {
                // This function can be extended for custom allowance calculations
                // For now, it's a placeholder
            }

            // Debounce function for allowance inputs
            let calculationTimeout;

            function debouncedSmartAdjustment() {
                clearTimeout(calculationTimeout);
                calculationTimeout = setTimeout(smartAdjustment, 300);
            }

            // Bind events
            $('#gross_salary').off('blur keyup').on('blur', function() {
                // Check if gross salary has changed from original
                const currentGross = parseFloat($(this).val()) || 0;
                const originalGross = parseFloat($(this).data('original-value')) || 0;

                console.log('Blur event - Current Gross:', currentGross, 'Original Gross:', originalGross);

                if (currentGross !== originalGross && currentGross > 0) {
                    // Gross salary has changed, recalculate everything
                    console.log('Gross salary changed, recalculating...');
                    calculateSalaryBreakdown();
                } else {
                    // No change, just update displays
                    console.log('No gross salary change, updating displays...');
                    updateDisplayValues();
                }
            });
            $('#gross_salary').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    const currentGross = parseFloat($(this).val()) || 0;
                    const originalGross = parseFloat($(this).data('original-value')) || 0;

                    if (currentGross !== originalGross && currentGross > 0) {
                        calculateSalaryBreakdown();
                    } else {
                        updateDisplayValues();
                    }
                }
            });

            // Focus cursor at the end of the number when clicking on gross salary field
            $('#gross_salary').on('focus', function() {
                const $this = $(this);
                const value = $this.val();
                if (value) {
                    // Set cursor position to end of the value
                    setTimeout(() => {
                        $this[0].setSelectionRange(value.length, value.length);
                    }, 0);
                }
            });
            $('.allowance-input').on('input', function() {
                // Allow only numbers and decimal point
                let value = $(this).val();
                value = value.replace(/[^0-9.]/g, '');

                // Prevent multiple decimal points
                let parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }

                // Limit to 2 decimal places
                if (parts.length === 2 && parts[1].length > 2) {
                    value = parts[0] + '.' + parts[1].substring(0, 2);
                }

                $(this).val(value);
                debouncedSmartAdjustment();
            });
            $('.allowance-input').on('change', smartAdjustment);

            // Focus cursor at the end of the number when clicking on input fields
            $('.allowance-input').on('focus', function() {
                const $this = $(this);
                const value = $this.val();
                if (value) {
                    // Set cursor position to end of the value
                    setTimeout(() => {
                        $this[0].setSelectionRange(value.length, value.length);
                    }, 0);
                }
            });

            // First, preserve any existing values
            preserveOriginalValues();

            // Check if we have existing values
            const hasExistingValues = Object.keys(originalValues).length > 0;

            if (!hasExistingValues) {
                // No existing values, calculate from scratch
                calculateSalaryBreakdown();
            } else {
                // We have existing values, just update displays without recalculating
                // Use a small delay to ensure DOM is fully ready
                setTimeout(() => {
                    updateDisplayValues();
                }, 50);
            }
        });
    </script>
@endsection
