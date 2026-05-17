<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FshipOrder;
use App\Models\CodRemittancePayment;
use Carbon\Carbon;

class ShippingController extends Controller
{
    // =====================================================
    // 🚚 Shipping Billing
    // =====================================================
    public function index()
    {
        $sellerId = auth()->id();

        $orders = FshipOrder::where('user_id', $sellerId)
            ->latest()
            ->paginate(50);

        $totalFreight = FshipOrder::where('user_id', $sellerId)
            ->sum('forward_charge');

        $codCharges = FshipOrder::where('user_id', $sellerId)
            ->sum('cod_charge');

        $totalAmount = $totalFreight + $codCharges;

        $cardStats = [
            'total_freight'   => round($totalAmount, 2),
            'billed_freight'  => 0,
            'unbilled_freight'=> round($totalAmount, 2),
            'excess_weight'   => 0,
            'invoice_due'     => 0,
        ];

        return view('seller.billing.shipping', compact('orders', 'cardStats'));
    }

    // =====================================================
    // 💰 COD REMITTANCE - FIXED: Data from cod_remittance_payments
    // =====================================================
    public function codRemittance(Request $request)
    {
        $userId = auth()->id();
        $today = Carbon::now()->startOfDay();
        $requiredWorkingDays = 3; // ✅ Defined at method level

        // ✅ Base Query - All COD Orders
        $baseQuery = FshipOrder::where('user_id', $userId)
            ->where('payment_mode', 1)
            ->whereIn('status', ['delivered', 'delivered complete', 'rto delivered'])
            ->where(function ($q) {
                $q->whereNull('is_refunded')->orWhere('is_refunded', 0);
            });

        // 📅 Date Filters
        if ($request->filled('from_date')) {
            $baseQuery->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $baseQuery->whereDate('created_at', '<=', $request->to_date);
        }

        // ✅ Get all orders for summary calculation
        $allOrders = (clone $baseQuery)->get();

        // ✅ Get all payment data in ONE efficient query
        $orderIds = $allOrders->pluck('id');
        $paymentsMap = CodRemittancePayment::whereIn('order_id', $orderIds)
            ->orderByDesc('id')
            ->get()
            ->groupBy('order_id')
            ->map(fn($items) => $items->first());

        // =====================================================
        // 💰 Summary Calculations from cod_remittance_payments
        // =====================================================
        
        $totalCodAmount = $allOrders->sum('product_subtotal');
        $totalFreightDeduction = $allOrders->sum('forward_charge');
        
        $remittedAmount = collect($paymentsMap)->where('status', 'paid')->sum('remitted_amount');
        $totalConvenienceFee = collect($paymentsMap)->where('status', 'paid')->sum('convenience_fee');
        
        $lastPayment = collect($paymentsMap)->where('status', 'paid')->sortByDesc('id')->first();
        $lastRemittanceAmount = $lastPayment ? $lastPayment->remitted_amount : 0;
        
        $paidOrderIds = collect($paymentsMap)->where('status', 'paid')->pluck('order_id');
        $pendingOrders = $allOrders->filter(fn($o) => !$paidOrderIds->contains($o->id));
        $totalRemittanceDue = $pendingOrders->sum(function($o) {
            return max(($o->product_subtotal ?? 0) - ($o->forward_charge ?? 0) - ($o->wallet_deduction_amount ?? 0), 0);
        });

        // =====================================================
        // 📊 Summary Cards
        // =====================================================
        $summary = [
            'total_cod_collected'    => round($totalCodAmount, 2),
            'remitted_amount'        => round($remittedAmount, 2),
            'remittance_pending'     => round($totalRemittanceDue, 2),
            'last_remittance_amount' => round($lastRemittanceAmount, 2),
            'next_remittance_due'    => 0,
            'delivered_rto_amount'   => 0,
            'recharge_from_cod'      => 0,
            'surcharge_amount'       => 0,
            'total_convenience_fee'  => round($totalConvenienceFee, 2),
        ];

        // =====================================================
        // 📄 Table Data with Payment Details
        // =====================================================
        $perPage = $request->get('per_page', 50);

        $orders = (clone $baseQuery)
            ->orderByDesc('updated_at')
            ->paginate($perPage)
            ->withQueryString();

        // ✅ FIXED: Add $requiredWorkingDays to use() clause
        $orders->getCollection()->transform(function ($order) use ($today, $paymentsMap, $requiredWorkingDays) {
            $productSubtotal = (float) ($order->product_subtotal ?? 0);
            $freight = (float) ($order->forward_charge ?? 0);
            $wallet = (float) ($order->wallet_deduction_amount ?? 0);
            $codFee = (float) ($order->cod_charge ?? 0);
            
            $order->net_amount = max($productSubtotal - $freight - $wallet, 0);
            $order->final_payable = max($productSubtotal - $freight - $wallet - $codFee, 0);
            
            // ✅ Get payment data from map
            $payment = $paymentsMap[$order->id] ?? null;
            
            if ($payment) {
                $order->cod_status = $payment->status;
                $order->remitted_amount = $payment->remitted_amount;
                $order->convenience_fee = $payment->convenience_fee;
                $order->payment_reference = $payment->payment_reference;
                $order->payment_date = $payment->payment_date;
                $order->payment_mode = $payment->payment_mode;
                $order->bank_name = $payment->bank_name;
                $order->bank_account = $payment->bank_account;
                $order->payment_remarks = $payment->remarks;
                $order->final_payable = $payment->remitted_amount;
            } else {
                $order->cod_status = 'pending';
                $order->remitted_amount = 0;
                $order->convenience_fee = 0;
                $order->payment_reference = '-';
                $order->payment_date = null;
                $order->payment_mode = null;
                $order->bank_name = null;
                $order->bank_account = null;
                $order->payment_remarks = null;
                $order->final_payable = max($productSubtotal - $freight - $wallet - $codFee, 0);
            }
            
            // Working days calculation for remarks
            if ($order->updated_at) {
                $deliveryDate = Carbon::parse($order->updated_at)->startOfDay();
                $wd = $this->calculateWorkingDays($deliveryDate, $today);
                $order->working_days_passed = $wd;
                // ✅ Now $requiredWorkingDays is accessible via use() clause
                $order->remaining_working_days = max(0, $requiredWorkingDays - $wd);
            } else {
                $order->working_days_passed = 0;
                $order->remaining_working_days = $requiredWorkingDays;
            }
            
            return $order;
        });

        return view('seller.billing.codRemittance', compact(
            'orders',
            'summary',
            'totalFreightDeduction'
        ));
    }
    
