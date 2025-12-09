<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Message</title>
    <style>

    </style>
</head>
<body>
    <div class="container">
        
        <h2>New Contact Message Received</h2>

        <div class="info"><strong>Name:</strong> {{ $name }}</div>
        <div class="info"><strong>Email:</strong> {{ $email }}</div>
        <div class="info"><strong>Phone:</strong> {{ $phone }}</div>
        <div class="info"><strong>Country:</strong> {{ $country }}</div>
        <div class="info"><strong>City:</strong> {{ $city }}</div>
        <div class="info"><strong>Postal Code:</strong> {{ $postal_code }}</div>
        <div class="info"><strong>Address:</strong> {{ $address }}</div>
        <div class="info"><strong>Profession:</strong> {{ $profession }}</div>

        <div class="info"><strong>Message:</strong></div>
        <div class="message-box">{{ $messageText }}</div>


    </div>
</body>
</html>
