<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
    <style>
        body {
            background-color: #0e1a2b;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px;
            color: #f0f0f0;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #152337;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 25px;
        }

        p {
            line-height: 1.6;
            color: #dcdcdc;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #2f80ed;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #1c60bd;
        }

        .footer {
            margin-top: 40px;
            font-size: 0.9rem;
            text-align: center;
            color: #aaaaaa;
        }

        a {
            color: #2f80ed;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Password Reset Request</h2>

        <p>Hello,</p>

        <p>We received a request to reset your password. Click the button below to proceed:</p>

        <p style="text-align: center;">
            <a href="{{ $resetLink }}" class="btn">Reset Password</a>
        </p>

        <p>If you didn’t request a password reset, you can safely ignore this email.</p>

        <p class="footer">
            — AutoBoli Team
        </p>
    </div>
</body>
</html>
