<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Wallet_transaction; // ✅ Snake_case model name (consistent)
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RechageToUserController extends Controller
{
    /**
     * Show wallet management page for admin to recharge user
     * Route: GET /admin/user-debit
     */
    public function adminRechargeToUser(Request $request)
    {
        // Get all seller_admin users with their wallets
        $sellerAdmins = User::where('role', 'seller_admin')
            ->with('wallet')
            ->orderBy('name')
            ->get();

        $selectedUser = null;
        $selectedWallet = null;
        $transactions = null;

        // If user is selected via query param (?user=ID)
        if ($request->has('user') && $request->user) {
            $selectedUser = User::where('role', 'seller_admin')
                ->with('wallet')
                ->findOrFail($request->user);
            
            $selectedWallet = $selectedUser->wallet;
            
            // Get recent transactions with source filter support
            $transactions = Wallet_transaction::where('user_id', $selectedUser->id)
                ->when($request->source, fn($q, $s) => $q->where('source', $s))
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('admin.billing.coustomerDebit', compact(
            'sellerAdmins',
            'selectedUser',
            'selectedWallet',
            'transactions'
        ));
    }

    /**
     * Adjust wallet balance (credit/debit) with source tracking
     * Route: POST /admin/wallet/{user}/adjust
     */
    public function adjustBalance(Request $request, $userId)
    {
        $request->validate([
            'type' => ['required', Rule::in(['credit', 'debit'])],
            'amount' => 'required|numeric|min:0.01',
            'charge_type' => 'required|string|max:50',
            'source' => 'nullable|string|max:50',
            'remark' => 'nullable|string|max:255',
        ]);

        $user = User::where('role', 'seller_admin')->findOrFail($userId);
        //dd($user);
        $wallet = $user->wallet;

        if (!$wallet) {
            return back()->with('error', 'Wallet not found for this user.');
        }

        $amount = round($request->amount, 2);
        $type = $request->type;
        $chargeType = $request->charge_type;
        $source = $request->source ?? 'admin_manual'; // ✅ Default source
        $remark = $request->remark;

        // Debit validation: check sufficient balance
        if ($type === 'debit' && $wallet->balance < $amount) {
            return back()->with('error', "Insufficient balance! Available: ₹" . number_format($wallet->balance, 2));
        }

        try {
            DB::beginTransaction();

            $openingBalance = $wallet->balance;

            // Update wallet balance
            if ($type === 'credit') {
                $wallet->increment('balance', $amount);
            } else {
                $wallet->decrement('balance', $amount);
            }

            $wallet->refresh();
            $closingBalance = $wallet->balance;

            // ✅ FIXED: Use Wallet_transaction (snake_case) for consistency
            Wallet_transaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => $type,
                'charge_type' => $chargeType,
                'source' => $source, // ✅ Track source
                'opening_balance' => round($openingBalance, 2),
                'closing_balance' => round($closingBalance, 2),
                'remark' => $remark ?: "Admin {$type}: ₹{$amount} via {$source}",
                'fship_order_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 
                "✅ ₹" . number_format($amount, 2) . " {$type}ed successfully! New balance: ₹" . number_format($closingBalance, 2)
            );

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Wallet Adjustment Failed: ' . $e->getMessage(), [
                'user_id' => $userId,
                'amount' => $amount,
                'type' => $type,
                'source' => $source
            ]);
            return back()->with('error', 'Failed to adjust balance. Please try again.');
        }
    }

    /**
     * ✅ STATIC Helpers for Blade (Call via \App\Http\Controllers\Admin\RechageToUserController::method())
     * OR better: Move to app/Helpers/WalletHelper.php
     */
    
    public static function getSourceBadgeClass(?string $source): string
    {
        return match ($source) {
            'admin_manual' => 'bg-blue-100 text-blue-700',
            'razorpay', 'stripe' => 'bg-indigo-100 text-indigo-700',
            'paytm', 'phonepe', 'gpay' => 'bg-purple-100 text-purple-700',
            'fship_refund' => 'bg-amber-100 text-amber-700',
            'forward', 'cod', 'rto', 'fship_booking' => 'bg-gray-100 text-gray-700',
            'recharge' => 'bg-green-100 text-green-700',
            'adjustment' => 'bg-gray-100 text-gray-600',
            'penalty' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public static function getSourceIcon(?string $source): string
    {
        return match ($source) {
            'admin_manual' => '<i class="fa fa-user-tie text-blue-500"></i>',
            'razorpay' => '<i class="fa fa-credit-card text-indigo-500"></i>',
            'stripe' => '<i class="fa fa-credit-card text-purple-500"></i>',
            'paytm' => '<i class="fa fa-mobile-alt text-blue-400"></i>',
            'phonepe' => '<i class="fa fa-mobile-alt text-purple-400"></i>',
            'gpay' => '<i class="fa fa-google text-green-500"></i>',
            'fship_refund' => '<i class="fa fa-undo text-amber-500"></i>',
            'forward' => '<i class="fa fa-truck text-gray-500"></i>',
            'cod' => '<i class="fa fa-money-bill-wave text-orange-500"></i>',
            'rto' => '<i class="fa fa-undo text-red-400"></i>',
            'recharge' => '<i class="fa fa-battery-full text-green-500"></i>',
            'adjustment' => '<i class="fa fa-cog text-gray-400"></i>',
            'penalty' => '<i class="fa fa-exclamation-triangle text-red-500"></i>',
            default => '<i class="fa fa-circle text-gray-300"></i>',
        };
    }

    public static function getSourceLabel(?string $source): string
    {
        return match ($source) {
            'admin_manual' => 'Admin',
            'razorpay' => 'Razorpay',
            'stripe' => 'Stripe',
            'paytm' => 'Paytm',
            'phonepe' => 'PhonePe',
            'gpay' => 'GPay',
            'fship_refund' => 'Refund',
            'forward' => 'Forward',
            'cod' => 'COD',
            'rto' => 'RTO',
            'recharge' => 'Recharge',
            'adjustment' => 'Adjust',
            'penalty' => 'Penalty',
            default => ucfirst(str_replace('_', ' ', $source ?? 'Unknown')),
        };
    }
}