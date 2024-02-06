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
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .logo {
            text-align: center;
        }
        .logo img {
            max-width: 150px;
            height: auto;
            border-radius: 50%;
        }
        .heading {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            margin-bottom: 30px;
        }
        p{
            text-align: center;
        }
        table {
            width: 100%;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        table td:first-child {
            font-weight: bold;
            width: 30%;
        }
        .footer tr td{
            border-bottom: 0px;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="logo">
            <img src="{{ asset('images/clogo.jpg') }}" alt="Logo">
        </div>
        <h1 class="heading">Hello Admin</h1>
        <p>A new product has been added to the platform. Here are the details:</p>
        <table style="margin-top: 30px;">
            <tr>
                <td>Product name:</td>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <td>Price:</td>
                <td>{{ $product->price }}</td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{ $product->user->email }}</td>
            </tr>
        </table>

        <table style="background-color: #fff; width: 100%; text-align: center;" class="footer">

            <tr>
                <td>
                    <p style="margin-bottom: 0; font-size:14px; text-align: left;">Best Regards,</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="margin: 0; font-size:14px; text-align: left;">Team</p>
                </td>
            </tr>
            <tr>
                <td>
                    <ul style="list-style: none; padding: 20px 0 0; display: flex; align-items: center;margin: 0; justify-content: center;">
                        <li style="margin: 10px 10px 0 10px;"><a href="#" target="_blank"><img src="{{ asset('images/facebook.png')}}" alt="facebook" /></a>
                        </li>
                        <li style="margin: 10px 10px 0 10px;"><a href="#" target="_blank"><img src="{{ asset('images/instagram.png')}}" alt="instagram" /></a>
                        </li>
                        <li style="margin: 10px 10px 0 10px;"><a href="#" target="_blank"><img src="{{ asset('images/linkedin.png')}}" alt="linkedin" /></a>
                        </li>
                        <li style="margin: 10px 10px 0 10px;"><a href="#" target="_blank"><img src="{{ asset('images/youtube.png')}}" alt="youtube" /></a></li>
                    </ul>example@example.com 0;">Copyright © {{ now()->year }} by Construction App All rights reserved.</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
