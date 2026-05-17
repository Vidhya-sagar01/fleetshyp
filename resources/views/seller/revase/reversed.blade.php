@extends('seller.layouts.app')

@section('content')
<div class="space-y-6">

    <h1>Reverse Order Management</h1>

    <!-- ✅ Alert Messages -->
    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <i class="fa fa-exclamation-triangle text-red-500 mr-3"></i>
            <div>
                <p class="font-medium text-red-800">Error</p>
                <p class="text-red-700 text-sm">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex">
            <i class="fa fa-list-ul text-yellow-600 mr-3 mt-1"></i>
            <div>
                <p class="font-medium text-yellow-800">Please fix the following issues:</p>
                <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <i class="fa fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- ✅ Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gradient-cream">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-gold flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fa fa-filter text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Filters</h3>
                        <p class="text-xs text-gray-500 hidden sm:block">Refine your reverse order search</p>
                    </div>
                </div>
                <button type="button" id="toggleFilters" class="flex items-center text-sm text-gray-600 hover:text-gold transition-colors focus:outline-none flex-shrink-0">
                    <span id="filterToggleText" class="hidden sm:inline">Show Filters</span>
                    <i id="filterToggleIcon" class="fa fa-chevron-down ml-2 transition-transform duration-200"></i>
                </button>
            </div>
        </div>

        <div id="filterBody" class="hidden">
            <div class="p-4 sm:p-6">
                <form action="{{ route('index') }}" method="GET" id="filterForm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Date From Filter -->
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">From Date</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" name="date_from" id="date_from" 
                                       class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" 
                                       placeholder="Select start date"
                                       value="{{ request('date_from') }}">
                            </div>
                        </div>

                        <!-- Date To Filter -->
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">To Date</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" name="date_to" id="date_to" 
                                       class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" 
                                       placeholder="Select end date"
                                       value="{{ request('date_to') }}">
                            </div>
                        </div>

                        <!-- Order ID Filter (Forward Order ID) -->
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Forward Order ID</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa fa-hashtag"></i>
                                </span>
                                <input type="text" name="order_id" 
                                       class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" 
                                       placeholder="Enter Forward Order ID"
                                       value="{{ request('order_id') }}">
                            </div>
                        </div>

                        <!-- Reverse Waybill / AWB Filter -->
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Reverse AWB</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa fa-truck"></i>
                                </span>
                                <input type="text" name="awb" 
                                       class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" 
                                       placeholder="Enter Reverse Waybill"
                                       value="{{ request('awb') }}">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Status</label>
                            <select name="status" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Status</option>
                                <option value="Initiated" {{ request('status') == 'Initiated' ? 'selected' : '' }}>Initiated</option>
                                <option value="Picked" {{ request('status') == 'Picked' ? 'selected' : '' }}>Picked</option>
                                <option value="In Transit" {{ request('status') == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                                <option value="QC Pending" {{ request('status') == 'QC Pending' ? 'selected' : '' }}>QC Pending</option>
                                <option value="QC Completed" {{ request('status') == 'QC Completed' ? 'selected' : '' }}>QC Completed</option>
                                <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- Payment Mode Filter -->
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Payment Mode</label>
                            <select name="payment_mode" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Payments</option>
                                <option value="COD" {{ request('payment_mode') == 'COD' ? 'selected' : '' }}>COD</option>
                                <option value="Prepaid" {{ request('payment_mode') == 'Prepaid' ? 'selected' : '' }}>Prepaid</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" id="clearFilters" class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all flex items-center justify-center">
                            <i class="fa fa-undo mr-2"></i> Clear All
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white bg-gradient-gold hover:shadow-lg rounded-lg transition-all flex items-center justify-center">
                            <i class="fa fa-search mr-2"></i> Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ✅ Main Content Area -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        <!-- ✅ Status Toggle Tabs -->
        <div class="px-4 sm:px-6 py-3 border-b border-gray-100 bg-white">
            <div class="flex items-center gap-2 overflow-x-auto pb-1">
                @php
                    $statuses = ['Initiated', 'Picked', 'In Transit', 'QC Pending', 'QC Completed', 'Delivered', 'Cancelled', 'All'];
                    $currentTab = request('tab', 'Initiated');
                    $sellerId = auth()->id();
                @endphp
                @foreach($statuses as $status)
                    @php
                        $tabKey = $status === 'All' ? 'all' : $status;
                        $isActive = ($currentTab === $tabKey) || ($currentTab == 'Initiated' && $status === 'Initiated');
                        $count = $status === 'All' 
                            ? \App\Models\FshipReverseOrder::where('seller_id', $sellerId)->count()
                            : \App\Models\FshipReverseOrder::where('seller_id', $sellerId)->where('status', $status)->count();
                    @endphp
                    <button class="status-tab px-4 py-2 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ $isActive ? 'bg-gold text-white' : 'text-gray-600 hover:bg-gray-100' }}" 
                            data-target="{{ $tabKey === 'all' ? 'all' : $status }}">
                        {{ $status }} <span class="ml-1 px-2 py-0.5 {{ $isActive ? 'bg-white/20' : 'bg-gray-200' }} rounded-full text-xs">{{ $count }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- ✅ Quick Actions Bar -->
        <div class="px-4 sm:px-6 py-3 border-b border-gray-100 flex flex-wrap items-center justify-end gap-2 bg-gray-50">
            <button type="button" onclick="handleBulkUpload()" class="px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:border-gold transition-all flex items-center">
                <i class="fa fa-upload mr-2"></i> Upload Bulk
            </button>
            
            <a href="{{ route('create') }}" 
               class="px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:border-gold transition-all flex items-center">
                <i class="fa fa-undo mr-2"></i> Add Reverse Order
            </a>
            
            <button type="button" onclick="exportCSV()" class="px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:border-gold transition-all flex items-center">
                <i class="fa fa-file-export mr-2"></i> Export CSV
            </button>
        </div>

        <!-- ✅ Reverse Orders Table - ALWAYS VISIBLE -->
        <div id="table-reverse-orders" class="active">
            <div class="overflow-x-auto">
                <table class="w-full" id="reverseOrdersTable">
                    <thead class="bg-gray-50 text-nowrap">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                <input type="checkbox" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold" id="selectAllReverse">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Created</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Reverse ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Forward Order</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Reverse AWB</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Reason</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[120px]">Mobile</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Pickup</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Payment</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Weight</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">QC</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($reverseOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors text-sm" data-order-id="{{ $order->id }}">
                            <!-- Checkbox -->
                            <td class="px-4 py-4 text-center align-middle">
                                <input type="checkbox" class="form-checkbox rounded border-gray-300 text-gold item-checkbox-reverse" value="{{ $order->id }}">
                            </td>
                            
                            <!-- Created At -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                <div class="text-gray-800 font-medium text-xs">
                                    {{ $order->reverse_order_created_at ? \Carbon\Carbon::parse($order->reverse_order_created_at)->format('d M Y') : (\Carbon\Carbon::parse($order->created_at)->format('d M Y')) }}
                                </div>
                                <div class="text-[10px] text-gray-400">
                                    {{ $order->reverse_order_created_at ? \Carbon\Carbon::parse($order->reverse_order_created_at)->format('h:i A') : \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}
                                </div>
                            </td>
                            
                            <!-- Reverse ID -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                <div class="text-gray-800 font-bold text-xs">#{{ $order->id }}</div>
                                <div class="text-[10px] text-gray-400">API: {{ $order->fship_api_order_id ?? 'N/A' }}</div>
                            </td>
                            
                            <!-- Forward Order ID -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                <div class="text-gray-800 font-medium text-xs">{{ $order->forward_order_id }}</div>
                                @if($order->invoice_number)
                                <div class="text-[10px] text-gray-400">Inv: {{ $order->invoice_number }}</div>
                                @endif
                            </td>
                            
                            <!-- Reverse AWB -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                @if($order->reverse_waybill)
                                    <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">{{ $order->reverse_waybill }}</span>
                                @else
                                    <span class="text-[10px] text-gray-400 italic">Pending</span>
                                @endif
                                @if($order->tracking_number)
                                <div class="text-[10px] text-gray-400">Track: {{ Str::limit($order->tracking_number, 12) }}</div>
                                @endif
                            </td>
                            
                            <!-- Status -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                @php
                                    $statusClass = match($order->status) {
                                        'Initiated' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'Picked' => 'bg-purple-50 text-purple-600 border-purple-100',
                                        'In Transit' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                        'QC Pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                        'QC Completed' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'Delivered' => 'bg-green-50 text-green-600 border-green-100',
                                        'Cancelled' => 'bg-red-50 text-red-600 border-red-100',
                                        default => 'bg-gray-50 text-gray-600 border-gray-100'
                                    };
                                @endphp
                                <span class="px-2 py-0.5 text-[9px] font-bold rounded border {{ $statusClass }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                                @if($order->cancelled_at)
                                <div class="text-[10px] text-red-400 mt-1">Cancelled</div>
                                @endif
                            </td>
                            
                            <!-- Return Reason -->
                            <td class="px-4 py-4 align-middle">
                                <div class="text-xs text-gray-700">
                                    {{ $order->return_reason ? str_replace('_', ' ', ucfirst($order->return_reason)) : 'N/A' }}
                                </div>
                                <div class="text-[10px] text-gray-400">
                                    @if($order->return_type == 1) Exchange
                                    @elseif($order->return_type == 2) Refund
                                    @else Return @endif
                                </div>
                            </td>
                            
                            <!-- Customer -->
                            <td class="px-4 py-4 align-middle">
                                <div class="font-semibold text-gray-800 text-xs">{{ $order->consignee_name }}</div>
                                <div class="text-[10px] text-gray-400">{{ $order->pickup_city }}, {{ $order->pickup_state }}</div>
                            </td>
                            
                            <!-- Mobile -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                @if($order->consignee_phone)
                                <a href="tel:{{ $order->consignee_phone }}" class="text-xs text-gold hover:underline font-medium">
                                    +91 {{ $order->consignee_phone }}
                                </a>
                                @else
                                <span class="text-[10px] text-gray-400">N/A</span>
                                @endif
                            </td>
                            
                            <!-- Pickup Location -->
                            <td class="px-4 py-4 align-middle">
                                <div class="text-xs text-gray-600 max-w-[140px] truncate" title="{{ $order->pickup_address }}">
                                    {{ $order->pickup_address }}
                                </div>
                                <div class="text-[10px] text-gray-400">PIN: {{ $order->pickup_pincode }}</div>
                            </td>
                            
                            <!-- Amount -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                <div class="text-xs font-bold text-gray-800">₹{{ number_format($order->total_amount, 2) }}</div>
                                @if($order->cod_amount > 0)
                                <div class="text-[10px] text-orange-600">COD: ₹{{ number_format($order->cod_amount, 2) }}</div>
                                @endif
                            </td>
                            
                            <!-- Payment Mode -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                <span class="text-xs font-bold {{ $order->payment_mode == 'COD' ? 'text-orange-600' : 'text-green-600' }}">
                                    {{ $order->payment_mode }}
                                </span>
                            </td>
                            
                            <!-- Weight/Dimension -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                <div class="text-xs font-bold text-gray-800">{{ $order->shipment_weight }} Kg</div>
                                <div class="text-[10px] text-gray-400">
                                    {{ $order->shipment_length }}×{{ $order->shipment_width }}×{{ $order->shipment_height }}
                                </div>
                            </td>
                            
                            <!-- QC Required -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                @if($order->is_qc_required)
                                    <span class="px-2 py-0.5 text-[9px] font-bold rounded bg-green-50 text-green-600 border border-green-100">Yes</span>
                                @else
                                    <span class="px-2 py-0.5 text-[9px] font-bold rounded bg-gray-100 text-gray-500 border border-gray-200">No</span>
                                @endif
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-4 py-4 align-middle whitespace-nowrap">
                                <div class="flex items-center gap-1">
                                    <!-- View Details -->
                                    <button class="p-1.5 text-blue-600 hover:bg-blue-50 rounded view-order-btn" 
                                            title="View Details"
                                            data-order='@json($order)'
                                            data-items='@json($order->items)'>
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Expandable Items Row -->
                        <tr class="order-items-row hidden bg-gray-50" id="items-{{ $order->id }}">
                            <td colspan="15" class="px-4 py-3">
                                <div class="pl-6">
                                    <h5 class="text-xs font-semibold text-gray-700 mb-2">
                                        Items ({{ $order->items->count() }})
                                    </h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                        @foreach($order->items as $item)
                                        <div class="bg-white p-2.5 rounded border border-gray-200 text-xs">
                                            <div class="font-semibold text-gray-800 truncate">{{ $item->product_name }}</div>
                                            <div class="text-gray-500 text-[10px]">SKU: {{ $item->sku ?? 'N/A' }}</div>
                                            <div class="flex justify-between mt-1">
                                                <span class="text-gray-600">Qty: {{ $item->quantity }}</span>
                                                <span class="font-bold text-gray-800">₹{{ number_format($item->total_price, 2) }}</span>
                                            </div>
                                            @if($item->return_reason)
                                            <div class="text-[10px] text-red-500 mt-1">
                                                ⚠ {{ str_replace('_', ' ', $item->return_reason) }}
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="15" class="px-4 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                    <i class="fa fa-undo text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-600 font-medium">No reverse orders found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting filters or create a new reverse order</p>
                                <a href="{{ route('create') }}" 
                                   class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white bg-gold rounded-lg hover:shadow-lg transition-all">
                                    <i class="fa fa-plus mr-2"></i> Create Reverse Order
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($reverseOrders->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <select class="form-select px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold" 
                            onchange="window.location.href=this.value">
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 20]) }}" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20/page</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50/page</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}" {{ request('per_page') == 100 ? 'selected' : '' }}>100/page</option>
                    </select>
                    <span class="text-sm text-gray-500">
                        Showing {{ $reverseOrders->firstItem() ?? 0 }}-{{ $reverseOrders->lastItem() ?? 0 }} of {{ $reverseOrders->total() }}
                    </span>
                </div>
                <div>
                    {{ $reverseOrders->withQueryString()->links('vendor.pagination.tailwind') }}
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

<!-- ✅ Order Detail Modal -->
<div class="modal fade fixed inset-0 z-50 overflow-y-auto hidden" id="orderDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl relative w-auto mx-4 pointer-events-none">
        <div class="modal-content relative flex flex-col w-full pointer-events-auto bg-white border border-gray-200 rounded-xl shadow-xl outline-none max-h-[90vh]">
            <div class="modal-header flex items-center justify-between p-4 sm:p-6 border-b border-gray-100">
                <h6 class="modal-title font-semibold text-gray-800">Reverse Order #<span id="modalOrderId"></span></h6>
                <button type="button" class="text-gray-400 hover:text-gray-600" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-4 sm:p-6 overflow-y-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Order Info -->
                    <div class="space-y-3">
                        <h5 class="font-semibold text-gray-700 border-b pb-2">Order Information</h5>
                        <dl class="grid grid-cols-2 gap-2 text-sm">
                            <dt class="text-gray-500">Forward Order:</dt><dd class="font-medium" id="modalForwardOrderId"></dd>
                            <dt class="text-gray-500">Reverse AWB:</dt><dd class="font-medium" id="modalReverseWaybill"></dd>
                            <dt class="text-gray-500">Status:</dt><dd><span id="modalStatus" class="font-bold"></span></dd>
                            <dt class="text-gray-500">Created:</dt><dd class="font-medium" id="modalCreatedAt"></dd>
                            <dt class="text-gray-500">Return Type:</dt><dd class="font-medium" id="modalReturnType"></dd>
                            <dt class="text-gray-500">QC Required:</dt><dd class="font-medium" id="modalQcRequired"></dd>
                            <dt class="text-gray-500">Payment:</dt><dd class="font-medium" id="modalPayment"></dd>
                            <dt class="text-gray-500">Total:</dt><dd class="font-bold text-gold" id="modalAmount"></dd>
                        </dl>
                    </div>
                    
                    <!-- Customer Info -->
                    <div class="space-y-3">
                        <h5 class="font-semibold text-gray-700 border-b pb-2">Customer & Pickup</h5>
                        <div class="text-sm space-y-2">
                            <div><span class="text-gray-500">Name:</span><br><strong id="modalCustomerName"></strong></div>
                            <div><span class="text-gray-500">Phone:</span><br><a href="#" id="modalPhone" class="text-gold"></a></div>
                            <div><span class="text-gray-500">Email:</span><br><span id="modalEmail" class="text-gray-700"></span></div>
                            <div class="pt-2">
                                <span class="text-gray-500">Pickup Address:</span><br>
                                <strong id="modalPickupAddress" class="block mt-1 text-gray-700"></strong>
                                <span id="modalPickupPincode" class="text-gray-500 text-sm"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Items -->
                    <div class="lg:col-span-2 space-y-3">
                        <h5 class="font-semibold text-gray-700 border-b pb-2">Items (<span id="modalItemsCount"></span>)</h5>
                        <div id="modalItemsList" class="grid grid-cols-1 md:grid-cols-2 gap-2"></div>
                    </div>
                    
                    <!-- Tracking -->
                    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 border-t">
                        <div>
                            <span class="text-gray-500 text-sm">Tracking:</span><br>
                            <strong id="modalTrackingNumber" class="text-gray-700"></strong>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm">Courier:</span><br>
                            <strong id="modalCourier" class="text-gray-700"></strong>
                        </div>
                        <div class="md:col-span-1">
                            <span class="text-gray-500 text-sm">Notes:</span><br>
                            <p id="modalNotes" class="text-gray-700 text-sm"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer flex justify-end gap-3 p-4 border-t">
                <button type="button" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200" data-bs-dismiss="modal">Close</button>
                <button type="button" class="px-4 py-2 text-sm text-white bg-gold rounded-lg hover:shadow-lg">
                    <i class="fa fa-print mr-2"></i> Print Label
                </button>
            </div>
        </div>
    </div>
</div>


<!-- ✅ CSS -->
<style>
    .flatpickr-calendar { border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15); border-radius: 12px; }
    .flatpickr-day.selected { background: #D4AF37 !important; border-color: #D4AF37 !important; }
    .overflow-x-auto::-webkit-scrollbar { height: 6px; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 3px; }
    .form-control:focus, .form-select:focus { outline: none; box-shadow: 0 0 0 3px rgba(212,175,55,0.15); }
    .modal.fade .modal-dialog { transition: transform 0.3s; transform: translateY(-20px); }
    .modal.fade.show .modal-dialog { transform: translateY(0); }
    .modal-backdrop { background: rgba(0,0,0,0.4); }
    #filterBody { transition: all 0.3s; }
    #filterBody.hidden { display: none; }
    .order-items-row.hidden { display: none; }
    @media (max-width:768px) { button,a,input,select { min-height: 44px; } }
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Flatpickr Date Filters
    flatpickr("#date_from", { dateFormat: "Y-m-d", maxDate: "today", 
        onChange: function(_, dateStr) { document.getElementById('date_to')._flatpickr?.set('minDate', dateStr); } });
    flatpickr("#date_to", { dateFormat: "Y-m-d", maxDate: "today", 
        onChange: function(_, dateStr) { document.getElementById('date_from')._flatpickr?.set('maxDate', dateStr); } });
    
    // Filter Toggle
    const filterBody = document.getElementById('filterBody');
    const toggleBtn = document.getElementById('toggleFilters');
    const toggleIcon = document.getElementById('filterToggleIcon');
    const toggleText = document.getElementById('filterToggleText');
    
    toggleBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        filterBody.classList.toggle('hidden');
        if(filterBody.classList.contains('hidden')) {
            toggleText.textContent = 'Show Filters';
            toggleIcon.classList.replace('fa-chevron-up', 'fa-chevron-down');
        } else {
            toggleText.textContent = 'Hide Filters';
            toggleIcon.classList.replace('fa-chevron-down', 'fa-chevron-up');
        }
    });
    
    document.getElementById('clearFilters')?.addEventListener('click', () => {
        document.getElementById('filterForm')?.reset();
        document.getElementById('date_from')._flatpickr?.clear();
        document.getElementById('date_to')._flatpickr?.clear();
    });
    
    // Select All Checkboxes
    const selectAll = document.getElementById('selectAllReverse');
    const checkboxes = document.querySelectorAll('.item-checkbox-reverse');
    selectAll?.addEventListener('change', () => checkboxes.forEach(cb => cb.checked = selectAll.checked));
    checkboxes.forEach(cb => cb.addEventListener('change', () => {
        if(selectAll && !cb.checked) selectAll.checked = false;
    }));
    
    // ✅ FIXED: Tab Toggle - Main table ALWAYS visible
  // ✅ Is function ko replace karein
