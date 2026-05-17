<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use App\Models\FshipOrder; 
use App\Models\Courier; 
use App\Models\FshipOrderStatus; 
use App\Models\PickupAddress;
use App\Models\Wallet;
use App\Services\FshipService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $fshipService;
    public function index(Request $request)
    {
        // ✅ Consistent: Use user_id everywhere (not seller_id)
        $query = FshipOrder::where('user_id', Auth::id())
            ->with(['items', 'pickupAddress']);

        // Filtering logic
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search_order')) {
            $query->where(function($q) use ($request) {
                $q->where('merchant_order_id', 'like', '%' . $request->search_order . '%')
                  ->orWhere('waybill', 'like', '%' . $request->search_order . '%');
            });
        }

        $perPage = $request->input('per_page', 25);
        $orders = $query->latest()->paginate($perPage);

        // ✅ Consistent: Use user_id for counts too
        $counts = [
            'all' => FshipOrder::where('user_id', Auth::id())->count(),
            'new' => FshipOrder::where('user_id', Auth::id())->where('status', 'new')->count(),
            'booked' => FshipOrder::where('user_id', Auth::id())->where('status', 'booked')->count(),
            'manifested' => FshipOrder::where('user_id', Auth::id())->where('status', 'manifested')->count(),
            'delivered' => FshipOrder::where('user_id', Auth::id())->where('status', 'delivered')->count(),
            'rto' => FshipOrder::where('user_id', Auth::id())->where('status', 'rto')->count(),
            'cancelled' => FshipOrder::where('user_id', Auth::id())->where('status', 'cancelled')->count(),
        ];

        return view('seller.orders.index', compact('orders', 'counts'));
    }

    /**
     * Get order details for Modal (AJAX)
     */
    // public function getDetails($orderId)
    // {
    //     try {
    //         // ✅ Consistent: Use user_id
    //         $order = FshipOrder::where('id', $orderId)
    //             ->where('user_id', Auth::id()) 
    //             ->with(['items', 'pickupAddress'])
    //             ->first();

    //         if (!$order) {
    //             return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    //         }
    //         dd($order);
    //         return response()->json([
    //             'success' => true,
    //             'order' => [
    //                 'created_at'        => $order->created_at->format('d-m-Y h:i A'),
    //                 'zone'              => $order->zone ?? 'N/A',
    //                 'merchant_order_id' => $order->merchant_order_id,
    //                 'status'            => strtoupper($order->status),
    //                 'total_amount'      => number_format($order->total_amount, 2),
    //                 'payment_mode'      => $order->payment_mode == 1 ? 'COD' : 'PREPAID',
    //                 'buyer_name'        => $order->buyer_name,
    //                 'phone_number'      => $order->phone_number,
    //                 'city'              => $order->city,
    //                 'state'             => $order->state,
    //                 'pincode'           => $order->pincode,
    //                 'complete_address'  => $order->complete_address,
    //                 'dimensions'        => $order->length . 'x' . $order->width . 'x' . $order->height . ' cm',
    //                 'weight'            => $order->weight . ' Kg',
    //                 'volumetric_weight' => $order->volumetric_weight ?? '0.00',
    //                 'pickup_name'       => $order->pickupAddress->warehouse_name ?? 'N/A',
    //                 'pickup_address'    => ($order->pickupAddress->address_line1 ?? '') . ' ' . ($order->pickupAddress->address_line2 ?? ''),
    //                 'pickup_pincode'    => $order->pickupAddress->pincode ?? '0',
    //                 'items' => $order->items->map(function($item) {
    //                     return [
    //                         'product_name' => $item->product_name,
    //                         'sku'          => $item->sku ?? 'N/A',
    //                         'qty'          => $item->quantity
    //                     ];
    //                 })
    //             ]
    //         ]);
   
    //     } catch (\Exception $e) {
    //         Log::error('Get Order Details Error: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    //     }
    // }
    public function getDetails($orderId)
{
    try {
        // ✅ Consistent: Use user_id for security
        $order = FshipOrder::where('id', $orderId)
            ->where('user_id', Auth::id()) 
            ->with(['items', 'pickupAddress'])
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        // ❌ REMOVE THIS LINE - it breaks JSON response!
        // dd($order);

        // ✅ Build response with safe field access and proper formatting
        $orderData = [
            'created_at'        => $order->created_at?->format('d-m-Y h:i A') ?? 'N/A',
            'order_date'        => $order->order_date ?? $order->created_at?->format('Y-m-d H:i:s') ?? 'N/A',
            'zone'              => $order->zone ?? 'N/A',
            'merchant_order_id' => $order->merchant_order_id ?? 'N/A',
            'waybill'           => $order->waybill ?? 'N/A',
            'status'            => strtoupper($order->status ?? 'NEW'),
            
            // ✅ CRITICAL FIX: Use product_subtotal for amount display
            'total_amount'      => number_format((float) ($order->total_amount ?? 0), 2),
            'product_subtotal'  => number_format((float) ($order->product_subtotal ?? 0), 2),
            
            // ✅ Safe payment mode comparison (handle both int and string)
            'payment_mode'      => ($order->payment_mode == 1 || $order->payment_mode === 'COD') ? 'COD' : 'PREPAID',
            
            'buyer_name'        => $order->buyer_name ?? 'N/A',
            'phone_number'      => $order->phone_number ?? 'N/A',
            'city'              => $order->city ?? 'N/A',
            'state'             => $order->state ?? 'N/A',
            'pincode'           => $order->pincode ?? 'N/A',
            'complete_address'  => $order->complete_address ?? 'N/A',
            
            // ✅ Safe dimension formatting
            'dimensions'        => sprintf('%dx%dx%d cm', 
                (int) ($order->length ?? 0), 
                (int) ($order->width ?? 0), 
                (int) ($order->height ?? 0)
            ),
            'weight'            => number_format((float) ($order->weight ?? 0), 3),
            'volumetric_weight' => number_format((float) ($order->volumetric_weight ?? 0), 3),
            
            // ✅ Safe pickup address access
            'pickup_address'    => $order->pickupAddress ? [
                'warehouse_name' => $order->pickupAddress->warehouse_name ?? 'Default Warehouse',
                'address_line1'  => $order->pickupAddress->address_line1 ?? '',
                'address_line2'  => $order->pickupAddress->address_line2 ?? '',
                'city'           => $order->pickupAddress->city ?? '',
                'pincode'        => $order->pickupAddress->pincode ?? 'N/A',
            ] : null,
            
            // ✅ Items with safe field access
            'items' => $order->items->map(function($item) {
                return [
                    'product_name' => $item->product_name ?? 'N/A',
                    'sku'          => $item->sku ?? 'N/A',
                    'quantity'     => $item->quantity ?? 1,
                    'unit_price'   => number_format((float) ($item->unit_price ?? 0), 2),
                ];
            })->toArray(),
        ];

        return response()->json([
            'success' => true,
            'order'   => $orderData
        ]);
   
    } catch (\Exception $e) {
        Log::error('Get Order Details Error: ' . $e->getMessage(), [
            'order_id' => $orderId,
            'user_id'  => Auth::id(),
            'trace'    => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false, 
            'message' => 'Failed to load order details: ' . $e->getMessage()
        ], 500);
    }
}



private function normalizeCourierName($name)
{
    if (!$name) return '';
    $name = strtolower(trim($name));
    
    $patterns = [
        '/\s*(surface|air|express|ndd|reverse|brand|new).*/i',
        '/\s*500\s*gm.*/i',
        '/\s*\(.*?\)/',
        '/\s+/',
    ];
    
    foreach ($patterns as $pattern) {
        $name = preg_replace($pattern, '', $name);
    }
    
    return trim($name);
}



// public function getRates($orderId, Request $request)
// {
//     try {
//         $fshipService = new \App\Services\FshipService();

//         // 1️⃣ Fetch Order
//         $order = FshipOrder::where('id', $orderId)
//             ->where('user_id', Auth::id())
//             ->firstOrFail();
//       // dd($order);
//         // 2️⃣ Fetch Pickup Address
//         $pickup = PickupAddress::find($request->pickup_address_id);
//         if (!$pickup) {
//             return response()->json(['success' => false, 'message' => 'Pickup address missing'], 422);
//         }
//       // dd($pickup);
//         // ✅ Clean pincodes (6-digit numeric only)
//         $cleanSourcePincode = preg_replace('/[^0-9]/', '', $pickup->pincode);
//         $cleanDestPincode = preg_replace('/[^0-9]/', '', $order->pincode);
        
//         if (strlen($cleanSourcePincode) !== 6 || strlen($cleanDestPincode) !== 6) {
//             return response()->json(['success' => false, 'message' => 'Invalid pincode format'], 422);
//         }

//         // 3️⃣ Pincode Serviceability Check
//         $serviceability = $fshipService->checkPincodeServiceability([
//             'source_Pincode' => $cleanSourcePincode,
//             'destination_Pincode' => $cleanDestPincode
//         ]);
        
//         if (!is_array($serviceability) || !isset($serviceability['status']) || $serviceability['status'] !== true) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Pincode not serviceable: ' . ($serviceability['response'] ?? 'Check failed')
//             ], 422);
//         }

//         // ✅ COD/Prepaid check
//         if ($order->payment_mode == 1 && ($serviceability['cod'] ?? 'No') !== 'Yes') {
//             return response()->json(['success' => false, 'message' => 'COD not available for this pincode.'], 422);
//         }
//         if ($order->payment_mode == 2 && ($serviceability['prepaid'] ?? 'No') !== 'Yes') {
//             return response()->json(['success' => false, 'message' => 'Prepaid not available for this pincode.'], 422);
//         }

//         // 4️⃣ Billing Weight
//         $actualWeight = (float) $order->weight;
//         $volumetricWeight = (float) $order->volumetric_weight;
//         $billingWeight = max($actualWeight, $volumetricWeight);
//         $billingWeight = ceil($billingWeight * 2) / 2;

//         // 5️⃣ Rate Calculator API Call
//         $ratePayload = [
//             "source_Pincode" => $cleanSourcePincode,
//             "destination_Pincode" => $cleanDestPincode,
//             "payment_Mode" => ($order->payment_mode == 1) ? "COD" : "P",
//             "amount" => (float) ($order->product_subtotal ?? $order->total_amount ?? 0),
//             "express_Type" => "surface",
//             "shipment_Weight" => round($billingWeight, 3),
//             "shipment_Length" => round((float) ($order->length ?? 10), 2),
//             "shipment_Width" => round((float) ($order->width ?? 10), 2),
//             "shipment_Height" => round((float) ($order->height ?? 10), 2),
//             "volumetric_Weight" => round($volumetricWeight, 3),
//         ];

//         $rateResponse = $fshipService->calculateRates($ratePayload);
//       //dd($rateResponse);
//         $apiResult = null;
        
//         if (is_object($rateResponse) && method_exists($rateResponse, 'successful')) {
//             if (!$rateResponse->successful()) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Fship API failed'
//                 ], 502);
//             }
//             $apiResult = $rateResponse->json();
//           // dd($apiResult);
//         } elseif (is_array($rateResponse)) {
//             $apiResult = $rateResponse;
//         }

//         if (!isset($apiResult['status']) || $apiResult['status'] !== true) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'No rates available'
//             ], 422);
//         }

//         // ✅ STEP: Filter ONLY bookable couriers
//         $availableCouriers = $apiResult['shipment_rates'] ?? [];
//         //dd($availableCouriers);
//         // ✅ Filter 1: Valid rates + service mode
//         $verifiedCouriers = collect($availableCouriers)->filter(function($c) {
//             return isset($c['shipping_charge']) 
//                 && $c['shipping_charge'] > 0 
//                 && in_array($c['service_mode'] ?? '', ['surface', 'air', 'express']);
//         })->values()->toArray();
//         //dd($verifiedCouriers);
//         if (empty($verifiedCouriers)) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'No courier available for this route'
//             ], 404);
//         }

//         // ✅ Filter 2: Cross-check with getallcourier API (optional but recommended)
//         $allCouriers = $fshipService->getAllCouriers();
//         $activeFshipIds = collect($allCouriers->json() ?? [])
//             ->where('isActive', true)
//             ->pluck('courierId')
//             ->toArray();
        
//         $verifiedCouriers = collect($verifiedCouriers)
//             ->filter(fn($c) => in_array($c['courier_id'] ?? null, $activeFshipIds))
//             ->values()
//             ->toArray();

