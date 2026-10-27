<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Account Status Changed</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: {{ $status === 'activated' ? '#10B981' : '#EF4444' }}; color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Account {{ ucfirst($status) }}</h1>
        </div>
        <div class="content">
            <p>Hello <strong>{{ $admin->name }}</strong>,</p>
            
            <p>Your account has been <strong>{{ $status }}</strong> by the administrator.</p>
            
            @if($status === 'activated')
                <p>You can now login to your account and access all features.</p>
                <p style="text-align: center;">
                    <a href="{{ route('admin.login') }}" style="display: inline-block; background: #10B981; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0;">Login Now</a>
                </p>
            @else
                <p>Your account is currently inactive. Please contact the administrator for more information.</p>
            @endif
            
            <p>Thank you,<br>{{ config('app.name') }} Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>