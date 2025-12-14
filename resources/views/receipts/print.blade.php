<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Receipt - {{ $order->reference }}</title>
    <style>
        @charset "UTF-8";
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }
            body {
                margin: 0;
                padding: 10px;
                font-size: 12px;
            }
            .no-print {
                display: none;
            }
        }
        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 12px;
            padding: 15px;
            max-width: 80mm;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }
        .header-logo {
            margin-bottom: 10px;
            text-align: center;
        }
        .header-logo img {
            max-width: 120px;
            max-height: 60px;
            object-fit: contain;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .info {
            margin-bottom: 10px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            padding: 5px;
            text-align: left;
            font-size: 11px;
        }
        th {
            border-bottom: 1px solid #000;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            border-top: 2px solid #000;
            padding-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px dashed #000;
            font-size: 10px;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #3b82f6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .print-btn:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn no-print">
        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
        </svg>
        Print Receipt
    </button>

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
            <p style="font-size: 10px; margin: 3px 0;">{{ $order->branch->business->address }}</p>
        @endif
        @if($order->branch && $order->branch->location)
            <p style="font-size: 10px; margin: 3px 0;">{{ $order->branch->location }}</p>
        @endif
        @if($order->branch && $order->branch->business && $order->branch->business->phone)
            <p style="font-size: 10px; margin: 3px 0;">Tel: {{ $order->branch->business->phone }}</p>
        @endif
        @if($order->branch && $order->branch->business && $order->branch->business->email)
            <p style="font-size: 10px; margin: 3px 0;">Email: {{ $order->branch->business->email }}</p>
        @endif
    </div>

    <div class="info">
        <p><strong>Receipt #:</strong> {{ $order->reference }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
        <p><strong>Cashier:</strong> {{ $order->user ? ($order->user->display_name ?? $order->user->name) : 'N/A' }}</p>
    </div>

    @if($order->customer)
    <div class="customer-info" style="margin-bottom: 10px; padding: 8px; background: #f5f5f5; border-left: 3px solid #000; font-size: 11px;">
        <p style="margin: 2px 0;"><strong>Customer:</strong> {{ $order->customer->name }}</p>
        @if($order->customer->phone)
            <p style="margin: 2px 0;"><strong>Phone:</strong> {{ $order->customer->phone }}</p>
        @endif
        @if($order->customer->email)
            <p style="margin: 2px 0;"><strong>Email:</strong> {{ $order->customer->email }}</p>
        @endif
        @if($order->customer->address)
            <p style="margin: 2px 0;"><strong>Address:</strong> {{ $order->customer->address }}</p>
        @endif
        @if($order->customer->full_address && $order->customer->full_address !== $order->customer->address)
            <p style="margin: 2px 0;">{{ $order->customer->full_address }}</p>
        @endif
    </div>
    @elseif($order->customer_name)
    <div class="customer-info" style="margin-bottom: 10px; padding: 8px; background: #f5f5f5; border-left: 3px solid #000; font-size: 11px;">
        <p style="margin: 2px 0;"><strong>Customer:</strong> {{ $order->customer_name }}</p>
    </div>
    @else
    <div class="customer-info" style="margin-bottom: 10px; padding: 8px; background: #f5f5f5; border-left: 3px solid #000; font-size: 11px;">
        <p style="margin: 2px 0;"><strong>Customer:</strong> Walk-in Customer</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>
                    {{ $item->product->name }}
                    @if($item->variant)
                        <br><small>- {{ $item->variant->name }}</small>
                    @endif
                </td>
                <td style="text-align: center;">{{ $item->qty }}</td>
                <td style="text-align: right;">N{{ number_format($item->unit_price / 100, 2) }}</td>
                <td style="text-align: right;">N{{ number_format($item->subtotal / 100, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p><strong>Total: N{{ number_format($order->total_amount / 100, 2) }}</strong></p>
        <p style="font-size: 11px; margin-top: 5px;">Payment Method: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p style="font-size: 9px; margin-top: 5px;">Cutietyha All Rights Reserved - Built by PointSync Systems Limited</p>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html>

