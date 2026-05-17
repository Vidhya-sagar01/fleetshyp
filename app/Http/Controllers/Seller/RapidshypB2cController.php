<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\RapidshypB2cOrder;
use App\Models\RapidshypB2cOrderItem;
use App\Models\RapidshypServiceabilityLog;
use App\Models\RapidshypWarehouse;
use App\Services\RapidShypService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class RapidshypB2cController extends Controller
{
    protected RapidShypService $rapidShyp;

    public function __construct(RapidShypService $rapidShyp)
    {
        $this->rapidShyp = $rapidShyp;
    }

    public function index(Request $request)
    {
        $query = RapidshypB2cOrder::where('seller_id', Auth::id())->orderByDesc('created_at');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('awb', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('order_status', $status);
        }

        if ($payment = $request->get('payment_method')) {
            $query->where('payment_method', $payment);
        }

        $orders = $query->paginate(20)->withQueryString();
        $statusCounts = RapidshypB2cOrder::where('seller_id', Auth::id())
            ->selectRaw('order_status, count(*) as count')
            ->groupBy('order_status')
            ->pluck('count', 'order_status');

        return view('seller.rapidshypb2c.rapidshypOrderList', compact('orders', 'statusCounts'));
    }

    public function createSingle()
    {
        $orderId    = 'O' . date('y') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $warehouses = RapidshypWarehouse::where('seller_id', Auth::id())
            ->orderByDesc('is_primary')
            ->get();

        return view('seller.rapidshypb2c.rapidshypCreateOrderb2c', compact('warehouses', 'orderId'));
    }

    public function checkServiceability(Request $request)
    {
        $validated = $request->validate([
            'pickup_pincode'    => 'required|digits:6',
            'delivery_pincode'  => 'required|digits:6',
            'cod'               => 'required|in:true,false,1,0',
            'total_order_value' => 'required|numeric|min:1',
            'weight'            => 'required|numeric|min:0.1',
        ]);

        $isCod   = filter_var($request->cod, FILTER_VALIDATE_BOOLEAN);
        $payload = [
            'Pickup_pincode'    => $validated['pickup_pincode'],
            'Delivery_pincode'  => $validated['delivery_pincode'],
            'cod'               => $isCod,
            'total_order_value' => (float) $validated['total_order_value'],
            'weight'            => (float) $validated['weight'],
        ];

        $result        = $this->rapidShyp->checkServiceability($payload);
        $isServiceable = false;
        $courierList   = [];
        $errorMessage  = null;

        if ($result['status'] === 'success' && isset($result['data'])) {
            $apiData = $result['data'];
            if (isset($apiData['status']) && $apiData['status'] === true) {
                $courierList   = $apiData['serviceable_courier_list'] ?? [];
                $isServiceable = !empty($courierList);
            }
            if (!$isServiceable) {
                $errorMessage = $apiData['remark'] ?? 'Delivery not available for this pincode combination.';
            }
        } else {
            $errorMessage = $result['message'] ?? ($result['details']['message'] ?? 'Serviceability check failed.');
        }

        RapidshypServiceabilityLog::create([
            'seller_id'         => Auth::id(),
            'pickup_pincode'    => $validated['pickup_pincode'],
            'delivery_pincode'  => $validated['delivery_pincode'],
            'is_cod'            => $isCod,
            'total_order_value' => (float) $validated['total_order_value'],
            'weight'            => (float) $validated['weight'],
            'is_serviceable'    => $isServiceable,
            'courier_list'      => $courierList,
            'raw_response'      => $result['data'] ?? $result,
            'api_status'        => $result['status'] ?? 'unknown',
            'error_message'     => $errorMessage,
        ]);

        if (!$isServiceable) {
            return response()->json([
                'success'     => false,
                'serviceable' => false,
                'message'     => $errorMessage,
            ], $errorMessage ? 400 : 200);
        }

        return response()->json([
            'success'      => true,
            'serviceable'  => true,
            'courier_list' => $courierList,
            'message'      => 'Delivery available! Select a courier to proceed.',
        ]);
    }

    /**
     * Store a new B2C order.
     *
     * IMPORTANT: This method ALWAYS returns JSON.
     * The frontend submits via fetch() with Content-Type: application/json,
     * so we must never return redirect() or back() here.
     */
    // public function store(Request $request)
    // {
    //     try {
    //         // ── 1. Log incoming request ───────────────────────────────────
    //         Log::info('=== ORDER CREATION REQUEST START ===', [
    //             'user_id'      => Auth::id(),
    //             'request_data' => $request->all(),
    //         ]);

    //         // ── 2. Validation (per API docs) ──────────────────────────────
    //         // Rules match RapidShyp API field constraints exactly.
    //         $validated = $request->validate([
    //             // Order basics
    //             'orderId'   => 'required|string|min:1|max:50',
    //             'orderDate' => 'required|date|before_or_equal:today|after:1990-01-01',
    //             'storeName' => 'required|string|max:100',

    //             // Pickup — one of pickupAddressName OR pickupLocation required (checked below)
    //             'pickupAddressName'             => 'nullable|string|max:75',
    //             'pickupLocation'                => 'nullable|array',
    //             'pickupLocation.pickupName'     => 'nullable|string|min:3|max:75',
    //             'pickupLocation.contactName'    => 'nullable|string|min:1|max:75',
    //             'pickupLocation.pickupPhone'    => 'nullable|regex:/^[6-9][0-9]{9}$/',
    //             'pickupLocation.pickupEmail'    => 'nullable|email|max:100',
    //             'pickupLocation.pickupAddress1' => 'nullable|string|min:3|max:100',
    //             'pickupLocation.pickupAddress2' => 'nullable|string|min:3|max:100',
    //             'pickupLocation.pinCode'        => 'nullable|digits:6',

    //             // Shipping address — API: firstName+lastName combined 3-75 chars; phone starts 6-9
    //             'shippingAddress'                => 'required|array',
    //             'shippingAddress.firstName'      => 'required|string|min:1|max:75',
    //             'shippingAddress.lastName'       => 'nullable|string|max:75',
    //             'shippingAddress.phone'          => ['required', 'regex:/^[6-9][0-9]{9}$/'],
    //             'shippingAddress.email'          => 'nullable|email|max:100',
    //             'shippingAddress.addressLine1'   => 'required|string|min:3|max:100',
    //             'shippingAddress.addressLine2'   => 'nullable|string|min:3|max:100',
    //             'shippingAddress.pinCode'        => 'required|digits:6',
    //             'shippingAddress.city'           => 'nullable|string',
    //             'shippingAddress.state'          => 'nullable|string',
    //             'shippingAddress.country'        => 'nullable|string',

    //             // Billing address
    //             'billingIsShipping'              => 'nullable|boolean',
    //             'billingAddress'                 => 'nullable|array',
    //             'billingAddress.firstName'       => 'required_if:billingIsShipping,false|string|min:1|max:75',
    //             'billingAddress.lastName'        => 'nullable|string|max:75',
    //             'billingAddress.phone'           => ['required_if:billingIsShipping,false', 'nullable', 'regex:/^[6-9][0-9]{9}$/'],
    //             'billingAddress.email'           => 'required_if:billingIsShipping,false|nullable|email|max:100',
    //             'billingAddress.addressLine1'    => 'required_if:billingIsShipping,false|string|min:3|max:100',
    //             'billingAddress.addressLine2'    => 'nullable|string|min:3|max:100',
    //             'billingAddress.pinCode'         => 'required_if:billingIsShipping,false|nullable|digits:6',
    //             'billingAddress.alternatePhone'  => 'nullable|regex:/^[6-9][0-9]{9}$/',
    //             'billingAddress.city'            => 'nullable|string',
    //             'billingAddress.state'           => 'nullable|string',
    //             'billingAddress.country'         => 'nullable|string',

    //             // Order items — API: itemName 3-200, unitPrice > 0, tax mandatory (pass 0 if none)
    //             'orderItems'                     => 'required|array|min:1',
    //             'orderItems.*.itemName'          => 'required|string|min:3|max:200',
    //             'orderItems.*.sku'               => 'nullable|string|max:200',
    //             'orderItems.*.description'       => 'nullable|string|max:500',
    //             'orderItems.*.units'             => 'required|integer|min:1',
    //             'orderItems.*.unitPrice'         => 'required|numeric|min:0.01',
    //             'orderItems.*.tax'               => 'required|numeric|min:0|max:100',
    //             'orderItems.*.hsn'               => 'nullable|string|max:50',
    //             'orderItems.*.productLength'     => 'nullable|numeric|min:0',
    //             'orderItems.*.productBreadth'    => 'nullable|numeric|min:0',
    //             'orderItems.*.productHeight'     => 'nullable|numeric|min:0',
    //             'orderItems.*.productWeight'     => 'nullable|numeric|min:0',
    //             'orderItems.*.brand'             => 'nullable|string|max:100',
    //             'orderItems.*.isFragile'         => 'nullable|boolean',
    //             'orderItems.*.isPersonalisable'  => 'nullable|boolean',
    //             'orderItems.*.pickupAddressName' => 'nullable|string|max:75',
    //             'orderItems.*.countryOfOrigin'   => 'nullable|string',

    //             // Package details — API: dimensions in CM, weight in KG
    //             'packageDetails'                 => 'required|array',
    //             'packageDetails.packageLength'   => 'required|numeric|min:0',
    //             'packageDetails.packageBreadth'  => 'required|numeric|min:0',
    //             'packageDetails.packageHeight'   => 'required|numeric|min:0',
    //             'packageDetails.packageWeight'   => 'required|numeric|min:0.001', // KG

    //             // Payment — API: all monetary values in RUPEES (float)
    //             'paymentMethod'      => 'required|in:COD,PREPAID',
    //             'shippingCharges'    => 'nullable|numeric|min:0',
    //             'giftWrapCharges'    => 'nullable|numeric|min:0',
    //             'transactionCharges' => 'nullable|numeric|min:0',
    //             'totalDiscount'      => 'nullable|numeric|min:0',
    //             'codCharges'         => 'nullable|numeric|min:0',
    //             'prepaidAmount'      => 'nullable|numeric|min:0',
    //             'totalOrderValue'    => 'required|numeric|min:0',
    //             'collectableAmount'  => 'nullable|numeric|min:0',

    //             // Serviceability reference (optional)
    //             'serviceability_log_id'  => 'nullable|integer',
    //             'selected_courier_code'  => 'nullable|string',
    //             'selected_courier_name'  => 'nullable|string',
    //         ]);

    //         Log::info('Validation passed', ['validated' => array_keys($validated)]);

    //         // ── 3. Pickup Logic ───────────────────────────────────────────
    //         $hasPickupName     = !empty($request->pickupAddressName);
    //         $hasPickupLocation = !empty($request->input('pickupLocation.pickupName'));

    //         // Try extracting pickup from first order item that has one
    //         if (!$hasPickupName && !empty($request->orderItems)) {
    //             $firstItemWithPickup = collect($request->orderItems)
    //                 ->first(fn($item) => !empty($item['pickupAddressName']));
    //             if ($firstItemWithPickup) {
    //                 $request->merge(['pickupAddressName' => $firstItemWithPickup['pickupAddressName']]);
    //                 $hasPickupName = true;
    //                 Log::info('Pickup extracted from orderItems', [
    //                     'pickupAddressName' => $firstItemWithPickup['pickupAddressName'],
    //                 ]);
    //             }
    //         }

    //         if (!$hasPickupName && !$hasPickupLocation) {
    //             Log::error('Pickup location missing');
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Please select or create a pickup location.',
    //                 'errors'  => ['pickupAddressName' => ['Please select or create a pickup location.']],
    //             ], 422);
    //         }

    //         // ── 4. Build Order Items ──────────────────────────────────────
    //         $orderItems = [];
    //         foreach ($request->orderItems as $item) {
    //             if (empty($item['itemName'])) continue;

    //             $orderItems[] = [
    //                 'itemName'          => $item['itemName'],
    //                 'sku'               => $item['sku'] ?? '',
    //                 'description'       => $item['description'] ?? '',
    //                 'units'             => (int) $item['units'],
    //                 'unitPrice'         => round((float) $item['unitPrice'], 2), // Rupees
    //                 'tax'               => (float) ($item['tax'] ?? 0),          // 0 if none
    //                 'hsn'               => $item['hsn'] ?? '',
    //                 'productLength'     => isset($item['productLength'])  ? (float) $item['productLength']  : null,
    //                 'productBreadth'    => isset($item['productBreadth']) ? (float) $item['productBreadth'] : null,
    //                 'productHeight'     => isset($item['productHeight'])  ? (float) $item['productHeight']  : null,
    //                 'productWeight'     => isset($item['productWeight'])  ? (float) $item['productWeight']  : null, // KG
    //                 'brand'             => $item['brand'] ?? '',
    //                 'imageURL'          => $item['imageURL'] ?? '',
    //                 'isFragile'         => !empty($item['isFragile']),
    //                 'isPersonalisable'  => !empty($item['isPersonalisable']),
    //                 'pickupAddressName' => $item['pickupAddressName'] ?? '',
    //             ];
    //         }

    //         if (empty($orderItems)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Please add at least one product.',
    //             ], 422);
    //         }

    //         Log::info('Order items built', ['count' => count($orderItems)]);

    //         // ── 5. Calculate Totals (Rupees) ──────────────────────────────
    //         $subtotal           = collect($orderItems)->sum(fn($i) => $i['unitPrice'] * $i['units']);
    //         $shippingCharges    = (float) ($request->shippingCharges    ?? 0);
    //         $giftWrapCharges    = (float) ($request->giftWrapCharges    ?? 0);
    //         $transactionCharges = (float) ($request->transactionCharges ?? 0);
    //         $totalDiscount      = (float) ($request->totalDiscount      ?? 0);
    //         $prepaidAmount      = (float) ($request->prepaidAmount      ?? 0);

    //         $totalOrderValue  = $subtotal + $shippingCharges + $giftWrapCharges + $transactionCharges - $totalDiscount;
    //         $collectableValue = $request->paymentMethod === 'COD'
    //             ? max(0, $totalOrderValue - $prepaidAmount)
    //             : 0;

    //         Log::info('Totals calculated (Rupees)', [
    //             'subtotal'        => $subtotal,
    //             'totalOrderValue' => $totalOrderValue,
    //             'collectableValue'=> $collectableValue,
    //         ]);

    //         // ── 6. Build Addresses ────────────────────────────────────────
    //         $billingIsShipping = (bool) $request->billingIsShipping;
    //         $sa                = $request->shippingAddress;

    //         $shippingAddress = [
    //             'firstName'    => $sa['firstName'],
    //             'lastName'     => $sa['lastName']     ?? '',
    //             'addressLine1' => $sa['addressLine1'],
    //             'addressLine2' => $sa['addressLine2'] ?? '',
    //             'pinCode'      => $sa['pinCode'],
    //             'email'        => $sa['email']        ?? '',
    //             'phone'        => $sa['phone'],
    //         ];

    //         $billingAddress = null;
    //         if (!$billingIsShipping && $request->billingAddress) {
    //             $ba = $request->billingAddress;
    //             $billingAddress = [
    //                 'firstName'    => $ba['firstName']    ?? '',
    //                 'lastName'     => $ba['lastName']     ?? '',
    //                 'addressLine1' => $ba['addressLine1'] ?? '',
    //                 'addressLine2' => $ba['addressLine2'] ?? '',
    //                 'pinCode'      => $ba['pinCode']      ?? '',
    //                 'email'        => $ba['email']        ?? '',
    //                 'phone'        => $ba['phone']        ?? '',
    //             ];
    //         }

    //         // ── 7. Build API Payload ──────────────────────────────────────
    //         $orderId = trim((string) $request->orderId);
    //         if (empty($orderId)) {
    //             return response()->json(['success' => false, 'message' => 'Order ID cannot be empty.'], 422);
    //         }

    //         // packageWeight: API docs table says "in kg" — send as-is
    //         $packageWeight = round((float) $request->input('packageDetails.packageWeight'), 3);

    //         $payload = [
    //             'orderId'           => $orderId,
    //             'orderDate'         => $request->orderDate,
    //             'storeName'         => $request->storeName,
    //             'billingIsShipping' => $billingIsShipping,
    //             'shippingAddress'   => $shippingAddress,
    //             'orderItems'        => $orderItems,
    //             'packageDetails'    => [
    //                 'packageLength'  => (float) $request->input('packageDetails.packageLength'),  // cm
    //                 'packageBreadth' => (float) $request->input('packageDetails.packageBreadth'), // cm
    //                 'packageHeight'  => (float) $request->input('packageDetails.packageHeight'),  // cm
    //                 'packageWeight'  => $packageWeight,                                           // kg
    //             ],
    //             'paymentMethod'      => $request->paymentMethod,
    //             'shippingCharges'    => round($shippingCharges, 2),
    //             'giftWrapCharges'    => round($giftWrapCharges, 2),
    //             'transactionCharges' => round($transactionCharges, 2),
    //             'totalDiscount'      => round($totalDiscount, 2),
    //             'totalOrderValue'    => round($totalOrderValue, 2),
    //             'codCharges'         => round((float) ($request->codCharges ?? 0), 2),
    //             'prepaidAmount'      => round($prepaidAmount, 2),
    //             'collectableAmount'  => round($collectableValue, 2),
    //         ];

    //         // Pickup
    //         if ($hasPickupName && !empty($request->pickupAddressName)) {
    //             $payload['pickupAddressName'] = $request->pickupAddressName;
    //         } elseif ($hasPickupLocation) {
    //             $pl                           = $request->pickupLocation;
    //             $payload['pickupAddressName'] = $pl['pickupName'];
    //             $payload['pickupLocation']    = [
    //                 'contactName'    => $pl['contactName'],
    //                 'pickupName'     => $pl['pickupName'],
    //                 'pickupPhone'    => $pl['pickupPhone'],
    //                 'pickupEmail'    => $pl['pickupEmail']    ?? '',
    //                 'pickupAddress1' => $pl['pickupAddress1'],
    //                 'pickupAddress2' => $pl['pickupAddress2'] ?? '',
    //                 'pinCode'        => $pl['pinCode'],
    //             ];
    //         }

    //         if (!$billingIsShipping && $billingAddress) {
    //             $payload['billingAddress'] = $billingAddress;
    //         }
    //       // dd($payload);
    //         Log::info('API Payload prepared', [
    //             'orderId'           => $payload['orderId'],
    //             'totalOrderValue'   => $payload['totalOrderValue'],
    //             'orderItems_count'  => count($payload['orderItems']),
    //             'unitPrice_first'   => $payload['orderItems'][0]['unitPrice'] ?? null,
    //             'packageWeight_kg'  => $payload['packageDetails']['packageWeight'],
    //             'pickupAddressName' => $payload['pickupAddressName'] ?? null,
    //             'full_payload_json' => json_encode($payload),
    //         ]);
           
    //         // ── 8. Call RapidShyp API ─────────────────────────────────────
    //         $apiResponse = $this->rapidShyp->createOrder($payload);
    //         dd($apiResponse);
    //         Log::info('RapidShyp API Response', ['response' => $apiResponse]);

    //         // API returns: status="success" + data.shipment array on success
    //         $apiSuccess   = ($apiResponse['status'] ?? '') === 'success' && !empty($apiResponse['data']);
    //         $responseData = $apiResponse['data'] ?? [];

    //         $awb         = null;
    //         $shipmentId  = null;
    //         $orderStatus = 'PENDING';

    //         if ($apiSuccess) {
    //             $shipments   = $responseData['shipment'] ?? [];
    //             $awb         = $shipments[0]['awb']        ?? null;
    //             $shipmentId  = $shipments[0]['shipmentId'] ?? null;
    //             $orderStatus = $awb ? 'READY_TO_SHIP' : 'PROCESSING';
    //         } else {
    //             $errorMsg = $apiResponse['details']['message']
    //                       ?? $apiResponse['details']['remarks']
    //                       ?? $apiResponse['message']
    //                       ?? 'Unknown API error';
    //             Log::error('RapidShyp API failed', [
    //                 'orderId'       => $orderId,
    //                 'error'         => $errorMsg,
    //                 'full_response' => $apiResponse,
    //                 'payload_sent'  => $payload,
    //             ]);
    //         }

    //         // ── 9. Save to Database ───────────────────────────────────────
    //         DB::beginTransaction();
    //         try {
    //             $orderData = [
    //                 'seller_id'           => Auth::id(),
    //                 'order_id'            => $orderId,
    //                 'order_date'          => $request->orderDate,
    //                 'store_name'          => $request->storeName,
    //                 'pickup_address_name' => $hasPickupName
    //                                             ? ($request->pickupAddressName ?? ($payload['pickupAddressName'] ?? null))
    //                                             : null,
    //                 'pickup_location'     => (!$hasPickupName && $hasPickupLocation)
    //                                             ? ($payload['pickupLocation'] ?? null)
    //                                             : null,
    //                 'shipping_address'    => $shippingAddress,
    //                 'billing_is_shipping' => $billingIsShipping,
    //                 'billing_address'     => $billingIsShipping ? null : $billingAddress,
    //                 'payment_method'      => $request->paymentMethod,
    //                 'shipping_charges'    => round($shippingCharges, 2),
    //                 'gift_wrap_charges'   => round($giftWrapCharges, 2),
    //                 'transaction_charges' => round($transactionCharges, 2),
    //                 'total_discount'      => round($totalDiscount, 2),
    //                 'total_order_value'   => round($totalOrderValue, 2),
    //                 'cod_charges'         => round((float) ($request->codCharges ?? 0), 2),
    //                 'prepaid_amount'      => round($prepaidAmount, 2),
    //                 'collectable_value'   => round($collectableValue, 2),
    //                 'api_response'        => $responseData ?: $apiResponse,
    //                 'api_status'          => $apiSuccess ? 'success' : 'error',
    //                 'awb'                 => $awb,
    //                 'shipment_id'         => $shipmentId,
    //                 'order_status'        => $orderStatus,
    //                 'package_details'     => $payload['packageDetails'],
    //             ];

    //             if (Schema::hasColumn('rapidshyp_b2c_orders', 'rapidshyp_shield')) {
    //                 $orderData['rapidshyp_shield'] = !empty($request->rapidShypShield);
    //             }

    //             $order = RapidshypB2cOrder::create($orderData);
    //             Log::info('Order saved to DB', ['db_id' => $order->id, 'order_id' => $orderId]);

    //             foreach ($orderItems as $itemData) {
    //                 RapidshypB2cOrderItem::create([
    //                     'rapidshyp_b2c_order_id' => $order->id,
    //                     'item_name'              => $itemData['itemName'],
    //                     'sku'                    => $itemData['sku'],
    //                     'description'            => $itemData['description'],
    //                     'units'                  => $itemData['units'],
    //                     'unit_price'             => round($itemData['unitPrice'], 2),
    //                     'tax'                    => $itemData['tax'],
    //                     'hsn'                    => $itemData['hsn'],
    //                     'product_length'         => $itemData['productLength'],
    //                     'product_breadth'        => $itemData['productBreadth'],
    //                     'product_height'         => $itemData['productHeight'],
    //                     'product_weight'         => $itemData['productWeight'],
    //                     'brand'                  => $itemData['brand'],
    //                     'image_url'              => $itemData['imageURL'],
    //                     'is_fragile'             => $itemData['isFragile'],
    //                     'is_personalisable'      => $itemData['isPersonalisable'],
    //                     'pickup_address_name'    => $itemData['pickupAddressName'],
    //                 ]);
    //             }
    //             Log::info('Order items saved', ['count' => count($orderItems)]);

    //             if ($request->serviceability_log_id) {
    //                 RapidshypServiceabilityLog::where('id', $request->serviceability_log_id)
    //                     ->where('seller_id', Auth::id())
    //                     ->update([
    //                         'order_id'              => $orderId,
    //                         'selected_courier_code' => $request->selected_courier_code,
    //                         'selected_courier_name' => $request->selected_courier_name,
    //                     ]);
    //             }

    //             DB::commit();
    //             Log::info('DB transaction committed');

    //             // ── 10. JSON Response (NEVER redirect) ───────────────────
    //             if ($apiSuccess) {
    //                 $msg = "Order #{$order->order_id} created successfully!";
    //                 if ($awb) $msg .= " AWB: {$awb}";
    //                 return response()->json([
    //                     'success'     => true,
    //                     'message'     => $msg,
    //                     'order_id'    => $order->order_id,
    //                     'awb'         => $awb,
    //                     'shipment_id' => $shipmentId,
    //                     'redirectUrl' => route('rapidshyp.b2c.orders.index'),
    //                 ]);
    //             }

    //             // API failed but order saved locally
    //             $errMsg = $apiResponse['details']['message']
    //                     ?? $apiResponse['details']['remarks']
    //                     ?? $apiResponse['message']
    //                     ?? 'API error';
    //             return response()->json([
    //                 'success'     => false,
    //                 'api_failed'  => true,
    //                 'message'     => "Order saved locally but API failed: {$errMsg}",
    //                 'redirectUrl' => route('rapidshyp.b2c.orders.index'),
    //             ], 200);

    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             Log::error('DB transaction failed', [
    //                 'error'    => $e->getMessage(),
    //                 'trace'    => $e->getTraceAsString(),
    //                 'order_id' => $orderId,
    //             ]);
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Failed to save order. Please try again.',
    //             ], 500);
    //         }

    //     } catch (ValidationException $e) {
    //         Log::error('Validation failed', ['errors' => $e->errors()]);
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation failed. Please check your inputs.',
    //             'errors'  => $e->errors(),
    //         ], 422);

    //     } catch (\Exception $e) {
    //         Log::error('Unexpected error in store()', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An unexpected error occurred. Please try again.',
    //         ], 500);
    //     }
    // }
public function store(Request $request)
{
    try {
        // ── 1. Log incoming request ───────────────────────────────────
        Log::info('=== ORDER CREATION REQUEST START ===', [
            'user_id'      => Auth::id(),
            'request_data' => $request->all(),
        ]);

        // ── 2. Validation ─────────────────────────────────────────────
        $validated = $request->validate([
            'orderId'   => 'required|string|min:1|max:50',
            'orderDate' => 'required|date|before_or_equal:today|after:1990-01-01',
            'storeName' => 'required|string|max:100',
            'pickupAddressName'             => 'nullable|string|max:75',
            'pickupLocation'                => 'nullable|array',
            'pickupLocation.contactName'    => 'nullable|string|max:75',
            'pickupLocation.pickupName'     => 'nullable|string|min:3|max:75',
            'pickupLocation.pickupPhone'    => 'nullable|regex:/^[6-9][0-9]{9}$/',
            'pickupLocation.pickupEmail'    => 'nullable|email|max:100',
            'pickupLocation.pickupAddress1' => 'nullable|string|min:3|max:100',
            'pickupLocation.pickupAddress2' => 'nullable|string|min:3|max:100',
            'pickupLocation.pinCode'        => 'nullable|digits:6',
            'shippingAddress'                => 'required|array',
            'shippingAddress.firstName'      => 'required|string|min:1|max:75',
            'shippingAddress.lastName'       => 'nullable|string|max:75',
            'shippingAddress.phone'          => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'shippingAddress.email'          => 'nullable|email|max:100',
            'shippingAddress.addressLine1'   => 'required|string|min:3|max:100',
            'shippingAddress.addressLine2'   => 'nullable|string|min:3|max:100',
            'shippingAddress.pinCode'        => 'required|digits:6',
            'billingIsShipping'              => 'nullable|boolean',
            'billingAddress'                 => 'nullable|array',
            'billingAddress.firstName'       => 'required_if:billingIsShipping,false|string|min:1|max:75',
            'billingAddress.lastName'        => 'nullable|string|max:75',
            'billingAddress.phone'           => ['required_if:billingIsShipping,false', 'regex:/^[6-9][0-9]{9}$/'],
            'billingAddress.email'           => 'required_if:billingIsShipping,false|email|max:100',
            'billingAddress.addressLine1'    => 'required_if:billingIsShipping,false|string|min:3|max:100',
            'billingAddress.addressLine2'    => 'nullable|string|min:3|max:100',
            'billingAddress.pinCode'         => 'required_if:billingIsShipping,false|digits:6',
            'orderItems'                     => 'required|array|min:1',
            'orderItems.*.itemName'          => 'required|string|min:3|max:200',
            'orderItems.*.sku'               => 'nullable|string|max:200',
            'orderItems.*.description'       => 'nullable|string|max:500',
            'orderItems.*.units'             => 'required|integer|min:1',
            'orderItems.*.unitPrice'         => 'required|numeric|min:0.01',
            'orderItems.*.tax'               => 'required|numeric|min:0|max:100',
            'orderItems.*.hsn'               => 'nullable|string|max:50',
            'orderItems.*.productLength'     => 'nullable|numeric|min:0',
            'orderItems.*.productBreadth'    => 'nullable|numeric|min:0',
            'orderItems.*.productHeight'     => 'nullable|numeric|min:0',
            'orderItems.*.productWeight'     => 'nullable|numeric|min:0',
            'orderItems.*.brand'             => 'nullable|string|max:100',
            'orderItems.*.isFragile'         => 'nullable|boolean',
            'orderItems.*.isPersonalisable'  => 'nullable|boolean',
            'orderItems.*.pickupAddressName' => 'nullable|string|max:75',
            'orderItems.*.countryOfOrigin'   => 'nullable|string',
            'packageDetails'                 => 'required|array',
            'packageDetails.packageLength'   => 'required|numeric|min:0',
            'packageDetails.packageBreadth'  => 'required|numeric|min:0',
            'packageDetails.packageHeight'   => 'required|numeric|min:0',
            'packageDetails.packageWeight'   => 'required|numeric|min:0.001',
            'paymentMethod'      => 'required|in:COD,PREPAID',
            'shippingCharges'    => 'nullable|numeric|min:0',
            'giftWrapCharges'    => 'nullable|numeric|min:0',
            'transactionCharges' => 'nullable|numeric|min:0',
            'totalDiscount'      => 'nullable|numeric|min:0',
            'codCharges'         => 'nullable|numeric|min:0',
            'prepaidAmount'      => 'nullable|numeric|min:0',
            'totalOrderValue'    => 'required|numeric|min:0',
            'collectableAmount'  => 'nullable|numeric|min:0',
            'serviceability_log_id'  => 'nullable|integer',
            'selected_courier_code'  => 'nullable|string',
            'selected_courier_name'  => 'nullable|string',
        ]);

        // ── 3. Pickup Logic ───────────────────────────────────────────
        $finalPickupName = null;
        $pickupLocationPayload = null;

        if (!empty($request->pickupAddressName)) {
            $finalPickupName = trim($request->pickupAddressName);
            $pickupLocationPayload = [
                'contactName'    => '',
                'pickupName'     => '',
                'pickupEmail'    => '',
                'pickupPhone'    => '',
                'pickupAddress1' => '',
                'pickupAddress2' => '',
                'pinCode'        => '',
            ];
        } elseif (!empty($request->input('pickupLocation.pickupName'))) {
            $pl = $request->pickupLocation;
            $finalPickupName = trim($pl['pickupName']);
            $pickupLocationPayload = [
                'contactName'    => $pl['contactName'] ?? '',
                'pickupName'     => $pl['pickupName'],
                'pickupPhone'    => $pl['pickupPhone'],
                'pickupEmail'    => $pl['pickupEmail'] ?? '',
                'pickupAddress1' => $pl['pickupAddress1'],
                'pickupAddress2' => $pl['pickupAddress2'] ?? '',
                'pinCode'        => $pl['pinCode'],
            ];
        } elseif (!empty($request->orderItems)) {
            $firstItemWithPickup = collect($request->orderItems)
                ->first(fn($item) => !empty($item['pickupAddressName']));
            if ($firstItemWithPickup) {
                $finalPickupName = trim($firstItemWithPickup['pickupAddressName']);
                $pickupLocationPayload = [
                    'contactName'    => '',
                    'pickupName'     => '',
                    'pickupEmail'    => '',
                    'pickupPhone'    => '',
                    'pickupAddress1' => '',
                    'pickupAddress2' => '',
                    'pinCode'        => '',
                ];
            }
        }

        if (!$finalPickupName) {
            Log::error('Pickup location missing');
            return response()->json([
                'success' => false,
                'message' => 'Please select or create a pickup location.',
                'errors'  => ['pickupAddressName' => ['Pickup location is required.']],
            ], 422);
        }

        // ── 4. Build Order Items ──────────────────────────────────────
        $orderItems = [];
        foreach ($request->orderItems as $item) {
            if (empty($item['itemName'])) continue;

            // ✅ FIX: Sanitize SKU for RapidShyp API (alphanumeric + hyphen/underscore only)
            $rawSku = $item['sku'] ?? '';
            $sanitizedSku = '';
            if (!empty($rawSku)) {
                // Remove special characters, replace spaces with hyphens, limit to 200 chars
                $sanitizedSku = preg_replace('/[^a-zA-Z0-9\-_]/', '-', trim($rawSku));
                $sanitizedSku = preg_replace('/-+/', '-', $sanitizedSku); // collapse multiple hyphens
                $sanitizedSku = trim($sanitizedSku, '-_'); // trim leading/trailing hyphens/underscores
                $sanitizedSku = substr($sanitizedSku, 0, 200); // enforce max length
                // Fallback if SKU becomes empty after sanitization
                if (empty($sanitizedSku)) {
                    $sanitizedSku = 'SKU-' . strtoupper(substr(md5($item['itemName'] . microtime()), 0, 8));
                }
            }

            $orderItem = [
                'itemName'          => $item['itemName'],
                'sku'               => $sanitizedSku, // ✅ Use sanitized SKU
                'description'       => $item['description'] ?? '',
                'units'             => (int) $item['units'],
                'unitPrice'         => round((float) $item['unitPrice'], 2),
                'tax'               => (float) ($item['tax'] ?? 0),
                'hsn'               => $item['hsn'] ?? '',
                'productLength'     => isset($item['productLength'])  ? (float) $item['productLength']  : null,
                'productBreadth'    => isset($item['productBreadth']) ? (float) $item['productBreadth'] : null,
                'productHeight'     => isset($item['productHeight'])  ? (float) $item['productHeight']  : null,
                'productWeight'     => isset($item['productWeight'])  ? (float) $item['productWeight']  : null,
                'brand'             => $item['brand'] ?? '',
                'imageURL'          => $item['imageURL'] ?? '',
                'isFragile'         => !empty($item['isFragile']),
                'isPersonalisable'  => !empty($item['isPersonalisable']),
                'countryOfOrigin'   => $item['countryOfOrigin'] ?? '',
            ];

            if (!empty($item['pickupAddressName']) && $item['pickupAddressName'] !== $finalPickupName) {
                $orderItem['pickupAddressName'] = trim($item['pickupAddressName']);
            }

            $orderItems[] = $orderItem;
        }

        if (empty($orderItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Please add at least one product.',
            ], 422);
        }

        // ── 5. Calculate Totals ───────────────────────────────────────
        $subtotal           = collect($orderItems)->sum(fn($i) => $i['unitPrice'] * $i['units']);
        $shippingCharges    = (float) ($request->shippingCharges    ?? 0);
        $giftWrapCharges    = (float) ($request->giftWrapCharges    ?? 0);
        $transactionCharges = (float) ($request->transactionCharges ?? 0);
        $totalDiscount      = (float) ($request->totalDiscount      ?? 0);
        $prepaidAmount      = (float) ($request->prepaidAmount      ?? 0);

        $totalOrderValue  = $subtotal + $shippingCharges + $giftWrapCharges + $transactionCharges - $totalDiscount;
        $collectableValue = $request->paymentMethod === 'COD' ? max(0, $totalOrderValue - $prepaidAmount) : 0;

        // ── 6. Build Addresses ────────────────────────────────────────
        $billingIsShipping = (bool) $request->billingIsShipping;
        $sa = $request->shippingAddress;

        $shippingAddress = [
            'firstName'    => $sa['firstName'],
            'lastName'     => $sa['lastName'] ?? '',
            'addressLine1' => $sa['addressLine1'],
            'addressLine2' => $sa['addressLine2'] ?? '',
            'pinCode'      => $sa['pinCode'],
            'email'        => $sa['email'] ?? '',
            'phone'        => $sa['phone'],
        ];

        $billingAddress = null;
        if (!$billingIsShipping && $request->billingAddress) {
            $ba = $request->billingAddress;
            $billingAddress = [
                'firstName'    => $ba['firstName'] ?? '',
                'lastName'     => $ba['lastName'] ?? '',
                'addressLine1' => $ba['addressLine1'] ?? '',
                'addressLine2' => $ba['addressLine2'] ?? '',
                'pinCode'      => $ba['pinCode'] ?? '',
                'email'        => $ba['email'] ?? '',
                'phone'        => $ba['phone'] ?? '',
            ];
        }

        // ── 7. Build API Payload ──────────────────────────────────────
        $orderId = trim((string) $request->orderId);
        if (empty($orderId)) {
            return response()->json(['success' => false, 'message' => 'Order ID cannot be empty.'], 422);
        }

        $storeName = trim($request->storeName);
// If storeName is not configured in RapidShyp, fallback to DEFAULT
$validStoreNames = ['DEFAULT']; // Add your actual RapidShyp store names here
if (!in_array($storeName, $validStoreNames)) {
    Log::warning('Invalid storeName provided, using DEFAULT', [
        'provided' => $storeName,
        'valid_options' => $validStoreNames
    ]);
    $storeName = 'DEFAULT'; // Fallback to DEFAULT
}

        $payload = [
            'orderId'           => $orderId,
            'orderDate'         => $request->orderDate,
            'storeName'         => $storeName,
            'billingIsShipping' => $billingIsShipping,
            'shippingAddress'   => $shippingAddress,
            'orderItems'        => $orderItems,
            'packageDetails'    => [
                'packageLength'  => (float) $request->input('packageDetails.packageLength'),
                'packageBreadth' => (float) $request->input('packageDetails.packageBreadth'),
                'packageHeight'  => (float) $request->input('packageDetails.packageHeight'),
                'packageWeight'  => round((float) $request->input('packageDetails.packageWeight'), 3),
            ],
            'paymentMethod'      => $request->paymentMethod,
            'shippingCharges'    => round($shippingCharges, 2),
            'giftWrapCharges'    => round($giftWrapCharges, 2),
            'transactionCharges' => round($transactionCharges, 2),
            'totalDiscount'      => round($totalDiscount, 2),
            'totalOrderValue'    => round($totalOrderValue, 2),
            'codCharges'         => round((float) ($request->codCharges ?? 0), 2),
            'prepaidAmount'      => round($prepaidAmount, 2),
            'collectableAmount'  => round($collectableValue, 2),
            'pickupAddressName'  => $finalPickupName,
            'pickupLocation'     => $pickupLocationPayload,
        ];

        if (!$billingIsShipping && $billingAddress) {
            $payload['billingAddress'] = $billingAddress;
        }

        Log::info('API Payload prepared', [
            'orderId'           => $payload['orderId'],
            'pickupAddressName' => $payload['pickupAddressName'],
            'sku_sample'        => $payload['orderItems'][0]['sku'] ?? null,
        ]);

        // ✅ REMOVED dd() - Use proper logging instead
        //dd($payload);

        // ── 8. Call RapidShyp API ─────────────────────────────────────
        $apiResponse = $this->rapidShyp->createOrder($payload);
        //dd($apiResponse);
        Log::info('RapidShyp API Response', [
            'order_id' => $orderId,
            'status'   => $apiResponse['status'] ?? 'unknown',
            'remarks'  => $apiResponse['details']['remarks'] ?? $apiResponse['message'] ?? null,
        ]);

        $apiSuccess   = ($apiResponse['status'] ?? '') === 'success' && !empty($apiResponse['data']);
        $responseData = $apiResponse['data'] ?? [];

        $awb = null;
        $shipmentId = null;
        $orderStatus = 'PENDING';

        if ($apiSuccess) {
            $shipments = $responseData['shipment'] ?? [];
            $awb = $shipments[0]['awb'] ?? null;
            $shipmentId = $shipments[0]['shipmentId'] ?? null;
            $orderStatus = $awb ? 'READY_TO_SHIP' : 'PROCESSING';
        } else {
            $errorMsg = $apiResponse['details']['message']
                      ?? $apiResponse['details']['remarks']
                      ?? $apiResponse['message']
                      ?? 'Unknown API error';
            Log::error('RapidShyp API failed', [
                'orderId'       => $orderId,
                'error'         => $errorMsg,
                'full_response' => $apiResponse,
                'payload_sent'  => $payload,
            ]);
        }

        // ── 9. Save to Database ───────────────────────────────────────
        DB::beginTransaction();
        try {
            $orderData = [
                'seller_id'           => Auth::id(),
                'order_id'            => $orderId,
                'order_date'          => $request->orderDate,
                'store_name'          => $request->storeName,
                'pickup_address_name' => $finalPickupName,
                'pickup_location'     => $pickupLocationPayload,
                'shipping_address'    => $shippingAddress,
                'billing_is_shipping' => $billingIsShipping,
                'billing_address'     => $billingIsShipping ? null : $billingAddress,
                'payment_method'      => $request->paymentMethod,
                'shipping_charges'    => round($shippingCharges, 2),
                'gift_wrap_charges'   => round($giftWrapCharges, 2),
                'transaction_charges' => round($transactionCharges, 2),
                'total_discount'      => round($totalDiscount, 2),
                'total_order_value'   => round($totalOrderValue, 2),
                'cod_charges'         => round((float) ($request->codCharges ?? 0), 2),
                'prepaid_amount'      => round($prepaidAmount, 2),
                'collectable_value'   => round($collectableValue, 2),
                'api_response'        => $responseData ?: $apiResponse,
                'api_status'          => $apiSuccess ? 'success' : 'error',
                'awb'                 => $awb,
                'shipment_id'         => $shipmentId,
                'order_status'        => $orderStatus,
                'package_details'     => $payload['packageDetails'],
            ];

            if (Schema::hasColumn('rapidshyp_b2c_orders', 'rapidshyp_shield')) {
                $orderData['rapidshyp_shield'] = !empty($request->rapidShypShield);
            }

            $order = RapidshypB2cOrder::create($orderData);

            foreach ($orderItems as $itemData) {
                RapidshypB2cOrderItem::create([
                    'rapidshyp_b2c_order_id' => $order->id,
                    'item_name'              => $itemData['itemName'],
                    'sku'                    => $itemData['sku'],
                    'description'            => $itemData['description'],
                    'units'                  => $itemData['units'],
                    'unit_price'             => round($itemData['unitPrice'], 2),
                    'tax'                    => $itemData['tax'],
                    'hsn'                    => $itemData['hsn'],
                    'product_length'         => $itemData['productLength'],
                    'product_breadth'        => $itemData['productBreadth'],
                    'product_height'         => $itemData['productHeight'],
                    'product_weight'         => $itemData['productWeight'],
                    'brand'                  => $itemData['brand'],
                    'image_url'              => $itemData['imageURL'],
                    'is_fragile'             => $itemData['isFragile'],
                    'is_personalisable'      => $itemData['isPersonalisable'],
                    'pickup_address_name'    => $itemData['pickupAddressName'] ?? null,
                ]);
            }

            if ($request->serviceability_log_id) {
                RapidshypServiceabilityLog::where('id', $request->serviceability_log_id)
                    ->where('seller_id', Auth::id())
                    ->update([
                        'order_id'              => $orderId,
                        'selected_courier_code' => $request->selected_courier_code,
                        'selected_courier_name' => $request->selected_courier_name,
                    ]);
            }

            DB::commit();

            // ── 10. JSON Response ─────────────────────────────────────
            if ($apiSuccess) {
                $msg = "Order #{$order->order_id} created successfully!";
                if ($awb) $msg .= " AWB: {$awb}";
                return response()->json([
                    'success'     => true,
                    'message'     => $msg,
                    'order_id'    => $order->order_id,
                    'awb'         => $awb,
                    'shipment_id' => $shipmentId,
                    'redirectUrl' => route('rapidshyp.b2c.orders.index'),
                ]);
            }

            $errMsg = $apiResponse['details']['message']
                    ?? $apiResponse['details']['remarks']
                    ?? $apiResponse['message']
                    ?? 'API error';
            return response()->json([
                'success'     => false,
                'api_failed'  => true,
                'message'     => "Order saved locally but API failed: {$errMsg}",
                'redirectUrl' => route('rapidshyp.b2c.orders.index'),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            Log::error('DB transaction failed', [
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
                'order_id' => $orderId,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to save order. Please try again.',
            ], 500);
        }

    } catch (ValidationException $e) {
        Log::error('Validation failed', ['errors' => $e->errors()]);
        return response()->json([
            'success' => false,
            'message' => 'Validation failed. Please check your inputs.',
            'errors'  => $e->errors(),
        ], 422);

    } catch (\Exception $e) {
        Log::error('Unexpected error in store()', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred. Please try again.',
        ], 500);
    }
}

}