<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 10px; color: #333; }
        .header { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
        .brand-name { font-size: 22px; font-weight: bold; text-transform: uppercase; }
        .manifest-title { float: right; text-align: right; font-size: 10px; }
        .info-section { margin-bottom: 15px; line-height: 1.4; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; word-wrap: break-word; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer-section { margin-top: 20px; border: 1px solid #000; padding: 10px; }
        .logistics-box { width: 100%; margin-top: 5px; }
        .seller-details { margin-top: 15px; font-size: 10px; border-top: 1px dashed #ccc; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <span class="brand-name">Fleetship Manifest</span>
        <div class="manifest-title">
            Generated on: {{ $generated_at }}
        </div>
    </div>

    <div class="info-section">
        <strong>Manifest ID:</strong> {{ $manifest_id }} <br>
        <strong>Total shipments to dispatch:</strong> {{ $total_shipments }} <br>
        <strong>Courier:</strong> {{ $courier_name }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">S.No.</th>
                <th style="width: 25%;">Order no</th>
                <th style="width: 25%;">Awb no</th>
                <th style="width: 40%;">Contents</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->merchant_order_id }}</td>
                <td>{{ $order->waybill }}</td>
                <td>
                    @if($order->items && $order->items->count() > 0)
                        @foreach($order->items as $item)
                            • {{ $item->product_name }} (x{{ $item->quantity }})<br>
                        @endforeach
                    @else
                        {{ $order->buyer_name }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-section">
        <h4 style="margin: 0 0 10px 0; font-size: 12px; border-bottom: 1px solid #eee;">To Be Filled By Logistics Executive</h4>
        <table style="border: none; margin-top: 0;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; padding: 0;">
                    Pick up time: _________________ <br><br>
                    FE Name: _____________________ <br><br>
                    FE Phone: ____________________
                </td>
                <td style="border: none; width: 50%; padding: 0; vertical-align: top;">
                    Total items picked: ___________ <br><br>
                    FE Signature: _________________
                </td>
            </tr>
        </table>
    </div>

    <div class="seller-details">
        <strong>Seller Details:</strong><br>
        {{ $warehouse->warehouseName ?? $warehouse->warehouse_name ?? 'N/A' }} <br>
        {{ $warehouse->addressLine1 ?? $warehouse->address_line1 ?? '' }}, 
        {{ $warehouse->city ?? '' }} - {{ $warehouse->pincode ?? '' }} <br>
        Phone No.: {{ $warehouse->phoneNumber ?? $warehouse->phone_number ?? 'N/A' }}
    </div>

</body>
</html>