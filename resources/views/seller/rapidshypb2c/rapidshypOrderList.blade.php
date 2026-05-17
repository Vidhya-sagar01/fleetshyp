@extends('seller.layouts.app')

@section('title', 'Orders')

@push('styles')
<style>
    :root {
        --golden: #D4AF37;
        --golden-dark: #B8941F;
        --golden-light: #fef3c7;
    }
    
    /* Status Tabs */
    .status-tab {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        background: transparent;
        color: #6b7280;
    }
    
    .status-tab.active {
        background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
    }
    
    .status-tab:hover:not(.active) {
        background: #f3f4f6;
        color: var(--golden-dark);
    }
    
    /* Buttons */
    .filter-btn {
        background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
    }
    
    .secondary-btn {
        background: white;
        color: #374151;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .secondary-btn:hover {
        background: #f9fafb;
        border-color: var(--golden);
        color: var(--golden-dark);
    }
    
    .create-order-btn {
        background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .create-order-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
    }
    
    /* Approve Button */
    .approve-btn {
        background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .approve-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
    }
    
    /* Action Menu Button */
    .action-menu-btn {
        width: 36px;
        height: 36px;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .action-menu-btn:hover {
        background: #f9fafb;
        border-color: var(--golden);
        color: var(--golden-dark);
    }
    
    /* Dropdown */
    .dropdown-menu {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 0.5rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        min-width: 200px;
        z-index: 50;
        opacity: 0;
        transform: scale(0.95);
        transition: all 0.2s;
        pointer-events: none;
        border: 1px solid #f3f4f6;
    }
    
    .dropdown-menu.show {
        opacity: 1;
        transform: scale(1);
        pointer-events: auto;
    }
    
    .dropdown-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #374151;
        font-size: 0.875rem;
        text-decoration: none;
    }
    
    .dropdown-item:hover {
        background: var(--golden-light);
        color: var(--golden-dark);
    }
    
    .dropdown-item i {
        color: var(--golden);
        width: 20px;
        text-align: center;
    }
    
    /* Table */
    .table-header {
        background: linear-gradient(135deg, #fef9f3 0%, #fef3c7 100%);
        border-bottom: 2px solid var(--golden-light);
    }
    
    .table-header th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--golden-dark);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .table-row {
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s;
    }
    
    .table-row:hover {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    }
    
    .table-cell {
        padding: 1rem;
        font-size: 0.875rem;
        color: #374151;
        vertical-align: middle;
    }
    
    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        gap: 0.375rem;
    }
    
    .badge-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }
    
    .badge-warning {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fcd34d;
    }
    
    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #f87171;
    }
    
    .badge-info {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #93c5fd;
    }
    
    /* Inputs */
    .date-range-input {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem 0.875rem;
        font-size: 0.875rem;
        color: #374151;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .date-range-input:focus {
        outline: none;
        border-color: var(--golden);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }
    
    .search-input {
        width: 100%;
        max-width: 400px;
        padding: 0.625rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--golden);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }
    
    /* Pagination */
    .bg-gradient-gold {
        background: linear-gradient(135deg, var(--golden) 0%, var(--golden-dark) 100%) !important;
    }
    
    .border-gold {
        border-color: var(--golden) !important;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state svg {
        max-width: 200px;
        margin: 0 auto 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-6">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <i class="fas fa-home text-[var(--golden)]"></i>
            <span>/</span>
            <span class="font-medium text-gray-700">Orders</span>
        </div>
        
        <!-- Top Controls -->
        <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
            <div class="flex items-center gap-2 overflow-x-auto pb-1">
                <button class="status-tab active whitespace-nowrap">Pending Approval <span class="ml-1">(0)</span></button>
                <button class="status-tab whitespace-nowrap">Processing <span class="ml-1">(0)</span></button>
                <button class="status-tab whitespace-nowrap">Partial <span class="ml-1">(0)</span></button>
                <button class="status-tab whitespace-nowrap">Cancelled <span class="ml-1">(1)</span></button>
                <button class="status-tab whitespace-nowrap">Closed <span class="ml-1">(2)</span></button>
                <button class="status-tab whitespace-nowrap">All <span class="ml-1">(5)</span></button>
            </div>
            
            <div class="relative">
                <button onclick="toggleCreateOrderDropdown()" class="create-order-btn">
                    <i class="fas fa-plus"></i>
                    <span>Create Order</span>
                    <i class="fas fa-chevron-down text-xs opacity-75"></i>
                </button>
                
                <div id="createOrderDropdown" class="dropdown-menu">
                    <div class="dropdown-item" onclick="window.location.href='{{ route('orders.create.single') }}'">
                        <i class="fas fa-file-invoice"></i>
                        <span>Single Order</span>
                    </div>
                    <div class="dropdown-item" onclick="window.location.href='#'">
                        <i class="fas fa-file-upload"></i>
                        <span>Bulk Order</span>
                    </div>
                    <div class="dropdown-item" onclick="window.location.href='#'">
                        <i class="fas fa-bolt"></i>
                        <span>Quick Order</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filters Bar -->
        <div class="flex items-center gap-3 mb-6 flex-wrap">
            <div class="flex items-center gap-2 bg-white rounded-lg p-1 border border-gray-200">
                <input type="text" class="date-range-input" placeholder="19/03/2026 - 18/04/2026" id="dateRange">
                <button class="secondary-btn !p-2" title="Refresh">
                    <i class="fas fa-redo"></i>
                </button>
            </div>
            
            <button class="filter-btn">
                <i class="fas fa-filter"></i>
                <span>More Filter</span>
            </button>
            
            <label class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg border border-gray-200 cursor-pointer hover:border-[var(--golden)] transition-colors">
                <input type="checkbox" class="w-4 h-4 text-[var(--golden)] rounded border-gray-300">
                <span class="text-sm font-medium text-gray-700">Select All</span>
            </label>
            
            <button class="secondary-btn">
                <i class="fas fa-download mr-2"></i>
                <span>Export</span>
            </button>
            
            <button class="secondary-btn">
                <i class="fas fa-book mr-2"></i>
                <span>Page Guide</span>
                <i class="fas fa-chevron-down text-xs ml-1"></i>
            </button>
        </div>
        
        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <input type="text" 
                       class="search-input" 
                       placeholder="Search AWB, Shipment ID, Order ID, Phone Number, Email">
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[var(--golden)] transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Orders Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="w-12">
                            <input type="checkbox" class="w-4 h-4 text-[var(--golden)] rounded border-gray-300">
                        </th>
                        <th>ORDER ID</th>
                        <th>ACTION</th>
                        <th>CHANNEL</th>
                        <th>CUSTOMER DETAILS</th>
                        <th>RTO RISK</th>
                        <th>PAYMENT INFO</th>
                        <th>STATUS</th>
                        <th>CREATED ON</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                    <tr class="table-row">
                        <td class="table-cell">
                            <input type="checkbox" class="w-4 h-4 text-[var(--golden)] rounded border-gray-300">
                        </td>
                        <td class="table-cell font-semibold text-gray-900">
                            {{ $order->order_id ?? 'ORD-001' }}
                        </td>
                        
                        <!-- ✅ FIXED ACTION Column - Clone buttons now appear in dropdown -->
                     <!-- ✅ ACTION Column - Matching your image -->
<td class="table-cell">
    <div class="flex items-center gap-2">
        <!-- View Shipment / Approve Button -->
        <button 
         class="btn btn-sm btn-primary assign-awb-btn"
         data-id="{{ $order->id }}">
           Approved
        </button>
        
        <!-- Three Dots Dropdown Menu -->
        <div class="relative" x-data="{ open: false }">
            <!-- Three Dot Button -->
            <button @click="open = !open" 
                    @click.away="open = false"
                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors cursor-pointer text-gray-400 hover:text-gray-600"
                    type="button">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                </svg>
            </button>

            <!-- ✅ Dropdown Menu - Positioned correctly -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                 style="display: none;">
                
                <!-- Clone Order -->
                <a href="#" 
                   target="_blank"
                   class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0">
                    Clone Order
                </a>
                
                <!-- Clone to B2B -->
                <a href="#" 
                   target="_blank"
                   class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    Clone to B2B
                </a>
            </div>
        </div>
    </div>
</td>
                        
                        <td class="table-cell">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-[var(--golden-light)] text-[var(--golden-dark)] border border-[var(--golden)]">
                                {{ $order->channel ?? 'DEFAULT' }}
                            </span>
                        </td>
                        <td class="table-cell">
                            <div class="text-sm font-medium text-gray-900">{{ $order->customer_name ?? 'Customer Name' }}</div>
                            <div class="text-xs text-gray-500">{{ $order->customer_email ?? 'email@example.com' }}</div>
                        </td>
                        <td class="table-cell">
                            @php
                                $rtoRisk = $order->rto_risk ?? 'low';
                                $badgeClass = $rtoRisk === 'high' ? 'badge-danger' : ($rtoRisk === 'medium' ? 'badge-warning' : 'badge-success');
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                <i class="fas fa-shield-alt"></i>
                                {{ ucfirst($rtoRisk) }}
                            </span>
                        </td>
                        <td class="table-cell">
                            <div class="text-sm font-medium">{{ $order->payment_method ?? 'COD' }}</div>
                            <div class="text-xs text-gray-500">₹{{ number_format($order->amount ?? 0, 2) }}</div>
                        </td>
                        <td class="table-cell">
                            @php
                                $status = $order->status ?? 'pending';
                                $statusClass = [
                                    'pending' => 'badge-warning',
                                    'processing' => 'badge-info',
                                    'shipped' => 'badge-info',
                                    'delivered' => 'badge-success',
                                    'cancelled' => 'badge-danger'
                                ][$status] ?? 'badge-warning';
                            @endphp
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="table-cell text-sm text-gray-500">
                            {{ $order->created_at ? $order->created_at->format('d/m/Y') : date('d/m/Y') }}
                        </td>
                    </tr>
                    @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-6">
                                    <circle cx="100" cy="100" r="80" fill="#FEF3C7"/>
                                    <path d="M70 70H130V130H70V70Z" fill="#D4AF37" opacity="0.3"/>
                                    <rect x="85" y="85" width="30" height="30" fill="#D4AF37"/>
                                    <circle cx="140" cy="60" r="15" fill="#EF4444"/>
                                    <text x="140" y="65" text-anchor="middle" fill="white" font-size="16" font-weight="bold">!</text>
                                    <path d="M60 140L75 155L95 135" stroke="#D4AF37" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Oops, Nothing Here!</h3>
                                <p class="text-gray-500 text-sm mb-4">No orders found matching your criteria</p>
                                <button onclick="window.location.href='{{ route('orders.create.single') }}'" class="filter-btn">
                                    <i class="fas fa-plus"></i>
                                    <span>Create Your First Order</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(isset($orders) && count($orders) > 0)
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 flex-wrap gap-3">
            <div class="flex items-center gap-2">
                <button class="secondary-btn !px-3" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="secondary-btn !px-3 bg-gradient-gold text-white border-gold">1</button>
                <button class="secondary-btn !px-3">2</button>
                <button class="secondary-btn !px-3">3</button>
                <span class="text-gray-400">...</span>
                <button class="secondary-btn !px-3">10</button>
                <button class="secondary-btn !px-3">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">Result per page:</span>
                <select class="date-range-input !py-1 !px-3">
                    <option value="20">20</option>
                    <option value="50" selected>50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<!-- ✅ Alpine.js CDN - Required for dropdowns to work -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

<script>
// Toggle Create Order Dropdown
function toggleCreateOrderDropdown() {
    const dropdown = document.getElementById('createOrderDropdown');
    dropdown.classList.toggle('show');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('createOrderDropdown');
    const button = event.target.closest('.create-order-btn');
    
    if (!button && dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
    }
});

// Status Tab Click Handler
document.querySelectorAll('.status-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.status-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const status = this.textContent.split('(')[0].trim();
        filterOrdersByStatus(status);
    });
});

function filterOrdersByStatus(status) {
    console.log('Filtering by status:', status);
}

// Date Range Picker
document.getElementById('dateRange')?.addEventListener('click', function() {
    console.log('Open date range picker');
});



// ✅ Approve Order Function
function approveOrder(orderId) {
    if(confirm('Are you sure you want to approve this order?')) {
        // Add your AJAX call or redirect here
        console.log('Approving order:', orderId);
        // Example: window.location.href = '/orders/' + orderId + '/approve';
    }
}


$(document).on('click', '.assign-awb-btn', function () {
    let orderId = $(this).data('id');

    if (!confirm('Assign AWB to this order?')) return;

    $.ajax({
        url: '/seller/orders/' + orderId + '/assign-awb',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            if (res.success) {
                alert('AWB Assigned: ' + res.awb);
                location.reload();
            } else {
                alert(res.message);
            }
        },
        error: function (xhr) {
            alert('Error occurred');
        }
    });
});
</script>
@endpush