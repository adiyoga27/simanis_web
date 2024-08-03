<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Success</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-content {
            font-size: 16px;
            line-height: 1.5;
        }
        .email-footer {
            text-align: center;
            margin-top: 20px;
        }
        .btn-custom {
            background-color: #28a745;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Email Verification Successful</h2>
            <hr>
        </div>
        <div class="email-content">
            <center><p>Dear {{ $user->name }},</p></center>
            <p>Thank you for verifying your email address. Your account has been successfully verified.</p>
            <p>We are excited to have you on board. You can now fully access all the features of our platform.</p>
            <p>If you have any questions or need assistance, feel free to contact our support team.</p>
        </div>
        <div class="email-footer">
            <p>Thank you,<br>The Team SIMANIS</p>
        </div>
    </div>
</body>
</html>
