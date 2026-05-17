<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shipping Labels</title>
    <style>
        @page { 
            margin: 8mm; 
            size: A4; 
        }
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif; 
            font-size: 8px; 
            line-height: 1.3;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .page-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 3mm;
            table-layout: fixed;
        }
        .page-table > tbody > tr > td {
            width: 50%;
            vertical-align: top;
            padding: 0;
            border: none;
        }

        .label-box {
            border: 1px dashed #333;
            padding: 6px;
            height: 128mm;
            overflow: hidden;
            box-sizing: border-box;
        }

        .label-header {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #333;
            margin-bottom: 5px;
        }
        .label-header td {
            border: none;
            padding: 0 0 4px 0;
            vertical-align: middle;
        }
        .header-title {
            font-size: 16px;
            font-weight: 800;
            font-style: italic;
            color: #1a1a1a;
        }
        .header-user {
            font-size: 7px;
            color: #4a4a4a;
            text-align: right;
            font-weight: 600;
        }

        .address-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .address-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }
        .deliver-td {
            width: 60%;
        }
        .payment-td {
            width: 40%;
            text-align: right;
        }

        /* ✅ ORDER INFO / BARCODE SECTION - tighter padding */
        .order-info {
            text-align: center;
            border-bottom: 0.8px solid #333;
            padding: 2px 0 3px 0;
            margin: 2px 0;
        }

        /* ✅ BARCODE - BIGGER & CENTERED for easy scanning */
        .barcode-container {
            text-align: center;
            margin: 3px auto 0 auto;
            display: block;
            width: 100%;
        }
        .barcode-container table {
            margin: 0 auto !important;
            border: none !important;
            width: auto !important;
            display: inline-block !important;
        }
        .barcode-container table td {
            border: none !important;
            padding: 0 !important;
        }
        .barcode-number {
            font-size: 8px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            margin-top: 2px;
            text-align: center;
            display: block;
            color: #000;
        }
        .courier-text {
            font-size: 7px;
            font-weight: bold;
            margin-top: 2px;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            font-size: 7px;
            border: 1.5px solid #333;
        }
        .products-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 6.5px;
            text-transform: uppercase;
            border: 1px solid #333;
            padding: 2px 3px;
            text-align: left;
        }
        .products-table td {
            border: 1px solid #333;
            padding: 2px 3px;
            text-align: left;
            vertical-align: middle;
        }
        .net-total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .info-block {
            margin-bottom: 3px;
            padding: 2px 4px;
            background-color: #fafafa;
            border-left: 2px solid #000;
            font-size: 7px;
            line-height: 1.2;
        }

        .label-footer {
            margin-top: 4px;
            font-size: 6px;
            color: #555;
            border-top: 1px solid #ddd;
            padding-top: 3px;
        }

        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        .sig-table td {
            border: none;
            padding: 0;
            width: 50%;
            text-align: center;
            font-size: 6px;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 3px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 4px;
            margin-bottom: 2px;
            font-size: 7px;
            text-transform: uppercase;
            color: #333;
        }
        .powered-by {
            text-align: right;
            font-size: 6px;
            margin-top: 4px;
            font-weight: bold;
        }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

@php
    $chunks = $orders->chunk(4);
@endphp

