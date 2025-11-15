<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .success-container {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .success-animation {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            border-radius: 50%;
            border: 4px solid #4CAF50;
            border-top-color: transparent;
            animation: rotate 1s linear infinite, success 0.3s ease-out 1s forwards;
        }

        .success-message {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease-out 1.5s forwards;
        }

        .success-message h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .success-message p {
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .home-button {
            display: inline-block;
            padding: 12px 24px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
            opacity: 0;
            animation: fadeIn 0.5s ease-out 2s forwards;
        }

        .home-button:hover {
            background: #45a049;
        }

        @keyframes rotate {
            100% { transform: rotate(360deg); }
        }

        @keyframes success {
            to {
                border-color: #4CAF50;
                transform: scale(1.1);
            }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-animation"></div>
        <div class="success-message">
            <h1>Payment Successful!</h1>
            <p>Thank you for your payment. Your transaction has been completed successfully.</p>
        </div>
    </div>
</body>
</html>