//         // ✅ Zone Mapping from API response
//         $rawZone = strtolower($verifiedCouriers[0]['zone_name'] ?? $serviceability['zone'] ?? '');
//         $zonePrefix = 'c';
//         if (str_contains($rawZone, 'local')) $zonePrefix = 'a';
//         elseif (str_contains($rawZone, 'metro') || str_contains($rawZone, 'regional')) $zonePrefix = 'b';
//         elseif (str_contains($rawZone, 'roi')) $zonePrefix = 'c';
//         elseif (str_contains($rawZone, 'special') || str_contains($rawZone, 'defence')) $zonePrefix = 'e';

//         // ✅ Local courier mapping
//         $courierMasters = Courier::where('is_active', 1)
//             ->get()
//             ->mapWithKeys(fn($c) => [$this->normalizeCourierName($c->name) => $c->id]);
//          //dd($courierMasters);
//         $finalRates = [];
//       //  dd($finalRates);
//         foreach ($verifiedCouriers as $apiCourier) {
//             $courierName = trim($apiCourier['courier_name'] ?? '');
//             $serviceMode = $apiCourier['service_mode'] ?? 'surface';
//             $normalizedApiName = $this->normalizeCourierName($courierName);
            
//             // Match courier name to local DB
//             $courierId = $courierMasters->get($normalizedApiName);
//             if (!$courierId) {
//                 foreach ($courierMasters as $normalizedName => $localId) {
//                     if (stripos($normalizedApiName, $normalizedName) !== false || 
//                         stripos($normalizedName, $normalizedApiName) !== false) {
//                         $courierId = $localId;
//                         break;
//                     }
//                 }
//             }
            
//             // 🔥 KEY FIX: ONLY include if courier_id matched AND user has rate for THIS MODE
//             if ($courierId) {
//                 // ✅ CRITICAL: Add ->where('mode', $serviceMode) to filter by surface/air/express
//                 $myRate = DB::table('shipping_rates_mini')
//                     ->where('user_id', Auth::id())
//                     ->where('courier_id', $courierId)
//                     ->where('mode', $serviceMode)  // 🔥 This ensures user's fixed rate for correct mode
//                     ->where('is_active', 1)
//                     ->first();
//                 //dd($myRate);
//                 if ($myRate) {
//                     $forwardKey = "zone_{$zonePrefix}_forward";
//                     $addForwardKey = "zone_{$zonePrefix}_add_forward";
//                     $codKey = "zone_{$zonePrefix}_cod_charge";
//                     $codPercentKey = "zone_{$zonePrefix}_cod_percent";

//                     if (!isset($myRate->$forwardKey)) continue;

//                     $baseShipping = (float) $myRate->$forwardKey;
//                     $extraShipping = 0;
//                     if ($billingWeight > 0.5) {
//                         $extraSlabs = ceil(($billingWeight - 0.5) / 0.5);
//                         $extraShipping = $extraSlabs * (float) ($myRate->$addForwardKey ?? 0);
//                     }
//                     $netSubTotal = $baseShipping + $extraShipping;

//                     $codCharge = 0;
//                     if ($order->payment_mode == 1) {
//                         $minCod = (float) ($myRate->$codKey ?? 0);
//                         $percentCod = ($order->product_subtotal * (float) ($myRate->$codPercentKey ?? 0)) / 100;
//                         $codCharge = max($minCod, $percentCod);
//                     }

//                     $gstRate = config('shipping.gst', 18);
//                     $grandTotal = ($netSubTotal + $codCharge) * (1 + $gstRate / 100);
//                     $localCourier = Courier::find($courierId);
                    
//                     // ✅ Final rate entry - courier_id hamesha populated rahega
//                     $finalRates[] = [
//                         'courier_id' => $courierId,  // ✅ Kabhi null nahi hoga
//                         'courier_name' => $courierName,
//                         'service_mode' => $serviceMode,
//                         'shipping_charge' => number_format($grandTotal, 2, '.', ''),
//                         'cod_charge' => number_format($codCharge, 2, '.', ''),
//                         'rto_charge' => $apiCourier['rto_charge'] ?? 0,
//                         'logo' => $localCourier?->logo_url ?? $localCourier?->logo,
//                         'rating' => $localCourier?->rating_delivery ?? 4.5,
//                         'expected_pickup' => $localCourier?->expected_pickup ?? 'Today',
//                         'estimated_delivery' => $localCourier?->estimated_delivery ?? ($serviceMode === 'air' ? '1-2 Days' : '3-5 Days'),
//                         'expected_delivery_date' => $apiCourier['expectedDeliveryDate'] ?? null,
//                     ];
//                 }
//                 // ❌ Agar rate nahi mila is courier+mode ke liye → SKIP karein (null courier_id avoid)
//             }
//             // ❌ Agar courier_id hi match nahi hua → SKIP karein
//         }

//         // ✅ Sort cheapest first
//         usort($finalRates, fn($a, $b) => (float)$a['shipping_charge'] <=> (float)$b['shipping_charge']);

//         return response()->json([
//             'success' => true,
//             'rates' => $finalRates,
//             'billing_weight' => $billingWeight,
//             'zone' => $verifiedCouriers[0]['zone_name'] ?? 'Unknown',
//             'zone_prefix' => $zonePrefix,
//             'source_pincode' => $cleanSourcePincode,
//             'destination_pincode' => $cleanDestPincode,
//             'total_couriers' => count($finalRates),
//         ]);

//     } catch (\Throwable $e) {
//         Log::error('getRates Error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
//         return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
//     }
// }

// public function getRates($orderId, Request $request)
// {
//     try {

//         // 1️⃣ Order
//         $order = FshipOrder::where('id', $orderId)
//             ->where('user_id', Auth::id())
//             ->firstOrFail();

//         // 2️⃣ Pickup Address
//         $pickup = PickupAddress::find($request->pickup_address_id);
//         if (!$pickup) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Pickup address missing'
//             ], 422);
//         }

//         // 3️⃣ Clean Pincode
//         $source = preg_replace('/[^0-9]/', '', $pickup->pincode);
//         $dest   = preg_replace('/[^0-9]/', '', $order->pincode);

//         if (strlen($source) !== 6 || strlen($dest) !== 6) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Invalid pincode'
//             ], 422);
//         }

//         // 4️⃣ Zone (LOCAL)
//         $zone = $this->getZone($source, $dest);

//         // 5️⃣ Billing Weight
//         $actualWeight = (float) $order->weight;
//         $volWeight    = (float) $order->volumetric_weight;

//         $billingWeight = max($actualWeight, $volWeight);
//         $billingWeight = ceil($billingWeight * 2) / 2;

//         // 6️⃣ Get User Rate Card
//         $rates = DB::table('shipping_rates_mini')
//             ->where('user_id', Auth::id())
//             ->where('is_active', 1)
//             ->get();

//         if ($rates->isEmpty()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'No rate card found'
//             ], 404);
//         }

//         $finalRates = [];

//         foreach ($rates as $rate) {

//             $forwardKey = "zone_{$zone}_forward";
//             $addKey     = "zone_{$zone}_add_forward";

//             if (!isset($rate->$forwardKey)) continue;

//             // 🔹 Base Charge
//             $base = (float) $rate->$forwardKey;

//             // 🔹 Extra Weight Charge
//             $extra = 0;
//             if ($billingWeight > 0.5) {
//                 $extraSlab = ceil(($billingWeight - 0.5) / 0.5);
//                 $extra = $extraSlab * (float) ($rate->$addKey ?? 0);
//             }

//             $subtotal = $base + $extra;

//             // ❌ COD removed
//             $codCharge = 0;

//             // 🔹 GST
//             $gst = 18;
//             $total = $subtotal * (1 + $gst / 100);

//             // 🔹 Courier Info (LOCAL DB)
//             $courier = DB::table('couriers')
//                 ->where('id', $rate->courier_id)
//                 ->where('is_active', 1)
//                 ->first();

//             if (!$courier) continue;

//             $finalRates[] = [
//                 'courier_id'   => $courier->id,
//                 'courier_name' => $courier->name,
//                 'service_mode' => $rate->mode,

//                 'shipping_charge' => number_format($total, 2, '.', ''),
//                 'base_charge'     => number_format($base, 2, '.', ''),
//                 'extra_charge'    => number_format($extra, 2, '.', ''),
//                 'cod_charge'      => 0,

//                 // ✅ Local courier table data
//                 'rating' => $courier->rating_delivery ?? 4.5,
//                 'pickup' => $courier->expected_pickup ?? 'Today',
//                 'delivery_days' => $courier->estimated_delivery ?? '3-5 Days',

//                 'logo' => $courier->logo_url ?? $courier->logo ?? null,
//             ];
//         }

//         // 7️⃣ Sort cheapest first
//         usort($finalRates, function ($a, $b) {
//             return (float)$a['shipping_charge'] <=> (float)$b['shipping_charge'];
//         });

//         return response()->json([
//             'success' => true,
//             'rates' => $finalRates,
//             'billing_weight' => $billingWeight,
//             'zone' => strtoupper($zone),
//             'source_pincode' => $source,
//             'destination_pincode' => $dest,
//             'total_couriers' => count($finalRates),
//         ]);

//     } catch (\Throwable $e) {

//         Log::error('Rate Error', [
//             'message' => $e->getMessage(),
//             'trace' => $e->getTraceAsString()
//         ]);

//         return response()->json([
//             'success' => false,
//             'message' => 'Server error'
//         ], 500);
//     }
// }

// public function getRates($orderId, Request $request)
// {
//     try {

//         // 1️⃣ Order
//         $order = FshipOrder::where('id', $orderId)
//             ->where('user_id', Auth::id())
//             ->firstOrFail();

//         // 2️⃣ Pickup
//         $pickup = PickupAddress::find($request->pickup_address_id);
//         if (!$pickup) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Pickup address missing'
//             ], 422);
//         }

//         // 3️⃣ Pincode Clean
//         $source = preg_replace('/[^0-9]/', '', $pickup->pincode);
//         $dest   = preg_replace('/[^0-9]/', '', $order->pincode);

//         if (strlen($source) !== 6 || strlen($dest) !== 6) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Invalid pincode'
//             ], 422);
//         }

//         // 4️⃣ Zone (LOCAL)
//         $zone = $this->getZone($source, $dest); // a,b,c,d,e

//         // 5️⃣ Billing Weight
//         $billingWeight = max((float)$order->weight, (float)$order->volumetric_weight);
//         $billingWeight = ceil($billingWeight * 2) / 2;

//         // 6️⃣ Rate Cards
//         $rates = DB::table('shipping_rates_mini')
//             ->where('user_id', Auth::id())
//             ->where('is_active', 1)
//             ->get();

//         if ($rates->isEmpty()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'No rate card found'
//             ], 404);
//         }

//         // 7️⃣ Courier Master (ONE TIME LOAD)
//         $couriers = DB::table('couriers')
//             ->where('is_active', 1)
//             ->get()
//             ->keyBy('id');

//         $finalRates = [];

//         foreach ($rates as $rate) {

//             $forwardKey = "zone_{$zone}_forward";
//             $addKey     = "zone_{$zone}_add_forward";

//             if (!isset($rate->$forwardKey)) continue;

//             // 🔹 Dynamic base weight & slab
//             $baseWeight = (float) ($rate->weight_info ?? 0.5);
//             $slabWeight = (float) ($rate->add_weight ?? 0.5);

//             // 🔹 Base charge
//             $base = (float) $rate->$forwardKey;

//             // 🔹 Extra charge
//             $extra = 0;
//             if ($billingWeight > $baseWeight) {
//                 $extraSlab = ceil(($billingWeight - $baseWeight) / $slabWeight);
//                 $extra = $extraSlab * (float) ($rate->$addKey ?? 0);
//             }

//             // 🔹 Subtotal (COD removed)
//             $subtotal = $base + $extra;

//             // 🔹 GST
//             $total = $subtotal * 1.18;

//             // 🔹 Courier Info
//             $courier = $couriers->get($rate->courier_id);
//             if (!$courier) continue;

//             $finalRates[] = [
//                 'courier_id'   => $courier->id,
//                 'courier_name' => $courier->name,
//                 'service_mode' => $rate->mode,

//                 'shipping_charge' => number_format($total, 2, '.', ''),
//                 'base_charge'     => number_format($base, 2, '.', ''),
//                 'extra_charge'    => number_format($extra, 2, '.', ''),

//                 // UI fields
//                 'rating' => $courier->rating_delivery ?? 4.5,
//                 'pickup' => $courier->expected_pickup ?? 'Today',
//                 'delivery_days' => $courier->estimated_delivery ?? '3-5 Days',

//                 'logo' => $courier->logo_url ?? $courier->logo,
//             ];
//         }

//         // ❗ Empty result safety
//         if (empty($finalRates)) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'No courier available for this route'
//             ], 404);
//         }