@foreach($chunks as $pageIndex => $pageOrders)
    @php
        $rows = $pageOrders->chunk(2);
    @endphp

    <table class="page-table">
        <tbody>
        @foreach($rows as $rowOrders)
            <tr>
                @foreach($rowOrders as $order)
                <td>
                <div class="label-box">

                    {{-- ✅ HEADER --}}
                    <table class="label-header" width="100%">
                        <tr>
                            <td class="header-title">Fleetshyp</td>
                            <td class="header-user">{{ $user->name ?? 'Seller' }}</td>
                        </tr>
                    </table>

                    {{-- ✅ RETURN ADDRESS --}}
                    @if(($settings['return_address'] ?? false) && isset($rtoAddress) && $rtoAddress)
                    <div class="info-block">
                        <strong>Return:</strong>
                        <strong>{{ $rtoAddress->warehouse_name ?? $rtoAddress->rto_nick_name ?? 'Warehouse' }}</strong>,
                        {{ $rtoAddress->address_line1 ?? '' }},
                        {{ $rtoAddress->city ?? '' }}
                        @if(isset($rtoAddress->state) && $rtoAddress->state)
                            - {{ $rtoAddress->state->name ?? '' }}
                        @else
                            - {{ $rtoAddress->pincode ?? '' }}
                        @endif
                        | +91 {{ $rtoAddress->phone ?? '' }}
                    </div>
                    @endif

                    {{-- ✅ DELIVER TO + PAYMENT --}}
                    <table class="address-table">
                        <tr>
                            @if(($settings['consignee'] ?? true))
                            <td class="deliver-td">
                                <strong style="font-size:7px;">Deliver To:</strong><br>
                                <strong style="font-size:8px;">{{ $order->buyer_name ?? 'N/A' }}</strong><br>
                                <span style="font-size:6.5px;">
                                    {{ $order->complete_address ?? '' }}<br>
                                    {{ $order->city ?? '' }}, {{ $order->state ?? '' }} - {{ $order->pincode ?? 'N/A' }}<br>
                                    <strong>Mob:</strong> {{ $order->phone_number ?? 'N/A' }}
                                </span>
                            </td>
                            @endif
                            <td class="payment-td">
                                <strong style="font-size:8px;">
                                    {{ $order->payment_mode == 1 ? 'COD' : 'PREPAID' }}
                                </strong><br>
                                <span style="font-size:7px;">
                                Rs. {{ number_format($order->product_subtotal ?? 0, 2) }}<br>
                                @if($order->payment_mode == 1)
                                <strong>COD: Rs. {{ number_format($order->product_subtotal ?? 0, 2) }}</strong><br>
                                @endif
                                Wt: {{ number_format($order->weight ?? 0, 2) }} Kg<br>
                                {{ (int)$order->length }}x{{ (int)$order->width }}x{{ (int)$order->height }} cm
                                </span>
                            </td>
                        </tr>
                    </table>

                    {{-- ✅ ORDER INFO + BARCODE --}}
                    @if(($settings['order_id'] ?? true))
                    <div class="order-info">

                        {{-- Order ID --}}
                        <strong style="font-size:9px;">{{ $order->merchant_order_id }}</strong><br>

                        @php
                            // ✅ FIX: Use raw waybill directly - sirf trim karo, regex mat lagao
                            // AWB numbers mein special chars nahi hote, raw value hi correct hoti hai
                            $rawWaybill = trim($order->waybill ?? '');

                            if (!empty($rawWaybill)) {
                                // ✅ Only take the AWB part before any space (if courier appends extra info)
                                $barcodeData = strtok($rawWaybill, ' ');
                            } else {
                                // Fallback to merchant order id
                                $barcodeData = trim($order->merchant_order_id ?? '');
                            }

                            // ✅ Ensure it's clean alphanumeric for CODE128 scanning
                            $barcodeData = preg_replace('/[^A-Za-z0-9\-]/', '', $barcodeData);
                        @endphp

                        {{-- ✅ BARCODE --}}
                        <div class="barcode-container">
                            @if(!empty($barcodeData))

                                <div style="text-align:center; width:100%; margin: 2px 0;">
                                    @if(class_exists('DNS1D'))
                                        @php
                                            try {
                                                // ✅ Width=1.5 (wider bars), Height=45 (taller) = easier to scan
                                                $barcode = DNS1D::getBarcodeHTML(
                                                    $barcodeData,
                                                    'C128',   // CODE128 - best for alphanumeric AWB
                                                    1.5,      // ✅ Bar width: 1.5 (was 1.0) - thicker bars = easier scan
                                                    45,       // ✅ Bar height: 45 (was 30) - taller = faster scan
                                                    '#000000'
                                                );
                                            } catch (\Exception $e) {
                                                $barcode = false;
                                            }
                                        @endphp

                                        @if(!empty($barcode) && $barcode !== false)
                                            <div style="display:inline-block; text-align:center; line-height:0;">
                                                {!! $barcode !!}
                                            </div>
                                        @else
                                            <div style="font-size:6px; padding:4px; border:1px solid #999; color:#666;">
                                                Barcode Error - AWB: {{ $barcodeData }}
                                            </div>
                                        @endif

                                    @else
                                        <div style="font-size:6px; padding:4px; border:1px solid #999; color:#666;">
                                            DNS1D not found
                                        </div>
                                    @endif
                                </div>

                                {{-- ✅ AWB Number neeche bada aur clear --}}
                                <div class="barcode-number">{{ $barcodeData }}</div>

                                {{-- ✅ Courier Name --}}
                                @if(!empty($order->courier_name))
                                <div class="courier-text">{{ strtoupper($order->courier_name) }}</div>
                                @endif

                            @else
                                <div style="padding:6px; border:1px solid #999; font-size:6px; text-align:center; color:#666;">
                                    No AWB Available
                                </div>
                            @endif
                        </div>

                    </div>
                    @endif

                    {{-- ✅ PRODUCTS TABLE --}}
                    @if(($settings['products'] ?? true))
                    @php
                        $colCount = 2;
                        if($settings['product_name'] ?? true) $colCount++;
                        if($settings['sku'] ?? true) $colCount++;
                        if($settings['amount'] ?? true) $colCount++;
                        $totalColspan = $colCount - 1;
                    @endphp
                    <table class="products-table">
                        <thead>
                            <tr>
                                @if(($settings['product_name'] ?? true))
                                <th style="width:38%;">Product</th>
                                @endif
                                @if(($settings['sku'] ?? true))
                                <th style="width:20%;">SKU</th>
                                @endif
                                <th style="width:10%; text-align:center;">Qty</th>
                                @if(($settings['amount'] ?? true))
                                <th style="width:16%; text-align:right;">Price</th>
                                @endif
                                <th style="width:16%; text-align:right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                @if(($settings['product_name'] ?? true))
                                <td>{{ $item->product_name }}</td>
                                @endif
                                @if(($settings['sku'] ?? true))
                                <td>{{ $item->sku }}</td>
                                @endif
                                <td style="text-align:center;">{{ $item->quantity }}</td>
                                @if(($settings['amount'] ?? true))
                                <td style="text-align:right;">
                                    {{ number_format($item->unit_price ?? 0, 2) }}
                                </td>
                                @endif
                                <td style="text-align:right;">
                                    {{ number_format(($item->unit_price ?? 0) * ($item->quantity ?? 1), 2) }}
                                </td>
                            </tr>
                            @endforeach
                            <tr class="net-total-row">
                                <td colspan="{{ $totalColspan }}" style="text-align:right; padding-right:5px;">
                                    Net Total:
                                </td>
                                <td style="text-align:right;">
                                    {{ number_format($order->product_subtotal ?? 0, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif

                    {{-- GST --}}
                    @if(($settings['gst'] ?? false))
                    <div class="section-title">GST:</div>
                    <div class="info-block">
                        GSTIN: {{ $company->gstin ?? 'XXXXXXXXXXXXX' }}
                        @if(($settings['gst_breakup'] ?? false))
                        | CGST: XX | SGST: XX | IGST: XX
                        @endif
                    </div>
                    @endif

                    {{-- WAREHOUSE CONTACT --}}
                    @if(($settings['warehouse_contact'] ?? false))
                    <div class="section-title">Warehouse:</div>
                    <div class="info-block">
                        {{ $order->pickupAddress->contact_name ?? 'N/A' }} |
                        +91 {{ $order->pickupAddress->phone_number ?? 'N/A' }}
                    </div>
                    @endif

                    {{-- SELLER CONTACT --}}
                    @if(($settings['seller_contact'] ?? false))
                    <div class="section-title">Seller:</div>
                    <div class="info-block">
                        +91 {{ $sellerPhone ?? 'N/A' }} | {{ $sellerEmail ?? 'N/A' }}
                    </div>
                    @endif

                    {{-- FOOTER --}}
                    <div class="label-footer">
                        All disputes subject to
                        <strong>{{ $order->state ?? 'State' }}</strong> jurisdiction.
                        Goods exchanged as per policy.
                        @if($label->show_signature_on_label ?? false)
                        <table class="sig-table">
                            <tr>
                                <td>Customer Signature</td>
                                <td>Authorized Signatory</td>
                            </tr>
                        </table>
                        @endif
                    </div>

                    {{-- POWERED BY --}}
                    <div class="powered-by">Powered By <em>Fleetshyp</em></div>

                </div>
                </td>
                @endforeach
                @if($rowOrders->count() == 1)
                <td></td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    @if(!$loop->last)
    <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>