@extends('backend.global.master')

@section('title', 'Payroll')
@section('heading', 'Payroll')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Payroll List</h2>
            <div>
                <a class="btn btn-sm btn-primary" href="{{ route('payrollDownload') }}">Download excel</a>
                <a href="{{ route('payrollGenerate') }}" class="btn btn-primary btn-sm">
                    Generate Payslip
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Month Name</th>
                        <th>Employee Name</th>
                        <th>Total Allowances</th>
                        <th>Total Deductions</th>
                        <th>Total Payable</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payrolls as $payroll)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $payroll->month_name }}</td>
                            <td>{{ $payroll->user->name }}</td>
                            <td>{{ $payroll->total_allowances  }}</td>
                            <td>
                                {{ $payroll->total_deduction ?? '----' }}
                                @if(!empty($payroll->deduction_reason))
                                    <p>Reason: {{ $payroll->deduction_reason }}</p>
                                @endif
                            </td>

                            <td>{{ $payroll->total_payable }}</td>

                            <td>
                                <!-- Edit Icon -->
                                <a class="btn btn-sm btn-outline-warning" title="Edit" href="{{ route('payrollCreateOrEdit', $payroll->id) }}">
                                    <i class="mdi mdi-pencil"></i>
                                </a>

                                {{-- <!-- Generate Icon -->
                                <a class="btn btn-sm btn-outline-info" title="Generate" href="">
                                <i class="mdi mdi-file-pdf"></i>
                                </a> --}}

                                <!-- Delete Icon -->
                                <a href="javascript:void(0);" data-url="" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" title="Delete"
                                class="btn btn-outline-danger btn-sm delete-btn">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="7">No data Found! PLease add data from <a
                                    href="">here</a> </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('backend_custom_js')

    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var deleteUrl = $(this).data('url');
                $('#confirmDeleteBtn').attr('href', deleteUrl);
            });
        });
    </script>
@endsection