//         // 8️⃣ Sort
//         usort($finalRates, fn($a, $b) =>
//             (float)$a['shipping_charge'] <=> (float)$b['shipping_charge']
//         );

//         return response()->json([
//             'success' => true,
//             'rates' => $finalRates,
//             'billing_weight' => $billingWeight,
//             'zone' => strtoupper($zone),
//             'source_pincode' => $source,
//             'destination_pincode' => $dest,
//             'total_couriers' => count($finalRates),
//         ]);

//     } catch (\Throwable $e) {

//         Log::error('Rate Error', [
//             'message' => $e->getMessage(),
//             'trace' => $e->getTraceAsString()
//         ]);

//         return response()->json([
//             'success' => false,
//             'message' => 'Server error'
//         ], 500);
//     }
// }

// public function getRates($orderId, Request $request)
// {
//     try {

//         // 1️⃣ Order
//         $order = FshipOrder::where('id', $orderId)
//             ->where('user_id', Auth::id())
//             ->firstOrFail();

//         // 2️⃣ Pickup
//         $pickup = PickupAddress::find($request->pickup_address_id);
//         if (!$pickup) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Pickup address missing'
//             ], 422);
//         }

//         // 3️⃣ Pincode Clean
//         $source = preg_replace('/[^0-9]/', '', $pickup->pincode);
//         $dest   = preg_replace('/[^0-9]/', '', $order->pincode);

//         if (strlen($source) !== 6 || strlen($dest) !== 6) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Invalid pincode'
//             ], 422);
//         }

//         // 4️⃣ Zone (API ya local)
//         $zone = $this->getZone($source, $dest); // a,b,c,d,e

//         // 5️⃣ Billing Weight
//         $billingWeight = max((float)$order->weight, (float)$order->volumetric_weight);
//         $billingWeight = ceil($billingWeight * 2) / 2;

//         // 6️⃣ Rate Cards
//         $rates = DB::table('shipping_rates_mini')
//             ->where('user_id', Auth::id())
//             ->where('is_active', 1)
//             ->get();

//         if ($rates->isEmpty()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'No rate card found'
//             ], 404);
//         }

//         // 7️⃣ Courier Master
//         $couriers = DB::table('couriers')
//             ->where('is_active', 1)
//             ->get()
//             ->keyBy('id');

//         $finalRates = [];

//         foreach ($rates as $rate) {

//             $forwardKey = "zone_{$zone}_forward";
//             $addKey     = "zone_{$zone}_add_forward";

//             if (!isset($rate->$forwardKey)) continue;

//             $baseWeight = (float) ($rate->weight_info ?? 0.5);
//             $slabWeight = (float) ($rate->add_weight ?? 0.5);

//             // 🔹 Base
//             $base = (float) $rate->$forwardKey;

//             // 🔹 Extra (ONLY if weight > baseWeight)
//             $extra = 0;
//             if ($billingWeight > $baseWeight) {
//                 $extraSlab = ceil(($billingWeight - $baseWeight) / $slabWeight);
//                 $extra = $extraSlab * (float) ($rate->$addKey ?? 0);
//             }

//             // 🔹 Subtotal
//             $subtotal = $base + $extra;

//             // 🔹 GST 18%
//             $total = $subtotal * 1.18;

//             // 🔹 Courier
//             $courier = $couriers->get($rate->courier_id);
//             if (!$courier) continue;

//             $finalRates[] = [
//                 'courier_id'   => $courier->id,
//                 'courier_name' => $courier->name,
//                 'service_mode' => $rate->mode,

//                 'shipping_charge' => number_format($total, 2, '.', ''),
//                 'base_charge'     => number_format($base, 2, '.', ''),
//                 'extra_charge'    => number_format($extra, 2, '.', ''),

//                 'rating' => $courier->rating_delivery ?? 4.5,
//                 'pickup' => $courier->expected_pickup ?? 'Today',
//                 'delivery_days' => $courier->estimated_delivery ?? '3-5 Days',

//                 'logo' => $courier->logo_url ?? $courier->logo,
//             ];
//         }

//         if (empty($finalRates)) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'No courier available'
//             ], 404);
//         }

//         // ✅ OPTIONAL: sorting hata bhi sakte ho
//         // usort($finalRates, fn($a, $b) =>
//         //     (float)$a['shipping_charge'] <=> (float)$b['shipping_charge']
//         // );

//         return response()->json([
//             'success' => true,
//             'rates' => $finalRates,
//             'billing_weight' => $billingWeight,
//             'zone' => strtoupper($zone),
//             'total_couriers' => count($finalRates),
//         ]);

//     } catch (\Throwable $e) {

//         Log::error('Rate Error', [
//             'message' => $e->getMessage()
//         ]);

//         return response()->json([
//             'success' => false,
//             'message' => 'Server error'
//         ], 500);
//     }
// }


public function getRates($orderId, Request $request)
{
    try {

        // 1️⃣ Order
        $order = FshipOrder::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // 2️⃣ Pickup
        $pickup = PickupAddress::find($request->pickup_address_id);
        if (!$pickup) {
            return response()->json([
                'success' => false,
                'message' => 'Pickup address missing'
            ], 422);
        }

        // 3️⃣ Clean Pincode
        $source = preg_replace('/[^0-9]/', '', $pickup->pincode);
        $dest   = preg_replace('/[^0-9]/', '', $order->pincode);

        if (strlen($source) !== 6 || strlen($dest) !== 6) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid pincode'
            ], 422);
        }

        // 4️⃣ Zone
        $zone = strtolower($this->getZone($source, $dest));

        // 5️⃣ Billing Weight
        $billingWeight = max((float)$order->weight, (float)$order->volumetric_weight);
        $billingWeight = ceil($billingWeight * 2) / 2;

        // 6️⃣ Rate Cards
        $rates = DB::table('shipping_rates_mini')
            ->where('user_id', Auth::id())
            ->where('is_active', 1)
            ->get();

        if ($rates->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No rate card found'
            ], 404);
        }

        // 7️⃣ Courier Master
        $couriers = DB::table('couriers')
            ->where('is_active', 1)
            ->get()
            ->keyBy('id');

        $finalRates = [];

        foreach ($rates as $rate) {

            $forwardKey   = "zone_{$zone}_forward";
            $addKey       = "zone_{$zone}_add_forward";
            $codChargeKey = "zone_{$zone}_cod_charge";

            if (!isset($rate->$forwardKey)) continue;

            $baseWeight = (float) ($rate->weight_info ?? 0.5);
            $slabWeight = (float) ($rate->add_weight ?? 0.5);

            // 🔹 Base charge
            $base = (float) $rate->$forwardKey;

            // 🔹 Extra weight charge
            $extra = 0;
            if ($billingWeight > $baseWeight) {
                $extraSlab = ceil(($billingWeight - $baseWeight) / $slabWeight);
                $extra = $extraSlab * (float) ($rate->$addKey ?? 0);
            }

            // 🔹 Subtotal
            $subtotal = $base + $extra;

            // 🔹 GST
            $total = $subtotal * 1.18;

            // ✅ FIX: ONLY FIXED COD (NO %)
            $codAmount = 0;
            if ((int)$order->payment_mode === 1) { // COD
                $codAmount = (float) ($rate->$codChargeKey ?? 0);
                $total += $codAmount;
            }

            // 🔹 Courier Info
            $courier = $couriers->get($rate->courier_id);
            if (!$courier) continue;

            $finalRates[] = [
                'courier_id'   => $courier->id,
                'courier_name' => $courier->name,
                'service_mode' => $rate->mode,

                'shipping_charge' => number_format($total, 2, '.', ''),
                'base_charge'     => number_format($base, 2, '.', ''),
                'extra_charge'    => number_format($extra, 2, '.', ''),
                'cod_charge'      => number_format($codAmount, 2, '.', ''),

                'rating' => $courier->rating_delivery ?? 4.5,
                'pickup' => $courier->expected_pickup ?? 'Today',
                'delivery_days' => $courier->estimated_delivery ?? '3-5 Days',

                'logo' => $courier->logo_url ?? $courier->logo,
            ];
        }

        if (empty($finalRates)) {
            return response()->json([
                'success' => false,
                'message' => 'No courier available'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'rates' => $finalRates,
            'billing_weight' => $billingWeight,
            'zone' => strtoupper($zone),
            'total_couriers' => count($finalRates),
        ]);

    } catch (\Throwable $e) {

        Log::error('Rate Error', [
            'message' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Server error'
        ], 500);
    }
}

// private function getZone($source, $dest)
// {
//     if ($source === $dest) return 'a'; // local
//     if (substr($source, 0, 3) === substr($dest, 0, 3)) return 'b'; // regional
//     return 'c'; // ROI
// }

private function getZone($source, $dest)
{
    try {
        $fshipService = new FshipService();

        $response = $fshipService->rateCalculator([
            'pickup_pincode'   => $source,
            'delivery_pincode' => $dest,
            'weight'           => 0.5,
            'payment_mode'     => 1
        ]);

        if (!empty($response['shipment_rates'][0]['zone_name'])) {
            $apiZone = strtolower(trim($response['shipment_rates'][0]['zone_name']));

            $zoneMap = [
                'regional'       => 'a',
                'metro'          => 'b',
                'roi'            => 'c',
                'rest of india'  => 'c',
                'within state'   => 'd',
                'special'        => 'e'
            ];

            return $zoneMap[$apiZone] ?? 'c';
        }

    } catch (\Throwable $e) {
        \Log::error('Zone API Error: ' . $e->getMessage());
    }

    // fallback
    if ($source === $dest) return 'a';
    if (substr($source, 0, 3) === substr($dest, 0, 3)) return 'b';
    return 'c';
}


//with defauld decide by fship which corrirr partner is  prosecess  this order
// public function bookCourier(Request $request)
// {
//     // 1️⃣ Validate Request Input
//     $request->validate([
//         'order_id' => 'required|integer',
//         'courier_name' => 'required|string',
//         'service_mode' => 'required|string|in:air,surface',
//         'forward_charge' => 'required|numeric|min:0',
//         'cod_charge' => 'nullable|numeric|min:0',
//     ]);

//     return DB::transaction(function () use ($request) {
//         try {
//             // 2️⃣ Fetch Order (with validation)
//             $order = FshipOrder::where('id', $request->order_id)
//                 ->where('user_id', auth()->id())
//                 ->where('status', 'NEW')
//                 ->with('items')
//                 ->firstOrFail();

//             // 3️⃣ Fetch Wallet (with lock for concurrency safety)
//             $wallet = Wallet::where('user_id', auth()->id())
//                 ->lockForUpdate()
//                 ->firstOrFail();

//             // 4️⃣ Calculate Charges
//             $forwardCharge = round((float)($request->forward_charge ?? 0), 2);
//             $codCharge = round((float)($request->cod_charge ?? 0), 2);
//             $totalCharge = $forwardCharge + $codCharge;

//             if ($totalCharge <= 0) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid charge amount.'
//                 ], 422);
//             }

//             if ($wallet->balance < $totalCharge) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => "Insufficient balance! Needed ₹" . number_format($totalCharge, 2)
//                 ], 402);
//             }

//             // 5️⃣ Fetch & Validate Warehouse
//             $warehouse = PickupAddress::where('id', $order->pick_address_ID)
//                 ->where('user_id', auth()->id())
//                 ->firstOrFail();
//            // dd($warehouse);
//             $fshipPickAddressId = (int)($warehouse->pick_address_ID ?? 0);
//             if (!$fshipPickAddressId) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Warehouse not synced with Fship. Please sync first.'
//                 ], 422);
//             }

//             // 6️⃣ Clean Pincodes (6-digit numeric only)
//             $cleanDestPincode = preg_replace('/[^0-9]/', '', $order->pincode ?? '');
//             $cleanSourcePincode = preg_replace('/[^0-9]/', '', $warehouse->pincode ?? '');

//             if (strlen($cleanDestPincode) !== 6 || strlen($cleanSourcePincode) !== 6) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid pincode format. Must be 6 digits.'
//                 ], 422);
//             }

//             // 7️⃣ Calculate Chargeable Weight
//             $productSubtotal = (float)($order->product_subtotal ?? $order->total_amount ?? 0);
//             $actualWeight = max(0.01, (float)($order->weight ?? 0));
//             $volumetricWeight = (float)($order->volumetric_weight ?? 0);

//             if ($volumetricWeight <= 0 && $order->length > 0 && $order->width > 0 && $order->height > 0) {
//                 $volumetricWeight = ($order->length * $order->width * $order->height) / 5000;
//             }

//             $chargeableWeight = round(max($actualWeight, $volumetricWeight), 3);

