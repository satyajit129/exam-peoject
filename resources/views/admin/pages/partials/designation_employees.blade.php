<div class="modal-header">
    <h5 class="modal-title">Employees</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
</div>

<div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Designation</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('employeeCreateOrEdit', $employee->employee->id) }}">{{ $employee->employee->name ?? 'N/A' }}</a>
                    </td>
                    <td>{{ $employee->employee->employee_id ?? 'N/A' }}</td>
                    <td>
                        {{ $employee->designation->designation ?? 'N/A' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No employees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
