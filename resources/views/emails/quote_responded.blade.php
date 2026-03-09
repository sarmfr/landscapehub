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

        .proposal-box {
            background: #f0fdf4;
            padding: 20px;
            border-radius: 16px;
            margin: 20px 0;
            border: 1px solid #dcfce7;
        }

        .price {
            font-size: 24px;
            font-weight: black;
            color: #065f46;
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
            <h2>New Proposal Received</h2>
            <p>Hi {{ $response->quote->user->name }},</p>
            <p>A vendor has submitted a proposal for your project: <strong>{{ $response->quote->category->name }}</strong>.</p>

            <div class="proposal-box">
                <p><strong>Vendor:</strong> {{ $response->vendor->business_name }}</p>
                <p class="price">KES {{ number_format($response->quoted_price) }}</p>
                <p><em>"{{ Str::limit($response->description, 100) }}"</em></p>
            </div>

            <p>Check the dashboard to compare proposals and hire the best vendor.</p>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('quotes.show', $response->quote) }}" class="btn">Review Proposal</a>
            </div>

            <p>Best regards,<br>The LandScapeHub Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} LandScapeHub Kenya.
        </div>
    </div>
</body>

</html>