<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            font-size: 14px; 
            color: #333;
        }
        .header {
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            border-bottom: 2px solid #000; 
            padding-bottom: 10px; 
            margin-bottom: 20px;
        }
        .company {
            font-size: 20px; 
            font-weight: bold;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }
        .paid { background-color: #28a745; }   /* Green */
        .unpaid { background-color: #dc3545; } /* Red */
        h2 { margin: 0; }
        .details { margin-bottom: 20px; }
        .details p { margin: 4px 0; }
        table {
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc; 
            padding: 10px; 
            text-align: left;
        }
        th { background-color: #f2f2f2; }
        .total-row td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="company">Your Company Name / Logo</div>
        
    </div>

    <h2>Order #{{ $order->orderno }}</h2>
    <div class="details">
        <p><strong>Date:</strong> {{ $order->created_at->setTimezone('Asia/Karachi')->format('d M Y h:i A') }}</p>
        <p><strong>Customer:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
    </div>

    <h3>Order Items</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($order->orderProducts as $item)
                @php $lineTotal = $item->price * $item->quantity; $grandTotal += $lineTotal; @endphp
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($lineTotal, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" style="text-align:left;">Grand Total</td>
                <td>{{ number_format($grandTotal, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Thank you for shopping with us!</p>
        <p>For any queries, contact support@yourcompany.com</p>
    </div>

</body>
</html>
