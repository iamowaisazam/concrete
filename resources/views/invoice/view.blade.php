<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Invoice #0001 • AutoBoli Pvt Ltd</title>
  <style>
 
    .invoice-wrapper {
      max-width: 750px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

.invoice-header {
  background: #0a1930;
  color: #fff;
  padding: 25px 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.company-info {
  display: flex;
  align-items: center;
  gap: 15px;
}

.company-info .logo {
  width: 60px;
  height: auto;
}

.company-info h2 {
  margin: 0;
  font-size: 20px;
}

.company-info p {
  margin: 3px 0 0;
  font-size: 12px;
  color: #aab6d1;
}

.invoice-label {
  text-align: right;
}

.invoice-label span {
  background: #0080ff;
  padding: 5px 12px;
  border-radius: 6px;
  color: #fff;
  font-weight: bold;
}

.invoice-label p {
  margin: 6px 0 0;
  color: #aab6d1;
  font-size: 12px;
}


    /* Customer Info */
    .customer-info {
      padding: 20px 30px;
      background: #f8f9fc;
      border-bottom: 1px solid #e0e6ef;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .customer-info div {
      width: 48%;
    }

    .customer-info h4 {
      margin: 0 0 8px;
      color: #0080ff;
      font-size: 14px;
    }

    .customer-info p {
      margin: 3px 0;
      font-size: 13px;
      color: #333;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 25px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: right;
    }

    th {
      background: #f6f8fb;
      text-align: left;
    }

    /* Totals */
    .totals {
      margin-top: 15px;
      width: 100%;
    }

    .totals td {
      border: none;
      padding: 6px 0;
    }

    .totals tr:last-child td {
      border-top: 1px dashed #ccc;
      padding-top: 10px;
    }

    .totals strong {
      color: #0080ff;
    }

    /* Button (for web only) */
    .download-btn {
      text-align: right;
      margin-top: 25px;
    }

    .btn {
      background: #0080ff;
      color: #fff;
      text-decoration: none;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 13px;
    }

    @media print {
      .btn { display: none; }
    }

    /* Footer */
    .invoice-footer {
      position: relative;
      text-align: center;
      color: #fff;
      background: #0a1930;
      padding-top: 60px;
      padding-bottom: 30px;
    }

    .invoice-footer::before {
      content: "";
        position: absolute;
        top: 51px;
        left: -2px;
        width: 204%;
        height: 157px;
        background: url('{{ asset("public/theme/invoice/footer-wave.png") }}') no-repeat center;

    }

    .invoice-footer p {
      margin: 5px 0;
      font-size: 12px;
      color: #aab6d1;
    }
.customer-info-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 25px;
  border: 1px solid #e0e6ef;
  background: #f9fbfe;
  border-radius: 6px;
}

.customer-info-table td {
  width: 50%;
  padding: 15px 20px;
  vertical-align: top;
  border-right: 1px solid #e0e6ef;
}

.customer-info-table td:last-child {
  border-right: none;
}

.customer-info-table h4 {
  margin: 0 0 8px 0;
  font-size: 15px;
  color: #0080ff;
  border-bottom: 1px solid #e0e6ef;
  padding-bottom: 4px;
}

.customer-info-table p {
  margin: 4px 0;
  font-size: 13px;
  color: #333;
}

.status {
  display: inline-block;
  padding: 3px 8px;
  border-radius: 5px;
  font-size: 12px;
  font-weight: bold;
  text-transform: uppercase;
}

.status.paid {
  background: #e6f8ec;
  color: #1a8f3d;
  border: 1px solid #a8e0b5;
}

.status.unpaid {
  background: #ffeaea;
  color: #cc0000;
  border: 1px solid #ffb3b3;
}
.tr_tables{
border: 2px solid  rgb(10, 25, 48)  !important;
}

  </style>
</head>

<body>
  <div class="invoice-wrapper">

  <!-- Header -->
@if ($downloadbtn != 0)
    
  <div class="invoice-header">
    <div class="company-info">
      <img src="{{ asset('public/theme/assets/nave-icon.png') }}" alt="AutoBoli Logo" class="logo">
      <div>
        <h2>AutoBoli Pvt Ltd</h2>
        <p>Karachi, Pakistan<br>info@autoboli.com</p>
      </div>
    </div>
    
    <div class="invoice-label">
      <span>INVOICE</span>
      <p>#{{ str_pad($membership->id, 4, '0', STR_PAD_LEFT) }}<br>{{ date('Y-m-d', strtotime($membership->created_at)) }}</p>
    </div>
  </div>
  @else
<table width="100%" cellspacing="0" cellpadding="0" 
       style="border-collapse: collapse; margin-bottom: 20px; background-color: #0a1930; color: #ffffff; font-family: Arial, sans-serif;">
  <tr>
    <!-- Left: Company Info -->
    <td style="width: 65%; vertical-align: middle; padding: 15px;">
      <table cellspacing="0" cellpadding="0" style="border: none;">
        <tr class="tr_tables">
          <td style="width: 65px; vertical-align: middle;">
            <img src="{{ asset('public/theme/assets/nave-icon.png') }}" alt="AutoBoli Logo" 
                 style="width: 55px; height: auto;">
          </td>
          <td style="vertical-align: middle; padding-left: 10px; text-align: left;" class="tr_tables">
            <h2 style="margin: 0; font-size: 20px; color: #ffffff;">AutoBoli Pvt Ltd</h2>
            <p style="margin: 3px 0 0 0; font-size: 12px; line-height: 17px; color: #ffffff;">
              Karachi, Pakistan<br>
              info@autoboli.com
            </p>
          </td>
        </tr>
      </table>
    </td>

    <!-- Right: Compact Invoice Box -->
    <td style="width: 35%; text-align: right; vertical-align: middle; padding: 10px 15px;">
      <table cellspacing="0" cellpadding="6" align="right" 
             style="border-collapse: collapse; background-color: #0a1930; color: #ffffff; width: 85%; border-radius: 8px;">
        <tr class="tr_tables">
          <td colspan="2" 
              style="font-weight: bold; text-align: center; font-size: 16px; padding: 8px 0;">
            INVOICE
          </td>
        </tr>
        <tr class="tr_tables">
          <td style="font-weight: bold; padding: 5px 8px;border: 1px solid #0a1930;">No:</td>
          <td style="padding: 5px 8px; text-align: right;border: 1px solid #0a1930;">#{{ str_pad($membership->id, 4, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr class="tr_tables">
          <td style="font-weight: bold; padding: 5px 8px;border: 1px solid #0a1930;">Date:</td>
          <td style="padding: 5px 8px; text-align: right;border: 1px solid #0a1930;">{{ date('Y-m-d', strtotime($membership->membership_start_date)) }}</td>
        </tr>
  
      </table>
    </td>
  </tr>
</table>




  @endif

  <!-- Customer Info -->
  <table class="customer-info-table">
    <tr>
      <td class="info-box">
        <h4>Billed To</h4>
        <p><strong>Customer Name:</strong> {{ $membership->user->firstName ?? ' ' }}</p>
        <p><strong>Email:</strong> {{ $membership->user->personalEmail ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $membership->user->phone ?? 'N/A' }}</p>
      </td>

      <td class="info-box">
        <h4>Billing Details</h4>
        <p><strong>Plan:</strong> {{ $membership->plan->plan_name ?? 'N/A' }}</p>
        <p><strong>Payment Method:</strong> {{ $membership->payment->payment_method ?? 'None' }}</p>
        <p><strong>Status:</strong>
       @php
            $today = \Carbon\Carbon::today();
            $expiry = \Carbon\Carbon::parse($membership->membership_expiry_date);
        @endphp

        @if ($expiry->lt($today))
            <span class="status unpaid">Expired</span>
        @else
            <span class="status paid">Active</span>
        @endif
        </p>
      </td>
    </tr>
  </table>

  <!-- Body -->
  <table class="invoice-items">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Plan Name</th>
        <th>Start</th>
        <th>Expiry</th>
        <th>Amount</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $membership->id }}</td>
        <td>{{ date('Y-m-d', strtotime($membership->created_at)) }}</td>
        <td>{{ $membership->plan->plan_name ?? 'N/A' }}</td>
        <td>{{ date('d-M-Y', strtotime($membership->membership_start_date)) }}</td>
        <td>{{ date('d-M-Y', strtotime($membership->membership_expiry_date)) }}</td>
        <td>{{ $membership->payment->amount ?? '0' }} {{ $membership->payment->currency ?? '£' }}</td>
        <td>
           @if ($expiry->lt($today))
            <span class="status unpaid">Expired</span>
          @else
              <span class="status paid">Active</span>
          @endif
        </td>
      </tr>
    </tbody>
  </table>






<p style="margin: 20;">Thank you for your business!</p>



<div class="invoice-footer">
    <p>AutoBoli Pvt Ltd © {{ date('Y') }} — All rights reserved</p>
    <p>www.autoboli.com</p>
  </div>

</div>

@if ($downloadbtn != 0)
<div class="download-btn" style="display: flex; justify-content: center; align-items: center; margin-top: 25px;">
  <div style="margin-top: 20px; display: inline-block;">
    <a href="{{ route('invoice.pdf', Crypt::encryptString($membership->id)) }}"
       class="btn btn-primary"
       style="padding: 10px 18px; border-radius: 6px; text-decoration: none; color: #ffffff; 
              background-color: #0a1930; display: inline-flex; align-items: center; gap: 8px; font-weight: bold;">
      <i class="fa fa-download" style="font-size: 14px;"></i> Download PDF
    </a>
  </div>
@endif

</div>
</body>
</html>
