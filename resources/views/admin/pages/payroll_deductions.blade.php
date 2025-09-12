@extends('backend.global.master')

@section('title', 'Payroll Deductions')
@section('heading', 'Payroll Deductions')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Payroll Deductions</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('payrollDeductionCreateOrEdit') }}" class="btn btn-primary">
                                <i class="mdi mdi-plus"></i> Add New Deduction
                            </a>
                        </div>
                    </div>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deductions as $index => $deduction)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $deduction->name }}</td>
                                        <td>
                                            @if ($deduction->type)
                                                <span
                                                    class="badge badge-{{ $deduction->type->value === 'fixed' ? 'success' : 'info' }}">
                                                    {{ $deduction->type->getLabel() }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">Not Set</span>
                                            @endif
                                        </td>
                                        <td>{{ $deduction->created_at->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('payrollDeductionCreateOrEdit', $deduction->id) }}"
                                                    class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <a href="{{ route('payrollDeductionDelete', $deduction->id) }}"
                                                    class="btn btn-sm btn-outline-danger ml-2" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this deduction?')">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No deductions found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
