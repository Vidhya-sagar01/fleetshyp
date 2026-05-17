<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FshipService;
use App\Models\FshipOrder;
use App\Models\PickupAddress;
use App\Models\FshipOrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class B2cOrderController extends Controller
{



// public function index(Request $request)
// {
//     // ✅ FIX: 'document' relationship ko load kiya taaki manifest details mil sakein
//     $query = FshipOrder::where('user_id', Auth::id())
//                 ->with(['items', 'pickupAddress', 'document']); 

//   // 1. Pehle status uthayein
// $status = $request->get('status', 'NEW');

// // 2. Filter apply karein
// if ($status && $status != 'all') {
//     if ($status == 'pickups') {
//         // ✅ Sabse zaroori badlaav:
//         // Jab user 'pickups' tab pe click kare, toh database mein 'Manifested' status waale orders dhundo
//         $query->where('status', '=', 'picked_up');
//     } else {
//         // Baaki sab ke liye wahi status use karein jo request mein aaya hai
//         $query->where('status', '=', $status);
//     }
// }

//     // Date Filters
//     $this->applyDateFilter($query, $request->order_date, 'created_at');
//     $this->applyDateFilter($query, $request->awb_date, 'updated_at');

//     // Search Logic (Order ID / AWB)
//     if ($request->search_order) {
//         $query->where(function($q) use ($request) {
//             $q->where('merchant_order_id', 'LIKE', "%{$request->search_order}%")
//               ->orWhere('waybill', 'LIKE', "%{$request->search_order}%");
//         });
//     }

//     // Search Logic (Customer)
//     if ($request->customer_search) {
//         $query->where(function($q) use ($request) {
//             $q->where('buyer_name', 'LIKE', "%{$request->customer_search}%")
//               ->orWhere('phone_number', 'LIKE', "%{$request->customer_search}%");
//         });
//     }

//     // Courier Filter
//     if ($request->courier) {
//         $query->where('courier_name', 'LIKE', "%{$request->courier}%");
//     }

//     // Product Search
//     if ($request->product_search) {
//         $query->whereHas('items', function($q) use ($request) {
//             $q->where('product_name', 'LIKE', "%{$request->product_search}%")
//               ->orWhere('sku', 'LIKE', "%{$request->product_search}%");
//         });
//     }

//     // Payment Mode
//     if ($request->filled('payment_mode')) {
//         $val = ($request->payment_mode == 'cod') ? '1' : '2';
//         $query->where('payment_mode', $val);
//     }

//     // ✅ Optimized Counts (Relationship load karne se ye count me status sahi dikhayega)
//     $counts = [
//         'all'        => FshipOrder::where('user_id', Auth::id())->count(),
//         'NEW'        => FshipOrder::where('user_id', Auth::id())->where('status', 'NEW')->count(),
//         'booked'     => FshipOrder::where('user_id', Auth::id())->where('status', 'Booked')->count(),
//         'manifested' => FshipOrder::where('user_id', Auth::id())->where('status', 'Manifested')->count(),
//         'pickups'          => FshipOrder::where('user_id', Auth::id())->where('status', 'Manifested')->count(),
//         'in_transit'       => FshipOrder::where('user_id', Auth::id())->where('status', 'in_transit')->count(),
//         'out_for_delivery' => FshipOrder::where('user_id', Auth::id())->where('status', 'Out For Delivery')->count(),
//         'delivered'  => FshipOrder::where('user_id', Auth::id())->where('status', 'Delivered')->count(),
//         'cancelled'  => FshipOrder::where('user_id', Auth::id())->where('status', 'Cancelled')->count(),
//         'rto'        => FshipOrder::where('user_id', Auth::id())->where('status', 'RTO')->count(),
//         'sync_error' => FshipOrder::where('user_id', Auth::id())->where('status', 'sync_error')->count(),
//     ];
//  // dd($counts);
//     $perPage = $request->get('per_page', 50);
//     $orders = $query->latest()->paginate($perPage)->appends($request->all());

//     // ✅ Yahan hum $status variable ko bhi pass karenge blade me
//     return view('seller.b2corder.orderList', compact('orders', 'counts', 'status'));
// }

public function index(Request $request)
{
    $query = FshipOrder::where('user_id', Auth::id())
                ->with(['items', 'pickupAddress', 'document']); 

    $status = $request->get('status', 'NEW');

    // ✅ FIXED: Status filter with correct database values
    if ($status && $status != 'all') {
        if ($status == 'pickups') {
            // ✅ Pickups tab = database status 'picked_up'
            $query->whereIn('status', ['manifested', 'picked_up']);
        }
        elseif ($status == 'manifested') {

        $query->whereIn('status', ['manifested', 'picked_up']);

    }
        elseif ($status == 'cancelled') {
            // ✅ Handle both cancelled variants if needed
            $query->where(function($q) {
                $q->where('status', 'cancelled')
                  ->orWhere('status', 'order_cancelled');
            });
        }
        elseif ($status == 'rto') {
    $query->whereIn('status', [
        'rto',
        'rto_in_transit',
        'rto_delivered'
    ]);
}
else {
    $query->where('status', '=', strtolower(str_replace(' ', '_', $status)));
}

    }      

    // ... (baaki filters same rahega) ...

    // ✅ FIXED: Counts with correct database status values
    $userId = Auth::id();
    $counts = [
        'all'        => FshipOrder::where('user_id', $userId)->count(),
        'NEW'        => FshipOrder::where('user_id', $userId)->where('status', 'NEW')->count(),
        'booked'     => FshipOrder::where('user_id', $userId)->where('status', 'booked')->count(),
        'manifested' => FshipOrder::where('user_id', $userId)->whereIn('status', ['manifested', 'picked_up'])->count(),
        'pickups' => FshipOrder::where('user_id', $userId)->whereIn('status', ['manifested', 'picked_up'])->count(),
        'in_transit' => FshipOrder::where('user_id', $userId)->where('status', 'in_transit')->count(),
        'out_for_delivery' => FshipOrder::where('user_id', $userId)->where('status', 'out_for_delivery')->count(),
        'delivered'  => FshipOrder::where('user_id', $userId)->where('status', 'delivered')->count(),
        'cancelled'  => FshipOrder::where('user_id', $userId)->where(function($q) {
                            $q->where('status', 'cancelled')
                              ->orWhere('status', 'order_cancelled');
                        })->count(),
        'rto' => FshipOrder::where('user_id', $userId)
    ->whereIn('status', [
        'rto',
        'rto_in_transit',
        'rto_delivered'
    ])
    ->count(),
        'sync_error' => FshipOrder::where('user_id', $userId)->where('status', 'sync_error')->count(),
    ];

    $perPage = $request->get('per_page', 50);
    $orders = $query->latest()->paginate($perPage)->appends($request->all());

    return view('seller.b2corder.orderList', compact('orders', 'counts', 'status'));
}
private function applyDateFilter($query, $dateRange, $column)
{
    if ($dateRange) {
        $dates = explode(' to ', $dateRange);
        if (count($dates) == 2) {
            $query->whereBetween($column, [
                \Carbon\Carbon::parse($dates[0])->startOfDay(),
                \Carbon\Carbon::parse($dates[1])->endOfDay()
            ]);
        } else {
            $query->whereDate($column, \Carbon\Carbon::parse($dates[0]));
        }
    }
}


    public function createOrederShow(Request $request){
        $addresses = PickupAddress::where('user_id', Auth::id())
                        ->where('is_active', 1)
                        ->latest()
                        ->get();
         return view('seller.b2corder.b2cOrderCreate', compact('addresses'));
    }



public function checkPincode(Request $request, FshipService $fship)
{
    $pincode = $request->pincode;
    
    // Validate pincode
    if (!$pincode || strlen($pincode) !== 6 || !ctype_digit($pincode)) {
        return response()->json([
            'status' => false,
            'response' => 'Invalid Pincode. Please enter 6-digit pincode.'
        ], 400);
    }

    // ✅ Fetch DEFAULT warehouse (is_default = 1) for source pincode
    $defaultWarehouse = PickupAddress::where('user_id', Auth::id())
        ->where('is_default', 1)  // ✅ Only default warehouse
        ->where('is_active', 1)
        ->first();

    if (!$defaultWarehouse) {
        return response()->json([
            'status' => false,
            'response' => 'Please set a default pickup address first.'
        ], 400);
    }

    //  Payload for Fship API
    $payload = [
        "source_Pincode" => $defaultWarehouse->pincode,      // From default warehouse
        "destination_Pincode" => $pincode                     // User entered pincode
    ];

    $apiResponse = $fship->checkPincodeServiceability($payload);

    // Handle API error
    if (isset($apiResponse['status']) && $apiResponse['status'] === false) {
        return response()->json($apiResponse, 400);
    }

    
    $formattedResponse = [
        'status' => true,
        'destination' => $apiResponse['destination'] ?? ($apiResponse['city'] ?? '') . ', ' . ($apiResponse['state'] ?? ''),
        'city' => $apiResponse['city'] ?? '',
        'state' => $apiResponse['state'] ?? '',
        'zone' => $apiResponse['zone'] ?? 'N/A',
        'cod' => $apiResponse['cod_available'] ?? $apiResponse['cod'] ?? 'Yes',
        'prepaid' => $apiResponse['prepaid_available'] ?? $apiResponse['prepaid'] ?? 'Yes',
        'serviceable' => $apiResponse['serviceable'] ?? true,
        'message' => $apiResponse['message'] ?? 'Pincode is serviceable',
        'source_warehouse' => [
            'id' => $defaultWarehouse->id,
            'name' => $defaultWarehouse->warehouse_name,
            'pincode' => $defaultWarehouse->pincode
        ]
    ];

    return response()->json($formattedResponse);
}

public function store(Request $request, FshipService $fship)
{
    // 1. Validation (Same as before)
    $validator = Validator::make($request->all(), [
        'buyer_name'        => 'required|string|max:255',
        'phone_number'      => 'required|digits:10',
        'pincode'           => 'required|digits:6',
        'city'              => 'required|string|max:100',
        'state'             => 'required|string|max:100',
        'weight'            => 'required|numeric|min:0.001|max:20',
        'length'            => 'required|numeric|min:0.5|max:45',    
        'width'             => 'required|numeric|min:0.5|max:45',
        'height'            => 'required|numeric|min:0.5|max:45',
        'pick_address_ID'   => 'required|exists:pickup_addresses,id',
        'payment_mode'      => 'required|in:1,2',
        'products'          => 'required|array|min:1',
        'products.*.name'   => 'required|string',
        'products.*.quantity'   => 'required|integer|min:1',
        'products.*.unit_price' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
    }

    try {
        // 2. WAREHOUSE DETAILS
        $warehouse = PickupAddress::where('id', $request->pick_address_ID)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        /* ========================================================
           3. PINCODE SERVICEABILITY CHECK (Optional - Local Validation)
           Note: API call nahi kar rahe, bas basic validation
        ======================================================== */
        // Agar aap chahein to yahan simple pincode format check kar sakte hain
        if (!preg_match('/^\d{6}$/', $request->pincode)) {
            throw new \Exception("Invalid Pincode Format");
        }

        /* ===============================
           4. CALCULATIONS (Same as before)
        =============================== */
        $productTotal = collect($request->products)->sum(function ($p) {
            return ((float)$p['unit_price'] * (int)$p['quantity']) - ((float)($p['discount'] ?? 0));
        });

        $otherCharges = (float)($request->shipping_charge ?? 0) + 
                        (float)($request->gift_wrap_charge ?? 0) + 
                        (float)($request->transaction_fee ?? 0);

        $totalAmount = $productTotal + $otherCharges - (float)($request->order_discount ?? 0);

        if ($totalAmount >= 50000) {
            return back()->withInput()->with('error', 'Order value must be less than ₹50,000.');
        }

        $actualWeight = (float)$request->weight;
        $volumetricWeight = ((float)$request->length * (float)$request->width * (float)$request->height) / 5000;
        $chargeableWeight = max($actualWeight, $volumetricWeight);

        /* ===============================
           5. ⚠️ FSHIP API CALL SKIP KAR RAHE HAIN
           Order ko 'NEW' status ke saath locally save karenge
           Baad mein "Book Now" button se API call hogi
        =============================== */

        /* ===============================
           6. DB SAVE (Status: NEW)
        =============================== */
        DB::transaction(function () use ($request, $chargeableWeight, $volumetricWeight, $totalAmount, $warehouse) {
            $order = FshipOrder::create([
                'user_id'            => Auth::id(),
                'fship_api_order_id' => null,  // API call nahi hui, so null
                'waybill'            => null,  // AWB baad mein generate hoga
                'merchant_order_id'  => $request->merchant_order_id,
                'order_type'         => $request->order_type ?? 'Manual',       
                'order_date'         => $request->order_date ?? now(),
                'buyer_name'         => $request->buyer_name,
                'phone_number'       => $request->phone_number,
                'alt_phone_number'   => $request->alt_phone_number,
                'email_id'           => $request->email_id,
                'complete_address'   => $request->complete_address,
                'landmark'           => $request->landmark,
                'pincode'            => $request->pincode,
                'city'               => $request->city,
                'state'              => $request->state,
                
                'weight'             => $chargeableWeight,
                'volumetric_weight'  => $volumetricWeight,
                'length'             => $request->length,
                'width'              => $request->width,
                'height'             => $request->height,
                'pick_address_ID'    => $warehouse->id, // Fixed: pick_address_ID ki jagah id
                'payment_mode'       => (int)$request->payment_mode,
                'product_subtotal'   => $totalAmount,
                'status'             => 'NEW',  // ⚠️ Status NEW rahega, booked nahi
                
                // Global Charges
                'shipping_charge'    => $request->shipping_charge ?? 0,
                'order_discount'     => $request->order_discount ?? 0,
            ]);

            // Order Items Save
            foreach ($request->products as $product) {
                $order->items()->create([
                    'product_name'     => $product['name'],
                    'quantity'         => $product['quantity'],
                    'unit_price'       => $product['unit_price'],
                    'sku'              => $product['sku'] ?? "NA",
                    'hsn_code'         => $product['hsn_code'] ?? "NA",
                    'shipping_charge'  => $request->shipping_charge ?? 0,
                    'gift_wrap_charge' => $request->gift_wrap_charge ?? 0,
                    'transaction_fee'  => $request->transaction_fee ?? 0,
                    'order_discount'   => $request->order_discount ?? 0,
                ]);
            }
        });

        return redirect()->route('orders.index')
            ->with('success', "Order created successfully! ");

    } catch (\Exception $e) {
        \Log::error('Order Store Error: ' . $e->getMessage());
        return back()->withInput()->with('error', $e->getMessage());
    }
}



// public function store(Request $request, FshipService $fship)
// {
//     // 1. Validation (Aapka existing validation...)
//     $validator = Validator::make($request->all(), [
//         'buyer_name'        => 'required|string|max:255',
//         'phone_number'      => 'required|digits:10',
//         'pincode'           => 'required|digits:6',
//         'city'              => 'required|string|max:100',
//         'state'             => 'required|string|max:100',
//         'weight'            => 'required|numeric|min:0.001|max:0.5',
//         'length'            => 'required|numeric|min:0.5|max:45',    
//         'width'             => 'required|numeric|min:0.5|max:45',
//         'height'            => 'required|numeric|min:0.5|max:45',
//         'pick_address_ID'   => 'required|exists:pickup_addresses,id',
//         'payment_mode'      => 'required|in:1,2',
//         'products'          => 'required|array|min:1',
//         'products.*.name'   => 'required|string',
//         'products.*.quantity'   => 'required|integer|min:1',
//         'products.*.unit_price' => 'required|numeric|min:0',
//     ]);

//     if ($validator->fails()) {
//         return back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
//     }

//     try {
//         // 2. WAREHOUSE DETAILS (Source Pincode ke liye)
//         $warehouse = PickupAddress::where('id', $request->pick_address_ID)
//             ->where('user_id', Auth::id())
//             ->firstOrFail();

//         /* ========================================================
//            3. PINCODE SERVICEABILITY CHECK (Zone Fetching)
//         ======================================================== */
//         $serviceability = $fship->checkPincodeServiceability([
//             'source_Pincode' => $warehouse->pincode, // Aapka warehouse pin (e.g. 110059)
//             'destination_Pincode' => $request->pincode // Buyer pin (e.g. 222301)
//         ]);

//         if (!isset($serviceability['status']) || $serviceability['status'] != true) {
//             throw new \Exception("Pincode Check Failed: " . ($serviceability['response'] ?? 'Invalid Pincode'));
//         }

//         // COD Availability Check
//         if ($request->payment_mode == 1 && $serviceability['cod'] == 'No') {
//             throw new \Exception("Is pincode par Cash on Delivery (COD) uplabd nahi hai.");
//         }

//         // Prepaid Availability Check
//         if ($request->payment_mode == 2 && ($serviceability['prepaid'] ?? 'Yes') == 'No') {
//             throw new \Exception("Is pincode par online payment (Prepaid) band hai.");
//         }

//         /* ===============================
//            4. CALCULATIONS
//         =============================== */
//         $productTotal = collect($request->products)->sum(function ($p) {
//             return ((float)$p['unit_price'] * (int)$p['quantity']) - ((float)($p['discount'] ?? 0));
//         });

//         $otherCharges = (float)($request->shipping_charge ?? 0) + 
//                         (float)($request->gift_wrap_charge ?? 0) + 
//                         (float)($request->transaction_fee ?? 0);

//         $totalAmount = $productTotal + $otherCharges - (float)($request->order_discount ?? 0);

//         if ($totalAmount >= 50000) {
//             return back()->withInput()->with('error', 'Order value must be less than ₹50,000.');
//         }

//         $actualWeight = (float)$request->weight;
//         $volumetricWeight = ((float)$request->length * (float)$request->width * (float)$request->height) / 5000;
//         $chargeableWeight = max($actualWeight, $volumetricWeight);

//         /* ===============================
//            5. FSHIP API CALL
//         =============================== */
//         $apiPayload = [
//             "customer_Name"    => $request->buyer_name,
//             "customer_Mobile"  => $request->phone_number,
//             "customer_Emailid" => $request->email_id ?? "",
//             "customer_Address" => $request->complete_address,
//             "customer_PinCode" => $request->pincode,
//             "customer_City"    => $request->city,
//             "orderId"          => $request->merchant_order_id,
//             "payment_Mode"     => (int)$request->payment_mode,
//             "product_Subtotal" => round($totalAmount, 2),
//             "product_Subtotal"  => round($totalAmount, 2), 
//             "total_Amount"      => round($totalAmount, 2), 
//             "Total_Amount"      => round($totalAmount, 2),
//             "cod_Amount"       => $request->payment_mode == 1 ? round($totalAmount, 2) : 0,
//             "shipment_Weight"  => round($chargeableWeight, 3),
//             "shipment_Length"  => round((float)$request->length, 2),
//             "shipment_Width"   => round((float)$request->width, 2),
//             "shipment_Height"  => round((float)$request->height, 2),
//             "volumetric_Weight"=> round($volumetricWeight, 3),
//             "pick_Address_ID"  => (int)$warehouse->pick_address_ID,
//             "customer_Address_Type" => "Home",
//             "products"         => collect($request->products)->map(fn($p) => [
//                                     "productName" => $p['name'],
//                                     "unitPrice"   => (float)$p['unit_price'],
//                                     "quantity"    => (int)$p['quantity'],
//                                     "sku"         => $p['sku'] ?? "NA"
//                                  ])->toArray()
//         ];

//         $response = $fship->createForwardOrder($apiPayload);
       
//         if (!isset($response['status']) || $response['status'] != true) {
//             throw new \Exception("Fship API Error: " . ($response['response'] ?? 'Order Failed'));
//         }

//         /* ===============================
//            6. DB SAVE (With Zone & Serviceability)
//         =============================== */
//         DB::transaction(function () use ($request, $response, $chargeableWeight, $volumetricWeight, $totalAmount, $warehouse, $serviceability) {
//             $order = FshipOrder::create([
//                 'user_id'            => Auth::id(),
//                 'fship_api_order_id' => $response['apiorderid'] ?? null,
//                 'waybill'            => $response['waybill'] ?? null,
//                 'merchant_order_id'  => $request->merchant_order_id,
//                 'order_type'         => $request->order_type,       
//                 'order_date'         => $request->order_date,
//                 'buyer_name'         => $request->buyer_name,
//                 'phone_number'       => $request->phone_number,
//                 'alt_phone_number'   => $request->alt_phone_number,
//                 'email_id'           => $request->email_id,
//                 'complete_address'   => $request->complete_address,
//                 'landmark'           => $request->landmark,
//                 'pincode'            => $request->pincode,
//                 'city'               => $request->city,
//                 'state'              => $request->state,
                
//                 // Saving Serviceability Data
//                 'zone'               => $serviceability['zone'] ?? 'Unknown',
//                 'is_pickup_available'  => $serviceability['pickup'] ?? 'No',
//                 'is_delivery_available'=> $serviceability['delivery'] ?? 'No',
//                 'is_cod_available'     => $serviceability['cod'] ?? 'No',
//                 'is_prepaid_available' => $serviceability['prepaid'] ?? 'Yes',
//                 'source_pincode'       => $warehouse->pincode,
//                 'destination_pincode'  => $request->pincode,
//                 'source_destination'   => ($warehouse->city ?? 'Source') . ' to ' . ($request->city ?? 'Dest'),

//                 'weight'             => $chargeableWeight,
//                 'volumetric_weight'  => $volumetricWeight,
//                 'length'             => $request->length,
//                 'width'              => $request->width,
//                 'height'             => $request->height,
//                 'pick_address_ID'    => $warehouse->pick_address_ID,
//                 'payment_mode'       => (int)$request->payment_mode,
//                 'product_subtotal'   => $totalAmount,
//                 'status'             => 'NEW',
                
//                 // Global Charges (Optional but good to have in main table)
//                 'shipping_charge'    => $request->shipping_charge ?? 0,
//                 'order_discount'     => $request->order_discount ?? 0,
//             ]);

//             foreach ($request->products as $product) {
//                 $order->items()->create([
//                     'product_name'     => $product['name'],
//                     'quantity'         => $product['quantity'],
//                     'unit_price'       => $product['unit_price'],
//                     'sku'              => $product['sku'] ?? "NA",
//                     'hsn_code'         => $product['hsn_code'] ?? "NA",
//                     'shipping_charge'  => $request->shipping_charge ?? 0,
//                     'gift_wrap_charge' => $request->gift_wrap_charge ?? 0,
//                     'transaction_fee'  => $request->transaction_fee ?? 0,
//                     'order_discount'   => $request->order_discount ?? 0,
//                 ]);
//             }
//         });

//         return redirect()->route('orders.index')->with('success', "Order Booked! Waybill: " . ($response['waybill']));

//     } catch (\Exception $e) {
//         return back()->withInput()->with('error', $e->getMessage());
//     }
// }
}
