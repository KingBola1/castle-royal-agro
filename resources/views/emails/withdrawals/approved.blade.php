<!DOCTYPE html>
<html>
<head>
    <title>Withdrawal Approved</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">
        <h2 style="color: #2d3748;">Great News, {{ $user->name }}!</h2>

        <p>Your withdrawal request has been processed successfully.</p>

        <div style="background-color: #f7fafc; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 0;"><strong>Amount:</strong> GH₵ {{ number_format($withdrawal->amount, 2) }}</p>
            <p style="margin: 0;"><strong>Destination:</strong> {{ $withdrawal->payment_details }}</p>
            <p style="margin: 0;"><strong>Status:</strong> <span style="color: green; font-weight: bold;">APPROVED</span></p>
        </div>

        <p>The funds are on their way to your account. Please allow up to 24 hours for the transaction to reflect.</p>

        <p>Thank you for investing with us!</p>
        <p><strong>Castle Royal Agro Team</strong></p>
    </div>
</body>
</html>