//             // 8️⃣ Build Payload as per FShip API Docs v1.2.3.2 (Page 8-9)
//             $payload = [
//                 // === Customer Details ===
//                 "customer_Name" => trim($order->buyer_name ?? 'Customer'),
//                 "customer_Mobile" => preg_replace('/[^0-9]/', '', $order->phone_number ?? ''),
//                 "customer_Emailid" => trim($order->email_id ?? 'noreply@example.com'),
//                 "customer_Address" => trim($order->complete_address ?? ''),
//                 "landMark" => trim($order->landmark ?? ''),
//                 "customer_Address_Type" => "Home",
//                 "customer_PinCode" => $cleanDestPincode,
//                 "customer_City" => trim($order->city ?? ''),

//                 // === Order Details ===
//                 "orderId" => (string)$order->merchant_order_id,
//                 "invoice_Number" => (string)$order->merchant_order_id,
//                 "payment_Mode" => (int)($order->payment_mode ?? 2), // 1=COD, 2=PREPAID
//                 "express_Type" => $request->service_mode ?? "surface",
//                 "is_Ndd" => 0,

//                 // === Amount Details ===
//                 "order_Amount" => round($productSubtotal, 2),
//                 "tax_Amount" => 0,
//                 "extra_Charges" => 0,
//                 "total_Amount" => round($productSubtotal, 2),
//                 "cod_Amount" => ($order->payment_mode == 1) ? round($productSubtotal, 2) : 0,

//                 // === Shipment Details ===
//                 "shipment_Weight" => $chargeableWeight,
//                 "shipment_Length" => round(max(1, (float)($order->length ?? 10)), 2),
//                 "shipment_Width" => round(max(1, (float)($order->width ?? 10)), 2),
//                 "shipment_Height" => round(max(1, (float)($order->height ?? 10)), 2),
//                 "volumetric_Weight" => round(max(0.01, $volumetricWeight), 3),

//                 // === Location ===
//                 "latitude" => 0,
//                 "longitude" => 0,

//                 // === Address IDs ===
//                 "pick_Address_ID" => $fshipPickAddressId,
//                 "return_Address_ID" => 0, // Same as pickup by default

//                 // === Products Array ===
//                 "products" => $order->items->map(function($item) {
//                     return [
//                         "productId" => (string)($item->sku ?? 'NA'),
//                         "productName" => trim($item->product_name ?? 'Product'),
//                         "unitPrice" => max(0.01, (float)($item->unit_price ?? 0)),
//                         "quantity" => max(1, (int)($item->quantity ?? 1)),
//                         "productCategory" => "General",
//                         "hsnCode" => $item->hsn_code ?? "NA",
//                         "sku" => (string)($item->sku ?? 'NA'),
//                         "taxRate" => 0,
//                         "productDiscount" => 0,
//                     ];
//                 })->filter(function($p) {
//                     return !empty($p['productName']) && $p['unitPrice'] > 0 && $p['quantity'] >= 1;
//                 })->values()->toArray(),
//             ];

//             // Validate products
//             if (empty($payload['products'])) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Order must have at least 1 valid product.'
//                 ], 422);
//             }
//            // dd($payload);
//             // 9️⃣ Call FShip API: createforwardorder
//             $fshipService = new FshipService();
//             $createResponse = $fshipService->createForwardOrder($payload);
//            //dd($createResponse);
//             \Log::info('Fship CreateForwardOrder Response', [
//                 'order_id' => $order->id,
//                 'merchant_order_id' => $order->merchant_order_id,
//                 'response' => $createResponse
//             ]);

//             // ✅ Handle API Error
//             if (!$createResponse || !isset($createResponse['status']) || $createResponse['status'] !== true) {
//                 $error = $createResponse['response'] ?? $createResponse['message'] ?? 'Unknown API Error';
//                 \Log::error('Fship CreateForwardOrder Failed', [
//                     'order_id' => $order->id,
//                     'error' => $error
//                 ]);

//                 $userMessage = 'Booking failed. Please try again.';
//                 if (stripos($error, 'not serviceable') !== false) {
//                     $userMessage = 'Yeh pincode delivery ke liye available nahi hai.';
//                 } elseif (stripos($error, 'warehouse') !== false) {
//                     $userMessage = 'Warehouse configuration error. Please sync warehouse first.';
//                 }

//                 return response()->json([
//                     'success' => false,
//                     'message' => $userMessage,
//                     'error_detail' => $error
//                 ], 422);
//             }

//             // ✅ Extract Waybill & API Order ID
//             $waybill = $createResponse['waybill'] ?? null;
//             $apiOrderId = $createResponse['apiorderid'] ?? null;

//             if (!$waybill) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'AWB not generated by courier. Please try again.'
//                 ], 422);
//             }

//             // 🔟 Call FShip API: registerpickup (Auto-schedule pickup)
//             $pickupResponse = $fshipService->registerPickup([
//                 'waybills' => [$waybill]
//             ]);

//             $pickupOrderId = null;
//             if ($pickupResponse && isset($pickupResponse['status']) && $pickupResponse['status'] === true) {
//                 $pickupOrderId = $pickupResponse['apipickuporderids'][0]['pickupOrderId'] ?? null;
//                 \Log::info('Fship RegisterPickup Success', [
//                     'waybill' => $waybill,
//                     'pickup_order_id' => $pickupOrderId
//                 ]);
//             } else {
//                 // ⚠️ Pickup registration failed, but order is already booked - log warning only
//                 \Log::warning('Fship RegisterPickup Failed (Non-Critical)', [
//                     'waybill' => $waybill,
//                     'response' => $pickupResponse
//                 ]);
//                 // Optional: Send notification to admin for manual pickup registration
//             }

//             // 1️⃣1️⃣ Wallet Deduction & Transaction Log
//             if ($totalCharge > 0) {
//                 $openingBal = $wallet->balance;
//                 $wallet->decrement('balance', $totalCharge);
//                 $wallet->refresh();
//                 $closingBal = $wallet->balance;

//                 DB::table('wallet_transactions')->insert([
//                     'user_id' => auth()->id(),
//                     'fship_order_id' => $order->id,
//                     'amount' => $totalCharge,
//                     'type' => 'debit',
//                     'charge_type' => 'forward', // ✅ FShip API terminology
//                     'opening_balance' => round($openingBal, 2),
//                     'closing_balance' => round($closingBal, 2),
//                     'remark' => "Booking: #{$order->merchant_order_id} | AWB: {$waybill}",
//                     'created_at' => now(),
//                     'updated_at' => now()
//                 ]);
//             }

//             // 1️⃣2️⃣ Update Order Status
//             $order->update([
//                 'fship_api_order_id' => $apiOrderId,
//                 'waybill' => $waybill,
//                 'status' => 'booked',
//                 'booked_at' => now(),
//                 'forward_charge' => $forwardCharge,
//                 'cod_charge' => $codCharge,
//                 'wallet_deduction_amount' => $totalCharge,
//                 'courier_name' => $request->courier_name,
//                 'service_mode' => $request->service_mode,
//                 'pickup_order_id' => $pickupOrderId, // Store if available
//             ]);

//             // 1️⃣3️⃣ (Optional) Get Shipping Label URL
//             $labelUrl = null;
//             try {
//                 $labelResponse = $fshipService->getShippingLabel(['waybill' => $waybill]);
//                 if ($labelResponse && isset($labelResponse['resultDetails'][$waybill]['labelUrl'])) {
//                     $labelUrl = $labelResponse['resultDetails'][$waybill]['labelUrl'];
//                 }
//             } catch (\Throwable $labelError) {
//                 \Log::warning('Shipping Label Fetch Failed', [
//                     'waybill' => $waybill,
//                     'error' => $labelError->getMessage()
//                 ]);
//                 // Label can be fetched later, not critical for booking
//             }

//             // ✅ Final Success Response
//             return response()->json([
//                 'success' => true,
//                 'message' => '✅ Order Booked Successfully!',
//                 'data' => [
//                     'waybill' => $waybill,
//                     'api_order_id' => $apiOrderId,
//                     'pickup_order_id' => $pickupOrderId,
//                     'label_url' => $labelUrl,
//                     'amount_deducted' => '₹' . number_format($totalCharge, 2),
//                     'remaining_balance' => '₹' . number_format($wallet->balance, 2)
//                 ]
//             ]);

//         } catch (\Throwable $e) {
//             \Log::error('Book Courier Critical Error: ' . $e->getMessage(), [
//                 'trace' => $e->getTraceAsString(),
//                 'order_id' => $request->order_id ?? null,
//                 'user_id' => auth()->id()
//             ]);

//             return response()->json([
//                 'success' => false,
//                 'message' => 'Server error. Please try again later.',
//                 'error_code' => 'BOOKING_ERROR'
//             ], 500);
//         }
//     });
// }



// this is the      chouse by user 
// public function bookCourier(Request $request)
// {
//    dd($request->all());
//     // 1️⃣ Validate Request Input
//     $request->validate([
//         'order_id' => 'required|integer',
//         'courier_name' => 'required|string',
//         'service_mode' => 'required|string|in:air,surface',
//         'forward_charge' => 'required|numeric|min:0',
//         'cod_charge' => 'nullable|numeric|min:0',
//         'courier_id' => 'nullable|integer|min:1',
//     ]);

//     return DB::transaction(function () use ($request) {
//         try {
//             // 2️⃣ Fetch Order (with validation)
//             $order = FshipOrder::where('id', $request->order_id)
//                 ->where('user_id', auth()->id())
//                 ->where('status', 'NEW')
//                 ->with('items')
//                 ->firstOrFail();

//             // 3️⃣ Fetch Wallet (with lock for concurrency safety)
//             $wallet = Wallet::where('user_id', auth()->id())
//                 ->lockForUpdate()
//                 ->firstOrFail();

//             // 4️⃣ Calculate Charges
//             $forwardCharge = round((float)($request->forward_charge ?? 0), 2);
//             $codCharge = round((float)($request->cod_charge ?? 0), 2);
//             $totalCharge = $forwardCharge + $codCharge;

//             if ($totalCharge <= 0) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid charge amount.'
//                 ], 422);
//             }

//             if ($wallet->balance < $totalCharge) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => "Insufficient balance! Needed ₹" . number_format($totalCharge, 2)
//                 ], 402);
//             }

//             // 5️⃣ Fetch & Validate Warehouse
//             $warehouse = PickupAddress::where('id', $order->pick_address_ID)
//                 ->where('user_id', auth()->id())
//                 ->firstOrFail();

//             $fshipPickAddressId = (int)($warehouse->pick_address_ID ?? 0);
//             if (!$fshipPickAddressId) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Warehouse not synced with Fship. Please sync first.'
//                 ], 422);
//             }

//             // 6️⃣ Clean Pincodes (6-digit numeric only)
//             $cleanDestPincode = preg_replace('/[^0-9]/', '', $order->pincode ?? '');
//             $cleanSourcePincode = preg_replace('/[^0-9]/', '', $warehouse->pincode ?? '');

//             if (strlen($cleanDestPincode) !== 6 || strlen($cleanSourcePincode) !== 6) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid pincode format. Must be 6 digits.'
//                 ], 422);
//             }

//             // ✅ 6.5️⃣ PINCODE SERVICEABILITY CHECK (NEW - Before API Call)
//             $fshipService = new FshipService();
//             $serviceability = $fshipService->checkPincodeServiceability([
//                 'source_Pincode' => $cleanSourcePincode,
//                 'destination_Pincode' => $cleanDestPincode
//             ]);

//             \Log::info('Pincode Serviceability Check', [
//                 'source' => $cleanSourcePincode,
//                 'destination' => $cleanDestPincode,
//                 'response' => $serviceability
//             ]);

//             // Handle serviceability API error
//             if (!($serviceability['status'] ?? false)) {
//                 $errorMsg = $serviceability['response'] ?? 'Pincode serviceability check failed';
//                 \Log::error('Pincode Not Serviceable', [
//                     'source' => $cleanSourcePincode,
//                     'destination' => $cleanDestPincode,
//                     'error' => $errorMsg
//                 ]);

//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Delivery not available for pincode ' . $cleanDestPincode . '. Please check with support.',
//                     'error_detail' => $errorMsg
//                 ], 422);
//             }

//             // Check if pickup is available
//             if (($serviceability['pickup'] ?? 'N') !== 'Y') {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Pickup not available from your warehouse pincode.'
//                 ], 422);
//             }

//             // Check if destination is serviceable for delivery
//             if (($serviceability['reverse'] ?? 'N') !== 'Y' && ($serviceability['cod'] ?? 'N') !== 'Y') {
//                 // Note: Some APIs use 'reverse' for delivery, others use 'cod' for COD availability
//                 // Adjust based on your FShip API response structure
//             }