function activateTab(targetId) {
    const url = new URL(window.location);
    
    // Tab parameter set karein
    if (targetId === 'all') {
        url.searchParams.delete('tab');
    } else {
        url.searchParams.set('tab', targetId);
    }
    
    // Page 1 par reset karein taaki purani pagination disturb na ho
    url.searchParams.delete('page');
    
    // URL reload karein - Iske bina data nahi badlega
    window.location.href = url.toString();
}
    
    // Initialize tabs
    const activeTab = new URLSearchParams(window.location.search).get('tab') || 'Initiated';
    activateTab(activeTab);
    
    document.querySelectorAll('.status-tab').forEach(tab => {
        tab.addEventListener('click', (e) => { e.preventDefault(); activateTab(tab.dataset.target); });
    });
    
    // Expand/Collapse Items Row
    document.querySelectorAll('.view-order-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const orderId = this.closest('tr').dataset.orderId;
            const row = document.getElementById('items-' + orderId);
            const isHidden = row.classList.contains('hidden');
            document.querySelectorAll('.order-items-row').forEach(r => r.classList.add('hidden'));
            if(isHidden) { row.classList.remove('hidden'); this.innerHTML = '<i class="fa fa-chevron-up"></i>'; }
            else { this.innerHTML = '<i class="fa fa-eye"></i>'; }
        });
    });
    
    // Order Detail Modal
    const detailModal = document.getElementById('orderDetailModal');
    document.querySelectorAll('.view-order-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const order = JSON.parse(this.dataset.order);
            const items = JSON.parse(this.dataset.items);
            
            document.getElementById('modalOrderId').textContent = order.id;
            document.getElementById('modalForwardOrderId').textContent = order.forward_order_id;
            document.getElementById('modalReverseWaybill').textContent = order.reverse_waybill || 'Pending';
            document.getElementById('modalStatus').textContent = order.status;
            document.getElementById('modalStatus').className = 'font-bold ' + getStatusColor(order.status);
            document.getElementById('modalCreatedAt').textContent = formatDate(order.reverse_order_created_at || order.created_at);
            document.getElementById('modalReturnType').textContent = {0:'Return',1:'Exchange',2:'Refund'}[order.return_type] || 'Return';
            document.getElementById('modalQcRequired').textContent = order.is_qc_required ? 'Yes' : 'No';
            document.getElementById('modalPayment').textContent = order.payment_mode;
            document.getElementById('modalAmount').textContent = '₹' + parseFloat(order.total_amount).toFixed(2);
            document.getElementById('modalCustomerName').textContent = order.consignee_name;
            document.getElementById('modalPhone').textContent = '+91 ' + order.consignee_phone;
            document.getElementById('modalPhone').href = 'tel:' + order.consignee_phone;
            document.getElementById('modalEmail').textContent = order.consignee_email || 'N/A';
            document.getElementById('modalPickupAddress').textContent = order.pickup_address;
            document.getElementById('modalPickupPincode').textContent = `PIN: ${order.pickup_pincode}, ${order.pickup_city}, ${order.pickup_state}`;
            document.getElementById('modalTrackingNumber').textContent = order.tracking_number || 'Not assigned';
            document.getElementById('modalCourier').textContent = order.courier_name || 'Not assigned';
            document.getElementById('modalNotes').textContent = order.notes || 'No notes';
            
            // Items
            const itemsList = document.getElementById('modalItemsList');
            document.getElementById('modalItemsCount').textContent = items.length;
            itemsList.innerHTML = items.map(item => `
                <div class="bg-gray-50 p-3 rounded border">
                    <div class="font-semibold">${item.product_name}</div>
                    <div class="text-xs text-gray-500">SKU: ${item.sku||'N/A'}</div>
                    <div class="flex justify-between mt-1 text-sm">
                        <span>Qty: ${item.quantity}</span>
                        <span class="font-bold">₹${parseFloat(item.total_price).toFixed(2)}</span>
                    </div>
                    ${item.return_reason ? `<div class="text-xs text-red-500 mt-1">⚠ ${item.return_reason.replace('_',' ')}</div>` : ''}
                </div>
            `).join('');
            
            detailModal.classList.remove('hidden');
            detailModal.style.display = 'block';
        });
    });
    
    detailModal?.addEventListener('click', (e) => {
        if(e.target === detailModal || e.target.closest('[data-bs-dismiss="modal"]')) {
            detailModal.classList.add('hidden'); detailModal.style.display = 'none';
        }
    });
    
   
    
    cancelModal?.addEventListener('click', (e) => {
        if(e.target === cancelModal || e.target.closest('[data-bs-dismiss="modal"]')) {
            cancelModal.classList.add('hidden'); cancelModal.style.display = 'none';
        }
    });
    
    // Helpers
    function getStatusColor(s) {
        return { 'Initiated':'text-blue-600', 'Picked':'text-purple-600', 'In Transit':'text-yellow-600', 
                 'QC Pending':'text-orange-600', 'QC Completed':'text-indigo-600', 'Delivered':'text-green-600', 
                 'Cancelled':'text-red-600' }[s] || 'text-gray-600';
    }
    function formatDate(d) {
        if(!d) return 'N/A';
        return new Date(d).toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' });
    }
    function showToast(msg, type='info') {
        const t = document.createElement('div');
        t.className = `fixed bottom-4 right-4 px-4 py-3 rounded-lg shadow-lg text-white text-sm z-50 ${type==='success'?'bg-green-600':type==='danger'?'bg-red-600':'bg-gray-800'}`;
        t.innerHTML = `<i class="fa fa-${type==='success'?'check-circle':type==='danger'?'exclamation-circle':'info-circle'} mr-2"></i>${msg}`;
        document.body.appendChild(t);
        setTimeout(() => { t.style.opacity='0'; setTimeout(()=>t.remove(),300); }, 3000);
    }
    
    // Actions
    window.handleBulkUpload = () => showToast('Bulk upload coming soon!', 'info');
    window.exportCSV = () => showToast('Exporting CSV...', 'info');
    
    // CSRF for forms
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    if(csrf) document.querySelectorAll('form').forEach(f => {
        if(!f.querySelector('input[name="_token"]')) {
            const i = document.createElement('input'); i.type='hidden'; i.name='_token'; i.value=csrf; f.appendChild(i);
        }
    });
});
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection