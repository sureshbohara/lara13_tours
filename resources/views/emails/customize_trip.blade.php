<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; line-height: 1.6; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background: #1A2B4C; color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .header p { margin: 10px 0 0; color: #D4AF6A; font-size: 14px; }
        .content { padding: 30px; }
        .info-row { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .info-row:last-child { border-bottom: none; }
        .label { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 5px; }
        .value { font-size: 16px; color: #1A2B4C; font-weight: 500; }
        .message-box { background: #f8f9fa; padding: 20px; border-radius: 6px; border-left: 4px solid #D4AF6A; margin-top: 20px; }
        .footer { background: #0F1A2E; color: #ffffff; text-align: center; padding: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Customize Trip Inquiry</h1>
            <p>SP Travel and Tours</p>
        </div>
        <div class="content">
            <div class="info-row">
                <div class="label">From</div>
                <div class="value">{{ $data['name'] }} ({{ $data['email'] }})</div>
            </div>
            <div class="info-row">
                <div class="label">Phone</div>
                <div class="value">{{ $data['phone'] ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Address</div>
                <div class="value">{{ $data['address'] ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Preferred Destination</div>
                <div class="value">{{ $data['destination'] ?? 'Not specified' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Travel Dates</div>
                <div class="value">
                    {{ $data['arrival_date'] ?? 'N/A' }} to {{ $data['departure_date'] ?? 'N/A' }}
                </div>
            </div>
            <div class="info-row">
                <div class="label">Number of Travelers</div>
                <div class="value">{{ $data['travelers'] ?? 'Not specified' }}</div>
            </div>
            <div class="info-row">
                <div class="label">Estimated Budget</div>
                <div class="value">{{ $data['budget'] ?? 'Not specified' }}</div>
            </div>
            
            <div class="message-box">
                <div class="label" style="margin-bottom: 10px;">Additional Requests or Questions</div>
                <div class="value" style="font-size: 15px; color: #555; white-space: pre-wrap;">
                    {{ $data['message'] ?? 'No additional message provided.' }}
                </div>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} SP Travel and Tours. All rights reserved.
        </div>
    </div>
</body>
</html>