//             // ✅ COD Availability Check (if order is COD)
//             if ($order->payment_mode == 1 && ($serviceability['cod'] ?? 'N') !== 'Y') {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'COD is not available for pincode ' . $cleanDestPincode . '. Please switch to Prepaid mode.',
//                     'suggestion' => 'Try changing payment mode to Prepaid to proceed with booking.'
//                 ], 422);
//             }

//             // 7️⃣ Calculate Chargeable Weight
//             $productSubtotal = (float)($order->product_subtotal ?? $order->total_amount ?? 0);
//             $actualWeight = max(0.01, (float)($order->weight ?? 0));
//             $volumetricWeight = (float)($order->volumetric_weight ?? 0);

//             if ($volumetricWeight <= 0 && $order->length > 0 && $order->width > 0 && $order->height > 0) {
//                 $volumetricWeight = ($order->length * $order->width * $order->height) / 5000;
//             }

//             $chargeableWeight = round(max($actualWeight, $volumetricWeight), 3);

//             // 8️⃣ Build Payload as per FShip API Docs v1.2.3.2 (Page 8-9)
//             $payload = [
//                 // === Customer Details ===
//                 "customer_Name" => trim($order->buyer_name ?? 'Customer'),
//                 "customer_Mobile" => preg_replace('/[^0-9]/', '', $order->phone_number ?? ''),
//                 "customer_Emailid" => trim($order->email_id ?? 'noreply@example.com'),
//                 "customer_Address" => trim($order->complete_address ?? ''),
//                 "landMark" => trim($order->landmark ?? ''),
//                 "customer_Address_Type" => "Home",
//                 "customer_PinCode" => $cleanDestPincode,
//                 "customer_City" => trim($order->city ?? ''),

//                 // === Order Details ===
//                 "orderId" => (string)$order->merchant_order_id,
//                 "invoice_Number" => (string)$order->merchant_order_id,
//                 "payment_Mode" => (int)($order->payment_mode ?? 2), // 1=COD, 2=PREPAID
//                 "express_Type" => $request->service_mode ?? "surface",
//                 "is_Ndd" => 0,

//                 // === Amount Details ===
//                 "order_Amount" => round($productSubtotal, 2),
//                 "tax_Amount" => 0,
//                 "extra_Charges" => 0,
//                 "total_Amount" => round($productSubtotal, 2),
//                 "cod_Amount" => ($order->payment_mode == 1) ? round($productSubtotal, 2) : 0,

//                 // === Shipment Details ===
//                 "shipment_Weight" => $chargeableWeight,
//                 "shipment_Length" => round(max(1, (float)($order->length ?? 10)), 2),
//                 "shipment_Width" => round(max(1, (float)($order->width ?? 10)), 2),
//                 "shipment_Height" => round(max(1, (float)($order->height ?? 10)), 2),
//                 "volumetric_Weight" => round(max(0.01, $volumetricWeight), 3),

//                 // === Location ===
//                 "latitude" => 0,
//                 "longitude" => 0,

//                 // === Address IDs ===
//                 "pick_Address_ID" => $fshipPickAddressId,
//                 "return_Address_ID" => 0, // Same as pickup by default

//                 // === Products Array ===
//                 "products" => $order->items->map(function($item) {
//                     return [
//                         "productId" => (string)($item->sku ?? 'NA'),
//                         "productName" => trim($item->product_name ?? 'Product'),
//                         "unitPrice" => max(0.01, (float)($item->unit_price ?? 0)),
//                         "quantity" => max(1, (int)($item->quantity ?? 1)),
//                         "productCategory" => "General",
//                         "hsnCode" => $item->hsn_code ?? "NA",
//                         "sku" => (string)($item->sku ?? 'NA'),
//                         "taxRate" => 0,
//                         "productDiscount" => 0,
//                     ];
//                 })->filter(function($p) {
//                     return !empty($p['productName']) && $p['unitPrice'] > 0 && $p['quantity'] >= 1;
//                 })->values()->toArray(),

//                 // ✅ Courier Selection (Optional - Auto-assign if 0 or null)
//                 "courierId" => (int)($request->courier_id ?? 0),
//             ];

//             // Validate products
//             if (empty($payload['products'])) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Order must have at least 1 valid product.'
//                 ], 422);
//             }
//             dd($payload);
//             // 9️⃣ Call FShip API: createforwardorder
//             $createResponse = $fshipService->createForwardOrder($payload);

//             \Log::info('Fship CreateForwardOrder Request', [
//                 'order_id' => $order->id,
//                 'courier_id_sent' => $payload['courierId'],
//                 'payload_summary' => [
//                     'customer_PinCode' => $payload['customer_PinCode'],
//                     'pick_Address_ID' => $payload['pick_Address_ID'],
//                     'payment_Mode' => $payload['payment_Mode'],
//                 ]
//             ]);

//             \Log::info('Fship CreateForwardOrder Response', [
//                 'order_id' => $order->id,
//                 'merchant_order_id' => $order->merchant_order_id,
//                 'response' => $createResponse
//             ]);

//             // ✅ Handle API Error
//             if (!$createResponse || !isset($createResponse['status']) || $createResponse['status'] !== true) {
//                 $error = $createResponse['response'] ?? $createResponse['message'] ?? 'Unknown API Error';
//                 \Log::error('Fship CreateForwardOrder Failed', [
//                     'order_id' => $order->id,
//                     'error' => $error,
//                     'courier_id_requested' => $payload['courierId']
//                 ]);

//                 $userMessage = 'Booking failed. Please try again.';
                
//                 // Specific error messages
//                 if (stripos($error, 'not serviceable') !== false) {
//                     $userMessage = 'Yeh pincode delivery ke liye available nahi hai.';
//                 } elseif (stripos($error, 'warehouse') !== false) {
//                     $userMessage = 'Warehouse configuration error. Please sync warehouse first.';
//                 } elseif (stripos($error, 'courier') !== false) {
//                     $userMessage = 'Selected courier is not available for this route. Please try auto-assign or select another courier.';
//                 }

//                 return response()->json([
//                     'success' => false,
//                     'message' => $userMessage,
//                     'error_detail' => $error
//                 ], 422);
//             }

//             // ✅ Extract Waybill & API Order ID
//             $waybill = $createResponse['waybill'] ?? null;
//             $apiOrderId = $createResponse['apiorderid'] ?? null;
//             $assignedCourierName = $createResponse['courier_name'] ?? null;

//             if (!$waybill) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'AWB not generated by courier. Please try again.'
//                 ], 422);
//             }

//             // 🔟 Call FShip API: registerpickup (Auto-schedule pickup)
//             $pickupResponse = $fshipService->registerPickup([
//                 'waybills' => [$waybill]
//             ]);

//             $pickupOrderId = null;
//             if ($pickupResponse && isset($pickupResponse['status']) && $pickupResponse['status'] === true) {
//                 $pickupOrderId = $pickupResponse['apipickuporderids'][0]['pickupOrderId'] ?? null;
//                 \Log::info('Fship RegisterPickup Success', [
//                     'waybill' => $waybill,
//                     'pickup_order_id' => $pickupOrderId
//                 ]);
//             } else {
//                 \Log::warning('Fship RegisterPickup Failed (Non-Critical)', [
//                     'waybill' => $waybill,
//                     'response' => $pickupResponse
//                 ]);
//             }

//             // 1️⃣1️⃣ Wallet Deduction & Transaction Log
//             if ($totalCharge > 0) {
//                 $openingBal = $wallet->balance;
//                 $wallet->decrement('balance', $totalCharge);
//                 $wallet->refresh();
//                 $closingBal = $wallet->balance;

//                 DB::table('wallet_transactions')->insert([
//                     'user_id' => auth()->id(),
//                     'fship_order_id' => $order->id,
//                     'amount' => $totalCharge,
//                     'type' => 'debit',
//                     'charge_type' => 'forward',
//                     'opening_balance' => round($openingBal, 2),
//                     'closing_balance' => round($closingBal, 2),
//                     'remark' => "Booking: #{$order->merchant_order_id} | AWB: {$waybill} | Courier: " . ($assignedCourierName ?? $request->courier_name),
//                     'created_at' => now(),
//                     'updated_at' => now()
//                 ]);
//             }

//             // 1️⃣2️⃣ Update Order Status
//             $order->update([
//                 'fship_api_order_id' => $apiOrderId,
//                 'waybill' => $waybill,
//                 'status' => 'booked',
//                 'booked_at' => now(),
//                 'forward_charge' => $forwardCharge,
//                 'cod_charge' => $codCharge,
//                 'wallet_deduction_amount' => $totalCharge,
//                 'courier_name' => $assignedCourierName ?? $request->courier_name,
//                 'service_mode' => $request->service_mode,
//                 'pickup_order_id' => $pickupOrderId,
//                 'fship_courier_id' => $payload['courierId'] > 0 ? $payload['courierId'] : null,
//             ]);

//             // 1️⃣3️⃣ (Optional) Get Shipping Label URL
//             $labelUrl = null;
//             try {
//                 $labelResponse = $fshipService->getShippingLabel(['waybill' => $waybill]);
//                 if ($labelResponse && isset($labelResponse['resultDetails'][$waybill]['labelUrl'])) {
//                     $labelUrl = $labelResponse['resultDetails'][$waybill]['labelUrl'];
//                 }
//             } catch (\Throwable $labelError) {
//                 \Log::warning('Shipping Label Fetch Failed', [
//                     'waybill' => $waybill,
//                     'error' => $labelError->getMessage()
//                 ]);
//             }

//             // ✅ Final Success Response
//             return response()->json([
//                 'success' => true,
//                 'message' => '✅ Order Booked Successfully!',
//                 'data' => [
//                     'waybill' => $waybill,
//                     'api_order_id' => $apiOrderId,
//                     'pickup_order_id' => $pickupOrderId,
//                     'courier_name' => $assignedCourierName ?? $request->courier_name,
//                     'courier_id' => $payload['courierId'] > 0 ? $payload['courierId'] : 'auto-assigned',
//                     'label_url' => $labelUrl,
//                     'amount_deducted' => '₹' . number_format($totalCharge, 2),
//                     'remaining_balance' => '₹' . number_format($wallet->balance, 2)
//                 ]
//             ]);

//         } catch (\Throwable $e) {
//             \Log::error('Book Courier Critical Error: ' . $e->getMessage(), [
//                 'trace' => $e->getTraceAsString(),
//                 'order_id' => $request->order_id ?? null,
//                 'user_id' => auth()->id()
//             ]);

//             return response()->json([
//                 'success' => false,
//                 'message' => 'Server error. Please try again later.',
//                 'error_code' => 'BOOKING_ERROR'
//             ], 500);
//         }
//     });
// }
// public function bookCourier(Request $request)
// {
//     // 1️⃣ Validate Request Input
//     $request->validate([
//         'order_id' => 'required|integer',
//         'courier_name' => 'required|string',
//         'service_mode' => 'required|string|in:air,surface',
//         'forward_charge' => 'required|numeric|min:0',
//         'cod_charge' => 'nullable|numeric|min:0',
//         'courier_id' => 'nullable|integer|min:1',
//     ]);

//     return DB::transaction(function () use ($request) {
//         try {
//             // 2️⃣ Fetch Order (with validation)
//             $order = FshipOrder::where('id', $request->order_id)
//                 ->where('user_id', auth()->id())
//                 ->where('status', 'NEW')
//                 ->with('items')
//                 ->firstOrFail();

//             // 3️⃣ Fetch Wallet (with lock for concurrency safety)
//             $wallet = Wallet::where('user_id', auth()->id())
//                 ->lockForUpdate()
//                 ->firstOrFail();

//             // 4️⃣ Calculate Charges
//             $forwardCharge = round((float)($request->forward_charge ?? 0), 2);
//             $codCharge = round((float)($request->cod_charge ?? 0), 2);
//             $totalCharge = $forwardCharge + $codCharge;

//             if ($totalCharge <= 0) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid charge amount.'
//                 ], 422);
//             }

//             if ($wallet->balance < $totalCharge) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => "Insufficient balance! Needed ₹" . number_format($totalCharge, 2)
//                 ], 402);
//             }

//             // 5️⃣ Fetch & Validate Warehouse
//             $warehouse = PickupAddress::where('id', $order->pick_address_ID)
//                 ->where('user_id', auth()->id())
//                 ->firstOrFail();

//             $fshipPickAddressId = (int)($warehouse->pick_address_ID ?? 0);
//             if (!$fshipPickAddressId) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Warehouse not synced with Fship. Please sync first.'
//                 ], 422);
//             }

