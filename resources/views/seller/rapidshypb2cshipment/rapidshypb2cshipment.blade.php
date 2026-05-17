@extends('seller.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header & Breadcrumb -->
    <div class="flex items-center justify-between">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('seller.dashboard') }}" class="text-gray-600 hover:text-[#D4AF37] transition-colors">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                </li>
                <li>
                    <span class="text-gray-400 mx-2">/</span>
                </li>
                <li>
                    <span class="text-gray-900 font-medium">Shipments</span>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Status Tabs -->
    <div class="bg-white rounded-lg shadow-sm p-1">
        <div class="flex space-x-1 overflow-x-auto scrollbar-hide">
            @php
                $statuses = [
                    'pending' => ['label' => 'Pending', 'count' => $counts['pending'] ?? 0],
                    'processing' => ['label' => 'Processing', 'count' => $counts['processing'] ?? 0],
                    'awb_assigned' => ['label' => 'AWB Assigned', 'count' => $counts['awb_assigned'] ?? 0],
                    'ready_to_ship' => ['label' => 'Ready To Ship', 'count' => $counts['ready_to_ship'] ?? 0],
                    'shipped' => ['label' => 'Shipped', 'count' => $counts['shipped'] ?? 0],
                    'in_transit' => ['label' => 'In Transit', 'count' => $counts['in_transit'] ?? 0],
                    'delivered' => ['label' => 'Delivered', 'count' => $counts['delivered'] ?? 0],
                    'rto' => ['label' => 'RTO', 'count' => $counts['rto'] ?? 0],
                    'exception' => ['label' => 'Exception', 'count' => $counts['exception'] ?? 0],
                    'cancelled' => ['label' => 'Cancelled', 'count' => $counts['cancelled'] ?? 0],
                    'all' => ['label' => 'All', 'count' => $counts['all'] ?? 0],
                ];
            @endphp

            @foreach($statuses as $key => $status)
                <button 
                    onclick="filterByStatus('{{ $key }}')"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-all whitespace-nowrap
                        {{ ($status ?? 'pending') === $key 
                            ? 'bg-[#D4AF37] text-white' 
                            : 'text-gray-600 hover:bg-gray-100' }}"
                >
                    {{ $status['label'] }} ({{ $status['count'] }})
                </button>
            @endforeach
        </div>
    </div>

    <!-- Filters & Actions Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <!-- Date Filter -->
                <div class="flex items-center gap-2">
                    <select id="dateFilterType" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">
                        <option value="created">Created Date</option>
                        <option value="updated">Updated Date</option>
                    </select>
                    <input type="date" id="dateFrom" value="{{ $dateFrom ?? '' }}" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">
                    <span class="text-gray-500">~</span>
                    <input type="date" id="dateTo" value="{{ $dateTo ?? '' }}" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">
                    <button onclick="applyFilters()" class="p-2 text-gray-600 hover:text-[#D4AF37] transition-colors">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                <!-- Search -->
                <input type="text" id="searchInput" placeholder="Search AWB, Order ID..." value="{{ $search ?? '' }}"
                    class="px-3 py-2 border border-gray-300 rounded-md text-sm w-48 focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">

                <!-- More Filters -->
                <button onclick="toggleMoreFilters()" class="px-4 py-2 bg-[#D4AF37] text-white rounded-md text-sm font-medium hover:bg-[#b8941f] transition-colors">
                    <i class="fas fa-filter mr-2"></i>More Filters
                </button>

                <!-- Download -->
                <div class="flex items-center gap-2">
                    <button onclick="exportShipments()" class="p-2 bg-[#D4AF37] text-white rounded-md hover:bg-[#b8941f] transition-colors">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>

            <!-- Page Guide -->
            <button onclick="showPageGuide()" class="px-4 py-2 bg-purple-50 text-[#D4AF37] rounded-md text-sm font-medium hover:bg-purple-100 transition-colors">
                <i class="fas fa-book-open mr-2"></i>Guide
            </button>
        </div>

        <!-- More Filters Panel -->
        <div id="moreFiltersPanel" class="hidden mt-4 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Courier</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">
                        <option value="">All Couriers</option>
                        <option value="bluedart">BlueDart</option>
                        <option value="delhivery">Delhivery</option>
                        <option value="ecom">Ecom Express</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">
                        <option value="">All</option>
                        <option value="cod">COD</option>
                        <option value="prepaid">Prepaid</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Channel</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">
                        <option value="">All</option>
                        <option value="default">DEFAULT</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Weight</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">
                        <option value="">Any</option>
                        <option value="0-1">0-1 kg</option>
                        <option value="1-5">1-5 kg</option>
                        <option value="5+">5+ kg</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="flex items-center justify-between bg-white rounded-lg shadow-sm p-3">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" id="selectAll" class="w-4 h-4 text-[#D4AF37] border-gray-300 rounded focus:ring-[#D4AF37]" onchange="toggleSelectAll()">
            <span class="text-sm font-medium text-gray-700">Select All</span>
        </label>
        
        <div class="flex items-center gap-3">
            <select id="bulkAction" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">
                <option value="">Bulk Action</option>
                <option value="label">Reprint Labels</option>
                <option value="manifest">Generate Manifest</option>
                <option value="cancel">Cancel Selected</option>
            </select>
            <button onclick="applyBulkAction()" class="px-4 py-2 bg-[#D4AF37] text-white rounded-md text-sm font-medium hover:bg-[#b8941f] transition-colors">
                Apply
            </button>
        </div>
    </div>

    <!-- Shipments Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                            <input type="checkbox" class="w-4 h-4 text-[#D4AF37] border-gray-300 rounded focus:ring-[#D4AF37]" onchange="toggleSelectAll()">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shipment</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($shipments as $shipment)
                    <tr class="hover:bg-gray-50 transition-colors" data-shipment-id="{{ $shipment->shipment_id }}">
                        <!-- Checkbox -->
                        <td class="px-4 py-4">
                            <input type="checkbox" name="shipment_ids[]" value="{{ $shipment->shipment_id }}" 
                                class="shipment-checkbox w-4 h-4 text-[#D4AF37] border-gray-300 rounded focus:ring-[#D4AF37]">
                        </td>

                        <!-- Shipment Details -->
                        <td class="px-4 py-4">
                            <div class="space-y-1">
                                <div class="font-semibold text-sm text-gray-900">
                                    {{ $shipment->awb ?? 'S'.strtoupper(substr(md5($shipment->id), 0, 8)) }}
                                </div>
                                <div class="text-xs text-gray-600">
                                    Order: <span class="text-[#D4AF37] cursor-pointer" onclick="viewOrder('{{ $shipment->order_id }}')">{{ $shipment->order_id }}</span>
                                </div>
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $shipment->pickup_address_name ?? 'Main Warehouse' }}
                                </div>
                                @if(($shipment->payment_method ?? '') === 'COD')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-[#D4AF37]">
                                    <i class="fas fa-shield-alt mr-1"></i>COD
                                </span>
                                @endif
                            </div>
                        </td>

                        <!-- Action -->
                        <td class="px-4 py-4">
                            @php
                                $orderStatus = $shipment->order_status ?? 'PENDING';
                            @endphp

                            @if(in_array($orderStatus, ['PENDING', 'PROCESSING']))
                                <button onclick="openShipNowModal('{{ $shipment->shipment_id }}', '{{ $shipment->order_id }}')" 
                                    class="px-4 py-2 bg-[#D4AF37] text-white text-sm font-medium rounded-md hover:bg-[#b8941f] transition-colors">
                                     Ship  Now
                                </button>
                            @elseif($orderStatus === 'AWB_ASSIGNED')
                                <button onclick="schedulePickup('{{ $shipment->shipment_id }}')" 
                                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors">
                                    Schedule Pickup
                                </button>
                            @else
                                <span class="text-sm text-gray-500">No Action</span>
                            @endif
                            
                            <!-- Three Dot Menu -->
                            <div class="relative inline-block ml-2">
                                <button onclick="toggleActionMenu({{ $shipment->id }})" class="p-1 text-gray-400 hover:text-gray-600 transition-colors">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div id="actionMenu{{ $shipment->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                    <a href="#" onclick="viewDetails('{{ $shipment->shipment_id }}')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-eye mr-2 text-gray-400"></i>View Details
                                    </a>
                                    @if($shipment->label_url)
                                    <a href="{{ $shipment->label_url }}" target="_blank" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-print mr-2 text-gray-400"></i>Download Label
                                    </a>
                                    @endif
                                    <a href="#" onclick="trackShipment('{{ $shipment->shipment_id }}')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-truck mr-2 text-gray-400"></i>Track Shipment
                                    </a>
                                    @if(in_array($orderStatus, ['PENDING', 'PROCESSING']))
                                    <div class="border-t border-gray-200 my-1"></div>
                                    <a href="#" onclick="cancelShipment('{{ $shipment->shipment_id }}')" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-times mr-2"></i>Cancel
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Customer Details -->
                        <td class="px-4 py-4">
                            <div class="space-y-1">
                                @php
                                    $shippingAddr = is_string($shipment->shipping_address) ? json_decode($shipment->shipping_address, true) : $shipment->shipping_address;
                                @endphp
                                <div class="text-sm font-medium text-gray-900">{{ $shippingAddr['firstName'] ?? 'N/A' }} {{ $shippingAddr['lastName'] ?? '' }}</div>
                                <div class="flex items-center gap-3 text-xs text-gray-600">
                                    <span title="{{ $shippingAddr['email'] ?? '' }}"><i class="fas fa-envelope"></i></span>
                                    <span title="{{ $shippingAddr['phone'] ?? '' }}"><i class="fas fa-phone"></i></span>
                                    <span title="{{ $shippingAddr['addressLine1'] ?? '' }}"><i class="fas fa-home"></i></span>
                                </div>
                            </div>
                        </td>

                        <!-- Package Details -->
                        <td class="px-4 py-4">
                            <div class="text-xs space-y-1">
                                @php
                                    $pkg = is_string($shipment->package_details) ? json_decode($shipment->package_details, true) : $shipment->package_details;
                                @endphp
                                <div class="text-gray-900">Wt: {{ $pkg['packageWeight'] ?? '0' }} kg</div>
                                <div class="text-gray-600">
                                    {{ $pkg['packageLength'] ?? '0' }}×{{ $pkg['packageBreadth'] ?? '0' }}×{{ $pkg['packageHeight'] ?? '0' }} cm
                                </div>
                            </div>
                        </td>

                        <!-- Payment Info -->
                        <td class="px-4 py-4">
                            <div class="space-y-1">
                                <div class="text-sm font-medium text-gray-900">₹{{ number_format($shipment->total_order_value ?? 0, 2) }}</div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ ($shipment->payment_method ?? 'PREPAID') === 'COD' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ strtoupper($shipment->payment_method ?? 'PREPAID') }}
                                </span>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-4">
                            @php
                                $statusMap = [
                                    'PENDING' => ['class' => 'bg-yellow-100 text-yellow-800', 'label' => 'PENDING'],
                                    'PROCESSING' => ['class' => 'bg-blue-100 text-blue-800', 'label' => 'PROCESSING'],
                                    'AWB_ASSIGNED' => ['class' => 'bg-indigo-100 text-indigo-800', 'label' => 'AWB ASSIGNED'],
                                    'READY_TO_SHIP' => ['class' => 'bg-green-100 text-green-800', 'label' => 'READY TO SHIP'],
                                    'SHIPPED' => ['class' => 'bg-purple-100 text-purple-800', 'label' => 'SHIPPED'],
                                    'IN_TRANSIT' => ['class' => 'bg-cyan-100 text-cyan-800', 'label' => 'IN TRANSIT'],
                                    'DELIVERED' => ['class' => 'bg-green-100 text-green-800', 'label' => 'DELIVERED'],
                                    'RTO' => ['class' => 'bg-red-100 text-red-800', 'label' => 'RTO'],
                                    'EXCEPTION' => ['class' => 'bg-orange-100 text-orange-800', 'label' => 'EXCEPTION'],
                                    'CANCELLED' => ['class' => 'bg-gray-100 text-gray-800', 'label' => 'CANCELLED'],
                                ];
                                $statusInfo = $statusMap[$shipment->order_status ?? 'PENDING'] ?? $statusMap['PENDING'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium {{ $statusInfo['class'] }}">
                                {{ $statusInfo['label'] }}
                            </span>
                        </td>

                        <!-- Created On -->
                        <td class="px-4 py-4">
                            <div class="text-xs space-y-1">
                                <div class="text-gray-900">{{ \Carbon\Carbon::parse($shipment->created_at)->format('d M Y') }}</div>
                                <div class="text-gray-500">{{ \Carbon\Carbon::parse($shipment->created_at)->format('h:i A') }}</div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-box-open text-6xl mb-4"></i>
                                <p class="text-lg font-medium text-gray-600">No shipments found</p>
                                <p class="text-sm">Create a new order to get started</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($shipments) && count($shipments) > 0)
        <div class="flex items-center justify-between px-4 py-3 border-t border-gray-200">
            <div class="flex items-center gap-2">
                <button onclick="changePage('prev')" class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50 disabled:opacity-50" {{ ($currentPage ?? 1) <= 1 ? 'disabled' : '' }}>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="px-3 py-1 bg-[#D4AF37] text-white rounded-md text-sm font-medium">{{ $currentPage ?? 1 }}</span>
                <button onclick="changePage('next')" class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Per page:</span>
                <select onchange="changePerPage(this.value)" class="px-2 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37]">
                    <option value="20" {{ ($perPage ?? 20) == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ ($perPage ?? 20) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ ($perPage ?? 20) == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Ship Now Modal (Right Sidebar) -->
<div id="shipNowModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeShipNowModal()"></div>
    
    <!-- Modal Content -->
    <div class="absolute right-0 top-0 h-full w-full max-w-6xl bg-white shadow-2xl transform transition-transform translate-x-full" id="shipNowModalContent">
        <div class="flex h-full">
            <!-- Left Sidebar - Shipment Info -->
            <div class="w-80 bg-gray-50 border-r border-gray-200 p-6 overflow-y-auto">
                <div class="space-y-6">
                    <!-- Shipment Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipment Details</h3>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-500">Shipment ID</span>
                                    <p class="font-semibold text-[#D4AF37]" id="modalShipmentId">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Order ID</span>
                                    <p class="text-gray-900" id="modalOrderId">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Addresses</h3>
                        <div class="bg-white rounded-lg p-4 border border-gray-200 space-y-4">
                            <!-- Pickup -->
                            <div class="relative">
                                <div class="absolute -left-3 top-0 w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-gray-600 text-xs"></i>
                                </div>
                                <div class="pl-6">
                                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Pickup</span>
                                    <p class="text-xs text-gray-600 mt-1" id="pickupAddress">-</p>
                                </div>
                            </div>
                            
                            <!-- Destination -->
                            <div class="relative">
                                <div class="absolute -left-3 top-0 w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-location-arrow text-gray-600 text-xs"></i>
                                </div>
                                <div class="pl-6">
                                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Destination</span>
                                    <p class="text-xs text-gray-600 mt-1" id="deliveryAddress">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipment Value -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipment Value</h3>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <div class="text-right mb-3 pb-3 border-b border-gray-200">
                                <span class="text-sm text-gray-600">Shipment Value</span>
                                <p class="text-lg font-bold text-gray-900">₹<span id="shipmentValue">0.00</span></p>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Dead Weight:</span>
                                    <span class="font-medium" id="deadWeight">0.000 kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Vol. Weight:</span>
                                    <span class="font-medium" id="volWeight">0.000 kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Applied Weight:</span>
                                    <span class="font-medium" id="appliedWeight">0.000 kg</span>
                                </div>
                                <div class="flex justify-between pt-2 border-t border-gray-200">
                                    <span class="text-gray-600">Payment Type:</span>
                                    <span class="font-medium" id="paymentType">PREPAID</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content - Courier Selection -->
            <div class="flex-1 p-6 overflow-y-auto">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <button onclick="closeShipNowModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-times text-xl text-gray-600"></i>
                        </button>
                        <h2 class="text-2xl font-bold text-gray-900">Select Courier</h2>
                    </div>
                </div>

                <!-- Loading State -->
                <div id="courierLoading" class="hidden text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-[#D4AF37] border-t-transparent"></div>
                    <p class="mt-4 text-gray-600">Fetching available couriers...</p>
                </div>

                <!-- Error State -->
                <div id="courierError" class="hidden text-center py-12 text-red-600">
                    <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                    <p id="courierErrorMsg">Failed to load couriers</p>
                    <button onclick="loadCouriers()" class="mt-4 px-4 py-2 bg-[#D4AF37] text-white rounded-md text-sm hover:bg-[#b8941f]">Retry</button>
                </div>

                <!-- Courier Table -->
                <div id="courierTableContainer" class="hidden">
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer">
                                        COURIER <i class="fas fa-sort ml-1"></i>
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">MODE</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">CUTOFF</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">WEIGHT</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer">
                                        RATE (₹) <i class="fas fa-sort ml-1"></i>
                                    </th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">ASSIGN</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="courierTableBody">
                                <!-- Courier rows loaded dynamically -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Note -->
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-gray-700">
                            <strong>Note:</strong> Amount shown is inclusive of Freight Charges, COD charges (if applicable) and GST. 
                            Ekart, Blue Dart, Velex & Blitz currently do not support alternate addresses for RTO.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Products Modal -->
<div id="viewProductsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[80vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Order Products</h3>
                <button onclick="closeModal('viewProductsModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="productsContent" class="space-y-3">
                <!-- Products loaded via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

const ROUTE_CHECK_SERVICEABILITY = "{{ route('rapidshyp.b2c.orders.check-serviceability') }}";
const ROUTE_SHIPPING_DETAILS = "{{ url('seller/shipping') }}/:id/details";
const ROUTE_ORDER_DETAILS_BASE = "{{  route('rapidshyp.b2c.orders.index')}}";

// Global variables for modal
let currentShipmentId = null;
let currentOrderId = null;
let currentPickupPincode = null;
let currentDeliveryPincode = null;
let currentOrderValue = 2000;
let currentWeight = 1;
let currentIsCod = false;

// ✅ Ship Now Modal
async function openShipNowModal(shipmentId, orderId) {
    currentShipmentId = shipmentId;
    currentOrderId = orderId;
    
    const modal = document.getElementById('shipNowModal');
    const modalContent = document.getElementById('shipNowModalContent');
    
    document.getElementById('modalShipmentId').textContent = shipmentId;
    document.getElementById('modalOrderId').textContent = orderId;
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('translate-x-full');
    }, 10);
    
    await loadShipmentDetails(shipmentId);
    await loadCouriers();
}

// ✅ Load shipment details
async function loadShipmentDetails(shipmentId) {
    try {
        const url = `${ROUTE_SHIPPING_BASE}/${shipmentId}/details`;
        const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
        
        if (response.ok) {
            const data = await response.json();
            populateShipmentDetails(data);
        } else {
            populateShipmentDetailsFromRow(shipmentId);
        }
    } catch (error) {
        console.error('Failed to load shipment details:', error);
        populateShipmentDetailsFromRow(shipmentId);
    }
}

// Populate modal with shipment data
function populateShipmentDetails(data) {
    const pickupAddr = [
        data.pickup_address_name || 'Main Warehouse',
        data.pickup_location?.pickupAddress1 || '',
        data.pickup_location?.city || '',
        data.pickup_location?.pinCode || ''
    ].filter(Boolean).join(', ');
    document.getElementById('pickupAddress').textContent = pickupAddr || 'Not specified';
    currentPickupPincode = data.pickup_location?.pinCode || '';
    
    const shippingAddr = data.shipping_address || {};
    const deliveryAddr = [
        `${shippingAddr.firstName || ''} ${shippingAddr.lastName || ''}`.trim(),
        shippingAddr.addressLine1 || '',
        shippingAddr.addressLine2 || '',
        shippingAddr.city || '',
        shippingAddr.pinCode || ''
    ].filter(Boolean).join(', ');
    document.getElementById('deliveryAddress').textContent = deliveryAddr || 'Not specified';
    currentDeliveryPincode = shippingAddr.pinCode || '';
    
    const pkg = data.package_details || {};
    document.getElementById('shipmentValue').textContent = (data.total_order_value || 0).toFixed(2);
    document.getElementById('deadWeight').textContent = `${(pkg.packageWeight || 0).toFixed(3)} kg`;
    document.getElementById('volWeight').textContent = '0.000 kg';
    document.getElementById('appliedWeight').textContent = `${(pkg.packageWeight || 0).toFixed(3)} kg`;
    
    currentIsCod = data.payment_method === 'COD';
    document.getElementById('paymentType').textContent = data.payment_method || 'PREPAID';
    
    currentOrderValue = data.total_order_value || 2000;
    currentWeight = pkg.packageWeight || 1;
}

// Fallback: Extract data from table row
function populateShipmentDetailsFromRow(shipmentId) {
    const row = document.querySelector(`tr[data-shipment-id="${shipmentId}"]`) || 
                Array.from(document.querySelectorAll('tbody tr')).find(tr => 
                    tr.innerHTML.includes(shipmentId)
                );
    
    if (row) {
        document.getElementById('pickupAddress').textContent = 'Main Warehouse';
        document.getElementById('deliveryAddress').textContent = 'Customer Address';
        document.getElementById('shipmentValue').textContent = '0.00';
        document.getElementById('deadWeight').textContent = '1.000 kg';
        document.getElementById('appliedWeight').textContent = '1.000 kg';
        document.getElementById('paymentType').textContent = 'PREPAID';
    }
}

// ✅ Load couriers via checkServiceability
async function loadCouriers() {
    const loading = document.getElementById('courierLoading');
    const error = document.getElementById('courierError');
    const tableContainer = document.getElementById('courierTableContainer');
    const tableBody = document.getElementById('courierTableBody');
    
    loading.classList.remove('hidden');
    error.classList.add('hidden');
    tableContainer.classList.add('hidden');
    tableBody.innerHTML = '';
    
    try {
        const response = await fetch(ROUTE_CHECK_SERVICEABILITY, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                pickup_warehouse_id: null,
                pickup_pincode: (currentPickupPincode || '110001').toString().padStart(6, '0').slice(0, 6),
                delivery_pincode: (currentDeliveryPincode || '110001').toString().padStart(6, '0').slice(0, 6),
                cod: currentIsCod,
                total_order_value: currentOrderValue,
                weight: currentWeight
            })
        });
        
        const data = await response.json();
        
        if (data.status === true) {
            const couriers = data.serviceable_courier_list || [];
            
            if (couriers.length > 0) {
                couriers.forEach(courier => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-4">
                            <div class="font-bold text-lg">${courier.courier_name || 'Unknown'}</div>
                            <div class="text-sm text-gray-600">${courier.parent_courier_name || ''} ${courier.freight_mode || 'Surface'}</div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600">${courier.freight_mode || 'Surface'}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">${courier.cutoff_time || 'N/A'}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">
                            ${courier.min_weight || 0} - ${courier.max_weight || 5000} kg
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-[#D4AF37]">₹${(courier.total_freight || 0).toFixed(2)}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <button onclick="assignCourier('${courier.courier_code}', '${courier.courier_name}')" 
                                class="px-4 py-2 bg-[#D4AF37] text-white text-sm font-medium rounded-md hover:bg-[#b8941f] transition-colors">
                                Assign
                            </button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
                
                tableContainer.classList.remove('hidden');
            } else {
                showError('No couriers available for this pincode combination.');
            }
        } else {
            showError(data.remark || 'Serviceability check failed');
        }
    } catch (error) {
        console.error('Courier load error:', error);
        showError('Failed to fetch couriers. Please try again.');
    } finally {
        loading.classList.add('hidden');
    }
}

