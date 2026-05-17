<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\FshipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FshipReverseOrderController extends Controller
{
    protected $fshipService;

    public function __construct(FshipService $fshipService)
    {
        $this->fshipService = $fshipService;
    }

    // ================================
    // CREATE FORM
    // ================================
    public function createReturnFrom()
    {
        $reverseOrders = \App\Models\FshipReverseOrder::with('fshipOrder')
            ->where('seller_id', auth()->id())
            ->latest()
            ->paginate(20);

        $warehouses = \App\Models\PickupAddress::where('user_id', auth()->id())
            ->where('is_active', 1)
            ->get();

        return view('seller.revase.from', compact('reverseOrders', 'warehouses'));
    }

    // ================================
    // SEARCH ORDER BY AWB
    // ================================
    public function searchOrderByAwb(Request $request)
    {
        $request->validate(['awb' => 'required|string|max:50']);

        $awb = trim($request->awb);

        $response = $this->fshipService->getLabelDataByWaybill(['waybill' => $awb]);

        if (
            isset($response['resultDetails']) &&
            is_array($response['resultDetails']) &&
            count($response['resultDetails']) > 0
        ) {
            $awbKey  = array_key_first($response['resultDetails']);
            $apiData = $response['resultDetails'][$awbKey];
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid API response'], 500);
        }

        $orderData = $this->normalizeOrderData($apiData);

        if (!empty($orderData['buyer_pincode'])) {
            $serviceability = $this->fshipService->checkPincodeServiceability([
                'source_Pincode'      => $orderData['seller_pincode'] ?? '',
                'destination_Pincode' => $orderData['buyer_pincode'],
            ]);
            $orderData['serviceability'] = $serviceability;
        }

        return response()->json(['success' => true, 'data' => $orderData]);
    }

    // ================================
    // PINCODE SERVICEABILITY CHECK
    // ================================
    public function getPincodeDetails(Request $request)
    {
        $pincode       = $request->query('pincode');
        $pickupPincode = $request->query('pickupPincode');

        if (strlen($pincode) !== 6) {
            return response()->json(['status' => false, 'message' => 'Invalid Pincode'], 400);
        }

        $result = $this->fshipService->checkPincodeServiceability([
            'source_Pincode'      => $pickupPincode ?? config('fship.default_pickup_pincode'),
            'destination_Pincode' => $pincode,
        ]);

        return response()->json($result);
    }

    // ================================
    // STORE REVERSE ORDER
    // ================================
    public function storeReverseOrder(Request $request)
    {
      //  dd($request->all());
        $validated = $request->validate([
            'awb_no'               => 'required|string|max:255',
            'order_id'             => 'required|string|max:100',
            'invoice_number'       => 'nullable|string|max:255',
            'consignee_name'       => 'required|string|max:255',
            'consignee_phone'      => 'required|string|max:20',
            'consignee_email'      => 'nullable|email|max:255',
            'pickup_address'       => 'required|string',
            'pickup_pincode'       => 'required|digits:6',
            'pickup_city'          => 'required|string|max:100',
            'pickup_state'         => 'required|string|max:100',
            'pickup_landmark'      => 'nullable|string|max:255',
            'pickup_address_type'  => 'nullable|string',
            'payment_mode'         => 'required|in:COD,Prepaid',
            'order_amount'         => 'nullable|numeric|min:0',
            'total_amount'         => 'nullable|numeric|min:0',
            'shipment_weight'      => 'required|numeric|min:0.001',
            'shipment_length'      => 'required|numeric|min:0.1',
            'shipment_width'       => 'required|numeric|min:0.1',
            'shipment_height'      => 'required|numeric|min:0.1',
            'volumetric_weight'    => 'nullable|numeric|min:0',
            'selected_warehouse_id'=> 'required|integer',
          //  'selected_warehouse_pincode' => 'required|digits:6',
            'reason_type'          => 'required|string',
            'is_qc_required'       => 'nullable',
            'return_type'          => 'nullable',
            'products'             => 'required|array|min:1',
            'products.*.name'      => 'required|string|max:255',
            'products.*.quantity'  => 'required|integer|min:1',
            'products.*.unit_price'=> 'required|numeric|min:0',
        ]);
       // dd($validated);
        try {

            if (empty($validated['order_amount']) || $validated['order_amount'] == 0) {
                $validated['order_amount'] = collect($validated['products'])
                      ->sum(fn($p) => ($p['quantity'] * $p['unit_price']));
             }

            if (empty($validated['total_amount']) || $validated['total_amount'] == 0) {
                 $validated['total_amount'] = $validated['order_amount'];
             }
            // Build payload as per Fship API docs
            $fshipPayload = $this->buildCreateReverseOrderPayload($validated, $request);

         // dd($fshipPayload); // Debug ke liye uncomment karo

            // Call Fship API
             $apiResponse = $this->fshipService->createReverseOrder($fshipPayload);

            // dd($apiResponse); // Debug ke liye uncomment karo

            
            if (isset($apiResponse['status']) && $apiResponse['status'] === false) {
                throw new \Exception($apiResponse['response'] ?? $apiResponse['message'] ?? 'Courier Service Error');
            }

           // API docs ke mutabiq response keys: orderId, awb, courierName, routeCode, isValid, message
            $fshipApiOrderId = $apiResponse['apiorderid']     ?? 0;
            $reverseWaybill  = $apiResponse['awb']         ?? null;
            $courierName     = $apiResponse['courierName'] ?? null;
            $routeCode       = $apiResponse['routeCode']   ?? null;

            if (empty($fshipApiOrderId) || $fshipApiOrderId == 0) {
                throw new \Exception("Fship API did not return a valid Order ID. Response: " . json_encode($apiResponse));
            }
           
            $localWarehouse = \App\Models\PickupAddress::where('pick_address_ID', $validated['selected_warehouse_id'])->first();

           if (!$localWarehouse) {
             return back()->withInput()->with('error', 'selected (ID: '.$validated['selected_warehouse_id'].') not found।');
          }
            // Save to database
            $reverseOrder = \App\Models\FshipReverseOrder::create([
                'seller_id'          => auth()->id(),
                'forward_order_id'   => $validated['order_id'],
                'fship_order_id'     => $validated['order_id'],
                'warehouse_id'       => $validated['selected_warehouse_id'],
                'consignee_name'     => $validated['consignee_name'],
                'original_waybill'   => $validated['awb_no'],
                'reverse_waybill'    => $reverseWaybill,
                'fship_api_order_id' => (string) $fshipApiOrderId,
                'is_qc_required'     => (bool) ($validated['is_qc_required'] ?? false),
                'return_reason'      => $validated['reason_type'],
                'courier_name'       => $courierName,
                'route_code'         => $routeCode,
                'status'             => 'Initiated',
                'consignee_phone'    => $validated['consignee_phone'],
                'consignee_email'    => $validated['consignee_email'] ?? null,
                'pickup_address'     => $validated['pickup_address'],
                'pickup_pincode'     => $validated['pickup_pincode'],
                'pickup_city'        => $validated['pickup_city'],
                'pickup_state'       => $validated['pickup_state'],
                'invoice_number'     => $validated['invoice_number'] ?? null,
                'order_amount'       => $validated['order_amount']   ?? 0,
                'total_amount'       => $validated['total_amount']   ?? 0,
                'payment_mode'       => $validated['payment_mode'],
                'shipment_weight'    => $validated['shipment_weight'],
                'shipment_length'    => $validated['shipment_length'],
                'shipment_width'     => $validated['shipment_width'],
                'shipment_height'    => $validated['shipment_height'],
                'volumetric_weight'  => $fshipPayload['volumetric_Weight'],
                'api_request'        => json_encode($fshipPayload),
                'api_response'       => json_encode($apiResponse),
                'is_valid'           => $apiResponse['isValid'] ?? 1,
            ]);

            foreach ($validated['products'] as $product) {
                $reverseOrder->items()->create([
                    'product_name' => $product['name'],
                    'sku'          => $product['sku']        ?? null,
                    'quantity'     => $product['quantity'],
                    'unit_price'   => $product['unit_price'],
                    'total_price'  => $product['quantity'] * $product['unit_price'],
                ]);
            }

            return redirect()
                ->route('index')
                ->with('success', "Reverse Order Created! AWB: {$reverseWaybill}");

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Fship Reverse Order Error', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
                'payload' => $request->all(),
            ]);
            return back()->withInput()->with('error', $e->getMessage());
        }
    }


    // ================================
    // BUILD PAYLOAD — API DOCS ke mutabiq
    // ================================
    // private function buildCreateReverseOrderPayload(array $validated, Request $request)
    // {
    //    // dd($validated);
    //     $isQcEnabled = filter_var($validated['is_qc_required'] ?? false, FILTER_VALIDATE_BOOLEAN);

    //     // Warehouse fetch karo — sirf pick_address_ID chahiye API ko
    //     $warehouse = \App\Models\PickupAddress::where('pick_address_ID', $validated['selected_warehouse_id'])->first();
    //     if (!$warehouse) {
    //         throw new \Exception("Warehouse with ID {$validated['selected_warehouse_id']} not found.");
    //     }

    //     // QC Parameters — max 4 per product (API constraint)
    //     $formQcParams = $request->input('qc_parameters', []);
    //     $qcParams     = [];
    //     if ($isQcEnabled && is_array($formQcParams)) {
    //         foreach (array_slice($formQcParams, 0, 4) as $param) {
    //             if (empty($param['questionId'])) continue;
    //             $qcParams[] = [
    //                 'questionId' => $param['questionId'],
    //                 'question'   => $param['question'] ?? '',
    //                 'value'      => (isset($param['value']) && strcasecmp($param['value'], 'Yes') === 0) ? 'Yes' : 'No',
    //             ];
    //         }
    //     }

    //     // Products array build karo
    //     $products = array_map(function ($product) use ($validated, $qcParams, $isQcEnabled) {
    //         return [
    //             // API docs mein ye fields hain
    //             'productId'        => !empty($product['sku']) ? $product['sku'] : uniqid('p_'),
    //             'productName'      => $product['name'],
    //             'quantity'         => (int)   $product['quantity'],
    //             'unitPrice'        => (float) $product['unit_price'],
    //             'productCategory'  => $product['category']  ?? '',
    //             'sku'              => $product['sku']        ?? '',
    //             'hsnCode'          => $product['hsn']        ?? '',
    //             'taxRate'          => (float) ($product['tax_rate']  ?? 0),
    //             'productDiscount'  => (float) ($product['discount']  ?? 0),
    //             'brandName'        => !empty($product['brand']) ? $product['brand'] : 'Generic',
    //             'color'            => !empty($product['color']) ? $product['color'] : 'NA',
    //             'size'             => !empty($product['size'])  ? $product['size']  : 'NA',
    //             'eanNo'            => $product['barcode']       ?? '',
    //             'serialNo'         => $product['serial_number'] ?? '',
    //             'imei'             => $product['imei']          ?? '',
    //             'isFragileProduct' => !empty($product['is_fragile']),
    //             'productImageUrl'  => !empty($product['image_url']) ? $product['image_url'] : 'https://via.placeholder.com/150x150.png?text=Product',
    //             'returnType'       => (int) ($validated['return_type'] ?? 0),
    //             'returnReason'     => $validated['reason_type'],
    //             // QC Parameters — sirf tab bhejo jab QC enabled ho
    //             'qcParameters'     => $isQcEnabled ? $qcParams : [],
    //         ];
    //     }, $validated['products']);

    //     // Volumetric weight calculate karo
    //     $vol = (float) ($validated['volumetric_weight'] ?? 0);
    //     if ($vol <= 0) {
    //         $vol = round(
    //             ((float)$validated['shipment_length'] *
    //              (float)$validated['shipment_width']  *
    //              (float)$validated['shipment_height']) / 5000,
    //             2
    //         );
    //     }

    //     // ✅ API DOCS ke EXACT fields — koi extra field nahi
    //     return [
    //         // Customer (Pickup location — jahan se return uthana hai)
    //         'customer_Name'         => $validated['consignee_name'],
    //         'customer_Mobile'       => $validated['consignee_phone'],
    //         'customer_Emailid'      => $validated['consignee_email'] ?? '',
    //         'customer_Address'      => $validated['pickup_address'],
    //         'customer_PinCode'      => $validated['pickup_pincode'],
    //         'landMark'              => $validated['pickup_landmark']     ?? '',
    //         'customer_Address_Type' => $validated['pickup_address_type'] ?? 'Home',
    //         'customer_PinCode'      => $validated['pickup_pincode'],   // Customer ka pincode
    //         'customer_City'         => $validated['pickup_city'],

    //         // Order details
    //         'orderId'               => $validated['order_id'],
    //         'invoice_Number'        => $validated['invoice_number'] ?? $validated['order_id'],
    //         // INHE YE KARO:
    //         'order_Amount'          => (float) ($validated['order_amount'] > 0 ? $validated['order_amount'] : collect($validated['products'])->sum(fn($p) => $p['quantity'] * $p['unit_price'])),
    //         'tax_Amount'            => (float) ($validated['tax_amount']   ?? 0),
    //         'extra_Charges'         => (float) ($validated['extra_charges'] ?? 0),
    //         'total_Amount'          => (float) ($validated['total_amount'] > 0 ? $validated['total_amount'] : collect($validated['products'])->sum(fn($p) => $p['quantity'] * $p['unit_price'])),

    //         // ✅ Warehouse — sirf pickUpAddressId chahiye (Fship internally pincode lookup karta hai)
    //         'pickUpAddressId'       => (int) $warehouse->pick_address_ID,
          

    //         // Dimensions
    //         'shipment_Weight'       => (float) $validated['shipment_weight'],
    //         'shipment_Length'       => (float) $validated['shipment_length'],
    //         'shipment_Width'        => (float) $validated['shipment_width'],
    //         'shipment_Height'       => (float) $validated['shipment_height'],
    //         'volumetric_Weight'     => $vol,

    //         // Products
    //         'products'              => $products,

    //         // Config
    //         'isQcRequired'          => $isQcEnabled,
    //         'courierId'             => (int) ($request->input('courierId', 0)),
    //         'isTaxIncluded'         => true,
    //     ];
    // }
    private function buildCreateReverseOrderPayload(array $validated, Request $request)
{
    $isQcEnabled = filter_var($validated['is_qc_required'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $warehouse = \App\Models\PickupAddress::where('pick_address_ID', $validated['selected_warehouse_id'])->first();

    // PDF Rule: Max 4 QC parameters allowed per product 
    // Value strictly "Yes" or "No" 
    $formQcParams = $request->input('qc_parameters', []);
    $qcParams = [];
    if ($isQcEnabled && is_array($formQcParams)) {
        foreach (array_slice($formQcParams, 0, 4) as $param) {
            if (empty($param['questionId'])) continue;
            $qcParams[] = [
                'questionId' => $param['questionId'], // e.g. "Check_Brand" [cite: 481]
                'question'   => $param['question'] ?? '',
                'value'      => (isset($param['value']) && strcasecmp($param['value'], 'Yes') === 0) ? 'Yes' : 'No',
            ];
        }
    }

    // Products Array 
    $products = array_map(function ($product) use ($validated, $qcParams, $isQcEnabled) {
        return [
            'productId'        => $product['sku'] ?? uniqid('p_'),
            'productName'      => $product['name'], // required 
            'quantity'         => (int)$product['quantity'], // required 
            'unitPrice'        => (float)$product['unit_price'], // required 
            'brandName'        => $product['brand'] ?? 'Generic', // required for QC 
            'color'            => $product['color'] ?? 'NA',
            'size'             => $product['size'] ?? 'NA',
            'productImageUrl'  => $product['image_url'] ?? 'https://via.placeholder.com/150', // required 
            'returnReason'     => $validated['reason_type'],
            'qcParameters'     => $isQcEnabled ? $qcParams : [], // 
        ];
    }, $validated['products']);

    // Final Payload [cite: 519, 522]
    return [
        'customer_Name'     => $validated['consignee_name'], // required
        'customer_Mobile'   => $validated['consignee_phone'], // required
        'customer_Address'  => $validated['pickup_address'], // required
        'customer_PinCode'  => $validated['pickup_pincode'], // required
        'customer_City'     => $validated['pickup_city'],
        'orderId'           => $validated['order_id'], // required
        'order_Amount'      => (float)$validated['order_amount'], // required
        'total_Amount'      => (float)$validated['total_amount'], // required
        'pickUpAddressId'   => (int)$warehouse->pick_address_ID, // required 
        'shipment_Weight'   => (float)$validated['shipment_weight'], // required
        'shipment_Length'   => (float)$validated['shipment_length'],
        'shipment_Width'    => (float)$validated['shipment_width'],
        'shipment_Height'   => (float)$validated['shipment_height'],
        'volumetric_Weight' => (float)($validated['volumetric_weight'] ?? 0),
        'products'          => $products,
        'isQcRequired'      => $isQcEnabled,
        'courierId'         => (int)($request->courierId ?? 0),
        'isTaxIncluded'     => true
    ];
}
    // ================================
    // NORMALIZE AWB DATA
    // ================================
    private function normalizeOrderData($apiResponse)
    {
        $consignee = $apiResponse['ConsigneeDetails'] ?? [];
        $returnTo  = $apiResponse['ReturnTo']         ?? [];
        $products  = [];

        if (!empty($apiResponse['Products']) && is_array($apiResponse['Products'])) {
            $products = array_map(fn($item) => [
                'name'     => $item['ProductName'] ?? '',
                'sku'      => $item['ProductSKU']  ?? '',
                'quantity' => $item['ProductQty']  ?? 1,
                'price'    => $item['ProductValue'] ?? 0,
            ], $apiResponse['Products']);
        } elseif (!empty($apiResponse['products']) && is_array($apiResponse['products'])) {
            $products = array_map(fn($item) => [
                'name'     => $item['ProductName'] ?? '',
                'sku'      => $item['ProductSKU']  ?? '',
                'quantity' => $item['ProductQty']  ?? 1,
                'price'    => $item['ProductValue'] ?? 0,
            ], $apiResponse['products']);
        } else {
            $products = [[
                'name'     => $apiResponse['product_name'] ?? 'Product',
                'sku'      => '',
                'quantity' => 1,
                'price'    => 0,
            ]];
        }

        return [
            'order_id'        => $apiResponse['OrderId']      ?? '',
            'awb'             => $apiResponse['AWBNumber']    ?? '',
            'order_date'      => isset($apiResponse['OrderDate'])
                                    ? date('Y-m-d', strtotime($apiResponse['OrderDate']))
                                    : date('Y-m-d'),
            'invoice_number'  => $apiResponse['InvoiceNum']   ?? '',
            'payment_mode'    => $apiResponse['PaymentMode']  ?? 'COD',
            'total_amount'    => $apiResponse['TotalAmount']  ?? 0,
            'cod_amount'      => ($apiResponse['PaymentMode'] ?? '') === 'COD'
                                    ? ($apiResponse['TotalAmount'] ?? 0) : 0,
            'weight'          => $apiResponse['ShipmentWt']   ?? 0.5,
            'length'          => 0,
            'width'           => 0,
            'height'          => 0,
            'courier_name'    => $apiResponse['FulfilledBy']  ?? '',
            'seller_name'     => $apiResponse['SellerName']   ?? '',
            'seller_phone'    => $returnTo['ReturnContact']   ?? '',
            'seller_address'  => $returnTo['ReturnAddress']   ?? '',
            'seller_city'     => $returnTo['City']            ?? '',
            'seller_state'    => $returnTo['State']           ?? '',
            'seller_pincode'  => $returnTo['Pincode']         ?? '',
            'buyer_name'      => $consignee['CustomerName']   ?? '',
            'buyer_email'     => '',
            'buyer_phone'     => $consignee['CustomerContact']    ?? '',
            'buyer_address_1' => $consignee['CustomerAddress1']   ?? '',
            'buyer_address_2' => $consignee['CustomerAddress2']   ?? '',
            'buyer_city'      => $consignee['City']               ?? '',
            'buyer_state'     => $consignee['State']              ?? '',
            'buyer_pincode'   => $consignee['Pincode']            ?? '',
            'products'        => $products,
            'is_qc_required'  => false,
            'return_reason'   => '',
            'return_type'     => 0,
        ];
    }

    // ================================
    // INDEX
    // ================================


public function index(Request $request)
{
    $query = \App\Models\FshipReverseOrder::with(['items'])
        ->where('seller_id', auth()->id());

    // ✅ Tab logic: Agar tab 'all' nahi hai, toh status filter karein
    if ($request->filled('tab') && $request->tab !== 'all') {
        $query->where('status', $request->tab);
    } 
    // Purana status filter bhi rakhein fallback ke liye
    elseif ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('awb')) $query->where('reverse_waybill', 'like', '%'.$request->awb.'%');
    if ($request->filled('order_id')) $query->where('forward_order_id', 'like', '%'.$request->order_id.'%');
    if ($request->filled('date_from')) $query->whereDate('created_at', '>=', $request->date_from);
    if ($request->filled('date_to')) $query->whereDate('created_at', '<=', $request->date_to);
    if ($request->filled('payment_mode')) $query->where('payment_mode', $request->payment_mode);

    $reverseOrders = $query->latest('created_at')->paginate(20)->withQueryString();

    return view('seller.revase.reversed', compact('reverseOrders'));
}

    // ================================
    // SHOW
    // ================================
    public function show($id)
    {
        $reverseOrder = \App\Models\FshipReverseOrder::with(['items'])
            ->where('seller_id', auth()->id())
            ->findOrFail($id);

        return view('seller.revase.show', compact('reverseOrder'));
    }

    // ================================
    // CANCEL
    // ================================
    public function cancel(Request $request, $id)
    {
        $reverseOrder = \App\Models\FshipReverseOrder::where('seller_id', auth()->id())->findOrFail($id);

        if ($reverseOrder->status !== 'Initiated') {
            return back()->with('error', 'Only Initiated orders can be cancelled');
        }

        $request->validate(['reason' => 'required|string|max:500']);

        try {
            if ($reverseOrder->reverse_waybill) {
                $cancelResponse = $this->fshipService->cancelOrder([
                    'waybill' => $reverseOrder->reverse_waybill,
                    'reason'  => $request->reason,
                ]);

                if (isset($cancelResponse['status']) && $cancelResponse['status'] === false) {
                    throw new \Exception($cancelResponse['response'] ?? 'Failed to cancel with Fship');
                }
            }

            $reverseOrder->update([
                'status'              => 'Cancelled',
                'cancellation_reason' => $request->reason,
            ]);

            return back()->with('success', 'Reverse order cancelled successfully');

        } catch (\Exception $e) {
            Log::error('Reverse Order Cancel Failed', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Failed to cancel: ' . $e->getMessage());
        }
    }
}