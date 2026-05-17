<?php
// app/Http/Controllers/Admin/AdminCodRemittanceController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FshipOrder;
use App\Models\CodRemittancePayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminCodRemittanceController extends Controller
{
    public function index(Request $request)
    {
        $query = FshipOrder::query()
            ->where('payment_mode', 1)
            ->whereIn('status', ['delivered', 'delivered complete']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('remittance_status')) {
            if ($request->remittance_status == 'pending') {
                $query->where('is_remitted', 0);
            } elseif ($request->remittance_status == 'paid') {
                $query->where('is_remitted', 1);
            }
        }

        $orders = $query
            ->with(['user', 'remittancePayments'])
            ->orderByDesc('updated_at')
            ->paginate(50);

        $sellers = User::where('role', 'seller')
            ->orWhere('role', 'user')
            ->select('id', 'name', 'email')
            ->get();

        $baseQuery = FshipOrder::query()
            ->where('payment_mode', 1)
            ->whereIn('status', ['delivered', 'delivered complete']);

        if ($request->filled('user_id')) {
            $baseQuery->where('user_id', $request->user_id);
        }
        if ($request->filled('from_date')) {
            $baseQuery->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $baseQuery->whereDate('created_at', '<=', $request->to_date);
        }

        $totalCod = (clone $baseQuery)->sum('product_subtotal');
        $totalPaid = (clone $baseQuery)->where('is_remitted', 1)->sum('product_subtotal');
        $totalPending = $totalCod - $totalPaid;

        return view('admin.cod-remittance.index', compact(
            'orders', 'sellers', 'totalCod', 'totalPaid', 'totalPending'
        ));
    }

    // public function processPayment(Request $request)
    // {
        
    //     $request->validate([
    //         'order_id' => 'nullable|exists:fship_orders,id',
    //         'order_ids' => 'nullable|string',
    //         'remitted_amount' => 'required|numeric|min:0',
    //         'payment_reference' => 'required|string|max:255',
    //         'payment_date' => 'required|date',
    //         'payment_mode' => 'nullable|string|max:255',
    //         'convenience_fee' => 'nullable|numeric|min:0',
    //         'remarks' => 'nullable|string',
    //         'waybill' => 'nullable|string|max:255',
    //         'bank_name' => 'nullable|string|max:255',
    //         'bank_account' => 'nullable|string|max:50',
    //     ]);

    //     $orderIds = [];
        
    //     if ($request->filled('order_ids')) {
    //         $orderIds = array_filter(explode(',', $request->order_ids), 'is_numeric');
    //     } elseif ($request->filled('order_id')) {
    //         $orderIds = [(int) $request->order_id];
    //     }

    //     if (empty($orderIds)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No valid orders selected for processing'
    //         ], 422);
    //     }

    //     $adminId = Auth::id();
    //     $processed = 0;
    //     $errors = [];

    //     DB::beginTransaction();
    //     try {
    //         foreach ($orderIds as $orderId) {
    //             $order = FshipOrder::findOrFail($orderId);

    //             if ($order->is_remitted) {
    //                 $errors[] = "Order #{$order->waybill} already remitted";
    //                 continue;
    //             }

    //             // ✅ Simple: Use amount directly from request
    //             $remittedAmount = (float) $request->remitted_amount;

    //             // Get waybill
    //             $waybill = $request->waybill ?? $order->waybill ?? $order->id;

    //             // ✅ Create payment record - with ALL fields including bank details
    //             CodRemittancePayment::create([
    //                 'user_id' => $order->user_id,
    //                 'order_id' => $order->id,
    //                 'waybill' => $waybill,
    //                 'admin_id' => $adminId,
    //                 'remitted_amount' => $remittedAmount,
    //                 'payment_reference' => $request->payment_reference,
    //                 'payment_date' => $request->payment_date,
    //                 'payment_mode' => $request->payment_mode,
    //                 'convenience_fee' => $request->convenience_fee ?? 0,
    //                 'bank_name' => $request->bank_name,        // ✅ ADDED
    //                 'bank_account' => $request->bank_account,  // ✅ ADDED
    //                 'status' => 'paid',
    //                 'remarks' => $request->remarks,
    //             ]);

    //             // Update order status
    //             $order->update([
    //                 'is_remitted' => 1,
    //                 'remitted_at' => now(),
    //             ]);

    //             $processed++;
    //         }

    //         DB::commit();

    //         $message = $processed > 1 
    //             ? "{$processed} payments processed successfully!" 
    //             : "Payment processed successfully!";

    //         return response()->json([
    //             'success' => true,
    //             'message' => $message,
    //             'processed' => $processed,
    //             'errors' => $errors,
    //         ]);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }
    
     public function processPayment(Request $request)
{
    $request->validate([
        'order_id' => 'nullable|exists:fship_orders,id',
        'order_ids' => 'nullable|string',
        'amount_to_pay' => 'required|numeric|min:0',
        'payment_reference' => 'required|string|max:255',
        'payment_date' => 'required|date',
        'payment_mode' => 'nullable|string|max:255',
        'convenience_fee' => 'nullable|numeric|min:0',
        'remarks' => 'nullable|string',
        'waybill' => 'nullable|string|max:255',
        'bank_name' => 'nullable|string|max:255',
        'bank_account' => 'nullable|string|max:50',
    ]);

    $orderIds = [];
    
    if ($request->filled('order_ids')) {
        $orderIds = array_filter(explode(',', $request->order_ids), 'is_numeric');
    } elseif ($request->filled('order_id')) {
        $orderIds = [(int) $request->order_id];
    }

    if (empty($orderIds)) {
        return response()->json([
            'success' => false,
            'message' => 'No valid orders selected for processing'
        ], 422);
    }

    $adminId = Auth::id();
    $processed = 0;
    $errors = [];

    DB::beginTransaction();
    try {
        foreach ($orderIds as $orderId) {
            $order = FshipOrder::findOrFail($orderId);

            if ($order->is_remitted) {
                $errors[] = "Order #{$order->waybill} already remitted";
                continue;
            }

            // Get waybill
            $waybill = $request->waybill ?? $order->waybill ?? $order->id;

            // ✅ Create payment record - direct request usage, no extra variables
            CodRemittancePayment::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'waybill' => $waybill,
                'admin_id' => $adminId,
                
                // ✅ Direct from request - no intermediate variables
                'remitted_amount' => $request->amount_to_pay,
                'convenience_fee' => $request->convenience_fee ?? 0,
                
                'payment_reference' => $request->payment_reference,
                'payment_date' => $request->payment_date,
                'payment_mode' => $request->payment_mode,
                'bank_name' => $request->bank_name,
                'bank_account' => $request->bank_account,
                'status' => 'paid',
                'remarks' => $request->remarks,
            ]);

            // Update order status
            $order->update([
                'is_remitted' => 1,
                'remitted_at' => now(),
            ]);

            $processed++;
        }

        DB::commit();

        $message = $processed > 1 
            ? "{$processed} payments processed successfully!" 
            : "Payment processed successfully!";

        return response()->json([
            'success' => true,
            'message' => $message,
            'processed' => $processed,
            'errors' => $errors,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Payment Process Error: ' . $e->getMessage(), [
            'request' => $request->all(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
        ], 500);
    }
}

    public function paymentDetail($identifier)
    {
        \Log::info('=== Payment Detail Request ===');
        \Log::info('Identifier: ' . $identifier);
        
        // Search by waybill first
        $order = FshipOrder::with(['user', 'remittancePayments.admin'])
            ->where('waybill', $identifier)
            ->first();
        
        // Fallback to numeric ID
        if (!$order && is_numeric($identifier)) {
            \Log::info('Waybill not found, trying numeric ID: ' . $identifier);
            $order = FshipOrder::with(['user', 'remittancePayments.admin'])
                ->find((int) $identifier);
        }

        if (!$order) {
            \Log::error('Order not found for: ' . $identifier);
            return response()->json([
                'success' => false,
                'message' => "Order not found for Waybill/ID: {$identifier}"
            ], 404);
        }

        \Log::info('Order found: ID=' . $order->id . ', Waybill=' . ($order->waybill ?? 'null'));
        
        // Fresh query for payments
        $payments = $order->remittancePayments()
            ->with('admin')
            ->orderByDesc('id')
            ->get();
        
        \Log::info('Payments fetched from DB: ' . $payments->count());

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'waybill' => $order->waybill ?? $order->id,
                'seller_name' => $order->user->name ?? 'N/A',
                'seller_email' => $order->user->email ?? 'N/A',
                'cod_date' => $order->updated_at?->format('d-m-Y H:i') ?? '-',
                'product_subtotal' => number_format($order->product_subtotal ?? 0, 2),
                // ✅ Only send what we need for display
            ],
            'payments' => $payments->map(fn($p) => [
                'id' => $p->id,
                'waybill' => $p->waybill ?? $order->waybill ?? 'N/A',
                'payment_reference' => $p->payment_reference,
                'payment_date' => $p->payment_date?->format('d-m-Y') ?? '-',
                'payment_mode' => $p->payment_mode,
                'remitted_amount' => number_format($p->remitted_amount, 2),
                'convenience_fee' => number_format($p->convenience_fee ?? 0, 2),
                'bank_name' => $p->bank_name,        // ✅ ADDED
                'bank_account' => $p->bank_account,  // ✅ ADDED
                'status' => $p->status,
                'remarks' => $p->remarks,
                'processed_by' => $p->admin?->name ?? 'Admin',
                'created_at' => $p->created_at?->format('d-m-Y H:i') ?? '-',
            ])->toArray(),
        ]);
    }

    public function generateStatement($userId, Request $request)
    {
        $fromDate = $request->from_date 
            ? Carbon::parse($request->from_date)->startOfDay() 
            : Carbon::now()->startOfMonth();
            
        $toDate = $request->to_date 
            ? Carbon::parse($request->to_date)->endOfDay() 
            : Carbon::now()->endOfMonth();

        $seller = User::findOrFail($userId);

        $orders = FshipOrder::where('user_id', $userId)
            ->where('payment_mode', 1)
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->whereIn('status', ['delivered', 'delivered complete'])
            ->orderBy('created_at', 'desc')
            ->get();

        $payments = CodRemittancePayment::where('user_id', $userId)
            ->whereBetween('payment_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')])
            ->orderBy('payment_date', 'desc')
            ->get();

        $totalCod = $orders->sum('product_subtotal');
        $totalFreight = $orders->sum('forward_charge');
        $totalPaid = $payments->sum('remitted_amount');

        return view('admin.cod-remittance.statement', compact(
            'seller', 'orders', 'payments', 
            'totalCod', 'totalFreight', 'totalPaid',
            'fromDate', 'toDate'
        ));
    }
}