<!DOCTYPE html>
<html>
<head>
    <title>Audit Logs Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2E7D32; padding-bottom: 10px; }
        .title { font-size: 24px; font-weight: bold; color: #2E7D32; margin-bottom: 5px; }
        .subtitle { font-size: 14px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f8f9fa; color: #2E7D32; font-weight: bold; }
        tr:nth-child(even) { background-color: #fcfcfc; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Castle Royal Agro</div>
        <div class="subtitle">Official System Audit Log Report</div>
        <div class="subtitle">Generated on: {{ now()->format('M d, Y - h:i A') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Admin / Staff</th>
                <th>Action</th>
                <th>Affected User</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                <td>{{ $log->admin ? $log->admin->name : 'System' }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->user ? $log->user->name : 'N/A' }}</td>
                <td>{{ $log->details }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>