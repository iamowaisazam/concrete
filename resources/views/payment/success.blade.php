<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
</head>
<body>
    <h1>Payment Successful!</h1>
    <p>Your payment of £12.00 has been processed successfully.</p>
    @if(isset($chargeId))
        <p>Charge ID: {{ $chargeId }}</p>
    @endif
    <p><a href="/">Go back to the homepage</a></p>
</body>
</html>