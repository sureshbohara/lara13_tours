<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Login Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #F59E0B; color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .info-box { background: white; padding: 20px; border-left: 4px solid #F59E0B; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 New Login Alert</h1>
        </div>
        <div class="content">
            <p>Hello <strong>{{ $admin->name }}</strong>,</p>
            
            <p>We detected a new login to your account. Here are the details:</p>
            
            <div class="info-box">
                <p><strong>Time:</strong> {{ $time }}</p>
                <p><strong>IP Address:</strong> {{ $ip_address }}</p>
                <p><strong>Browser:</strong> {{ $browser }}</p>
            </div>
            
            <p><strong>If this was you,</strong> you can safely ignore this email.</p>
            
            <p><strong>If this wasn't you,</strong> please take the following steps immediately:</p>
            <ol>
                <li>Change your password</li>
                <li>Review your account activity</li>
                <li>Contact our support team</li>
            </ol>
            
            <p>Stay secure!<br>{{ config('app.name') }} Security Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>