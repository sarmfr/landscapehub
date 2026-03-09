<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            border: 1px solid #eee;
            border-radius: 24px;
        }

        .header {
            background: #065f46;
            color: white;
            padding: 30px;
            border-radius: 20px 20px 0 0;
            text-align: center;
        }

        .content {
            padding: 30px;
            background: #fff;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        .congrats-box {
            background: #ecfdf5;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid #10b981;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #065f46;
            color: white !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🌿 LandScapeHub</h1>
        </div>
        <div class="content">
            <div class="congrats-box">
                <h2 style="color: #065f46; margin-top: 0;">You've Been Hired!</h2>
                <p>The customer has accepted your proposal for the <strong>{{ $quote->category->name }}</strong> project!</p>
            </div>

            <p>Hi <strong>{{ $response->vendor->business_name }}</strong>,</p>
            <p>Great news! Your proposal of <strong>KES {{ number_format($response->quoted_price) }}</strong> was accepted by {{ $quote->user->name }}.</p>

            <p>You can now reach out to the customer to finalize the details and start working.</p>

            <p><strong>Project Location:</strong> {{ $quote->location }}</p>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('vendor.quotes.responses') }}" class="btn">View Project Details</a>
            </div>

            <p>Happy Landscaping!<br>The LandScapeHub Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} LandScapeHub Kenya.
        </div>
    </div>
</body>

</html>