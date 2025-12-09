<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Auction Status Update</title>
</head>
<body>
    <h2>Auction Status Update</h2>

    <p>Dear User,</p>

    <p>The auction <strong>{{ $auction->name }}</strong> has been updated.</p>


    <p><strong>New Status:</strong> {{ $newStatus }}</p>

    <p><strong>Auction Date:</strong> {{ $auction->auction_date }}</p>

    <p>
        This is a system-generated notification to inform you about the latest changes in the auction schedule.
    </p>

    <p>Thank you,<br>
    {{ config('app.name') }} Team</p>
</body>
</html>
