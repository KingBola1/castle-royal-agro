<!DOCTYPE html>
<html>
<head>
    <title>Withdrawal Rejected</title>
</head>
<body>
    <h1>Hello {{ $withdrawal->user->name }}.</h1>
    <p>Unfortunately, your withdrawal request for <strong>GH₵ {{ number_format($withdrawal->amount, 2) }}</strong> was rejected.</p>
    <p>Please contact support for details.</p>
</body>
</html>
