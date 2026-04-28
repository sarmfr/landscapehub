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

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }

        .approved {
            background: #d1fae5;
            color: #065f46;
        }

        .rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .suspended {
            background: #fef3c7;
            color: #92400e;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #065f46;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🌿 LandScapeHub</h1>
        </div>
        <div class="content">
            <h2>Account Status Update</h2>
            <p>Hello <strong>{{ $vendor->business_name }}</strong>,</p>

            <p>There has been an update to your vendor account status:</p>

            <div class="status-badge {{ $status }}">
                {{ $status }}
            </div>

            @if($status === 'approved')
            <p>Congratulations! Your account has been approved. You can now start listing your products and services on our marketplace.</p>
            <p><strong>Your Commission Rate:</strong> {{ $vendor->commission_rate }}% (This is the platform fee deducted from your sales)</p>
            <a href="{{ route('vendor.dashboard') }}" class="btn">Go to Dashboard</a>
            @elseif($status === 'rejected')
            <p>We regret to inform you that your vendor application has been rejected.</p>
            @if($reason)
            <p><strong>Reason:</strong> {{ $reason }}</p>
            @endif
            <p>If you believe this is a mistake, please contact our support team.</p>
            @elseif($status === 'suspended')
            <p>Your account has been temporarily suspended.</p>
            @if($reason)
            <p><strong>Reason:</strong> {{ $reason }}</p>
            @endif
            <p>Please contact the administrator to resolve this issue.</p>
            @endif

            <p>Thank you,<br>The LandScapeHub Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} LandScapeHub Kenya. All rights reserved.
        </div>
    </div>
</body>

</html>