<!DOCTYPE html>
<html>
<head>
    <title>Payslip PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Payslip for {{ $payroll->user->name }}</h2>
    <p>Month: {{ $payroll->month_name }}, Year: {{ $payroll->year }}</p>

    <table>
        <tr>
            <th>Total Allowances</th>
            <td>{{ $payroll->total_allowances }}</td>
        </tr>
        <tr>
            <th>Total Deduction</th>
            <td>{{ $payroll->total_deduction ?? '----' }}</td>
        </tr>
        @if(!empty($payroll->deduction_reason))
        <tr>
            <th>Deduction Reason</th>
            <td>{{ $payroll->deduction_reason }}</td>
        </tr>
        @endif
        <tr>
            <th>Total Payable</th>
            <td>{{ $payroll->total_payable }}</td>
        </tr>
    </table>
</body>
</html>
