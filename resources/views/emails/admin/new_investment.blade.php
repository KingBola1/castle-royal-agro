<!DOCTYPE html>
<html>
<head>
    <title>New Investment Alert</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">
        <h2 style="color: #2d3748; text-align: center;">New Investment Received</h2>
        
        <p>Hello Admin,</p>
        
        <p>A new investment has been placed on the platform. Please review and approve it.</p>
        
        <div style="background-color: #f7fafc; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Investor:</strong> {{ $investment->user->name }} ({{ $investment->user->email }})</p>
            <p><strong>Package:</strong> {{ $investment->package->name }}</p>
            <p><strong>Units Purchased:</strong> {{ $investment->units }}</p>
            <p><strong>Total Amount:</strong> GHS {{ number_format($investment->amount_invested, 2) }}</p>
            <p><strong>Payment Reference:</strong> {{ $investment->payment_reference }}</p>
            <p><strong>Date:</strong> {{ $investment->created_at->format('M d, Y h:i A') }}</p>
        </div>
        
        <p style="text-align: center; margin-top: 30px;">
            <a href="{{ route('admin.investments.index') }}" style="background-color: #4a5568; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Login to Approve</a>
        </p>
        
        <hr style="border: 0; border-top: 1px solid #e0e0e0; margin: 30px 0;">
        
        <p style="font-size: 12px; color: #718096; text-align: center;">
            &copy; {{ date('Y') }} Castle Royal Agro. All rights reserved.
        </p>
    </div>
</body>
</html>
