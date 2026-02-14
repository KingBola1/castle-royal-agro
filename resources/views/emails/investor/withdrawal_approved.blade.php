<!DOCTYPE html>
<html>
<head>
    <title>Withdrawal Approved</title>
</head>
<body>
    <h1>Great news {{ $withdrawal->user->name }}!</h1>
    <p>Your withdrawal request for <strong>GH₵ {{ number_format($withdrawal->amount, 2) }}</strong> has been approved and processed to your account.</p>
    <p>Payment Details Used: {{ $withdrawal->payment_details }}</p>
    <p>Thank you for investing with Castle Royal Agro.</p>
</body>
</html>
