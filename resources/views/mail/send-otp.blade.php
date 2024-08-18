<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #2c3e50;
            padding: 15px 0;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            color: #333333;
            text-align: center;
        }
        .content h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .otp {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
            letter-spacing: 5px;
            color: #e74c3c;
        }
        .content p {
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #999999;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h2>Lupa Password Anda?</h2>
            <p>Gunakan kode OTP berikut untuk mereset password Anda:</p>
            <div class="otp">{{ $otp }}</div>
            <p>Kode ini berlaku selama 10 menit. Jika Anda tidak meminta reset password, harap abaikan email ini.</p>
        </div>
        <div class="footer">
            <p>Terima kasih,</p>
            <p>{{ config('app.name') }} Team</p>
        </div>
    </div>
</body>
</html>