function showError(message) {
    document.getElementById('courierLoading').classList.add('hidden');
    document.getElementById('courierTableContainer').classList.add('hidden');
    const error = document.getElementById('courierError');
    document.getElementById('courierErrorMsg').textContent = message;
    error.classList.remove('hidden');
}

function closeShipNowModal() {
    const modal = document.getElementById('shipNowModal');
    const modalContent = document.getElementById('shipNowModalContent');
    
    modalContent.classList.add('translate-x-full');
    setTimeout(() => {
        modal.classList.add('hidden');
        currentShipmentId = null;
        currentOrderId = null;
    }, 300);
}

// ✅ Assign courier
function assignCourier(courierCode, courierName) {
    if (!currentShipmentId) return;
    if (!confirm(`Assign ${courierName} to this shipment?`)) return;
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Assigning...';
    
    const url = `${ROUTE_SHIPPING_BASE}/${currentShipmentId}/assign-awb`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({ courier_code: courierCode })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(`✅ AWB Assigned: ${data.awb}\nCourier: ${data.courier}`);
            closeShipNowModal();
            location.reload();
        } else {
            alert('❌ Error: ' + (data.message || 'Assignment failed'));
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Failed to assign AWB');
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

// Close action menus when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative.inline-block')) {
        document.querySelectorAll('[id^="actionMenu"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});

function toggleActionMenu(shipmentId) {
    document.querySelectorAll('[id^="actionMenu"]').forEach(menu => {
        if (menu.id !== 'actionMenu' + shipmentId) {
            menu.classList.add('hidden');
        }
    });
    const menu = document.getElementById('actionMenu' + shipmentId);
    menu.classList.toggle('hidden');
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    document.querySelectorAll('.shipment-checkbox').forEach(cb => cb.checked = selectAll.checked);
}

function filterByStatus(status) {
    const url = new URL(window.location.href);
    url.searchParams.set('status', status);
    window.location.href = url.toString();
}

function toggleMoreFilters() {
    document.getElementById('moreFiltersPanel').classList.toggle('hidden');
}

function applyFilters() {
    const url = new URL(window.location.href);
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    const search = document.getElementById('searchInput').value;
    
    if (dateFrom) url.searchParams.set('date_from', dateFrom);
    if (dateTo) url.searchParams.set('date_to', dateTo);
    if (search) url.searchParams.set('search', search);
    
    window.location.href = url.toString();
}

function exportShipments() {
    alert('Export functionality will be implemented');
}

function showPageGuide() {
    alert('Page guide will be shown here');
}

function applyBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const selected = Array.from(document.querySelectorAll('.shipment-checkbox:checked')).map(cb => cb.value);
    
    if (!action) { alert('Please select an action'); return; }
    if (selected.length === 0) { alert('Please select at least one shipment'); return; }
    
    console.log('Bulk action:', action, 'on:', selected);
    alert(`Applying "${action}" to ${selected.length} shipments`);
}

// ✅ Schedule pickup
function schedulePickup(shipmentId) {
    if (!confirm('Schedule pickup for this shipment?')) return;
    
    const url = `${ROUTE_SHIPPING_BASE}/${shipmentId}/schedule-pickup`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('✅ Pickup scheduled successfully!');
            location.reload();
        } else {
            alert('❌ Error: ' + data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Failed to schedule pickup');
    });
}

