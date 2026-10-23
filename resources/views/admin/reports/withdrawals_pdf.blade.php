<!DOCTYPE html>
<html>
<head>
    <title>Withdrawals Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #b7791f; padding-bottom: 10px; }
        .title { font-size: 22px; font-weight: bold; color: #b7791f; margin-bottom: 5px; }
        .subtitle { font-size: 13px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; color: #b7791f; font-weight: bold; }
        tr:nth-child(even) { background-color: #fcfcfc; }
        .amount { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Castle Royal Agro</div>
        <div class="subtitle">Global Withdrawal & Payouts Report</div>
        <div class="subtitle">Generated on: {{ now()->format('M d, Y - h:i A') }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Date Requested</th>
                <th>Investor</th>
                <th>Payment Details</th>
                <th style="text-align: right;">Amount (GHS)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($withdrawals as $withdrawal)
            <tr>
                <td>{{ $withdrawal->created_at->format('M d, Y H:i') }}</td>
                <td>{{ $withdrawal->user->name ?? 'N/A' }}<br><span style="font-size: 9px; color: #666;">{{ $withdrawal->user->email ?? '' }}</span></td>
                <td>{{ $withdrawal->payment_details }}</td>
                <td class="amount">{{ number_format($withdrawal->amount, 2) }}</td>
                <td>{{ ucfirst($withdrawal->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>