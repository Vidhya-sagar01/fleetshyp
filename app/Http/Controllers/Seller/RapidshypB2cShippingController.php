<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\RapidshypB2cOrder;
use App\Models\RapidshypB2cOrderItem;
use App\Models\RapidshypWarehouse;
use App\Models\RateCard;
use App\Services\RapidShypService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RapidshypB2cShippingController extends Controller
{
    protected $rapidShypService;

    public function __construct(RapidShypService $rapidShypService)
    {
        
        $this->rapidShypService = $rapidShypService;
    }

    /**
     * Display list of shipments
     * Route: GET /seller/shipping
     * Name: shipping.create
     */
    public function index(Request $request)
    {
        try {
            $sellerId = Auth::id();
            
            $status = $request->get('status', 'pending');
            $dateFrom = $request->get('date_from');
            $dateTo = $request->get('date_to');
            $search = $request->get('search');
            $perPage = $request->get('per_page', 20);

            $query = RapidshypB2cOrder::where('seller_id', $sellerId);

            // Filter by status
            if ($status && $status !== 'all') {
                $statusMap = [
                    'pending' => 'PENDING',
                    'processing' => 'PROCESSING',
                    'awb_assigned' => 'AWB_ASSIGNED',
                    'ready_to_ship' => 'READY_TO_SHIP',
                    'shipped' => 'SHIPPED',
                    'in_transit' => 'IN_TRANSIT',
                    'delivered' => 'DELIVERED',
                    'rto' => 'RTO',
                    'exception' => 'EXCEPTION',
                    'cancelled' => 'CANCELLED',
                ];
                $dbStatus = $statusMap[$status] ?? strtoupper($status);
                $query->where('order_status', $dbStatus);
            }

            // Filter by date range
            if ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            }
            if ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            }

            // Search by AWB, Order ID, or Customer Name
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('order_id', 'like', "%{$search}%")
                      ->orWhere('awb', 'like', "%{$search}%")
                      ->orWhereRaw("JSON_EXTRACT(shipping_address, '$.firstName') LIKE ?", ["%{$search}%"]);
                });
            }

            $shipments = $query->orderBy('created_at', 'desc')
                               ->paginate($perPage)
                               ->withQueryString();

            // Count by status for tabs
            $counts = [
                'pending' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'PENDING')->count(),
                'processing' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'PROCESSING')->count(),
                'awb_assigned' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'AWB_ASSIGNED')->count(),
                'ready_to_ship' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'READY_TO_SHIP')->count(),
                'shipped' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'SHIPPED')->count(),
                'in_transit' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'IN_TRANSIT')->count(),
                'delivered' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'DELIVERED')->count(),
                'rto' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'RTO')->count(),
                'exception' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'EXCEPTION')->count(),
                'cancelled' => RapidshypB2cOrder::where('seller_id', $sellerId)->where('order_status', 'CANCELLED')->count(),
                'all' => RapidshypB2cOrder::where('seller_id', $sellerId)->count(),
            ];

            return view('seller.rapidshypb2cshipment.rapidshypb2cshipment', compact(
                'shipments', 'counts', 'status', 'dateFrom', 'dateTo', 'search', 'perPage'
            ));

        } catch (\Exception $e) {
            Log::error('Shipments Index Error', [
                'seller_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Failed to load shipments. Please try again.');
        }
    }

    /**
     * Check pincode serviceability via RapidShypService
     * Route: POST /seller/orders/check-serviceability
     * Name: rapidshyp.b2c.orders.check-serviceability
     */
    public function checkServiceability(Request $request)
    {
        try {
            $sellerId = Auth::id();
            
            $validated = $request->validate([
                'pickup_warehouse_id' => 'nullable|integer|exists:rapidshyp_warehouses,id,seller_id,' . $sellerId,
                'pickup_pincode' => 'nullable|digits:6',
                'delivery_pincode' => 'required|digits:6',
                'cod' => 'nullable|boolean',
                'total_order_value' => 'nullable|numeric|min:0',
                'weight' => 'nullable|numeric|min:0.1',
            ]);

            // Get Pickup Pincode
            $pickupPincode = null;
            
            if (!empty($validated['pickup_warehouse_id'])) {
                $warehouse = RapidshypWarehouse::where('id', $validated['pickup_warehouse_id'])
                                              ->where('seller_id', $sellerId)
                                              ->first();
                if ($warehouse) {
                    $pickupPincode = $warehouse->pincode;
                }
            }
            
            if (empty($pickupPincode) && !empty($validated['pickup_pincode'])) {
                $pickupPincode = $validated['pickup_pincode'];
            }
            
            if (empty($pickupPincode)) {
                $primaryWarehouse = RapidshypWarehouse::where('seller_id', $sellerId)
                                                      ->where('is_primary', true)
                                                      ->first();
                $pickupPincode = $primaryWarehouse?->pincode ?? '110001';
            }

            // Get Delivery Pincode
            $deliveryPincode = $validated['delivery_pincode'];
            
            if (!empty($request->order_id)) {
                $order = RapidshypB2cOrder::where('order_id', $request->order_id)
                                          ->where('seller_id', $sellerId)
                                          ->first();
                if ($order && !empty($order->shipping_address)) {
                    $shippingAddr = is_string($order->shipping_address) 
                        ? json_decode($order->shipping_address, true) 
                        : $order->shipping_address;
                    if (!empty($shippingAddr['pinCode'])) {
                        $deliveryPincode = $shippingAddr['pinCode'];
                    }
                }
            }

            // Prepare API Request
            $apiPayload = [
                'Pickup_pincode' => $pickupPincode,
                'Delivery_pincode' => $deliveryPincode,
                'cod' => $validated['cod'] ?? false,
                'total_order_value' => $validated['total_order_value'] ?? 2000,
                'weight' => $validated['weight'] ?? 1,
            ];

            // Call RapidShyp Serviceability API via Service
            $serviceResult = $this->rapidShypService->checkServiceability($apiPayload);
            
            if ($serviceResult['status'] !== 'success') {
                return response()->json([
                    'status' => false,
                    'remark' => $serviceResult['message'] ?? 'Serviceability check failed',
                    'serviceable_courier_list' => []
                ], $serviceResult['code'] ?? 200);
            }

            $apiResult = $serviceResult['data'];
            
            // Fetch B2C Rate Cards from Local Database
            $localRateCards = RateCard::where('type', 'b2c')
                                      ->where('user_id', $sellerId)
                                      ->where('is_active', true)
                                      ->with('courier')
                                      ->get();

            // Merge API Couriers with Local Rate Cards
            $serviceableCouriers = $apiResult['serviceable_courier_list'] ?? [];
            $mergedCouriers = [];

            foreach ($serviceableCouriers as $apiCourier) {
                $courierCode = $apiCourier['courier_code'] ?? null;
                $courierName = $apiCourier['courier_name'] ?? 'Unknown';
                
                $localRate = $localRateCards->first(function($rc) use ($courierCode, $courierName) {
                    return ($rc->courier?->rapidshyp_code == $courierCode) || 
                           (stripos($rc->courier?->name ?? '', $courierName) !== false) ||
                           (stripos($rc->plan_name ?? '', $courierName) !== false);
                });

                $mergedCouriers[] = [
                    'courier_code' => $courierCode,
                    'courier_name' => $courierName,
                    'parent_courier_name' => $apiCourier['parent_courier_name'] ?? null,
                    'cutoff_time' => $apiCourier['cutoff_time'] ?? null,
                    'freight_mode' => $apiCourier['freight_mode'] ?? 'Surface',
                    'max_weight' => $apiCourier['max_weight'] ?? null,
                    'min_weight' => $apiCourier['min_weight'] ?? null,
                    'total_freight' => $apiCourier['total_freight'] ?? 0,
                    'local_rate_card_id' => $localRate?->id,
                    'local_plan_name' => $localRate?->plan_name,
                    'local_zone_rates' => $localRate ? [
                        'zone_a' => $localRate->zone_a_forward,
                        'zone_b' => $localRate->zone_b_forward,
                        'zone_c' => $localRate->zone_c_forward,
                        'zone_d' => $localRate->zone_d_forward,
                        'zone_e' => $localRate->zone_e_forward,
                    ] : null,
                    'pickup_pincode' => $pickupPincode,
                    'delivery_pincode' => $deliveryPincode,
                    'estimated_delivery' => $apiCourier['estimated_delivery'] ?? null,
                ];
            }

            return response()->json([
                'status' => true,
                'remark' => 'Success',
                'pickup_pincode' => $pickupPincode,
                'delivery_pincode' => $deliveryPincode,
                'serviceable_courier_list' => $mergedCouriers,
                'total_couriers' => count($mergedCouriers),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'remark' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Serviceability Check Error', [
                'seller_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            
            return response()->json([
                'status' => false,
                'remark' => 'Internal server error: ' . $e->getMessage(),
                'serviceable_courier_list' => []
            ], 500);
        }
    }

    /**
     * Assign AWB via RapidShypService
     * Route: POST /seller/shipping/{shipmentId}/assign-awb
     * Name: shipping.assign-awb
     */
    public function assignAwb(Request $request, $shipmentId)
    {
        try {
            $order = RapidshypB2cOrder::where('shipment_id', $shipmentId)
                                      ->where('seller_id', Auth::id())
                                      ->firstOrFail();
            
            $courierCode = $request->get('courier_code', '');
            
            // Call service
            $serviceResult = $this->rapidShypService->assignAWB($shipmentId, $courierCode);
            
            if ($serviceResult['status'] !== 'success') {
                return response()->json([
                    'success' => false,
                    'message' => $serviceResult['message'] ?? 'AWB assignment failed'
                ], $serviceResult['code'] ?? 422);
            }

            $result = $serviceResult['data'];
            
            // Update order in DB
            $order->update([
                'awb' => $result['awb'] ?? null,
                'courier_name' => $result['courier_name'] ?? null,
                'courier_code' => $result['courier_code'] ?? null,
                'order_status' => 'AWB_ASSIGNED',
                'api_response' => $result,
                'api_status' => 'success',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'AWB assigned successfully!',
                'awb' => $result['awb'],
                'courier' => $result['courier_name'],
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Shipment not found'], 404);
        } catch (\Exception $e) {
            Log::error('AWB Assignment Error', ['shipment_id' => $shipmentId, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to assign AWB: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Schedule pickup via RapidShypService
     * Route: POST /seller/shipping/{shipmentId}/schedule-pickup
     * Name: shipping.schedule-pickup
     */
    public function schedulePickup(Request $request, $shipmentId)
    {
        try {
            $order = RapidshypB2cOrder::where('shipment_id', $shipmentId)
                                      ->where('seller_id', Auth::id())
                                      ->firstOrFail();
            
            // Call service
            $serviceResult = $this->rapidShypService->schedulePickup($shipmentId, $order->awb ?? '');
            
            if ($serviceResult['status'] !== 'success') {
                return response()->json([
                    'success' => false,
                    'message' => $serviceResult['message'] ?? 'Pickup scheduling failed'
                ], $serviceResult['code'] ?? 422);
            }

            $result = $serviceResult['data'];
            
            $order->update([
                'pickup_scheduled' => true,
                'pickup_scheduled_at' => now(),
                'order_status' => 'READY_TO_SHIP',
                'api_response' => $result,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pickup scheduled successfully!',
                'routing_code' => $result['routingCode'] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Schedule Pickup Error', ['shipment_id' => $shipmentId, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to schedule pickup: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Generate label via RapidShypService
     * Route: GET /seller/shipping/{shipmentId}/label
     * Name: shipping.label
     */
    public function generateLabel($shipmentId)
    {
        try {
            $order = RapidshypB2cOrder::where('shipment_id', $shipmentId)
                                      ->where('seller_id', Auth::id())
                                      ->firstOrFail();
            
            // Call service
            $serviceResult = $this->rapidShypService->generateLabel([$shipmentId]);
            
            if ($serviceResult['status'] !== 'success') {
                return back()->with('error', $serviceResult['message'] ?? 'Failed to generate label');
            }

            $result = $serviceResult['data'];
            $labelUrl = $result['labelData'][0]['labelURL'] ?? null;
            
            if ($labelUrl) {
                $order->update(['label_url' => $labelUrl]);
                return redirect()->away($labelUrl);
            }

            return back()->with('error', 'Label URL not found in response');

        } catch (\Exception $e) {
            Log::error('Generate Label Error', ['shipment_id' => $shipmentId, 'error' => $e->getMessage()]);
            return back()->with('error', 'Failed to generate label: ' . $e->getMessage());
        }
    }

    /**
     * Generate invoice via RapidShypService
     * Route: GET /seller/shipping/{shipmentId}/invoice
     * Name: shipping.invoice
     */
    public function generateInvoice($shipmentId)
    {
        try {
            $order = RapidshypB2cOrder::where('shipment_id', $shipmentId)
                                      ->where('seller_id', Auth::id())
                                      ->firstOrFail();
            
            // Call service
            $serviceResult = $this->rapidShypService->generateInvoice([$shipmentId]);
            
            if ($serviceResult['status'] !== 'success') {
                return back()->with('error', $serviceResult['message'] ?? 'Failed to generate invoice');
            }

            $result = $serviceResult['data'];
            $invoiceUrl = $result['invoiceData'][0]['invoiceURL'] ?? null;
            
            if ($invoiceUrl) {
                return redirect()->away($invoiceUrl);
            }

            return back()->with('error', 'Invoice URL not found in response');

        } catch (\Exception $e) {
            Log::error('Generate Invoice Error', ['shipment_id' => $shipmentId, 'error' => $e->getMessage()]);
            return back()->with('error', 'Failed to generate invoice: ' . $e->getMessage());
        }
    }

    /**
     * Track shipment via RapidShypService
     * Route: GET /seller/shipping/{shipmentId}/tracking
     * Name: shipping.tracking
     */
    public function trackShipment($shipmentId)
    {
        try {
            $order = RapidshypB2cOrder::where('shipment_id', $shipmentId)
                                      ->where('seller_id', Auth::id())
                                      ->firstOrFail();
            
            // Call service
            $serviceResult = $this->rapidShypService->trackOrder([
                'seller_order_id' => $order->order_id,
                'awb' => $order->awb
            ]);
            
            if ($serviceResult['status'] !== 'success') {
                return back()->with('error', $serviceResult['message'] ?? 'Tracking info not available');
            }

            $result = $serviceResult['data'];
            $trackingData = $result['records'][0] ?? null;
            
            return view('seller.rapidshypb2cshipment.tracking', compact('trackingData', 'order'));

        } catch (\Exception $e) {
            Log::error('Track Shipment Error', ['shipment_id' => $shipmentId, 'error' => $e->getMessage()]);
            return back()->with('error', 'Failed to fetch tracking: ' . $e->getMessage());
        }
    }

    /**
     * Cancel shipment via RapidShypService
     * Route: POST /seller/shipping/{shipmentId}/cancel
     * Name: shipping.cancel
     */
    public function cancelShipment(Request $request, $shipmentId)
    {
        try {
            $order = RapidshypB2cOrder::where('shipment_id', $shipmentId)
                                      ->where('seller_id', Auth::id())
                                      ->firstOrFail();
            
            // Call service
            $serviceResult = $this->rapidShypService->cancelOrder(
                $order->order_id,
                $order->store_name ?? 'DEFAULT'
            );
            
            if ($serviceResult['status'] !== 'success') {
                return response()->json([
                    'success' => false,
                    'message' => $serviceResult['message'] ?? 'Cancellation failed'
                ], $serviceResult['code'] ?? 422);
            }

            $order->update([
                'order_status' => 'CANCELLED',
                'cancelled_at' => now(),
                'api_response' => $serviceResult['data'],
            ]);

            return response()->json(['success' => true, 'message' => 'Shipment cancelled successfully!']);

        } catch (\Exception $e) {
            Log::error('Cancel Shipment Error', ['shipment_id' => $shipmentId, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to cancel: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show shipment details page
     * Route: GET /seller/shipping/{shipmentId}
     * Name: shipping.show
     */
    public function show($shipmentId)
    {
        $order = RapidshypB2cOrder::where('shipment_id', $shipmentId)
                                  ->where('seller_id', Auth::id())
                                  ->with('items')
                                  ->firstOrFail();
        return view('seller.rapidshypb2cshipment.details', compact('order'));
    }

    /**
     * Get shipment details for AJAX (Modal)
     * Route: GET /seller/shipping/{shipmentId}/details
     * Name: shipping.details
     */
    public function details($Id)
    {
        $order = RapidshypB2cOrder::where('id', $Id)
                                  ->where('seller_id', Auth::id())
                                  ->firstOrFail();
        dd($order);
        return response()->json([
            'shipment_id' => $order->shipment_id,
            'order_id' => $order->order_id,
            'pickup_address_name' => $order->pickup_address_name,
            'pickup_location' => $order->pickup_location,
            'shipping_address' => $order->shipping_address,
            'package_details' => $order->package_details,
            'total_order_value' => $order->total_order_value,
            'payment_method' => $order->payment_method,
            'order_status' => $order->order_status,
        ]);
    }


    
    public function getProducts($shipmentId)
    {
        $items = RapidshypB2cOrderItem::whereHas('order', function($q) use ($shipmentId) {
            $q->where('shipment_id', $shipmentId)
              ->where('seller_id', Auth::id());
        })->get();

        return response()->json(['success' => true, 'items' => $items]);
    }

    /**
     * Bulk actions handler
     * Route: POST /seller/shipping/bulk-action (if needed)
     */
    public function bulkAction(Request $request)
    {
        $action = $request->get('action');
        $shipmentIds = $request->get('shipment_ids', []);

        if (empty($shipmentIds)) {
            return back()->with('error', 'No shipments selected');
        }

        $success = 0;
        $failed = 0;

        foreach ($shipmentIds as $shipmentId) {
            try {
                switch ($action) {
                    case 'label':
                        $result = $this->generateLabel($shipmentId);
                        if ($result instanceof \Illuminate\Http\RedirectResponse && $result->getSession()->has('error')) {
                            $failed++;
                        } else {
                            $success++;
                        }
                        break;
                    case 'cancel':
                        $cancelResult = $this->cancelShipment($request, $shipmentId);
                        if ($cancelResult->original['success'] ?? false) {
                            $success++;
                        } else {
                            $failed++;
                        }
                        break;
                    default:
                        $failed++;
                }
            } catch (\Exception $e) {
                $failed++;
                Log::error('Bulk Action Error', ['action' => $action, 'shipment_id' => $shipmentId, 'error' => $e->getMessage()]);
            }
        }

        return back()->with('success', "Bulk action completed: {$success} success, {$failed} failed");
    }
}