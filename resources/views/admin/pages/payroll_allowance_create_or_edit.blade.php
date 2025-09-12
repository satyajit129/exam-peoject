@extends('backend.global.master')

@section('title', $allowance->id ? 'Edit Payroll Allowance' : 'Create Payroll Allowance')
@section('heading', $allowance->id ? 'Edit Payroll Allowance' : 'Create Payroll Allowance')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $allowance->id ? 'Edit' : 'Create' }} Payroll Allowance</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('payrollAllowanceSave', $allowance->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $allowance->name) }}"
                                        placeholder="Enter allowance name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type"
                                        name="type" required>
                                        <option value="">Select Type</option>
                                        @foreach ($allowanceTypes as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('type', $allowance->type?->value) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="allowance" id="allowance-label">Allowance</label>
                                    <input type="number" class="form-control @error('allowance') is-invalid @enderror"
                                        id="allowance" name="allowance"
                                        value="{{ old('allowance', $allowance->allowance) }}" step="0.01" min="0"
                                        placeholder="Enter allowance value">
                                    <small class="form-text text-muted" id="allowance-help">
                                        Leave empty for fixed type, required for percentage type
                                    </small>
                                    @error('allowance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_allowance_id">Parent Allowance</label>
                                    <select class="form-control select2 @error('parent_allowance_id') is-invalid @enderror"
                                        id="parent_allowance_id" name="parent_allowance_id">
                                        <option value="">Select Parent Allowance (Optional)</option>
                                        @foreach ($parentAllowances as $parentAllowance)
                                            <option value="{{ $parentAllowance->id }}"
                                                {{ old('parent_allowance_id', $allowance->parent_allowance_id) == $parentAllowance->id ? 'selected' : '' }}>
                                                {{ $parentAllowance->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_allowance_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('payrollAllowanceList') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> {{ $allowance->id ? 'Update' : 'Save' }} Allowance
                            </button>
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
            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Select Parent Allowance',
                allowClear: true
            });

            // Handle type change
            $('#type').change(function() {
                const type = $(this).val();
                const allowanceField = $('#allowance');
                const allowanceLabel = $('#allowance-label');
                const allowanceHelp = $('#allowance-help');

                if (type === 'fixed') {
                    allowanceLabel.html('Allowance (Optional)');
                    allowanceHelp.text('Leave empty for fixed type');
                    allowanceField.prop('required', false);
                    allowanceField.attr('max', '');
                } else if (type === 'percentage') {
                    allowanceLabel.html('Allowance <span class="text-danger">*</span>');
                    allowanceHelp.text('Required for percentage type (0-100)');
                    allowanceField.prop('required', true);
                    allowanceField.attr('max', '100');
                } else {
                    allowanceLabel.html('Allowance');
                    allowanceHelp.text('Select a type first');
                    allowanceField.prop('required', false);
                }
            });

            // Trigger change on page load
            $('#type').trigger('change');
        });
    </script>
@endsection
