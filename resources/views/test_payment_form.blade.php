<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Payment</title>
</head>
<body>
    <h1>Pay £{{ number_format($amount, 2) }}</h1>
    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <input type="hidden" name="amount" value="{{ $amount }}">
        <button type="submit">Pay with PayPal</button>
    </form>
</body>
</html>