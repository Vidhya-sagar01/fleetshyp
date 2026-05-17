<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Wallet_transaction;  // ✅ Sirf underscore wala model use karein
use App\Models\Wallet;
use App\Models\WalletRecharge;

class WalletTransactionController extends Controller
{
    /**
     * Display wallet transactions (Passbook)
     */
    public function index(Request $request)
    {
        // ✅ FIX: Kewal login user ki hi transactions fetch honi chahiye
        $query = Wallet_transaction::where('user_id', Auth::id());

        // ✅ Date filter (single date)
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // ✅ Type filter (credit/debit)
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // ✅ Charge Type filter (forward/cod/rto/recharge/etc.) - via 'status' param
        if ($request->status) {
            $query->where('charge_type', $request->status);
        }

        // ✅ Source filter (admin_manual/razorpay/fship_booking/etc.)
        if ($request->source) {
            $query->where('source', $request->source);
        }

        // ✅ Search filter (AWB / Order ID)
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('fship_order_id', 'like', "%{$searchTerm}%")
                  ->orWhere('remark', 'like', "%{$searchTerm}%");
            });
        }

        // ✅ Pagination
        $transactions = $query->latest()->paginate(25)->withQueryString();

        // ✅ Counts for tabs (using cloned query to avoid affecting main query)
        $baseQuery = Wallet_transaction::where('user_id', Auth::id());
        
        // Apply same filters to counts for accuracy
        if ($request->date) {
            $baseQuery->whereDate('created_at', $request->date);
        }
        if ($request->source) {
            $baseQuery->where('source', $request->source);
        }
        if ($request->search) {
            $searchTerm = $request->search;
            $baseQuery->where(function($q) use ($searchTerm) {
                $q->where('fship_order_id', 'like', "%{$searchTerm}%")
                  ->orWhere('remark', 'like', "%{$searchTerm}%");
            });
        }

        $counts = [
            'credit' => (clone $baseQuery)->where('type', 'credit')->count(),
            'debit' => (clone $baseQuery)->where('type', 'debit')->count(),
            'forward' => (clone $baseQuery)->where('charge_type', 'forward')->count(),
            'cod' => (clone $baseQuery)->where('charge_type', 'cod')->count(),
            'rto' => (clone $baseQuery)->where('charge_type', 'rto')->count(),
            'recharge' => (clone $baseQuery)->where('charge_type', 'recharge')->count(),
            'adjustment' => (clone $baseQuery)->where('charge_type', 'adjustment')->count(),
        ];

        return view('seller.transaction.index', compact('transactions', 'counts'));
    }

    /**
     * ✅ Download CSV with source column
     */
    public function download(Request $request)
    {
        $query = Wallet_transaction::where('user_id', Auth::id());

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->type) {
            $query->where('type', $request->type);
        }
        if ($request->status) {
            $query->where('charge_type', $request->status);
        }
        if ($request->source) {
            $query->where('source', $request->source);
        }

        $transactions = $query->latest()->get();

        $filename = "wallet_transactions_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Date',
                'Reference (Order/AWB)',
                'Amount',
                'Type',
                'Charge Type',
                'Source',
                'Opening Balance',
                'Closing Balance',
                'Remark'
            ]);

            foreach ($transactions as $row) {
                fputcsv($file, [
                    $row->created_at?->format('Y-m-d H:i:s'),
                    $row->fship_order_id ?? 'N/A',
                    $row->amount,
                    $row->type,
                    $row->charge_type,
                    $row->source ?? 'unknown',
                    $row->opening_balance,
                    $row->closing_balance,
                    $row->remark
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * ✅ Manual Wallet Recharge (Admin/Seller side - Direct Credit) - FIXED
     */
    public function recharge(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'remark' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $amount = round($request->amount, 2);
        $remark = $request->remark ?? 'Manual wallet recharge';

        try {
            DB::beginTransaction();

            // ✅ Fetch wallet with lock - Create if not exists
            $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();
            if (!$wallet) {
                $wallet = Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0,
                    'currency' => 'INR'
                ]);
            }

            $openingBalance = $wallet->balance;
            $wallet->increment('balance', $amount);
            $wallet->refresh();
            $closingBalance = $wallet->balance;

            // ✅ FIXED: Use CORRECT model name (Wallet_transaction with underscore)
            Wallet_transaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'credit',
                'charge_type' => 'recharge',
                'source' => 'admin_manual',
                'opening_balance' => round($openingBalance, 2),
                'closing_balance' => round($closingBalance, 2),
                'remark' => $remark,
                'fship_order_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            Log::info('Manual Recharge Success', [
                'user_id' => $user->id,
                'amount' => $amount,
                'new_balance' => $closingBalance
            ]);

            return back()->with('success', "✅ Wallet recharged! ₹{$amount} added. New balance: ₹{$closingBalance}");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Manual Recharge Failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'amount' => $amount,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Recharge failed: ' . $e->getMessage());
        }
    }

    /**
     * ✅ Razorpay: Create Order for Wallet Recharge
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => 'recharge_' . time() . '_' . auth()->id(),
            'amount' => $request->amount * 100,
            'currency' => 'INR',
            'notes' => [
                'user_id' => auth()->id(),
                'purpose' => 'wallet_recharge'
            ]
        ]);

        WalletRecharge::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'razorpay_order_id' => $order['id'],
            'status' => WalletRecharge::STATUS_PENDING,
            'payment_method' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $request->amount,
            'key' => env('RAZORPAY_KEY'),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * ✅ Razorpay: Verify Payment & Credit Wallet - FIXED
     */
    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            // 1️⃣ Verify Razorpay signature
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ]);

            // 2️⃣ Fetch recharge record
            $recharge = WalletRecharge::where('razorpay_order_id', $request->razorpay_order_id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$recharge) {
                Log::error('Recharge record not found', ['order_id' => $request->razorpay_order_id]);
                return response()->json(['status' => false, 'message' => 'Recharge record not found'], 404);
            }

            if ($recharge->status === WalletRecharge::STATUS_SUCCESS) {
                return response()->json([
                    'status' => true, 
                    'message' => 'Already processed', 
                    'new_balance' => auth()->user()->wallet->balance ?? 0
                ]);
            }

            DB::beginTransaction();

            // 3️⃣ Mark recharge as success
            $recharge->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'payment_method' => $request->razorpay_payment_method ?? 'card',
                'status' => WalletRecharge::STATUS_SUCCESS,
                'processed_at' => now(),
                'metadata' => [
                    'email' => $request->razorpay_email ?? null,
                    'contact' => $request->razorpay_contact ?? null,
                ]
            ]);

            // 4️⃣ Update wallet balance WITH LOCK + AUTO-CREATE
            $user = auth()->user();
            $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();
            
            if (!$wallet) {
                $wallet = Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0,
                    'currency' => 'INR'
                ]);
            }

            $openingBalance = $wallet->balance;
            $wallet->increment('balance', $recharge->amount);
            $wallet->refresh();
            $closingBalance = $wallet->balance;

            // 5️⃣ ✅ FIXED: Create wallet transaction - USE CORRECT MODEL NAME
            Wallet_transaction::create([
                'user_id' => $user->id,
                'amount' => $recharge->amount,
                'type' => 'credit',
                'charge_type' => 'recharge',
                'source' => 'razorpay',
                'opening_balance' => round($openingBalance, 2),
                'closing_balance' => round($closingBalance, 2),
                'remark' => "Razorpay Recharge: {$recharge->razorpay_payment_id}",
                'fship_order_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            Log::info('Razorpay Recharge Success', [
                'user_id' => $user->id,
                'payment_id' => $request->razorpay_payment_id,
                'amount' => $recharge->amount,
                'new_balance' => $closingBalance
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Payment successful! Wallet credited.',
                'new_balance' => $closingBalance
            ]);

        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            DB::rollBack();
            Log::error('Razorpay Signature Failed: ' . $e->getMessage(), [
                'order_id' => $request->razorpay_order_id,
                'payment_id' => $request->razorpay_payment_id
            ]);
            return response()->json(['status' => false, 'message' => 'Invalid payment signature'], 400);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Recharge Processing Failed: ' . $e->getMessage(), [
                'order_id' => $request->razorpay_order_id,
                'payment_id' => $request->razorpay_payment_id,
                'trace' => $e->getTraceAsString()
            ]);

            WalletRecharge::where('razorpay_order_id', $request->razorpay_order_id)
                ->update([
                    'status' => WalletRecharge::STATUS_FAILED,
                    'failure_reason' => $e->getMessage()
                ]);

            return response()->json([
                'status' => false,
                'message' => 'Payment failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Recharge History Page (with source filter)
     */
    public function rechargeHistory(Request $request)
    {
        // ✅ Query Wallet_transaction table (not WalletRecharge)
        $query = Wallet_transaction::where('user_id', auth()->id())
            ->where('charge_type', 'recharge');

        // Filter: Status (type: credit/debit)
        if ($request->status) {
            $statusMap = [
                'success' => 'credit',
                'failed' => 'debit',
            ];
            $query->where('type', $statusMap[$request->status] ?? $request->status);
        }

        // Filter: Source (admin_manual, razorpay, etc.)
        if ($request->source) {
            $query->where('source', $request->source);
        }

        // Filter: Date range
        if ($request->date_range) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $query->whereBetween('created_at', [
                    trim($dates[0]) . ' 00:00:00',
                    trim($dates[1]) . ' 23:59:59'
                ]);
            }
        }

        // ✅ Pagination
        $recharges = $query->latest()
            ->paginate($request->per_page ?? 25)
            ->withQueryString();

        return view('seller.transaction.recharges', compact('recharges'));
    }

    /**
     * ✅ API: Get wallet summary for frontend (optional) - FIXED
     */
    public function summary()
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        $summary = Wallet_transaction::where('user_id', $user->id)  // ✅ FIXED: Use correct model
            ->selectRaw('source, type, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('source', 'type')
            ->get()
            ->groupBy('source');

        return response()->json([
            'current_balance' => $wallet?->balance ?? 0,
            'summary_by_source' => $summary
        ]);
    }
}