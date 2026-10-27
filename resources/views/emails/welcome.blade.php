<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4F46E5; color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; background: #4F46E5; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to {{ config('app.name') }}!</h1>
        </div>
        <div class="content">
            <p>Hello <strong>{{ $admin->name }}</strong>,</p>
            
            <p>Welcome to our admin panel! We're excited to have you on board.</p>
            
            <p>Your account has been successfully created with the following details:</p>
            
            <ul>
                <li><strong>Name:</strong> {{ $admin->name }}</li>
                <li><strong>Email:</strong> {{ $admin->email }}</li>
                <li><strong>Role:</strong> {{ $admin->role?->display_name ?? 'Admin' }}</li>
            </ul>
            
            <p>You can now login to your account using the button below:</p>
            
            <p style="text-align: center;">
                <a href="{{ route('admin.login') }}" class="button">Login to Dashboard</a>
            </p>
            
            <p>If you have any questions, feel free to contact our support team.</p>
            
            <p>Best regards,<br>{{ config('app.name') }} Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>