//             // 6️⃣ Clean Pincodes (6-digit numeric only)
//             $cleanDestPincode = preg_replace('/[^0-9]/', '', $order->pincode ?? '');
//             $cleanSourcePincode = preg_replace('/[^0-9]/', '', $warehouse->pincode ?? '');

//             if (strlen($cleanDestPincode) !== 6 || strlen($cleanSourcePincode) !== 6) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid pincode format. Must be 6 digits.'
//                 ], 422);
//             }

//             // ✅ 6.5️⃣ PINCODE SERVICEABILITY CHECK
//             $fshipService = new FshipService();
//             $serviceability = $fshipService->checkPincodeServiceability([
//                 'source_Pincode' => $cleanSourcePincode,
//                 'destination_Pincode' => $cleanDestPincode
//             ]);

//             \Log::info('Pincode Serviceability Check', [
//                 'source' => $cleanSourcePincode,
//                 'destination' => $cleanDestPincode,
//                 'response' => $serviceability
//             ]);

//             if (!($serviceability['status'] ?? false)) {
//                 $errorMsg = $serviceability['response'] ?? 'Pincode serviceability check failed';
//                 \Log::error('Pincode Not Serviceable', [
//                     'source' => $cleanSourcePincode,
//                     'destination' => $cleanDestPincode,
//                     'error' => $errorMsg
//                 ]);
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Delivery not available for pincode ' . $cleanDestPincode . '. Please check with support.',
//                     'error_detail' => $errorMsg
//                 ], 422);
//             }

//             // ✅ FIXED: Check for 'Yes' (not 'Y') as per API response
//             if (($serviceability['pickup'] ?? 'No') !== 'Yes') {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Pickup not available from your warehouse pincode.'
//                 ], 422);
//             }

//             // ✅ FIXED: COD check - API returns 'Yes', not 'Y'
//             if ($order->payment_mode == 1 && ($serviceability['cod'] ?? 'No') !== 'Yes') {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'COD is not available for pincode ' . $cleanDestPincode . '. Please switch to Prepaid mode.',
//                     'suggestion' => 'Try changing payment mode to Prepaid to proceed with booking.'
//                 ], 422);
//             }

//             // 7️⃣ Calculate Chargeable Weight
//             $productSubtotal = (float)($order->product_subtotal ?? $order->total_amount ?? 0);
//             $actualWeight = max(0.01, (float)($order->weight ?? 0));
//             $volumetricWeight = (float)($order->volumetric_weight ?? 0);

//             if ($volumetricWeight <= 0 && $order->length > 0 && $order->width > 0 && $order->height > 0) {
//                 $volumetricWeight = ($order->length * $order->width * $order->height) / 5000;
//             }
//             $chargeableWeight = round(max($actualWeight, $volumetricWeight), 3);

//             // ✅ NEW: Resolve Fship Courier ID from local DB
//             $fshipCourierId = 0; // Default: Auto-assign by Fship
//             if ($request->courier_id) {
//                 $localCourier = \App\Models\Courier::where('id', $request->courier_id)
//                     ->where('is_active', 1)
//                     ->first();
                
//                 if ($localCourier) {
//                     // ✅ Use fship_courier_id if available, else fallback to 0 (auto-assign)
//                     $fshipCourierId = $localCourier->fship_courier_id ?? 0;
                    
//                     \Log::info('Courier ID Mapping for API', [
//                         'local_id' => $localCourier->id,
//                         'fship_id' => $localCourier->fship_courier_id,
//                         'courier_name' => $localCourier->name,
//                         'final_api_id' => $fshipCourierId
//                     ]);
//                 }
//             }

//             // 8️⃣ Build Payload as per FShip API Docs v1.2.3.2
//             $payload = [
//                 // === Customer Details ===
//                 "customer_Name" => trim($order->buyer_name ?? 'Customer'),
//                 "customer_Mobile" => preg_replace('/[^0-9]/', '', $order->phone_number ?? ''),
//                 "customer_Emailid" => trim($order->email_id ?? 'noreply@example.com'),
//                 "customer_Address" => trim($order->complete_address ?? ''),
//                 "landMark" => trim($order->landmark ?? ''),
//                 "customer_Address_Type" => "Home",
//                 "customer_PinCode" => $cleanDestPincode,
//                 "customer_City" => trim($order->city ?? ''),

//                 // === Order Details ===
//                 "orderId" => (string)$order->merchant_order_id,
//                 "invoice_Number" => (string)$order->merchant_order_id,
//                 "payment_Mode" => (int)($order->payment_mode ?? 2),
//                 "express_Type" => $request->service_mode ?? "surface",
//                 "is_Ndd" => 0,

//                 // === Amount Details ===
//                 "order_Amount" => round($productSubtotal, 2),
//                 "tax_Amount" => 0,
//                 "extra_Charges" => 0,
//                 "total_Amount" => round($productSubtotal, 2),
//                 "cod_Amount" => ($order->payment_mode == 1) ? round($productSubtotal, 2) : 0,

//                 // === Shipment Details ===
//                 "shipment_Weight" => $chargeableWeight,
//                 "shipment_Length" => round(max(1, (float)($order->length ?? 10)), 2),
//                 "shipment_Width" => round(max(1, (float)($order->width ?? 10)), 2),
//                 "shipment_Height" => round(max(1, (float)($order->height ?? 10)), 2),
//                 "volumetric_Weight" => round(max(0.01, $volumetricWeight), 3),

//                 // === Location ===
//                 "latitude" => 0,
//                 "longitude" => 0,

//                 // === Address IDs ===
//                 "pick_Address_ID" => $fshipPickAddressId,
//                 "return_Address_ID" => 0,

//                 // === Products Array ===
//                 "products" => $order->items->map(function($item) {
//                     return [
//                         "productId" => (string)($item->sku ?? 'NA'),
//                         "productName" => trim($item->product_name ?? 'Product'),
//                         "unitPrice" => max(0.01, (float)($item->unit_price ?? 0)),
//                         "quantity" => max(1, (int)($item->quantity ?? 1)),
//                         "productCategory" => "General",
//                         "hsnCode" => $item->hsn_code ?? "NA",
//                         "sku" => (string)($item->sku ?? 'NA'),
//                         "taxRate" => 0,
//                         "productDiscount" => 0,
//                     ];
//                 })->filter(function($p) {
//                     return !empty($p['productName']) && $p['unitPrice'] > 0 && $p['quantity'] >= 1;
//                 })->values()->toArray(),

//                 // ✅ FIXED: Use resolved fship_courier_id
//                 "courierId" => $fshipCourierId,
//             ];

//             // Validate products
//             if (empty($payload['products'])) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Order must have at least 1 valid product.'
//                 ], 422);
//             }

//             // 9️⃣ Call FShip API: createforwardorder
//             $createResponse = $fshipService->createForwardOrder($payload);
//             //dd($createResponse);
//             \Log::info('Fship CreateForwardOrder Request', [
//                 'order_id' => $order->id,
//                 'courier_id_sent' => $payload['courierId'],
//                 'payload_summary' => [
//                     'customer_PinCode' => $payload['customer_PinCode'],
//                     'pick_Address_ID' => $payload['pick_Address_ID'],
//                     'payment_Mode' => $payload['payment_Mode'],
//                 ]
//             ]);

//             \Log::info('Fship CreateForwardOrder Response', [
//                 'order_id' => $order->id,
//                 'merchant_order_id' => $order->merchant_order_id,
//                 'response' => $createResponse
//             ]);

//             // ✅ Handle API Error
//             if (!$createResponse || !isset($createResponse['status']) || $createResponse['status'] !== true) {
//                 $error = $createResponse['response'] ?? $createResponse['message'] ?? 'Unknown API Error';
//                 \Log::error('Fship CreateForwardOrder Failed', [
//                     'order_id' => $order->id,
//                     'error' => $error,
//                     'courier_id_requested' => $payload['courierId']
//                 ]);

//                 $userMessage = 'Booking failed. Please try again.';
                
//                 if (stripos($error, 'not serviceable') !== false) {
//                     $userMessage = 'Yeh pincode delivery ke liye available nahi hai.';
//                 } elseif (stripos($error, 'warehouse') !== false) {
//                     $userMessage = 'Warehouse configuration error. Please sync warehouse first.';
//                 } elseif (stripos($error, 'courier') !== false) {
//                     $userMessage = 'Selected courier is not available for this route. Please try auto-assign or select another courier.';
//                 }

//                 return response()->json([
//                     'success' => false,
//                     'message' => $userMessage,
//                     'error_detail' => $error
//                 ], 422);
//             }

//             // ✅ Extract Waybill & API Order ID
//             $waybill = $createResponse['waybill'] ?? null;
//             $apiOrderId = $createResponse['apiorderid'] ?? null;
//             $assignedCourierName = $createResponse['courier_name'] ?? null;

//             if (!$waybill) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'AWB not generated by courier. Please try again.'
//                 ], 422);
//             }

//             // 🔟 Call FShip API: registerpickup
//             $pickupResponse = $fshipService->registerPickup([
//                 'waybills' => [$waybill]
//             ]);

//             $pickupOrderId = null;
//             if ($pickupResponse && isset($pickupResponse['status']) && $pickupResponse['status'] === true) {
//                 $pickupOrderId = $pickupResponse['apipickuporderids'][0]['pickupOrderId'] ?? null;
//                 \Log::info('Fship RegisterPickup Success', [
//                     'waybill' => $waybill,
//                     'pickup_order_id' => $pickupOrderId
//                 ]);
//             } else {
//                 \Log::warning('Fship RegisterPickup Failed (Non-Critical)', [
//                     'waybill' => $waybill,
//                     'response' => $pickupResponse
//                 ]);
//             }

//             // 1️⃣1️⃣ Wallet Deduction & Transaction Log
//             if ($totalCharge > 0) {
//                 $openingBal = $wallet->balance;
//                 $wallet->decrement('balance', $totalCharge);
//                 $wallet->refresh();
//                 $closingBal = $wallet->balance;

//                 DB::table('wallet_transactions')->insert([
//                     'user_id' => auth()->id(),
//                     'fship_order_id' => $order->id,
//                     'amount' => $totalCharge,
//                     'type' => 'debit',
//                     'charge_type' => 'forward',
//                     'opening_balance' => round($openingBal, 2),
//                     'closing_balance' => round($closingBal, 2),
//                     'remark' => "Booking: #{$order->merchant_order_id} | AWB: {$waybill} | Courier: " . ($assignedCourierName ?? $request->courier_name),
//                     'created_at' => now(),
//                     'updated_at' => now()
//                 ]);
//             }

//             // 1️⃣2️⃣ Update Order Status
//             $order->update([
//                 'fship_api_order_id' => $apiOrderId,
//                 'waybill' => $waybill,
//                 'status' => 'booked',
//                 'booked_at' => now(),
//                 'forward_charge' => $forwardCharge,
//                 'cod_charge' => $codCharge,
//                 'wallet_deduction_amount' => $totalCharge,
//                 'courier_name' => $assignedCourierName ?? $request->courier_name,
//                 'service_mode' => $request->service_mode,
//                 'pickup_order_id' => $pickupOrderId,
//                 'fship_courier_id' => $fshipCourierId > 0 ? $fshipCourierId : null,
//             ]);

//             // 1️⃣3️⃣ (Optional) Get Shipping Label URL
//             $labelUrl = null;
//             try {
//                 $labelResponse = $fshipService->getShippingLabel(['waybill' => $waybill]);
//                 if ($labelResponse && isset($labelResponse['resultDetails'][$waybill]['labelUrl'])) {
//                     $labelUrl = $labelResponse['resultDetails'][$waybill]['labelUrl'];
//                 }
//             } catch (\Throwable $labelError) {
//                 \Log::warning('Shipping Label Fetch Failed', [
//                     'waybill' => $waybill,
//                     'error' => $labelError->getMessage()
//                 ]);
//             }

//             // ✅ Final Success Response
//             return response()->json([
//                 'success' => true,
//                 'message' => '✅ Order Booked Successfully!',
//                 'data' => [
//                     'waybill' => $waybill,
//                     'api_order_id' => $apiOrderId,
//                     'pickup_order_id' => $pickupOrderId,
//                     'courier_name' => $assignedCourierName ?? $request->courier_name,
//                     'courier_id' => $fshipCourierId > 0 ? $fshipCourierId : 'auto-assigned',
//                     'label_url' => $labelUrl,
//                     'amount_deducted' => '₹' . number_format($totalCharge, 2),
//                     'remaining_balance' => '₹' . number_format($wallet->balance, 2)
//                 ]
//             ]);

