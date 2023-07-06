<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your OTP For Reset Password</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        .otp {
            font-size: 30px;
            font-weight: bold;
            color: #009900;
            margin-bottom: 30px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Your OTP</h1>
    <p>Dear User,</p>
    <p>Your One-Time Password (OTP) is:</p>
    <p class="otp">{{ $otp }}</p>
    <p>Please use this OTP to proceed with your Reset Password.</p>
    <div class="footer">
        <p>If you did not request this OTP, please ignore this email.</p>
        <p>&copy; {{ date('Y') }} Mchongoo. All rights reserved.</p>
    </div>
</div>
</body>
</html>
