<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead >
            <tr>
                <th colspan="2" class="text-center ">Salary Breakdown Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Employee Name:</strong></td>
                <td>{{ $salary_breakdown->employee->name ?? 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
</div>
