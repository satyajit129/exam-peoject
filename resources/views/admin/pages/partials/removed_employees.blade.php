<div class="modal-header">
    <h5 class="modal-title">Removed Employees</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
</div>
<div class="modal-body">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        <a href="{{ route('employeeRestore',  $employee) }}" 
                           class="btn btn-sm btn-success">
                           <i class="mdi mdi-restore"></i> Restore
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No removed employees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
