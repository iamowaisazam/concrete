<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
</head>
<body>
    <h1>Payment Failed</h1>
    <p>There was an error processing your payment.</p>
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <p><a href="{{ route('test.payment.form') }}">Try again</a></p>
</body>
</html>