//         } catch (\Throwable $e) {
//             \Log::error('Book Courier Critical Error: ' . $e->getMessage(), [
//                 'trace' => $e->getTraceAsString(),
//                 'order_id' => $request->order_id ?? null,
//                 'user_id' => auth()->id()
//             ]);

//             return response()->json([
//                 'success' => false,
//                 'message' => 'Server error. Please try again later.',
//                 'error_code' => 'BOOKING_ERROR'
//             ], 500);
//         }
//     });
// }


// public function bookCourier(Request $request)
// {
//     $request->validate([
//         'order_id' => 'required|integer',
//         'courier_name' => 'required|string',
//         'service_mode' => 'required|string|in:air,surface',
//         'forward_charge' => 'required|numeric|min:0',
//         'cod_charge' => 'nullable|numeric|min:0',
//         'courier_id' => 'required|integer|min:1',
//     ]);

//     return DB::transaction(function () use ($request) {

//         try {

//             // 1️⃣ ORDER
//             $order = FshipOrder::where('id', $request->order_id)
//                 ->where('user_id', auth()->id())
//                 ->where('status', 'NEW')
//                 ->with('items')
//                 ->firstOrFail();

//             // 2️⃣ WALLET
//             $wallet = Wallet::where('user_id', auth()->id())
//                 ->lockForUpdate()
//                 ->firstOrFail();

//             $forwardCharge = round((float)$request->forward_charge, 2);
//             $codCharge = round((float)($request->cod_charge ?? 0), 2);
//             $totalCharge = $forwardCharge + $codCharge;

//             if ($wallet->balance < $totalCharge) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Insufficient balance'
//                 ], 402);
//             }

//             // 3️⃣ WAREHOUSE
//             $warehouse = PickupAddress::where('id', $order->pick_address_ID)
//                 ->where('user_id', auth()->id())
//                 ->firstOrFail();

//             $fshipPickAddressId = (int)($warehouse->pick_address_ID ?? 0);

//             if (!$fshipPickAddressId) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Warehouse not synced'
//                 ], 422);
//             }

//             // 4️⃣ PINCODE
//             $cleanDest = preg_replace('/[^0-9]/', '', $order->pincode ?? '');
//             $cleanSource = preg_replace('/[^0-9]/', '', $warehouse->pincode ?? '');

//             if (strlen($cleanDest) !== 6 || strlen($cleanSource) !== 6) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid pincode'
//                 ], 422);
//             }

//             // 5️⃣ COURIER
//             $localCourier = \App\Models\Courier::where('id', $request->courier_id)
//                 ->where('is_active', 1)
//                 ->firstOrFail();

//             $fshipCourierId = $localCourier->fship_courier_id;

//             if (!$fshipCourierId) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Courier mapping missing'
//                 ], 422);
//             }

//             // 6️⃣ WEIGHT
//             $actualWeight = max(0.01, (float)$order->weight);
//             $volumetricWeight = $order->volumetric_weight > 0
//                 ? $order->volumetric_weight
//                 : ($order->length * $order->width * $order->height) / 5000;

//             $chargeableWeight = round(max($actualWeight, $volumetricWeight), 3);

//             $fshipService = new FshipService();

//             // 7️⃣ RATE VALIDATION
//             $rates = $fshipService->calculateRates([
//                 'source_Pincode' => $cleanSource,
//                 'destination_Pincode' => $cleanDest,
//                 'payment_Mode' => $order->payment_mode == 1 ? 'COD' : 'P',
//                 'amount' => $order->product_subtotal,
//                 'express_Type' => $request->service_mode,
//                 'shipment_Weight' => $chargeableWeight,
//                 'shipment_Length' => $order->length,
//                 'shipment_Width' => $order->width,
//                 'shipment_Height' => $order->height,
//             ]);

//             $matched = collect($rates['shipment_rates'] ?? [])
//                 ->first(fn($r) => stripos($r['courier_name'], $localCourier->name) !== false);

//             if (!$matched) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Selected courier not serviceable'
//                 ], 422);
//             }

//             // 8️⃣ PAYLOAD
//             $payload = [
//                 "customer_Name" => $order->buyer_name,
//                 "customer_Mobile" => preg_replace('/[^0-9]/', '', $order->phone_number),
//                 "customer_Emailid" => $order->email_id ?? 'noreply@example.com',
//                 "customer_Address" => $order->complete_address,
//                 "customer_PinCode" => $cleanDest,
//                 "customer_City" => $order->city,
//                 "customer_Address_Type" => "Home",

//                 "orderId" => (string)$order->merchant_order_id,
//                 "invoice_Number" => (string)$order->merchant_order_id,

//                 "payment_Mode" => (int)$order->payment_mode,
//                 "express_Type" => $request->service_mode,

//                 "order_Amount" => round($order->product_subtotal, 2),
//                 "total_Amount" => round($order->product_subtotal, 2),
//                 "cod_Amount" => $order->payment_mode == 1 ? round($order->product_subtotal, 2) : 0,

//                 "shipment_Weight" => $chargeableWeight,
//                 "shipment_Length" => (float)$order->length,
//                 "shipment_Width" => (float)$order->width,
//                 "shipment_Height" => (float)$order->height,

//                 "pick_Address_ID" => $fshipPickAddressId,

//                 "products" => $order->items->map(fn($item) => [
//                     "productId" => (string)($item->sku ?? 'SKU_'.$item->id),
//                     "productName" => $item->product_name,
//                     "unitPrice" => (float)$item->unit_price,
//                     "quantity" => (int)$item->quantity,
//                 ])->toArray(),

//                 "courierId" => $fshipCourierId
//             ];

//             // 9️⃣ CREATE ORDER
//             $create = $fshipService->createForwardOrder($payload);

//             if (!($create['status'] ?? false)) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => $create['response'] ?? 'Booking failed'
//                 ], 422);
//             }

//             $waybill = $create['waybill'];

//             // 🔟 PICKUP
//             $pickupResponse = $fshipService->registerPickup([
//                 'waybills' => [$waybill]
//             ]);

//             $pickupData = $pickupResponse->json();

//             \Log::info('Pickup Response', $pickupData);

//             $pickup = $pickupData['apipickuporderids'][0] ?? [];

//             // 1️⃣1️⃣ WALLET
//             $opening = $wallet->balance;
//             $wallet->decrement('balance', $totalCharge);

//             DB::table('wallet_transactions')->insert([
//                 'user_id' => auth()->id(),
//                 'fship_order_id' => $order->id,
//                 'amount' => $totalCharge,
//                 'type' => 'debit',
//                 'charge_type' => 'forward',
//                 'opening_balance' => $opening,
//                 'closing_balance' => $wallet->balance,
//                 'remark' => "Booking AWB: {$waybill}",
//                 'created_at' => now(),
//                 'updated_at' => now()
//             ]);

//             // 1️⃣2️⃣ UPDATE ORDER
//             $order->update([
//                 'waybill' => $waybill,
//                 'status' => 'booked',
//                 'courier_name' => $localCourier->name,
//                 'fship_courier_id' => $fshipCourierId,
//                 'wallet_deduction_amount' => $totalCharge,

//                 // pickup save
//                 'pickup_order_id' => $pickup['pickupOrderId'] ?? null,
//                 'fship_api_order_id' => $pickup['fshipPickupId'] ?? null,
//                 'courier_pickup_id' => $pickup['courierPickupId'] ?? null,
//                 'pickup_date' => isset($pickup['pickupDate']) ? \Carbon\Carbon::parse($pickup['pickupDate']) : null,
//                 'pickup_time' => $pickup['pickupTime'] ?? null,
//                 'pickup_status_id' => $pickup['pickupStatusId'] ?? null,
//                 'pickup_provider_name' => $pickup['serviceProviderName'] ?? null,
//                 'pickup_raw_response' => json_encode($pickupData),
//             ]);

//             return response()->json([
//                 'success' => true,
//                 'message' => 'Order booked successfully',
//                 'data' => [
//                     'waybill' => $waybill,
//                     'pickup_id' => $pickup['pickupOrderId'] ?? null,
//                     'courier' => $localCourier->name
//                 ]
//             ]);

//         } catch (\Throwable $e) {

//             \Log::error('Booking Error', [
//                 'error' => $e->getMessage()
//             ]);

//             return response()->json([
//                 'success' => false,
//                 'message' => 'Server error',
//                 'error' => $e->getMessage()
//             ], 500);
//         }
//     });
// }

