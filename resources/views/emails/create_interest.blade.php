<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Interest Created</title>
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
      background:#000F21; 
      border-radius:12px; 
      overflow:hidden; 
      border: 1px solid rgba(255,255,255,0.1);
    }
    
    .email-header { 
      padding:32px 24px; 
      background: linear-gradient(135deg, #000F21 0%, #001a3d 100%);
      border-bottom: 2px solid #0080FF;
      color:#fff; 
    }
    
    .email-header h1 { 
      margin:0; 
      font-size:24px; 
      font-weight:700; 
      color:#ffffff;
      letter-spacing:-0.5px;
    }
    
    .email-body { 
      padding:32px 24px; 
      background:#000F21;
    }
    
    .lead { 
      font-size:18px; 
      margin-bottom:16px; 
      color:#ffffff;
      font-weight:500;
    }
    
    .email-body p {
      color:#e0e0e0;
      line-height:1.6;
    }
    
    .details { 
      margin:24px 0; 
      font-size:15px; 
      line-height:1.8; 
      color:#ffffff;
      background:rgba(255,255,255,0.05);
      padding:20px;
      border-radius:8px;
      border-left:3px solid #0080FF;
    }
    
    .detail-row { 
      margin:10px 0; 
      display:flex;
      padding:8px 0;
      border-bottom:1px solid rgba(255,255,255,0.08);
    }
    
    .detail-row:last-child {
      border-bottom:none;
    }
    
    .detail-row strong {
      color:#0080FF;
      min-width:140px;
      font-weight:600;
    }
    
    .btn { 
      display:inline-block; 
      padding:14px 32px; 
      border-radius:8px; 
      text-decoration:none; 
      font-weight:600; 
      background:#0080FF; 
      color:#ffffff;
      font-size:15px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0,128,255,0.3);
    }
    
    .btn:hover {
      background:#0066cc;
      box-shadow: 0 6px 16px rgba(0,128,255,0.4);
    }
    
    .footer { 
      padding:24px; 
      font-size:13px; 
      color:#8a8a8a; 
      background:rgba(255,255,255,0.03);
      text-align:center; 
      border-top:1px solid rgba(255,255,255,0.08);
    }
    
    .footer div {
      margin:4px 0;
    }
    
    .notice {
      margin-top:24px;
      padding:16px;
      background:rgba(255,255,255,0.05);
      border-radius:6px;
      color:#b0b0b0;
      font-size:13px;
      border:1px solid rgba(255,255,255,0.08);
    }
    
    @media only screen and (max-width:480px) {
      .email-wrapper { 
        margin:12px; 
        border-radius:8px;
      }
      .email-header { 
        padding:24px 20px; 
      }
      .email-header h1 { 
        font-size:20px; 
      }
      .lead { 
        font-size:16px; 
      }
      .email-body {
        padding:24px 20px;
      }
      .details {
        padding:16px;
      }
      .detail-row {
        flex-direction:column;
      }
      .detail-row strong {
        margin-bottom:4px;
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
              <h1>{{ config('app.name') }} — Interest Created</h1>
            </div>
            
            <div class="email-body">
              <p class="lead">Hi {{ $interest->user->name ?? 'User' }},</p>
              
              <p style="margin:0 0 16px 0;">Your interest <strong style="color:#0080FF;">"{{ $interest->title }}"</strong> has been created successfully. Below are the details you provided:</p>
              
              <div class="details" role="list">
                <div class="detail-row">
                  <strong>Make:</strong> 
                  <span>{{ $interest->make->name ?? '-' }}</span>
                </div>
                <div class="detail-row">
                  <strong>Model:</strong> 
                  <span>{{ $interest->model->name ?? '-' }}</span>
                </div>
                <div class="detail-row">
                  <strong>Year:</strong> 
                  <span>{{ $interest->year_from ?? '-' }} @if($interest->year_from || $interest->year_to) - {{ $interest->year_to ?? '-' }} @endif</span>
                </div>
                <div class="detail-row">
                  <strong>Mileage:</strong> 
                  <span>{{ $interest->mileage_from ?? '-' }} to {{ $interest->mileage_to ?? '-' }}</span>
                </div>
                <div class="detail-row">
                  <strong>Engine CC:</strong> 
                  <span>{{ $interest->cc_from ?? '-' }} to {{ $interest->cc_to ?? '-' }}</span>
                </div>
                <div class="detail-row">
                  <strong>Transmission:</strong> 
                  <span>{{ $interest->transmission ?? '-' }}</span>
                </div>
                <div class="detail-row">
                  <strong>Fuel Type:</strong> 
                  <span>{{ $interest->fuel_type ?? '-' }}</span>
                </div>
                <div class="detail-row">
                  <strong>Former Keeper:</strong> 
                  <span>{{ $interest->former_keeper ?? '-' }}</span>
                </div>
                <div class="detail-row">
                  <strong>Grade:</strong> 
                  <span>{{ $interest->grade ?? '-' }}</span>
                </div>
                <div class="detail-row">
                  <strong>Price Range:</strong> 
                  <span>{{ $interest->price_from ?? '-' }} to {{ $interest->price_to ?? '-' }}</span>
                </div>
              </div>
              
              <p style="margin-top:24px; text-align:center;">
                <a class="btn" href="{{ url('/interest') }}" target="_blank" rel="noopener">View My Interests</a>
              </p>
              
              <div class="notice">
                If you didn't create this interest or think this is a mistake, please contact our support team.
              </div>
            </div>
            
            <div class="footer">
              <div style="font-weight:600; color:#ffffff;">{{ config('app.name') }}</div>
              <div style="margin-top:8px;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
            </div>
          </div>
        </td>
      </tr>
    </table>
  </center>
</body>
</html>