<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FshipOrder;
use App\Models\FshipOrderItem;
use App\Models\PickupAddress;
use App\Models\VendorAddress;
use App\Models\RtoAddress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MiniOrderController extends Controller
{
    /**
     * Analytics Dashboard - Main Index
     * Route: GET /admin/minioerders → miniOerder.index
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        
        // 👥 User-wise Stats (EXCLUDING ADMIN)
        $userStats = User::selectRaw('
            users.id, users.name, users.email, users.role,
            COUNT(DISTINCT fship_orders.id) as total_orders,
            COUNT(DISTINCT fship_order_items.id) as total_items,
            SUM(fship_orders.total_amount) as total_revenue,
            SUM(CASE WHEN fship_orders.payment_mode = 1 THEN fship_orders.total_amount ELSE 0 END) as total_cod,
            COUNT(DISTINCT CASE WHEN fship_orders.payment_mode = 1 THEN fship_orders.id END) as cod_orders,
            COUNT(DISTINCT pickup_addresses.id) as pickup_count,
            COUNT(DISTINCT vendor_addresses.id) as vendor_count,
            COUNT(DISTINCT rto_addresses.id) as rto_count
        ')
        ->leftJoin('fship_orders', 'fship_orders.user_id', '=', 'users.id')
        ->leftJoin('fship_order_items', 'fship_order_items.fship_order_id', '=', 'fship_orders.id')
        ->leftJoin('pickup_addresses', 'pickup_addresses.user_id', '=', 'users.id')
        ->leftJoin('vendor_addresses', 'vendor_addresses.pickup_address_id', '=', 'pickup_addresses.id')
        ->leftJoin('rto_addresses', 'rto_addresses.pickup_address_id', '=', 'pickup_addresses.id')
        ->where('users.role', '!=', 'admin') // ✅ ADMIN ROLE EXCLUDED HERE
        ->where(function($query) use ($startDate, $endDate) {
            $query->whereBetween('fship_orders.created_at', [$startDate, $endDate])
                  ->orWhereBetween('users.created_at', [$startDate, $endDate]);
        })
        ->groupBy('users.id', 'users.name', 'users.email', 'users.role')
        ->havingRaw('total_orders > 0 OR pickup_count > 0 OR vendor_count > 0 OR rto_count > 0')
        ->orderByDesc('total_orders')
        ->paginate(15);
        
        // 📦 Global Stats (EXCLUDING ADMIN)
        $globalStats = [
            'total_users' => User::where('role', '!=', 'admin')->count(), // ✅ ADMIN EXCLUDED
            'active_users' => User::where('role', '!=', 'admin')->whereHas('fshipOrders')->count(), // ✅ ADMIN EXCLUDED
            'total_orders' => FshipOrder::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_items' => FshipOrderItem::whereHas('order', fn($q) => 
                $q->whereBetween('created_at', [$startDate, $endDate])
            )->count(),
            'total_revenue' => FshipOrder::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount'),
            'total_cod' => FshipOrder::whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_mode', 1)->sum('total_amount'),
            'cod_order_count' => FshipOrder::whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_mode', 1)->count(),
            'prepaid_order_count' => FshipOrder::whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_mode', 2)->count(),
            'pickup_addresses' => PickupAddress::count(),
            'vendor_addresses' => VendorAddress::count(),
            'rto_addresses' => RtoAddress::count(),
        ];
        
        // 🗺️ Location Stats
        $locationStats = DB::table('fship_orders')
            ->selectRaw('state, city, pincode, COUNT(*) as order_count, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('state', 'city', 'pincode')
            ->orderByDesc('order_count')
            ->limit(50)
            ->get();
        
        // 📊 Chart Data
        $chartData = [
            'orders_by_status' => FshipOrder::selectRaw('status, COUNT(*) as count')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('status')
                ->pluck('count', 'status'),
            'orders_by_courier' => FshipOrder::selectRaw('courier_name, COUNT(*) as count')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('courier_name')
                ->where('courier_name', '!=', '')
                ->groupBy('courier_name')
                ->pluck('count', 'courier_name'),
            'orders_by_payment' => [
                'COD' => FshipOrder::whereBetween('created_at', [$startDate, $endDate])->where('payment_mode', 1)->count(),
                'Prepaid' => FshipOrder::whereBetween('created_at', [$startDate, $endDate])->where('payment_mode', 2)->count(),
            ],
            'revenue_by_date' => FshipOrder::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('date')
                ->pluck('revenue', 'date'),
        ];
        
        // 🎯 Zone Stats
        $zoneStats = FshipOrder::selectRaw('zone, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('zone')
            ->groupBy('zone')
            ->orderByDesc('count')
            ->get();
        
        // 📦 Recent Orders for initial load
        $recentOrders = FshipOrder::with(['user'])
            ->select([
                'fship_orders.id', 'fship_orders.waybill', 'fship_orders.merchant_order_id',
                'fship_orders.buyer_name', 'fship_orders.phone_number',
                'fship_orders.city', 'fship_orders.state', 'fship_orders.pincode',
                'fship_orders.total_amount', 'fship_orders.payment_mode',
                'fship_orders.courier_name', 'fship_orders.status',
                'fship_orders.created_at', 'fship_orders.user_id'
            ]);

        // 🔍 Orders Search & Filters (As you setup previously)
        if($request->filled('search')) {
            $search = $request->search;
            $recentOrders->where(function($q) use ($search) {
                $q->where('merchant_order_id', 'like', "%{$search}%")
                  ->orWhere('waybill', 'like', "%{$search}%")
                  ->orWhere('buyer_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('pincode', 'like', "%{$search}%");
            });
        }
        
        if($request->filled('status')) {
            $recentOrders->where('fship_orders.status', $request->status);
        }
        
        if($request->filled('payment')) {
            $recentOrders->where('fship_orders.payment_mode', $request->payment);
        }

        $recentOrders = $recentOrders->whereBetween('fship_orders.created_at', [$startDate, $endDate])
            ->orderBy('fship_orders.created_at', 'desc')
            ->paginate(20);
        
        return view('admin.miniOrder.miniOerder', compact(
            'userStats', 'globalStats', 'locationStats', 'chartData', 
            'startDate', 'endDate', 'zoneStats', 'recentOrders'
        ));
    }
    
    /**
     * API: User Details for Modal
     * Route: GET /admin/miniorder/users/{userId} → user.details
     */
    public function userDetails($userId)
    {
        try {
            // 1. User fetch karo
            $user = User::findOrFail($userId);
            
            // 2. Orders fetch karo direct table se
            $orders = FshipOrder::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
            $orderIds = $orders->pluck('id');
            
            // 3. Items count fetch karo
            $itemsCount = FshipOrderItem::whereIn('fship_order_id', $orderIds)->count();
            
            // 4. Addresses count fetch karo
            $pickupIds = PickupAddress::where('user_id', $userId)->pluck('id');
            $pickupCount = $pickupIds->count();
            
            $vendorCount = VendorAddress::whereIn('pickup_address_id', $pickupIds)->count();
            $rtoCount = RtoAddress::whereIn('pickup_address_id', $pickupIds)->count();
            
            // 5. Response return karo
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'orders' => $orders->count(),
                'items' => $itemsCount,
                'revenue' => $orders->sum('total_amount'),
                'cod_revenue' => $orders->where('payment_mode', 1)->sum('total_amount'),
                'pickup_count' => $pickupCount,
                'vendor_count' => $vendorCount,
                'rto_count' => $rtoCount,
                'delta' => $pickupCount - ($vendorCount + $rtoCount),
                'recent_orders' => $orders->take(5)->map(fn($o) => [
                    'id' => $o->id, 
                    'waybill' => $o->waybill, 
                    'buyer' => $o->buyer_name,
                    'city' => $o->city, 
                    'state' => $o->state, 
                    'amount' => $o->total_amount,
                    'payment' => $o->payment_mode == 1 ? 'COD' : 'Prepaid',
                    'status' => $o->status, 
                    'date' => $o->created_at->format('M d, Y')
                ])
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * API: Location Data
     * Route: GET /admin/miniorder/api/locations → api.locations
     */
    public function locationsData(Request $request)
    {
        $data = DB::table('fship_orders')
            ->selectRaw('state, city, pincode, COUNT(*) as orders, SUM(total_amount) as revenue')
            ->groupBy('state', 'city', 'pincode')
            ->orderByDesc('orders')
            ->limit(100)
            ->get();
        return response()->json($data);
    }
    
    /**
     * API: Orders Timeline
     * Route: GET /admin/miniorder/api/orders → api.orders
     */
    public function ordersData(Request $request)
    {
        $period = $request->input('period', '7d');
        $groupBy = match($period) {
            '24h' => 'HOUR(created_at)', '7d' => 'DATE(created_at)',
            '30d' => 'DATE(created_at)', default => 'DATE(created_at)',
        };
        $days = match($period) { '24h' => 1, '7d' => 7, '30d' => 30, default => 7 };
        
        $data = FshipOrder::selectRaw("{$groupBy} as period, COUNT(*) as count, SUM(total_amount) as revenue")
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('period')
            ->orderBy('period')
            ->get();
        return response()->json($data);
    }
    
    /**
     * API: Users Data for Charts
     * Route: GET /admin/minioerder/api/users → api.users
     */
    public function usersData(Request $request)
    {
        $data = User::selectRaw('
            users.name,
            COUNT(DISTINCT fship_orders.id) as orders,
            COUNT(DISTINCT fship_order_items.id) as items,
            SUM(fship_orders.total_amount) as revenue
        ')
        ->leftJoin('fship_orders', 'fship_orders.user_id', '=', 'users.id')
        ->leftJoin('fship_order_items', 'fship_order_items.fship_order_id', '=', 'fship_orders.id')
        ->where('users.role', '!=', 'admin') 
        ->groupBy('users.id', 'users.name')
        ->havingRaw('orders > 0')
        ->orderByDesc('orders')
        ->limit(10)
        ->get();
        
        return response()->json($data);
    }
    
    /**
     * Export Analytics to CSV
     * Route: GET /admin/miniorder/export → export
     */
    public function export(Request $request)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="analytics_'.date('Y-m-d').'.csv"',
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['User ID','Name','Email','Role','Total Orders','Total Revenue','Pickup Addr','Vendor Addr','RTO Addr','Delta']);
            
            
            User::where('role', '!=', 'admin')
                ->withCount(['fshipOrders', 'pickupAddresses'])
                ->withSum('fshipOrders', 'total_amount')
                ->get()
                ->each(function($user) use ($file) {
                    $vendorCount = collect($user->pickupAddresses)->sum(fn($p) => $p->vendorAddresses->count());
                    $rtoCount = collect($user->pickupAddresses)->sum(fn($p) => $p->rtoAddresses->count());
                    $delta = ($user->pickup_addresses_count ?? 0) - ($vendorCount + $rtoCount);
                    
                    fputcsv($file, [
                        $user->id, 
                        $user->name, 
                        $user->email, 
                        $user->role, 
                        $user->fship_orders_count ?? 0, 
                        number_format($user->fship_orders_sum_total_amount ?? 0, 2, '.', ''), // Fixed formatting for CSV
                        $user->pickup_addresses_count ?? 0, 
                        $vendorCount, 
                        $rtoCount, 
                        $delta
                    ]);
                });
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}