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

        .order-summary {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .order-summary th,
        .order-summary td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
            color: #065f46;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🌿 LandScapeHub</h1>
        </div>
        <div class="content">
            @if($type === 'customer')
            <h2>Order Confirmed!</h2>
            <p>Thank you for your purchase. We've received your order <strong>#{{ $order->order_number }}</strong>.</p>
            @else
            <h2>New Order Received!</h2>
            <p>Congratulations! You have received a new order <strong>#{{ $order->order_number }}</strong>.</p>
            @endif

            <table class="order-summary">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Service' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>KES {{ number_format($item->price) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right; font-weight: bold;">Total:</td>
                        <td class="total">KES {{ number_format($order->total_amount) }}</td>
                    </tr>
                </tfoot>
            </table>

            <p>You can view full details in your dashboard.</p>

            <p>Thank you,<br>LandScapeHub Marketplace</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} LandScapeHub Kenya.
        </div>
    </div>
</body>

</html>