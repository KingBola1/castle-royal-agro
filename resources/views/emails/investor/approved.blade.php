<!DOCTYPE html>
<html>
<head>
    <title>Investment Approved</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">
        <h2 style="color: #2f855a; text-align: center;">Investment Approved!</h2>
        
        <p>Hello {{ $investment->user->name }},</p>
        
        <p>Great news! Your investment has been successfully approved and is now <strong>ACTIVE</strong>.</p>
        
        <div style="background-color: #f0fff4; padding: 15px; border-radius: 5px; border-left: 4px solid #38a169; margin: 20px 0;">
            <p><strong>Package:</strong> {{ $investment->package->name }}</p>
            <p><strong>Amount Invested:</strong> GHS {{ number_format($investment->amount_invested, 2) }}</p>
            <p><strong>Start Date:</strong> {{ $investment->updated_at->format('M d, Y') }}</p>
            @if($investment->expected_roi)
            <p><strong>Expected Return:</strong> GHS {{ number_format($investment->expected_roi, 2) }}</p>
            @endif
        </div>
        
        <p>You can track the performance of your investment directly from your dashboard.</p>
        
        <p style="text-align: center; margin-top: 30px;">
            <a href="{{ route('dashboard') }}" style="background-color: #38a169; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Go to Dashboard</a>
        </p>
        
        <hr style="border: 0; border-top: 1px solid #e0e0e0; margin: 30px 0;">
        
        <p style="font-size: 12px; color: #718096; text-align: center;">
            &copy; {{ date('Y') }} Castle Royal Agro. All rights reserved.
        </p>
    </div>
</body>
</html>
