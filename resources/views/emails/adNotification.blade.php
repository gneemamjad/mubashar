<!DOCTYPE html>
<html dir="ltr">
<head>
    <title>Ad Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            direction: ltr;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .message {
            font-size: 16px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            margin: 0 10px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" >
            <img src="{{ asset('assets/images/logo.png') }}" alt="Company Logo" class="logo">
        </div>
        
        <div class="content" style="text-align: center;">
            <h1 style="color: #007bff; margin-bottom: 20px;">اشعار جديد</h1>
            
            <div class="message">
                {{ $msg }}
            </div>
            
            {{-- <p>If you have any questions, please don't hesitate to contact our support team.</p> --}}
        </div>
        
        <div class="footer">
            <p>شكرا لاتخدامك خدماتنا</p>
            
            {{-- <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px;">
                © {{ date('Y') }} Your Company Name. All rights reserved.
            </p> --}}
        </div>
    </div>
</body>
</html>