<!DOCTYPE html>
<html>
<head>
    <title>Auction Reminder</title>
</head>
<body>
    <h2>Auction Reminder</h2>
    <p>Dear User,</p>
    <p>This is a reminder that the auction <strong>{{ $auction->name }}</strong> is starting at <strong>{{ date('d-m-Y h:i A', strtotime($auction->auction_date)) }}</strong>.</p>
    <p>Check it here: <a href="{{ url('/auction-finder?platform=' . $auction->platform_id) }}">View Auction</a></p>
</body>
</html>
