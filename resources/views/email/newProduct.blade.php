<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Product Added</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .body-content {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }
        .store-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>New Product Added</h1>
        </div>

        <div class="body-content">
            <p>Hello Admin,</p>
            <p>A new product has been added to the platform. Here are the details:</p>

            <!-- Store Details Section -->
            <div class="store-details">
                <p><strong>Product Name:</strong> {{ $product->name }}</p>
                <p><strong>Price:</strong> {{ $product->price }}</p>
                <p><strong>Description:</strong> {{ $product->description }}</p>
                <p><strong>Email:</strong> {{ $product->user->email }}</p>
                <!-- Add more store details as needed -->
            </div>

            <p>Please review the product details and take any necessary action.</p>

            <p>Best Regards,<br>Your Team</p>
        </div>

        <div class="footer">
            <p>&copy; 2024 Contruction. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
