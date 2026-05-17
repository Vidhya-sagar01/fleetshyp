<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FshipService;
use App\Models\FshipOrder;
use App\Models\NdrManagement;
use App\Models\NdrProductDetail;
use App\Models\NdrTrackingHistoryLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NdrController extends Controller
{
    protected $fshipService;

    public function __construct(FshipService $fshipService)
    {
        $this->fshipService = $fshipService;
    }

    // =====================================================
    // 📦 NDR Index - Only UNDELIVERED Orders
    // =====================================================
   public function index(Request $request)
{
    $userId = auth()->id();
    $activeTab = $request->get('tab', 'action-required');

    // ✅ STEP 1: Find waybills from ndr_management table
    $ndrWaybills = \DB::table('ndr_management')
        ->where('status', 'action_taken')
        ->whereRaw("JSON_EXTRACT(api_response_data, '$.status') = true")
        ->pluck('waybill_number');

    // ✅ Base Query - Start with user's orders
    $query = FshipOrder::where('user_id', $userId);

    // ✅ Global Filters
    if ($request->filled('waybill')) {
        $query->where('waybill', $request->waybill);
    }
    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    // ✅ Base query for tab counts
    $baseCountQuery = FshipOrder::where('user_id', $userId);
    if ($request->filled('waybill')) {
        $baseCountQuery->where('waybill', $request->waybill);
    }
    if ($request->filled('from_date')) {
        $baseCountQuery->whereDate('created_at', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $baseCountQuery->whereDate('created_at', '<=', $request->to_date);
    }

    // ✅ STEP 2: Tab-Based Filtering - NDR FIRST, then STATUS
    switch ($activeTab) {
        case 'delivered':
            // ✅ Orders with NDR action + status = delivered
            $query->whereIn('waybill', $ndrWaybills)
                ->where('status', 'delivered');
            break;

        case 'rto':
            // ✅ Orders with NDR action + status = rto
            $query->whereIn('waybill', $ndrWaybills)
                ->where('status', 'rto');
            break;

        case 'action-taken':
            // ✅ Orders with NDR action + status = undelivered
            $query->whereIn('waybill', $ndrWaybills)
                ->where('status', 'undelivered');
            break;

        case 'action-required':
            // ✅ Orders WITHOUT successful NDR action + status = undelivered
            $query->where('status', 'undelivered')
                ->whereNotIn('waybill', $ndrWaybills);
            break;

        case 'all':
        default:
            $query->whereIn('status', ['undelivered', 'delivered', 'rto', 'in_transit']);
            break;
    }

    // ✅ STEP 3: Calculate Tab Counts - NDR FIRST logic
    $tabCounts = [
        'delivered' => (clone $baseCountQuery)
            ->whereIn('waybill', $ndrWaybills)
            ->where('status', 'delivered')
            ->count(),
        
        'rto' => (clone $baseCountQuery)
            ->whereIn('waybill', $ndrWaybills)
            ->where('status', 'rto')
            ->count(),
        
        'action-taken' => (clone $baseCountQuery)
            ->whereIn('waybill', $ndrWaybills)
            ->where('status', 'undelivered')
            ->count(),
        
        'action-required' => (clone $baseCountQuery)
            ->where('status', 'undelivered')
            ->whereNotIn('waybill', $ndrWaybills)
            ->count(),
    ];

    // ✅ Get orders with pagination
    $orders = $query
        ->with(['ndrLogs' => function ($q) { $q->latest(); }])
        ->orderByDesc('updated_at')
        ->paginate(25)
        ->withQueryString();

    return view('seller.ndr.ndr', compact('orders', 'activeTab', 'tabCounts'));
}
    // =====================================================
    // 💳 Take NDR Action - Fship API Integration (FIXED)
    // =====================================================
    public function takeAction(Request $request)
    {
        // ✅ Validation as per Fship API spec
        $request->validate([
            'apiorderid'       => 'required|integer',
            'action'           => 'required|in:re-attempt,change-address,change-phone,rto',
            'contact_name'     => 'required_if:action,re-attempt,change-address,change-phone|string|max:255',
            'complete_address' => 'required_if:action,re-attempt,change-address|string|max:500',
            'mobilenumber'     => 'required_if:action,re-attempt,change-phone|regex:/^[0-9]{10}$/|max:15',
            'reattempt_date'   => 'required_if:action,re-attempt|date|after_or_equal:today',
            'remarks'          => 'nullable|string|max:500',
            'landmark'         => 'nullable|string|max:255',
        ]);
      // dd($request->all());
        // ✅ Find order with user restriction (security)
        $order = FshipOrder::where('user_id', auth()->id())
            ->where('fship_api_order_id', $request->apiorderid)
            ->first();
       // dd($order);          
        if (!$order) {
            return back()->with('error', 'Order not found or access denied');
        }

        // ✅ Prepare payload as per Fship API spec (v1.2.3.2)
        $payload = [
            'apiorderid'       => (int) $request->apiorderid,
            'action'           => $request->action,
            'reattempt_date'   => $request->action === 're-attempt' ? $request->reattempt_date : null,
            'contact_name'     => $request->contact_name ?? $order->buyer_name,
            'complete_address' => $request->complete_address ?? $order->complete_address,
            'landmark'         => $request->landmark ?? $order->landmark ?? '',  // ✅ Added landmark
            'mobilenumber'     => $request->mobilenumber ?? $order->phone_number,
            'remarks'          => $request->remarks ?? '',
        ];
       // dd($payload);
        // ✅ Call Fship API via Service
        $response = $this->fshipService->reAttemptOrder($payload);
        //dd($response);
        // ✅ Start DB transaction for data consistency
        DB::beginTransaction();
        try {
            // ✅ Use Eloquent Model: NdrManagement (instead of raw DB)
            $ndr = NdrManagement::updateOrCreate(
                ['api_order_id' => $request->apiorderid],
                [
                    'waybill_number'      => $order->waybill,
                    'user_id'             => auth()->id(),  // ✅ Added user_id
                    'last_action_taken'   => $request->action,
                    'reattempt_date'      => $request->reattempt_date,
                    'contact_name'        => $request->contact_name,
                    'mobilenumber'        => $request->mobilenumber,
                    'complete_address'    => $request->complete_address,
                    'landmark'            => $request->landmark,
                    'remarks'             => $request->remarks,
                    'api_request_payload' => $payload,  // Auto-casted to JSON by model
                    'api_response_data'   => $response, // Auto-casted to JSON by model
                    'status'              => ($response['status'] ?? false) ? 'action_taken' : 'pending',
                ]
            );

            // ✅ Get the actual ID (updateOrCreate returns model instance)
            $ndrId = $ndr->id;

            // ✅ Handle Products (if sent from frontend)
            if (($response['status'] ?? false) && $request->filled('products')) {
                // Clear old products for this NDR (optional - based on your logic)
                NdrProductDetail::where('ndr_id', $ndrId)->delete();

                foreach ($request->products as $product) {
                    NdrProductDetail::create([
                        'ndr_id'       => $ndrId,
                        'product_id'   => $product['productId'] ?? null,
                        'product_name' => $product['productName'] ?? '',
                        'sku'          => $product['sku'] ?? null,
                        'quantity'     => $product['quantity'] ?? 1,
                        'unit_price'   => $product['unitPrice'] ?? 0,
                    ]);
                }
            }

            // ✅ Add tracking history log using Eloquent Model
            if ($response['status'] ?? false) {
                NdrTrackingHistoryLog::create([
                    'waybill_number'   => $order->waybill,
                    'scan_date_time'   => now(),
                    'scan_status'      => 'Action Taken: ' . $request->action,
                    'scan_location'    => $order->city . ', ' . $order->state,
                    'scan_remark'      => $request->remarks ?? 'Seller processed NDR via dashboard',
                    'shipment_journey' => 0, // 0 = forward, 1 = reverse
                ]);
            }

            // ✅ Commit transaction
            DB::commit();

            // ✅ Return response
            if ($response['status'] ?? false) {
                return back()->with('success', '✅ Action sent to Fleetshyp : ' . ($response['response'] ?? 'Success')); 
            }

            return back()->with('error', '⚠️ API Warning: ' . ($response['response'] ?? 'Check response'));

        } catch (\Exception $e) {
            // ✅ Rollback on error
            DB::rollBack();
            dd($e->getMessage());
            // Log error for debugging
            \Log::error('NDR Action Failed', [
                'user_id' => auth()->id(),
                'apiorderid' => $request->apiorderid,
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);

            return back()->with('error', '❌ Error: ' . $e->getMessage());
        }
    }
        // =====================================================
    // 🔄 Auto Track Status - For Live Polling (No Button)
    // =====================================================
    public function autoTrackStatus(Request $request)
    {
        $request->validate([
            'waybills' => 'required|array',
            'waybills.*' => 'string|max:50'
        ]);

        $waybills = $request->waybills;
        $results = [];

        foreach ($waybills as $waybill) {
            try {
                // ✅ Call Fship Tracking History API via Service
                $apiResponse = $this->fshipService->getTrackingHistory($waybill);
                
                if (($apiResponse['status'] ?? false) && !empty($apiResponse['summary'])) {
                    $summary = $apiResponse['summary'];
                    $latestScan = $apiResponse['trackingdata'][0] ?? [];
                    
                    $results[$waybill] = [
                        'success' => true,
                        'status' => $summary['status'] ?? 'Unknown',
                        'statusCode' => $summary['statusCode'] ?? '',
                        'lastScanDate' => $summary['lastscandate'] ?? null,
                        'location' => $latestScan['Location'] ?? $latestScan['location'] ?? '-',
                        'remark' => $latestScan['Remark'] ?? $latestScan['remark'] ?? '-',
                        // ✅ Badge class for color coding
                        'badgeClass' => $this->getStatusBadgeClass($summary['status'] ?? ''),
                    ];
                } else {
                    $results[$waybill] = [
                        'success' => false,
                        'error' => $apiResponse['response'] ?? 'Unable to fetch status'
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Auto Track Error: ' . $e->getMessage(), ['waybill' => $waybill]);
                $results[$waybill] = [
                    'success' => false,
                    'error' => 'API Error'
                ];
            }
        }

        return response()->json(['data' => $results]);
    }

    // ✅ Helper: Return Tailwind class for status badge
    private function getStatusBadgeClass($status)
    {
        $status = strtolower($status);
        
        if (str_contains($status, 'delivered')) {
            return 'bg-green-100 text-green-700';
        } elseif (str_contains($status, 'undelivered') || str_contains($status, 'exception')) {
            return 'bg-yellow-100 text-yellow-700';
        } elseif (str_contains($status, 'rto') || str_contains($status, 'return')) {
            return 'bg-red-100 text-red-700';
        } elseif (str_contains($status, 'in transit') || str_contains($status, 'out for delivery')) {
            return 'bg-blue-100 text-blue-700';
        }
        
        return 'bg-gray-100 text-gray-700';
    }
    
        // =====================================================
    // 📦 Get Tracking History from Fship API
    // =====================================================
    public function getTrackingHistory(Request $request)
    {
        $request->validate([
            'waybill' => 'required|string|max:50'
        ]);

        $waybill = $request->waybill;
        $userId = auth()->id();

        // ✅ Verify order belongs to user
        $order = FshipOrder::where('user_id', $userId)
            ->where('waybill', $waybill)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found or access denied'
            ], 404);
        }

        try {
            // ✅ Call Fship Tracking History API
            $apiResponse = $this->fshipService->getTrackingHistory($waybill);

            if (($apiResponse['status'] ?? false)) {
                return response()->json([
                    'success' => true,
                    'trackingdata' => $apiResponse['trackingdata'] ?? [],
                    'summary' => $apiResponse['summary'] ?? []
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $apiResponse['response'] ?? 'Unable to fetch tracking history'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Tracking History Error: ' . $e->getMessage(), [
                'waybill' => $waybill,
                'user_id' => $userId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error fetching tracking history: ' . $e->getMessage()
            ], 500);
        }
    }
}