    // ✅ Helper: Calculate working days (exclude Sat/Sun) - DEFINED ONLY ONCE
    private function calculateWorkingDays($startDate, $endDate)
    {
        $workingDays = 0;
        $current = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();
        
        while ($current->lte($end)) {
            if (!in_array($current->dayOfWeek, [0, 6])) {
                $workingDays++;
            }
            $current->addDay();
        }
        return $workingDays;
    }

        // =====================================================
    // 📤 Export COD Remittance to CSV
    // =====================================================
    public function exportCodRemittance(Request $request)
    {
        $userId = auth()->id();
        
        // ✅ Base Query - Same as index page
        $query = FshipOrder::where('user_id', $userId)
            ->where('payment_mode', 1)
            ->whereIn('status', ['delivered', 'delivered complete', 'rto delivered'])
            ->where(function ($q) {
                $q->whereNull('is_refunded')->orWhere('is_refunded', 0);
            });

        // 📅 Apply date filters if present
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('payment_status')) {
            if ($request->payment_status === 'paid') {
                // Get orders that have paid payments
                $paidOrderIds = CodRemittancePayment::where('status', 'paid')->pluck('order_id');
                $query->whereIn('id', $paidOrderIds);
            } elseif ($request->payment_status === 'pending') {
                // Get orders without paid payments
                $paidOrderIds = CodRemittancePayment::where('status', 'paid')->pluck('order_id');
                $query->whereNotIn('id', $paidOrderIds);
            }
        }

