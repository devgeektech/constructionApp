<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Approval Notification</title>
    <style>
        /* Define your styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
        }
        .content {
            color: #555;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Product Approval Notification</h1>
        </div>
        <div class="content">
            <p>Hello {{ $store->user->name }},</p>
            <p>Your product {{$store->name }} has been approved!</p>
            <p>Congratulations, your product is now live and visible to customers.</p>
            <p>Thank you for choosing our platform.</p>
        </div>
        <div class="footer">
            <p>This is an automated message, please do not reply.</p>
            <p>&copy; 2024 Construction. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
