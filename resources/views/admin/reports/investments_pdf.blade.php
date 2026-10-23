<!DOCTYPE html>
<html>
<head>
    <title>Investments Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2E7D32; padding-bottom: 10px; }
        .title { font-size: 22px; font-weight: bold; color: #2E7D32; margin-bottom: 5px; }
        .subtitle { font-size: 13px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; color: #2E7D32; font-weight: bold; }
        tr:nth-child(even) { background-color: #fcfcfc; }
        .amount { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Castle Royal Agro</div>
        <div class="subtitle">Global Investment Portfolio Report</div>
        <div class="subtitle">Generated on: {{ now()->format('M d, Y - h:i A') }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Investor</th>
                <th>Package</th>
                <th>Units</th>
                <th style="text-align: right;">Amount (GHS)</th>
                <th style="text-align: right;">Exp. ROI (GHS)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($investments as $inv)
            <tr>
                <td>{{ $inv->created_at->format('M d, Y') }}</td>
                <td>{{ $inv->user->name ?? 'N/A' }}<br><span style="font-size: 9px; color: #666;">{{ $inv->user->email ?? '' }}</span></td>
                <td>{{ $inv->package->name ?? 'Manual Entry' }}</td>
                <td>{{ $inv->units }}</td>
                <td class="amount">{{ number_format($inv->amount_invested, 2) }}</td>
                <td class="amount" style="color: #2E7D32;">{{ number_format($inv->expected_roi, 2) }}</td>
                <td>{{ ucfirst($inv->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>