<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Receipt - {{ $order->reference }}</title>
    <style>
        @charset "UTF-8";
        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 12px;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-logo {
            margin-bottom: 15px;
            text-align: center;
        }
        .header-logo img {
            max-width: 150px;
            max-height: 80px;
            object-fit: contain;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .info {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-logo">
            @php
                $logoPath = storage_path('app/logo/logo.png');
            @endphp
            @if(file_exists($logoPath))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}" alt="Logo">
            @endif
        </div>
        <h1>{{ $order->branch && $order->branch->business ? $order->branch->business->name : 'Business Name' }}</h1>
        @if($order->branch && $order->branch->business && $order->branch->business->address)
            <p>{{ $order->branch->business->address }}</p>
        @endif
        @if($order->branch && $order->branch->location)
            <p>{{ $order->branch->location }}</p>
        @endif
        @if($order->branch && $order->branch->business && $order->branch->business->phone)
            <p>Tel: {{ $order->branch->business->phone }}</p>
        @endif
        @if($order->branch && $order->branch->business && $order->branch->business->email)
            <p>Email: {{ $order->branch->business->email }}</p>
        @endif
        <p><strong>Receipt #:</strong> {{ $order->reference }}</p>
    </div>

    <div class="info">
        <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
        <p><strong>Cashier:</strong> {{ $order->user ? ($order->user->display_name ?? $order->user->name) : 'N/A' }}</p>
    </div>

    @if($order->customer)
    <div class="info" style="background: #f5f5f5; padding: 10px; border-left: 3px solid #000;">
        <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
        @if($order->customer->phone)
            <p><strong>Phone:</strong> {{ $order->customer->phone }}</p>
        @endif
        @if($order->customer->email)
            <p><strong>Email:</strong> {{ $order->customer->email }}</p>
        @endif
        @if($order->customer->address)
            <p><strong>Address:</strong> {{ $order->customer->address }}</p>
        @endif
        @if($order->customer->full_address && $order->customer->full_address !== $order->customer->address)
            <p>{{ $order->customer->full_address }}</p>
        @endif
    </div>
    @elseif($order->customer_name)
    <div class="info" style="background: #f5f5f5; padding: 10px; border-left: 3px solid #000;">
        <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
    </div>
    @else
    <div class="info" style="background: #f5f5f5; padding: 10px; border-left: 3px solid #000;">
        <p><strong>Customer:</strong> Walk-in Customer</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }} @if($item->variant) - {{ $item->variant->name }} @endif</td>
                <td>{{ $item->qty }}</td>
                <td>N{{ number_format($item->unit_price / 100, 2) }}</td>
                <td>N{{ number_format($item->subtotal / 100, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p><strong>Total: N{{ number_format($order->total_amount / 100, 2) }}</strong></p>
        <p>Payment Method: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
    </div>

    <div style="text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px dashed #000;">
        <p>Thank you for your business!</p>
        <p style="font-size: 10px; margin-top: 5px;">Cutietyha All Rights Reserved - Built by PointSync Systems Limited</p>
    </div>
</body>
</html>