// ✅ View details
function viewDetails(shipmentId) {
    window.location.href = `${ROUTE_SHIPPING_BASE}/${shipmentId}`;
}

// ✅ Track shipment
function trackShipment(shipmentId) {
    window.location.href = `${ROUTE_SHIPPING_BASE}/${shipmentId}/tracking`;
}

// ✅ Cancel shipment
function cancelShipment(shipmentId) {
    if (!confirm('Are you sure you want to cancel this shipment?')) return;
    
    const url = `${ROUTE_SHIPPING_BASE}/${shipmentId}/cancel`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('✅ Shipment cancelled!');
            location.reload();
        } else {
            alert('❌ Error: ' + data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Failed to cancel shipment');
    });
}

// ✅ View products
function viewProducts(shipmentId) {
    const modal = document.getElementById('viewProductsModal');
    const content = document.getElementById('productsContent');
    
    modal.classList.remove('hidden');
    content.innerHTML = '<p class="text-gray-500">Loading products...</p>';
    
    const url = `${ROUTE_SHIPPING_BASE}/${shipmentId}/products`;
    
    fetch(url)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.items.length > 0) {
                content.innerHTML = data.items.map(item => `
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <div>
                            <div class="font-medium text-sm">${item.item_name}</div>
                            <div class="text-xs text-gray-500">SKU: ${item.sku || 'N/A'}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium">₹${item.unit_price}</div>
                            <div class="text-xs text-gray-500">Qty: ${item.units}</div>
                        </div>
                    </div>
                `).join('');
            } else {
                content.innerHTML = '<p class="text-gray-500">No products found</p>';
            }
        })
        .catch(() => {
            content.innerHTML = '<p class="text-red-500">Failed to load products</p>';
        });
}

// ✅ View order helper
function viewOrder(orderId) {
    window.location.href = `${ROUTE_ORDER_DETAILS_BASE}/${orderId}/details`;
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function changePage(direction) {
    const url = new URL(window.location.href);
    const current = {{ $currentPage ?? 1 }};
    const newPage = direction === 'next' ? current + 1 : current - 1;
    if (newPage >= 1) {
        url.searchParams.set('page', newPage);
        window.location.href = url.toString();
    }
}

function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

// Set default date range (last 30 days)
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(today.getDate() - 30);
    
    document.getElementById('dateFrom').value = thirtyDaysAgo.toISOString().split('T')[0];
    document.getElementById('dateTo').value = today.toISOString().split('T')[0];
});
</script>

<!-- Spinner CSS -->
<style>
.spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s linear infinite;
    vertical-align: middle;
    margin-right: 4px;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
@endpush