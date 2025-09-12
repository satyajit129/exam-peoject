@extends('backend.global.master')

@section('title', 'Payroll Allowances')
@section('heading', 'Payroll Allowances')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Payroll Allowances</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('payrollAllowanceCreateOrEdit') }}" class="btn btn-primary">
                                <i class="mdi mdi-plus"></i> Add New Allowance
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
                                    <th>Allowance</th>
                                    {{-- <th>Parent Allowance</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allowances as $index => $allowance)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $allowance->name }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $allowance->type->value === 'fixed' ? 'success' : 'info' }}">
                                                {{ $allowance->type->getLabel() }}
                                            </span>
                                        </td>
                                        <td>{{ $allowance->formatted_allowance }}</td>
                                        {{-- <td>{{ $allowance->parentAllowance ? $allowance->parentAllowance->name : '-' }}</td> --}}
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('payrollAllowanceCreateOrEdit', $allowance->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <a href="{{ route('payrollAllowanceDelete', $allowance->id) }}"
                                                    class="btn btn-sm btn-danger ml-2" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this allowance?')">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No allowances found</td>
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
