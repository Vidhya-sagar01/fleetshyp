{{-- resources/views/admin/miniOrder/miniOerder.blade.php --}}
@extends('admin.layouts.app')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
<style>
    :root {
        --primary: #4f46e5; --primary-hover: #4338ca;
        --success: #10b981; --warning: #f59e0b; --danger: #ef4444;
        --surface: #ffffff; --surface-alt: #f8fafc;
        --border: #e2e8f0; --text-primary: #1e293b; --text-secondary: #64748b;
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --radius: 16px; --radius-sm: 12px;
    }
    body { font-family: 'Inter', system-ui, sans-serif; background: linear-gradient(135deg, #f0f4ff 0%, #f8fafc 100%); }
    .stat-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); padding: 1.25rem; transition: all 0.2s ease; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1); }
    .stat-label { font-size: 0.75rem; color: var(--text-secondary); }
    .chart-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); padding: 1.25rem; }
    .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
    .chart-title { font-size: 1.125rem; font-weight: 600; color: var(--text-primary); }
    .data-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .data-table th { background: var(--surface-alt); padding: 1rem; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-secondary); border-bottom: 2px solid var(--border); text-align: left; white-space: nowrap; }
    .data-table td { padding: 1rem; border-bottom: 1px solid var(--border); font-size: 0.9375rem; color: var(--text-primary); }
    .data-table tr:hover { background: var(--surface-alt); }
    .badge { display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; white-space: nowrap; }
    .badge-primary { background: #eef2ff; color: #4338ca; }
    .badge-success { background: #ecfdf5; color: #047857; }
    .badge-warning { background: #fffbeb; color: #92400e; }
    .badge-danger { background: #fef2f2; color: #991b1b; }
    .badge-info { background: #ecfeff; color: #0e7490; }
    .badge-cod { background: #fef3c7; color: #92400e; }
    .badge-prepaid { background: #dcfce7; color: #166534; }
    .filter-bar { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); padding: 1rem; display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; }
    .filter-input { padding: 0.5rem 1rem; border: 2px solid var(--border); border-radius: 8px; font-size: 0.875rem; outline: none; transition: border-color 0.2s; min-width: 140px; }
    .filter-input:focus { border-color: var(--primary); }
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.625rem 1.25rem; font-size: 0.875rem; font-weight: 500; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; white-space: nowrap; }
    .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-hover)); color: white; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4); }
    .btn-outline { background: transparent; border: 2px solid var(--border); color: var(--text-primary); }
    .btn-outline:hover { background: var(--surface-alt); }
    .btn-sm { padding: 0.375rem 0.75rem; font-size: 0.8125rem; }
    .role-badge { padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.7rem; font-weight: 500; text-transform: uppercase; }
    .role-admin { background: #ede9fe; color: #6d28d9; }
    .role-seller { background: #dbeafe; color: #1d4ed8; }
    .role-user { background: #f1f5f9; color: #475569; }
    .delta-positive { color: var(--success); font-weight: 600; }
    .delta-negative { color: var(--danger); font-weight: 600; }
    .delta-neutral { color: var(--text-secondary); font-weight: 500; }
    .pagination-wrapper { margin-top: 1rem; display: flex; justify-content: center; overflow-x: auto; padding-bottom: 0.5rem; }
    .btn-icon { width: 36px; height: 36px; padding: 0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); transition: var(--transition); }
    .btn-icon:hover { background: var(--surface-alt); color: var(--primary); transform: scale(1.05); }
    
    @media (max-width: 768px) { 
        .filter-bar { flex-direction: column; align-items: stretch; } 
        .filter-input { width: 100%; }
        .data-table { font-size: 0.8125rem; } 
        .data-table th, .data-table td { padding: 0.75rem 0.5rem; } 
        .hide-mobile { display: none; } 
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    
    {{-- 🎯 Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">📊 Analytics Dashboard</h1>
            <p class="text-slate-500 text-sm">User activity, orders & location insights</p>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <a href="{{ route('miniOerder.export') }}" class="btn btn-outline flex-1 md:flex-none">
                <i class="fas fa-download"></i> <span class="hide-mobile">Export CSV</span>
            </a>
            <button onclick="window.location.reload()" class="btn btn-outline flex-1 md:flex-none" title="Refresh">
                <i class="fas fa-sync-alt"></i> <span class="md:hidden">Refresh</span>
            </button>
        </div>
    </div>

    {{-- 🔍 Main Filter Bar --}}
    <form method="GET" action="{{ route('miniOerder.index') }}" class="filter-bar mb-6">
        <label class="text-sm text-slate-600 font-medium hide-mobile">📅 Date Range:</label>
        <input type="date" name="start_date" value="{{ request('start_date', $startDate) }}" class="filter-input">
        <span class="text-slate-400 text-center hide-mobile">to</span>
        <input type="date" name="end_date" value="{{ request('end_date', $endDate) }}" class="filter-input">
        <button type="submit" class="btn btn-primary w-full sm:w-auto">
            <i class="fas fa-filter"></i> Apply Dates
        </button>
        <a href="{{ route('miniOerder.index') }}" class="btn btn-outline w-full sm:w-auto text-center">Reset All</a>
    </form>

    {{-- 📈 Global Stats Cards (Fully Responsive Layout) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
        
        <div class="stat-card flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <span class="stat-label uppercase font-bold tracking-wider">Total Users</span>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white bg-gradient-to-br from-blue-500 to-blue-700 shadow-sm shrink-0"><i class="fas fa-users"></i></div>
            </div>
            <div class="text-2xl lg:text-xl xl:text-2xl font-bold text-slate-800 truncate" title="{{ number_format($globalStats['total_users']) }}">
                {{ number_format($globalStats['total_users']) }}
            </div>
        </div>

        <div class="stat-card flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <span class="stat-label uppercase font-bold tracking-wider">Total Orders</span>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-sm shrink-0"><i class="fas fa-box"></i></div>
            </div>
            <div class="text-2xl lg:text-xl xl:text-2xl font-bold text-slate-800 truncate" title="{{ number_format($globalStats['total_orders']) }}">
                {{ number_format($globalStats['total_orders']) }}
            </div>
        </div>

        <div class="stat-card flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <span class="stat-label uppercase font-bold tracking-wider">Total Items</span>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white bg-gradient-to-br from-purple-500 to-purple-700 shadow-sm shrink-0"><i class="fas fa-cube"></i></div>
            </div>
            <div class="text-2xl lg:text-xl xl:text-2xl font-bold text-slate-800 truncate" title="{{ number_format($globalStats['total_items']) }}">
                {{ number_format($globalStats['total_items']) }}
            </div>
        </div>

        <div class="stat-card flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <span class="stat-label uppercase font-bold tracking-wider">Total Revenue</span>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white bg-gradient-to-br from-orange-400 to-orange-600 shadow-sm shrink-0"><i class="fas fa-rupee-sign"></i></div>
            </div>
            <div class="text-2xl lg:text-xl xl:text-2xl font-bold text-slate-800 truncate" title="₹{{ number_format($globalStats['total_revenue'] ?? 0, 2) }}">
                ₹{{ number_format($globalStats['total_revenue'] ?? 0, 2) }}
            </div>
        </div>

        <div class="stat-card flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <span class="stat-label uppercase font-bold tracking-wider">COD Revenue</span>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white bg-gradient-to-br from-red-500 to-red-700 shadow-sm shrink-0"><i class="fas fa-hand-holding-usd"></i></div>
            </div>
            <div class="text-2xl lg:text-xl xl:text-2xl font-bold text-slate-800 truncate" title="₹{{ number_format($globalStats['total_cod'] ?? 0, 2) }}">
                ₹{{ number_format($globalStats['total_cod'] ?? 0, 2) }}
            </div>
        </div>

        <div class="stat-card flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <span class="stat-label uppercase font-bold tracking-wider">COD/Prepaid</span>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white bg-gradient-to-br from-cyan-400 to-cyan-600 shadow-sm shrink-0"><i class="fas fa-exchange-alt"></i></div>
            </div>
            <div class="text-2xl lg:text-xl xl:text-2xl font-bold text-slate-800 truncate" title="{{ $globalStats['cod_order_count'] ?? 0 }} / {{ $globalStats['prepaid_order_count'] ?? 0 }}">
                {{ $globalStats['cod_order_count'] ?? 0 }} / {{ $globalStats['prepaid_order_count'] ?? 0 }}
            </div>
        </div>

    </div>

    {{-- 🗺️ Address Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="stat-card flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <span class="stat-label uppercase font-bold tracking-wider text-blue-600">📍 Pickup Addr.</span>
                <i class="fas fa-map-marker-alt text-2xl text-blue-300"></i>
            </div>
            <div class="text-3xl font-bold text-slate-800">{{ number_format($globalStats['pickup_addresses']) }}</div>
        </div>
        <div class="stat-card flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <span class="stat-label uppercase font-bold tracking-wider text-purple-600">🏢 Vendor Addr.</span>
                <i class="fas fa-warehouse text-2xl text-purple-300"></i>
            </div>
            <div class="text-3xl font-bold text-slate-800">{{ number_format($globalStats['vendor_addresses']) }}</div>
        </div>
        <div class="stat-card flex flex-col justify-between">
            <div class="flex justify-between items-start mb-2">
                <span class="stat-label uppercase font-bold tracking-wider text-orange-600">🔄 RTO Addr.</span>
                <i class="fas fa-undo text-2xl text-orange-300"></i>
            </div>
            <div class="text-3xl font-bold text-slate-800">{{ number_format($globalStats['rto_addresses']) }}</div>
        </div>
    </div>

    {{-- 📊 Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="chart-card">
            <div class="chart-header"><span class="chart-title">📦 Orders by Status</span></div>
            <canvas id="statusChart" height="200"></canvas>
        </div>
        <div class="chart-card">
            <div class="chart-header"><span class="chart-title">💳 Payment Mode</span></div>
            <canvas id="paymentChart" height="200"></canvas>
        </div>
        <div class="chart-card lg:col-span-2">
            <div class="chart-header"><span class="chart-title">🚚 Orders by Courier</span></div>
            <canvas id="courierChart" height="150"></canvas>
        </div>
    </div>

    {{-- 👥 User Analytics Table --}}
    <div class="stat-card mb-6 overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
            <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                <i class="fas fa-users text-blue-500"></i> 👥 User-wise Analytics
            </h3>
            <span class="text-sm text-slate-500 bg-slate-100 px-3 py-1 rounded-full self-start">{{ $userStats->total() }} users</span>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th><th>Role</th><th>Orders</th><th class="hide-mobile">Items</th>
                        <th>Revenue</th><th>COD</th><th class="hide-mobile">📍 Pickup</th>
                        <th class="hide-mobile">🏢 Vendor</th><th class="hide-mobile">🔄 RTO</th><th>Delta</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($userStats as $user)
                    @php
                        $delta = ($user->pickup_count ?? 0) - (($user->vendor_count ?? 0) + ($user->rto_count ?? 0));
                        $deltaClass = $delta > 0 ? 'delta-positive' : ($delta < 0 ? 'delta-negative' : 'delta-neutral');
                        $deltaIcon = $delta > 0 ? '📈' : ($delta < 0 ? '📉' : '➡️');
                    @endphp
                    <tr onclick="viewUserDetails({{ $user->id }})" class="cursor-pointer">
                        <td>
                            <div class="font-medium whitespace-nowrap">{{ Str::limit($user->name, 20) }}</div>
                            <div class="text-xs text-slate-400 whitespace-nowrap">{{ Str::limit($user->email, 25) }}</div>
                        </td>
                        <td><span class="role-badge role-{{ $user->role }}">{{ $user->role }}</span></td>
                        <td><span class="badge badge-primary font-bold">{{ $user->total_orders ?? 0 }}</span></td>
                        <td class="hide-mobile">{{ $user->total_items ?? 0 }}</td>
                        <td class="font-medium text-green-600 whitespace-nowrap">₹{{ number_format($user->total_revenue ?? 0, 2) }}</td>
                        <td>@if(($user->total_cod ?? 0) > 0)<span class="badge badge-cod whitespace-nowrap">₹{{ number_format($user->total_cod, 2) }}</span>@else<span class="text-slate-400">—</span>@endif</td>
                        <td class="hide-mobile"><span class="badge badge-success">{{ $user->pickup_count ?? 0 }}</span></td>
                        <td class="hide-mobile"><span class="badge badge-warning">{{ $user->vendor_count ?? 0 }}</span></td>
                        <td class="hide-mobile"><span class="badge badge-danger">{{ $user->rto_count ?? 0 }}</span></td>
                        <td><span class="{{ $deltaClass }} font-bold whitespace-nowrap">{{ $deltaIcon }} {{ $delta >= 0 ? '+' : '' }}{{ $delta }}</span></td>
                        <td><button onclick="event.stopPropagation(); viewUserDetails({{ $user->id }})" class="btn-icon w-8 h-8 rounded-lg hover:bg-slate-100"><i class="fas fa-eye text-slate-500"></i></button></td>
                    </tr>
                    @empty
                    <tr><td colspan="11" class="text-center py-8 text-slate-400"><i class="fas fa-inbox text-4xl mb-3 block"></i>No users found for this date range</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($userStats->hasPages())
        <div class="pagination-wrapper mt-4">
            {{ $userStats->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    {{-- 📦 ORDERS LIST TABLE --}}
    <div class="stat-card mt-6 overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
            <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                <i class="fas fa-list text-indigo-500"></i> 📋 Order Details
            </h3>
            <span class="text-sm text-slate-500 bg-slate-100 px-3 py-1 rounded-full self-start">{{ $recentOrders->total() }} orders found</span>
        </div>
        
        {{-- 🔍 Filter Form for Orders --}}
        <form method="GET" action="{{ route('miniOerder.index') }}" class="flex flex-col md:flex-row flex-wrap items-stretch md:items-center gap-3 mb-4 pb-4 border-b border-slate-200">
            <input type="hidden" name="start_date" value="{{ request('start_date', $startDate) }}">
            <input type="hidden" name="end_date" value="{{ request('end_date', $endDate) }}">
            
            <div class="relative flex-1 w-full">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search waybill, customer, PIN..." class="filter-input pl-9 w-full">
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <select name="status" class="filter-input w-full sm:w-auto">
                    <option value="">All Status</option>
                    <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                    <option value="Picked" {{ request('status') == 'Picked' ? 'selected' : '' }}>Picked</option>
                    <option value="In Transit" {{ request('status') == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="RTO" {{ request('status') == 'RTO' ? 'selected' : '' }}>RTO</option>
                </select>
                <select name="payment" class="filter-input w-full sm:w-auto">
                    <option value="">All Payments</option>
                    <option value="1" {{ request('payment') == '1' ? 'selected' : '' }}>COD</option>
                    <option value="2" {{ request('payment') == '2' ? 'selected' : '' }}>Prepaid</option>
                </select>
            </div>

            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="btn btn-primary btn-sm flex-1"><i class="fas fa-search"></i> Search</button>
                @if(request()->hasAny(['search', 'status', 'payment']))
                    <a href="{{ route('miniOerder.index', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-outline btn-sm text-red-500 border-red-200 hover:bg-red-50 flex-1 text-center">Clear</a>
                @endif
            </div>
        </form>
        
        {{-- 📊 Table --}}
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th><th>Waybill</th><th>Customer</th><th class="hide-mobile">Location</th>
                        <th>Amount</th><th>Payment</th><th class="hide-mobile">Courier</th><th>Status</th><th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="font-medium text-slate-700 whitespace-nowrap">#{{ $order->merchant_order_id ?? $order->id }}</td>
                        <td class="font-mono text-sm">{{ $order->waybill ?? 'N/A' }}</td>
                        <td>
                            <div class="font-medium whitespace-nowrap">{{ Str::limit($order->buyer_name, 20) }}</div>
                            <div class="text-xs text-slate-500">{{ $order->phone_number }}</div>
                        </td>
                        <td class="hide-mobile">
                            <div class="whitespace-nowrap">{{ Str::limit($order->city, 15) }}</div>
                            <div class="text-xs text-slate-500 whitespace-nowrap">{{ $order->state }} - {{ $order->pincode }}</div>
                        </td>
                        <td class="font-medium whitespace-nowrap">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            @if($order->payment_mode == 1)
                                <span class="badge badge-cod">COD</span>
                            @else
                                <span class="badge badge-prepaid">Prepaid</span>
                            @endif
                        </td>
                        <td class="hide-mobile">
                            @if($order->courier_name)
                                <span class="badge badge-info">{{ $order->courier_name }}</span>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = match(strtolower($order->status)) {
                                    'delivered' => 'badge-success',
                                    'cancelled', 'rto' => 'badge-danger',
                                    'in transit', 'shipped' => 'badge-primary',
                                    default => 'badge-warning'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $order->status ?? 'Pending' }}</span>
                        </td>
                        <td class="text-sm text-slate-500 whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-slate-500">No orders found matching your criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- 📄 Pagination --}}
        @if($recentOrders->hasPages())
        <div class="pagination-wrapper mt-6">
            {{ $recentOrders->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

{{-- 👁️ User Details Modal --}}
<div id="userModal" class="fixed inset-0 z-[100] hidden" onclick="if(event.target===this)closeUserModal()">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-3xl mx-4 max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl">
        <div class="bg-white">
            <div class="sticky top-0 bg-white z-10 p-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-slate-800"><i class="fas fa-user-circle text-indigo-500"></i> <span id="modalUserName">User Details</span></h3>
                <button onclick="closeUserModal()" class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center"><i class="fas fa-times text-slate-400"></i></button>
            </div>
            <div class="p-6" id="userModalContent"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 📊 Initialize Charts
    initStatusChart(@json($chartData['orders_by_status'] ?? []));
    initPaymentChart(@json($chartData['orders_by_payment'] ?? []));
    initCourierChart(@json($chartData['orders_by_courier'] ?? []));

    // 🎬 Card Animations
    document.querySelectorAll('.stat-card').forEach((card, i) => {
        card.style.opacity = '0'; 
        card.style.transform = 'translateY(10px)';
        setTimeout(() => { 
            card.style.transition = 'opacity 0.3s ease, transform 0.3s ease'; 
            card.style.opacity = '1'; 
            card.style.transform = 'translateY(0)'; 
        }, 100 * i);
    });
});

// Chart.js renderers
function initStatusChart(data) {
    const ctx = document.getElementById('statusChart'); if(!ctx || Object.keys(data).length === 0) return;
    new Chart(ctx, { type: 'doughnut', data: { labels: Object.keys(data), datasets: [{ data: Object.values(data), backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#64748b'], borderWidth: 0 }] }, options: { responsive: true, plugins: { legend: { position: 'bottom' } }, cutout: '65%' } });
}

function initPaymentChart(data) {
    const ctx = document.getElementById('paymentChart'); if(!ctx || Object.keys(data).length === 0) return;
    new Chart(ctx, { type: 'pie', data: { labels: Object.keys(data), datasets: [{ data: Object.values(data), backgroundColor: ['#f59e0b', '#10b981'], borderWidth: 0 }] }, options: { responsive: true, plugins: { legend: { position: 'bottom' } } } });
}

function initCourierChart(data) {
    const ctx = document.getElementById('courierChart'); if(!ctx || Object.keys(data).length === 0) return;
    const sorted = Object.entries(data).sort((a,b) => b[1] - a[1]).slice(0, 10);
    new Chart(ctx, { type: 'bar', data: { labels: sorted.map(([k]) => k), datasets: [{ label: 'Orders', data: sorted.map(([,v]) => v), backgroundColor: 'rgba(79, 70, 229, 0.7)', borderColor: '#4f46e5', borderWidth: 2, borderRadius: 6 }] }, options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } } });
}

// User Modal Logic
async function viewUserDetails(userId) {
    const modal = document.getElementById('userModal');
    const content = document.getElementById('userModalContent');
    const title = document.getElementById('modalUserName');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    content.innerHTML = '<div class="text-center text-slate-400 py-12"><i class="fas fa-spinner fa-spin text-3xl mb-4"></i><div class="font-medium">Fetching User Details...</div></div>';
    
    try {
        const res = await fetch(`/admin/miniorder/users/${userId}`);
        if(!res.ok) throw new Error(`Server Error (${res.status}). Ensure API route and Model relationships are correct.`);
        const user = await res.json();
        
        title.textContent = user.name;
        
        content.innerHTML = `
            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-5 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border border-indigo-100">
                    <div class="w-16 h-16 rounded-full bg-indigo-500 flex items-center justify-center text-2xl font-bold text-white shadow-md shrink-0">
                        ${user.name?.charAt(0)?.toUpperCase() ?? '?'}
                    </div>
                    <div>
                        <div class="font-bold text-xl text-slate-800">${user.name}</div>
                        <div class="text-slate-600">${user.email}</div>
                        <span class="inline-block mt-2 px-3 py-1 bg-white border border-slate-200 rounded-full text-xs font-bold uppercase tracking-wider text-slate-600">${user.role}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center"><div class="text-3xl font-bold text-blue-600">${user.orders ?? 0}</div><div class="text-xs uppercase font-bold tracking-wider text-slate-500 mt-1">Orders</div></div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center"><div class="text-3xl font-bold text-purple-600">${user.items ?? 0}</div><div class="text-xs uppercase font-bold tracking-wider text-slate-500 mt-1">Items</div></div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center"><div class="text-3xl font-bold text-green-600 truncate" title="₹${(user.revenue ?? 0).toLocaleString()}">₹${(user.revenue ?? 0).toLocaleString()}</div><div class="text-xs uppercase font-bold tracking-wider text-slate-500 mt-1">Revenue</div></div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center"><div class="text-3xl font-bold text-orange-600 truncate" title="₹${(user.cod_revenue ?? 0).toLocaleString()}">₹${(user.cod_revenue ?? 0).toLocaleString()}</div><div class="text-xs uppercase font-bold tracking-wider text-slate-500 mt-1">COD Revenue</div></div>
                </div>

                <div class="p-5 bg-gradient-to-r from-slate-50 to-slate-100 border border-slate-200 rounded-xl">
                    <div class="font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="fas fa-map-marked-alt text-slate-400"></i> Address Distribution</div>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-white p-3 rounded-lg shadow-sm"><div class="text-2xl font-bold text-blue-600">${user.pickup_count ?? 0}</div><div class="text-xs uppercase font-bold tracking-wider text-slate-500 mt-1">Pickup</div></div>
                        <div class="bg-white p-3 rounded-lg shadow-sm"><div class="text-2xl font-bold text-purple-600">${user.vendor_count ?? 0}</div><div class="text-xs uppercase font-bold tracking-wider text-slate-500 mt-1">Vendor</div></div>
                        <div class="bg-white p-3 rounded-lg shadow-sm"><div class="text-2xl font-bold text-orange-600">${user.rto_count ?? 0}</div><div class="text-xs uppercase font-bold tracking-wider text-slate-500 mt-1">RTO</div></div>
                    </div>
                </div>

                ${user.recent_orders?.length ? `
                <div>
                    <div class="font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="fas fa-box-open text-slate-400"></i> Recent Orders</div>
                    <div class="space-y-3">
                        ${user.recent_orders.map(o => `
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-white border border-slate-200 rounded-xl shadow-sm hover:border-indigo-300 transition-colors">
                                <div class="mb-2 sm:mb-0">
                                    <div class="font-bold text-slate-800 flex items-center gap-2">
                                        #${o.waybill || o.id} 
                                        <span class="text-[10px] px-2 py-0.5 rounded-full ${o.payment === 'COD' ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700'} uppercase font-bold tracking-wider">${o.payment}</span>
                                    </div>
                                    <div class="text-sm text-slate-500 mt-1"><i class="far fa-user text-slate-400 mr-1"></i> ${o.buyer} &nbsp; <i class="fas fa-map-pin text-slate-400 mx-1"></i> ${o.city}</div>
                                </div>
                                <div class="sm:text-right flex items-center justify-between sm:block border-t sm:border-0 pt-2 sm:pt-0 mt-2 sm:mt-0 border-slate-100">
                                    <div class="font-bold text-lg text-slate-800">₹${(o.amount ?? 0).toLocaleString()}</div>
                                    <div class="text-xs text-slate-400 mt-1">${o.date}</div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>` : '<div class="text-center text-slate-400 py-6 border border-dashed border-slate-300 rounded-xl bg-slate-50"><i class="fas fa-box text-2xl mb-2 text-slate-300"></i><br>No recent orders found</div>'}
            </div>
        `;
    } catch(e) {
        console.error(e);
        content.innerHTML = `
            <div class="text-center text-red-500 py-12">
                <i class="fas fa-exclamation-triangle text-4xl mb-4 text-red-400"></i>
                <div class="font-bold text-lg">Error loading details</div>
                <div class="text-sm mt-2 text-red-400/80 bg-red-50 p-3 rounded-lg inline-block mx-auto max-w-lg break-words">${e.message}</div>
            </div>`;
    }
}

function closeUserModal() { 
    document.getElementById('userModal').classList.add('hidden'); 
    document.body.style.overflow = ''; 
}

document.addEventListener('keydown', e => { 
    if(e.key === 'Escape') closeUserModal(); 
});
</script>
@endpush