        // ✅ Get orders with payment data
        $orders = $query->with('latestPayment')->orderByDesc('updated_at')->get();
        
        // ✅ Get payment data map for efficient lookup
        $orderIds = $orders->pluck('id');
        $paymentsMap = CodRemittancePayment::whereIn('order_id', $orderIds)
            ->orderByDesc('id')
            ->get()
            ->groupBy('order_id')
            ->map(fn($items) => $items->first());

        // ✅ CSV Headers - EXACT as per table columns
        $headers = [
            'ID',
            'COD Date',
            'Amount',
            'COD Status',
            'Freight Deduction',
            'Remittance',
            'Recharge From COD',
            'Delivered RTO Amount',
            'Surcharge Amount',
            'Convenience Fee',
            'Final Payable Amount',
            'Remarks',
            'Payment No.',
            'Waybill',
            'Seller Name',
            'Bank Name',
            'Bank Account',
            'Payment Date',
            'Payment Mode',
        ];

        // ✅ Generate CSV content
        $csvData = [];
        $csvData[] = $headers; // Header row

        foreach ($orders as $order) {
            $payment = $paymentsMap[$order->id] ?? null;
            
            $productSubtotal = (float) ($order->product_subtotal ?? 0);
            $freight = (float) ($order->forward_charge ?? 0);
            $wallet = (float) ($order->wallet_deduction_amount ?? 0);
            $codFee = (float) ($order->cod_charge ?? 0);
            
            // ✅ Values from cod_remittance_payments table
            $codStatus = $payment ? $payment->status : 'pending';
            $convenienceFee = $payment ? $payment->convenience_fee : 0;
            $finalPayable = $payment ? $payment->remitted_amount : max($productSubtotal - $freight - $wallet - $codFee, 0);
            $paymentReference = $payment ? $payment->payment_reference : '-';
            $paymentDate = $payment ? ($payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') : '-') : '-';
            $paymentMode = $payment ? $payment->payment_mode : '-';
            $bankName = $payment ? $payment->bank_name : '-';
            $bankAccount = $payment ? $payment->bank_account : '-';
            $paymentRemarks = $payment ? $payment->remarks : '';
            
            // Remarks logic
            if ($codStatus === 'paid') {
                $remarks = $paymentRemarks ?: 'Remitted';
            } elseif ($codStatus === 'processed') {
                $remarks = $paymentRemarks ?: 'Processing';
            } elseif (strtolower(trim($order->status)) === 'rto delivered') {
                $remarks = 'RTO Delivered';
            } else {
                $remarks = 'Pending';
            }

            // ✅ CSV Row - EXACT column order as table
            $csvData[] = [
                $order->id,
                $order->updated_at ? $order->updated_at->format('d-m-Y') : '-',
                number_format($productSubtotal, 2),
                $codStatus,
                number_format($freight, 2),
                number_format($payment ? $payment->remitted_amount : 0, 2),
                '0.00',  // Recharge From COD
                '0.00',  // Delivered RTO Amount
                '0.00',  // Surcharge Amount
                number_format($convenienceFee, 2),
                number_format($finalPayable, 2),
                $remarks,
                $paymentReference,
                $order->waybill ?? $order->waybill_number ?? $order->id,
                $order->user->name ?? '-',
                $bankName,
                $bankAccount,
                $paymentDate,
                $paymentMode,
            ];
        }

        // ✅ Generate and download CSV file
        $filename = 'cod_remittance_' . date('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://output', 'w');
        
        // Add BOM for Excel UTF-8 support
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);

        return response()->streamDownload(function () use ($csvData) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

}
