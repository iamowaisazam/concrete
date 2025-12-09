<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            color: #ffffff;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        .email-header {
            background: linear-gradient(135deg, #000F21 0%, #001a3d 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .logo-section {
            margin-bottom: 15px;
        }
        .logo-text {
            font-size: 32px;
            font-weight: bold;
            color: #0080FF;
            letter-spacing: 1px;
        }
        .email-body {
            background-color: #000F21;
            padding: 40px 30px;
            color: #ffffff;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #e8e8e8;
        }
        .greeting {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: #ffffff;
        }
        .btn-container {
            text-align: center;
            margin: 30px 0 20px;
        }
        .btn {
            display: inline-block;
            background-color: #0080FF;
            color: #ffffff;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 128, 255, 0.3);
        }
        .btn:hover {
            background-color: #0066cc;
            box-shadow: 0 6px 20px rgba(0, 128, 255, 0.4);
            transform: translateY(-2px);
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
            margin: 30px 0;
        }
        .email-footer {
            background-color: #000a15;
            text-align: center;
            padding: 30px 20px;
            color: #8a8a8a;
        }
        .footer-content {
            font-size: 13px;
            line-height: 1.6;
        }
        .footer-content p {
            margin: 8px 0;
        }
        .company-name {
            color: #0080FF;
            font-weight: 600;
        }
        .social-links {
            margin: 20px 0 15px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #0080FF;
            text-decoration: none;
            font-size: 14px;
        }
        .copyright {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 12px;
            color: #666;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .email-header {
                padding: 30px 20px;
            }
            .email-header h1 {
                font-size: 24px;
            }
            .email-body {
                padding: 30px 20px;
            }
            .btn {
                padding: 12px 28px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper"> 
        <div class="email-header">
            <div class="logo-section">
                <div class="logo-text">AUTOBOLI</div>
            </div>
            <h1>{{ $title }}</h1>
        </div>


        <div class="email-body">
            <p class="greeting">Hello,</p>
            
            <p>{{ $messageContent }}</p>
            
            <div class="divider"></div>
            
            <div class="btn-container">
                <a href="{{ url('/') }}" class="btn">Visit Our Website</a>
            </div>
            
            <p style="margin-top: 30px; font-size: 14px; color: #b0b0b0;">
                If you have any questions, feel free to reach out to our support team. We're here to help!
            </p>
        </div>

        <div class="email-footer">
            <div class="footer-content">
                <p><span class="company-name">Autoboli</span></p>
                
                <div class="social-links">
                    <a href="#">Facebook</a> | 
                    <a href="#">Twitter</a> | 
                    <a href="#">Instagram</a> | 
                    <a href="#">LinkedIn</a>
                </div>
                
                <p>123 Business Street, City, Country</p>
                <p>Email: support@autoboli.com | Phone: +1 234 567 8900</p>
                
                <div class="copyright">
                    &copy; {{ date('Y') }} Autoboli. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>