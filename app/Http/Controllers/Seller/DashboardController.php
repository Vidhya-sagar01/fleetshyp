<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FshipOrder;
use App\Models\Wallet;
use App\Models\NdrManagement;
use App\Models\Wallet_transaction; // ✅ PascalCase import
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = Auth::id();
        $today = Carbon::today()->toDateString();
        
        // 1. Date Range Filters (Default: Last 30 Days)
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Base Query for filtered data
        $baseQuery = FshipOrder::where('user_id', $sellerId)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // 2. Top Stats Cards
        $shipmentStats = [
            'today_orders'  => FshipOrder::where('user_id', $sellerId)->whereDate('created_at', $today)->count(),
            'today_revenue' => FshipOrder::where('user_id', $sellerId)->whereDate('created_at', $today)->sum('total_amount'),
            'avg_shipment'  => round($baseQuery->count() / max(1, Carbon::parse($startDate)->diffInDays($endDate)), 2),
            'total'         => $baseQuery->count(),
            'pickups'       => (clone $baseQuery)->where('status', 'pickups')->count(),
            'in_transit'    => (clone $baseQuery)->where('status', 'in_transit')->count(),
            'delivered'     => (clone $baseQuery)->where('status', 'delivered')->count(),
            'rto'           => (clone $baseQuery)->where('status', 'rto')->count(),
            'ndr_pending'   => NdrManagement::whereHas('order', function($q) use ($sellerId) {
                                    $q->where('user_id', $sellerId);
                               })->where('status', 'pending')->count(),
        ];

        // 3. NDR Detailed Stats
        $ndrStats = [
            'total_ndr'       => NdrManagement::whereHas('order', function($q) use ($sellerId) { 
                                    $q->where('user_id', $sellerId); 
                                 })->count(),
            'your_reattempt'  => NdrManagement::where('last_action_taken', 're-attempt')->count(),
            'buyer_reattempt' => NdrManagement::where('status', 'pending')->count(),
            'ndr_delivered'   => NdrManagement::where('status', 'delivered')->count(),
        ];

        // 4. COD & Wallet Stats ✅ FIXED
        $wallet = Wallet::where('user_id', $sellerId)->first();
        $codStats = [
            // payment_mode 1 = COD 
            'total_cod' => (clone $baseQuery)->where('payment_mode', 1)->sum('product_subtotal'),
            
            // ✅ FIXED: 'cod_payout' → 'cod' (ENUM value match)
            'cod_remitted' => Wallet_transaction::where('user_id', $sellerId)
                ->where('charge_type', 'cod')  // ✅ Changed from 'cod_payout' to 'cod'
                ->where('type', 'credit')       // ✅ COD payout = credit to wallet
                ->sum('amount'),
                
            // ✅ FIXED: Add charge_type filter for COD-specific credits only
            'last_cod_remitted' => Wallet_transaction::where('user_id', $sellerId)
                ->where('charge_type', 'cod')    // ✅ Only COD-related transactions
                ->where('type', 'credit')
                ->latest()
                ->value('amount') ?? 0,
                
            'next_cod_available' => $wallet->balance ?? 0,
        ];

        // 5. Analytics Data for SVG Charts
        $analytics = [
            'delivery_vs_rto' => [
                'delivered' => $shipmentStats['delivered'],
                'rto'       => $shipmentStats['rto']
            ],
            'shipment_status' => [
                'booked'     => (clone $baseQuery)->where('status', 'booked')->count(),
                'manifested' => (clone $baseQuery)->where('status', 'manifested')->count(),
                'in_transit' => $shipmentStats['in_transit'],
                'delivered'  => $shipmentStats['delivered'],
                'rto'        => $shipmentStats['rto']
            ]
        ];

        return view('seller.dashboard.index', compact(
            'shipmentStats', 
            'ndrStats', 
            'codStats', 
            'analytics', 
            'startDate', 
            'endDate'
        ));
    }
}