@extends('backend.global.master')

@section('title', 'Employee Salary Breakdowns')
@section('heading', 'Employee Salary Breakdowns')

@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Employee Salary Breakdowns</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('employeeSalaryBreakdownCreateOrEdit') }}" class="btn btn-primary">
                                <i class="mdi mdi-plus"></i> Add New Salary Breakdown
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
                                    <th>Employee</th>
                                    {{-- <th>Gross Salary</th>
                                    <th>Total Allowances</th> --}}
                                    <th>Net Salary</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($salaryBreakdowns as $index => $breakdown)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $breakdown->employee->name }}</td>
                                        {{-- <td>৳{{ number_format($breakdown->gross_salary, 2) }}</td>
                                        <td>৳{{ number_format($breakdown->total_allowances, 2) }}</td> --}}
                                        <td>৳{{ number_format($breakdown->net_salary, 2) }}</td>
                                        <td>{{ $breakdown->created_at->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('employeeSalaryBreakdownCreateOrEdit', $breakdown->id) }}"
                                                    class="btn btn-sm btn-outline-warning mr-1" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <a href="{{ route('salaryBreakDownShow', $breakdown->id) }}"
                                                    class="breakdown_view btn btn-sm btn-outline-primary mr-1"
                                                    data-breakdown-id="{{ $breakdown->id }}" title="View">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a href="{{ route('employeeSalaryBreakdownDelete', $breakdown->id) }}"
                                                    class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this salary breakdown?')">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No salary breakdowns found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="salaryBreakdownModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salaryBreakdownModalLabel">Salary Breakdown Details</h5>
                </div>
                <div class="modal-body" id="salaryBreakdownContent">
                    Modal body text goes here.
                </div>
            </div>
        </div>
    </div>
@endsection

@section('backend_custom_js')
    <script>
        $(document).ready(function() {
            $('.breakdown_view').on('click', function(e) {
                var id = $(this).data('breakdown-id');
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('salaryBreakDownShow') }}",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $('#salaryBreakdownContent').html(response);
                        $('#salaryBreakdownModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
