<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f6f6f6; margin: 0; padding: 0; }
        .container { background-color: #ffffff; max-width: 600px; margin: 40px auto; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #2d6a4f; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #2d6a4f; margin: 0; font-size: 24px; }
        .otp-box { background-color: #f0e6d3; color: #1a1a2e; font-size: 32px; font-weight: bold; letter-spacing: 5px; text-align: center; padding: 20px; border-radius: 8px; margin: 30px 0; border: 1px dashed #d4af37; }
        .footer { text-align: center; color: #888888; font-size: 12px; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eeeeee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Madrasa Dar-ul-Falah</h1>
        </div>
        
        <h2>Assalamu Alaikum, {{ $userName }},</h2>
        
        <p>You recently requested to reset your password for your Madrasa Dar-ul-Falah account. Please use the following 6-digit OTP code to proceed with the password reset.</p>
        
        <div class="otp-box">
            {{ $otpCode }}
        </div>
        
        <p><strong>Note:</strong> This code is valid for exactly <strong>5 minutes</strong>. If you did not request a password reset, please ignore this email.</p>
        
        <p>Jazakallah Khair,<br>The Madrasa Dar-ul-Falah Team</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Madrasa Dar-ul-Falah. All rights reserved.</p>
            <p>This is an automated message, please do not reply.</p>
        </div>
    </div>
</body>
</html>
