<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Interest Alert</title>
  <style>
    /* Basic resets for email */
    body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table { border-collapse: collapse !important; }
    img { border:0; height:auto; line-height:100%; outline:none; text-decoration:none; }
    body { 
      margin:0 !important; 
      padding:0 !important; 
      width:100% !important; 
      background-color:#000F21; 
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
      color:#ffffff; 
    }

    .email-wrapper { 
      width:100%; 
      max-width:600px; 
      margin:28px auto; 
      background:#001529; 
      border-radius:12px; 
      overflow:hidden; 
      box-shadow:0 4px 20px rgba(0,127,255,0.15); 
    }

    .email-header { 
      padding:28px 32px; 
      background: linear-gradient(135deg, #0080FF 0%, #0056b3 100%); 
      color:#fff; 
      text-align:center;
    }

    .email-header h1 { 
      margin:0; 
      font-size:24px; 
      font-weight:700; 
      letter-spacing:-0.5px;
    }

    .email-body { 
      padding:32px; 
    }

    .greeting { 
      font-size:18px; 
      margin-bottom:8px; 
      font-weight:600;
      color:#ffffff;
    }

    .intro-text {
      font-size:15px;
      color:#b8c5d6;
      margin:0 0 24px 0;
      line-height:1.5;
    }

    /* Added table styles for vehicle summary */
    .summary-table {
      width:100%;
      margin:24px 0;
      border-radius:8px;
      overflow:hidden;
      border:1px solid rgba(0,127,255,0.2);
    }

    .summary-table thead {
      background:#0080FF;
    }

    .summary-table th {
      padding:14px 16px;
      text-align:left;
      font-size:13px;
      font-weight:600;
      color:#ffffff;
      text-transform:uppercase;
      letter-spacing:0.5px;
    }

    .summary-table tbody tr {
      border-bottom:1px solid rgba(255,255,255,0.08);
      transition:background-color 0.2s ease;
    }

    .summary-table tbody tr:last-child {
      border-bottom:none;
    }

    .summary-table tbody tr:hover {
      background-color:rgba(0,127,255,0.08);
    }

    .summary-table td {
      padding:16px;
      font-size:14px;
      color:#e8eef5;
    }

    .summary-table td:first-child {
      font-weight:600;
      color:#ffffff;
    }

    .summary-table td:last-child {
      text-align:center;
      font-weight:700;
      color:#0080FF;
      font-size:16px;
    }

    .count-badge {
      display:inline-block;
      background:rgba(0,127,255,0.15);
      padding:6px 14px;
      border-radius:20px;
      border:1px solid rgba(0,127,255,0.3);
    }

    .cta-section {
      margin-top:32px;
      text-align:center;
    }

    .cta-text {
      font-size:14px;
      color:#b8c5d6;
      margin-bottom:18px;
    }

    .btn { 
      display:inline-block; 
      padding:14px 32px; 
      border-radius:8px; 
      text-decoration:none; 
      font-weight:600; 
      font-size:15px;
      background:#0080FF; 
      color:#ffffff; 
      box-shadow:0 4px 12px rgba(0,127,255,0.3);
      transition:all 0.3s ease;
    }

    .btn:hover {
      background:#0066cc;
      box-shadow:0 6px 16px rgba(0,127,255,0.4);
      transform:translateY(-1px);
    }

    .footer { 
      padding:24px 32px; 
      font-size:12px; 
      color:#6b7d94; 
      background:#000a15; 
      text-align:center; 
      line-height:1.6;
    }

    .footer-brand {
      font-weight:600;
      color:#8a9db5;
      margin-bottom:4px;
    }

    @media only screen and (max-width:480px) {
      .email-wrapper { 
        margin:12px; 
        border-radius:8px;
      }
      .email-header { 
        padding:20px 24px; 
      }
      .email-header h1 { 
        font-size:20px; 
      }
      .email-body { 
        padding:24px 20px; 
      }
      .greeting { 
        font-size:16px; 
      }
      .summary-table th,
      .summary-table td {
        padding:12px 10px;
        font-size:13px;
      }
      .btn {
        padding:12px 24px;
        font-size:14px;
      }
    }
  </style>
</head>
<body>
  <center>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:680px;">
      <tr>
        <td align="center">
          <div class="email-wrapper">
            <div class="email-header">
              <h1>🎉 New Vehicles Match Your Interests!</h1>
            </div>

            <div class="email-body">
              <p class="greeting">Hello {{ $data['user_name'] }},</p>

              <!-- Changed "cars" to "vehicles" -->
              <p class="intro-text">
                Great news! We found new vehicles matching your saved interests. Here's a summary of what's available:
              </p>

              <!-- Replaced ul/li with table structure -->
              <table class="summary-table" role="presentation" cellpadding="0" cellspacing="0">
                <thead>
                  <tr>
                    <th>Interest</th>
                    <th style="text-align:center;">New Vehicles</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data['summary'] as $item)
                  <tr>
                    <td>{{ $item['interest'] }}</td>
                    <td>
                      <span class="count-badge">{{ $item['count'] }}</span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <div class="cta-section">
                <p class="cta-text">
                  Visit our website to explore these vehicles in detail and find your perfect match.
                </p>
                <a class="btn" href="{{ url('/vehicles') }}" target="_blank" rel="noopener">View All Vehicles</a>
              </div>
            </div>

            <div class="footer">
              <div class="footer-brand">{{ config('app.name') }}</div>
              <div>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
            </div>
          </div>
        </td>
      </tr>
    </table>
  </center>
</body>
</html>