public function bookCourier(Request $request)
{
    $request->validate([
        'order_id' => 'required|integer',
        'courier_name' => 'required|string',
        'service_mode' => 'required|string|in:air,surface',
        'courier_id' => 'required|integer|min:1',
    ]);

    return DB::transaction(function () use ($request) {

        try {

            // 1️⃣ ORDER
            $order = FshipOrder::where('id', $request->order_id)
                ->where('user_id', auth()->id())
                ->where('status', 'NEW')
                ->with('items')
                ->firstOrFail();

            // 2️⃣ WALLET LOCK
            $wallet = Wallet::where('user_id', auth()->id())
                ->lockForUpdate()
                ->firstOrFail();

            // 3️⃣ WAREHOUSE
            $warehouse = PickupAddress::where('id', $order->pick_address_ID)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $fshipPickAddressId = (int)($warehouse->pick_address_ID ?? 0);

            if (!$fshipPickAddressId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse not synced'
                ], 422);
            }

            // 4️⃣ PINCODE CLEAN
            $cleanDest   = preg_replace('/[^0-9]/', '', $order->pincode ?? '');
            $cleanSource = preg_replace('/[^0-9]/', '', $warehouse->pincode ?? '');

            if (strlen($cleanDest) !== 6 || strlen($cleanSource) !== 6) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid pincode'
                ], 422);
            }

            // 5️⃣ COURIER
            $localCourier = \App\Models\Courier::where('id', $request->courier_id)
                ->where('is_active', 1)
                ->firstOrFail();

            if (!$localCourier->fship_courier_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Courier mapping missing'
                ], 422);
            }

            // 6️⃣ WEIGHT
            $actualWeight = max(0.01, (float)$order->weight);
            $volumetricWeight = $order->volumetric_weight > 0
                ? $order->volumetric_weight
                : ($order->length * $order->width * $order->height) / 5000;

            $billingWeight = ceil(max($actualWeight, $volumetricWeight) * 2) / 2;

            // ================================
            // 🔥 RATE CARD
            // ================================
            $zone = strtolower($this->getZone($cleanSource, $cleanDest));

            $rate = DB::table('shipping_rates_mini')
                ->where('user_id', auth()->id())
                ->where('courier_id', $localCourier->id)
                ->where('mode', $request->service_mode)
                ->where('is_active', 1)
                ->first();

            if (!$rate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rate card not found'
                ], 404);
            }

            $forwardKey = "zone_{$zone}_forward";
            $addKey     = "zone_{$zone}_add_forward";
            $codKey     = "zone_{$zone}_cod_charge";

            $base = (float) ($rate->$forwardKey ?? 0);
            $baseWeight = (float) ($rate->weight_info ?? 0.5);
            $slabWeight = (float) ($rate->add_weight ?? 0.5);

            $extra = 0;
            if ($billingWeight > $baseWeight) {
                $extraSlab = ceil(($billingWeight - $baseWeight) / $slabWeight);
                $extra = $extraSlab * (float) ($rate->$addKey ?? 0);
            }

            $subtotal = $base + $extra;
            $forwardCharge = round($subtotal * 1.18, 2);

            $codCharge = ((int)$order->payment_mode === 1)
                ? (float) ($rate->$codKey ?? 0)
                : 0;

            $totalCharge = $forwardCharge + $codCharge;

            // WALLET CHECK
            if ($wallet->balance < $totalCharge) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance'
                ], 402);
            }

            // ================================
            // 🔥 FSHIP API
            // ================================
            $fshipService = new FshipService();

            $payload = [
                "customer_Name" => $order->buyer_name,
                "customer_Mobile" => preg_replace('/[^0-9]/', '', $order->phone_number),
                "customer_Emailid" => $order->email_id ?? 'noreply@example.com',
                "customer_Address" => $order->complete_address,
                "customer_PinCode" => $cleanDest,
                "customer_City" => $order->city,
                "customer_Address_Type" => "Home",

                "orderId" => (string)$order->merchant_order_id,
                "invoice_Number" => (string)$order->merchant_order_id,

                "payment_Mode" => (int)$order->payment_mode,
                "express_Type" => $request->service_mode,

                "order_Amount" => round($order->product_subtotal, 2),
                "total_Amount" => round($order->product_subtotal, 2),
                "cod_Amount" => $order->payment_mode == 1 ? round($order->product_subtotal, 2) : 0,

                "shipment_Weight" => $billingWeight,
                "shipment_Length" => (float)$order->length,
                "shipment_Width" => (float)$order->width,
                "shipment_Height" => (float)$order->height,

                "pick_Address_ID" => $fshipPickAddressId,

                "products" => $order->items->map(fn($item) => [
                    "productId" => (string)($item->sku ?? 'SKU_'.$item->id),
                    "productName" => $item->product_name,
                    "unitPrice" => (float)$item->unit_price,
                    "quantity" => (int)$item->quantity,
                ])->toArray(),

                "courierId" => $localCourier->fship_courier_id
            ];

            // CREATE ORDER
            $create = $fshipService->createForwardOrder($payload);

            if (!($create['status'] ?? false)) {
                return response()->json([
                    'success' => false,
                    'message' => $create['response'] ?? 'Booking failed'
                ], 422);
            }

            $waybill = $create['waybill'];

            // ================================
            // ✅ FIXED PICKUP CALL
            // ================================
            $pickupRes = $fshipService->registerPickup([
                'waybills' => [$waybill]
            ])->json();

            \Log::info('Pickup API Response', $pickupRes);

            $pickup = [];
            if (!empty($pickupRes) && isset($pickupRes['apipickuporderids'][0])) {
                $pickup = $pickupRes['apipickuporderids'][0];
            }

            // ================================
            // WALLET DEDUCT
            // ================================
            $opening = $wallet->balance;
            $wallet->decrement('balance', $totalCharge);

            DB::table('wallet_transactions')->insert([
                'user_id' => auth()->id(),
                'fship_order_id' => $order->id,
                'amount' => $totalCharge,
                'type' => 'debit',
                'charge_type' => 'forward',
                'opening_balance' => $opening,
                'closing_balance' => $wallet->balance,
                'remark' => "Booking AWB: {$waybill}",
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // ORDER UPDATE (pickup save added)
            $order->update([
                'waybill' => $waybill,
                'status' => 'booked',
                'courier_name' => $localCourier->name,
                'fship_courier_id' => $localCourier->fship_courier_id,
                'courier_id' => $localCourier->fship_courier_id,
                'wallet_deduction_amount' => $totalCharge,
                'zone' => $zone,

                'pickup_order_id' => $pickup['pickupOrderId'] ?? null,
                'fship_api_order_id' => $pickup['fshipPickupId'] ?? null,
                'courier_pickup_id' => $pickup['courierPickupId'] ?? null,
                'pickup_date' => isset($pickup['pickupDate']) ? \Carbon\Carbon::parse($pickup['pickupDate']) : null,
                'pickup_time' => $pickup['pickupTime'] ?? null,
                'pickup_status_id' => $pickup['pickupStatusId'] ?? null,
                'pickup_provider_name' => $pickup['serviceProviderName'] ?? null,
                'pickup_raw_response' => json_encode($pickupRes),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order booked successfully',
                'data' => [
                    'waybill' => $waybill,
                    'pickup_id' => $pickup['pickupOrderId'] ?? null,
                    'courier' => $localCourier->name,
                    'charged_amount' => $totalCharge
                ]
            ]);

        } catch (\Throwable $e) {

            \Log::error('Booking Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'error' => $e->getMessage()
            ], 500);
        }
    });
}
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $orderIds = json_decode($request->input('orders'));

        if (!$orderIds) return back()->with('error', 'No orders selected');

        try {
            DB::beginTransaction();
            
            // ✅ Consistent: Use user_id
            if ($action === 'delete') {
                FshipOrder::whereIn('id', $orderIds)
                    ->where('user_id', Auth::id())
                    ->delete();
            } elseif ($action === 'manifest') {
                FshipOrder::whereIn('id', $orderIds)
                    ->where('user_id', Auth::id())
                    ->update(['status' => 'manifested']);
            } elseif ($action === 'cancel') {
                FshipOrder::whereIn('id', $orderIds)
                    ->where('user_id', Auth::id())
                    ->whereIn('status', ['new', 'booked'])
                    ->update(['status' => 'cancelled']);
            }

            DB::commit();
            return back()->with('success', 'Bulk action completed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk Action Error: ' . $e->getMessage());
            return back()->with('error', 'Failed: ' . $e->getMessage());
        }
    }

    
  

    public function updateTag(Request $request)
{
    // 1. Validation: 'order_id' ab required hai, chahe array ho ya string
    $request->validate([
        'order_id' => 'required', 
        'tag'      => 'required|array'
    ]);

    try {
        // 2. Flexible IDs: Agar single ID aayi hai toh use array mein convert kar do
        // (array)$request->order_id karne se string "83" ban jayega ["83"]
        $orderIds = (array)$request->order_id;

        // 3. Eloquent update with whereIn
        $updatedCount = FshipOrder::whereIn('id', $orderIds)
            ->where('user_id', Auth::id())
            ->update([
                // DB mein hamesha JSON string hi save hogi
                'tags' => json_encode($request->tag) 
            ]);

        if ($updatedCount > 0) {
            return response()->json([
                'success' => true, 
                'message' => 'Tags updated successfully for ' . $updatedCount . ' order(s).'
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => 'No matching orders found or permission denied.'
        ], 404);

    } catch (\Exception $e) {
        \Log::error("Tag Update Error: " . $e->getMessage());
        return response()->json([
            'success' => false, 
            'message' => 'System Error: ' . $e->getMessage()
        ], 500);
    }
}



public function bulkUpdateDimensions(Request $request)
{
    // 1. Validation
    $request->validate([
        'order_ids' => 'required|array',
        'height'    => 'nullable|numeric',
        'width'     => 'nullable|numeric',
        'length'    => 'nullable|numeric',
        'weight'    => 'nullable|numeric',
    ]);

    try {
        // 2. Sirf wahi fields nikalein jo khali nahi hain
        $updateData = array_filter([
            'height' => $request->height,
            'width'  => $request->width,
            'length' => $request->length,
            'weight' => $request->weight,
        ], function($value) {
            return $value !== null && $value !== '';
        });

        if (empty($updateData)) {
            return response()->json(['success' => false, 'message' => 'No valid dimensions provided for update.'], 422 );
        }

        // 3. Volumetric calculation logic (agar L, W, H teeno hain)
        if (isset($updateData['length'], $updateData['width'], $updateData['height'])) {
            $updateData['volumetric_weight'] = ($updateData['length'] * $updateData['width'] * $updateData['height']) / 5000;
        }

        // 4. Bulk Update
        \App\Models\FshipOrder::whereIn('id', $request->order_ids)
            ->where('user_id', auth()->id())
            ->update($updateData);

        return response()->json([
            'success' => true,
            'message' => count($request->order_ids) . ' update successful'
        ]);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
}

    /**
     * Get user's pickup addresses
     */
    public function getPickupAddresses()
    {
        try {
            $userId = Auth::id();
            
            // ✅ Query by user_id only (seller_id column doesn't exist)
            $addresses = PickupAddress::where('user_id', $userId)
                ->where('is_active', 1)
                ->select('id', 'warehouse_name', 'address_line1', 'address_line2', 'city', 'pincode', 'is_default')
                ->orderBy('is_default', 'desc')
                ->get();

            Log::info('Pickup Addresses Fetched', [
                'user_id' => $userId,
                'count' => $addresses->count()
            ]);

            return response()->json([
                'success' => true,
                'addresses' => $addresses,
                'count' => $addresses->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Pickup Addresses Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
 * Get order data for edit modal (AJAX)
 */

    public function editData(FshipOrder $order)  // ✅ Use FshipOrder typehint
    {
        // Ensure user owns this order
        // if ($order->user_id !== auth()->id()) {
        //     return response()->json([
        //         'success' => false, 
        //         'message' => 'Unauthorized'
        //     ], 403);
        // }
        
        // Load relationships
        $order->load(['items', 'pickupAddress']);
        
        // ✅ Add field aliases for Blade compatibility
        $orderData = $order->toArray();
        $orderData['email'] = $orderData['email_id'] ?? null;           // alias
        $orderData['address'] = $orderData['complete_address'] ?? null; // alias
        //dd($orderData);
        return response()->json([
            'success' => true,
            'order' => $orderData
        ]);
    }



public function updateFromModal(Request $request, $id)
{
    // 🔍 Manually fetch to debug
    $order = \DB::table('fship_orders')->where('id', $id)->first();
    
    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    }

    // if ($order->user_id !== auth()->id()) {
    //     return response()->json([
    //         'success' => false, 
    //         'message' => 'Unauthorized',
    //         'debug' => [
    //             'order_user_id' => $order->user_id,
    //             'auth_id' => auth()->id()
    //         ]
    //     ], 403);
    // }

    $validated = $request->validate([
        'status' => 'nullable|in:new,booked,manifested,in_transit,out_for_delivery,delivered,rto,cancelled,NEW',
        'payment_mode' => 'nullable|in:1,2',
        'total_amount' => 'nullable|numeric|min:0',
        'product_subtotal' => 'nullable|numeric|min:0',
        'product_name' => 'nullable|string|max:255',
        'sku' => 'nullable|string|max:100',
        'unit_price' => 'nullable|numeric|min:0',
        'quantity' => 'nullable|integer|min:1',
        'hsn' => 'nullable|string|max:50',
        'discount' => 'nullable|numeric|min:0',
        'shipping_charge' => 'nullable|numeric|min:0',
        'gift_wrap_charge' => 'nullable|numeric|min:0',
        'transaction_fee' => 'nullable|numeric|min:0',
        'dead_weight' => 'nullable|numeric|min:0',
        'length' => 'nullable|numeric|min:0',
        'width' => 'nullable|numeric|min:0',
        'height' => 'nullable|numeric|min:0',
        'buyer_name' => 'nullable|string|max:255',
        'phone_number' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'company_name' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:500',
        'pincode' => 'nullable|string|max:10',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'alt_phone' => 'nullable|string|max:20',
        'landmark' => 'nullable|string|max:255',
    ]);

    try {
        \DB::beginTransaction();

        // 🔢 Weight calculation
        $l = (float)($validated['length'] ?? 0);
        $w = (float)($validated['width'] ?? 0);
        $h = (float)($validated['height'] ?? 0);
        $volWeight = ($l * $w * $h) / 5000;
        $deadWeight = (float)($validated['dead_weight'] ?? 0);
        $billingWeight = max($deadWeight, $volWeight);

        // 📦 Order update data
        $orderData = [
            'status' => $validated['status'] ?? null,
            'payment_mode' => $validated['payment_mode'] ?? null,
            'product_subtotal' => $validated['product_subtotal'] ?? null,
            'total_amount' => $validated['total_amount'] ?? null,
            'buyer_name' => $validated['buyer_name'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'email_id' => $validated['email'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
            'complete_address' => $validated['address'] ?? null,
            'pincode' => $validated['pincode'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'landmark' => $validated['landmark'] ?? null,
            'alt_phone_number' => $validated['alt_phone'] ?? null,
            'weight' => $deadWeight ?: null,
            'length' => $l ?: null,
            'width' => $w ?: null,
            'height' => $h ?: null,
            'volumetric_weight' => $volWeight ?: null,
            'updated_at' => now(),
        ];

        // Remove nulls
        $orderData = array_filter($orderData, fn($v) => !is_null($v));

        \Log::info('Order Update Data', $orderData);

        // ✅ Direct DB update (bypasses model issues)
        $updated = \DB::table('fship_orders')
            ->where('id', $id)
            ->update($orderData);

        \Log::info('Rows affected in fship_orders: ' . $updated);

        // 🛍️ Update Items
        $item = \DB::table('fship_order_items')
            ->where('fship_order_id', $id)
            ->first();

        if ($item) {
            $itemData = array_filter([
                'product_name' => $validated['product_name'] ?? null,
                'sku' => $validated['sku'] ?? null,
                'unit_price' => $validated['unit_price'] ?? null,
                'quantity' => $validated['quantity'] ?? null,
                'hsn_code' => $validated['hsn'] ?? null,
                'order_discount' => $validated['discount'] ?? null,
                'shipping_charge' => $validated['shipping_charge'] ?? null,
                'gift_wrap_charge' => $validated['gift_wrap_charge'] ?? null,
                'transaction_fee' => $validated['transaction_fee'] ?? null,
                'updated_at' => now(),
            ], fn($v) => !is_null($v));

            $itemUpdated = \DB::table('fship_order_items')
                ->where('id', $item->id)
                ->update($itemData);

            \Log::info('Rows affected in fship_order_items: ' . $itemUpdated);
        }

        \DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'billing_weight' => round($billingWeight, 3),
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Order Update Failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'order_id' => $id
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Update failed: ' . $e->getMessage()
        ], 500);
    }
}
}
