@extends('seller.layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Alert Messages --}}
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

    {{-- Filter Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gradient-cream">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-gold flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fa fa-filter text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Filters</h3>
                        <p class="text-xs text-gray-500 hidden sm:block">Refine your order search</p>
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
                <form action="{{ route('orders.index') }}" method="GET" id="filterForm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Order Date</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="order_date" class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Select range" value="{{ request('order_date') }}" id="orderDateRange">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">AWB Date</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="awb_date" class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Select range" value="{{ request('awb_date') }}" id="awbDateRange">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Status Date</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="status_date" class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Select range" value="{{ request('status_date') }}" id="statusDateRange">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Search Order</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fa fa-search"></i></span>
                                <input type="text" name="search_order" class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Order ID or AWB" value="{{ request('search_order') }}">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Customer</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fa fa-user"></i></span>
                                <input type="text" name="customer_search" class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Name or Phone" value="{{ request('customer_search') }}">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Courier</label>
                            <select name="courier" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Couriers</option>
                                <option value="amazon"     {{ request('courier')=='amazon'     ?'selected':'' }}>Amazon New</option>
                                <option value="bluedart"   {{ request('courier')=='bluedart'   ?'selected':'' }}>Bluedart Air Prime</option>
                                <option value="delhivery"  {{ request('courier')=='delhivery'  ?'selected':'' }}>Delhivery</option>
                                <option value="shadowfax"  {{ request('courier')=='shadowfax'  ?'selected':'' }}>Shadowfax</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Product/SKU</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fa fa-box"></i></span>
                                <input type="text" name="product_search" class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Product or SKU" value="{{ request('product_search') }}">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Pickup Address</label>
                            <select name="pickup_address" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Addresses</option>
                                <option value="veda"  {{ request('pickup_address')=='veda'  ?'selected':'' }}>Veda Herbal</option>
                                <option value="vaida" {{ request('pickup_address')=='vaida' ?'selected':'' }}>Vaida Herbal</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Store</label>
                            <select name="store" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Stores</option>
                                <option value="shopify"     {{ request('store')=='shopify'     ?'selected':'' }}>Shopify</option>
                                <option value="woocommerce" {{ request('store')=='woocommerce' ?'selected':'' }}>WooCommerce</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Status</label>
                            <select name="status" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Status</option>
                                <option value="NEW"        {{ request('status')=='NEW'        ?'selected':'' }}>New</option>
                                <option value="booked"     {{ request('status')=='booked'     ?'selected':'' }}>Booked</option>
                                <option value="manifested" {{ request('status')=='manifested' ?'selected':'' }}>Manifested</option>
                                <option value="delivered"  {{ request('status')=='delivered'  ?'selected':'' }}>Delivered</option>
                                <option value="rto"        {{ request('status')=='rto'        ?'selected':'' }}>RTO</option>
                                <option value="cancelled"  {{ request('status')=='cancelled'  ?'selected':'' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Payment Mode</label>
                            <select name="payment_mode" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Payments</option>
                                <option value="cod"     {{ request('payment_mode')=='cod'     ?'selected':'' }}>COD</option>
                                <option value="prepaid" {{ request('payment_mode')=='prepaid' ?'selected':'' }}>Prepaid</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">WhatsApp Status</label>
                            <select name="whatsapp_status" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All</option>
                                <option value="confirmed" {{ request('whatsapp_status')=='confirmed' ?'selected':'' }}>Confirmed</option>
                                <option value="cancelled" {{ request('whatsapp_status')=='cancelled' ?'selected':'' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">IVR Status</label>
                            <select name="ivr_status" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All</option>
                                <option value="contacted"     {{ request('ivr_status')=='contacted'     ?'selected':'' }}>Contacted</option>
                                <option value="not_contacted" {{ request('ivr_status')=='not_contacted' ?'selected':'' }}>Not Contacted</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Tags</label>
                            <select name="tags[]" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white" multiple>
                                <option value="order_confirmed" {{ in_array('order_confirmed', request('tags', [])) ?'selected':'' }}>Order Confirmed</option>
                                <option value="call_back"       {{ in_array('call_back',       request('tags', [])) ?'selected':'' }}>Call Back Later</option>
                                <option value="urgent"          {{ in_array('urgent',          request('tags', [])) ?'selected':'' }}>Urgent</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Shopify Tags</label>
                            <select name="shopify_tags" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Tags</option>
                                <option value="vip"    {{ request('shopify_tags')=='vip'    ?'selected':'' }}>VIP Customer</option>
                                <option value="repeat" {{ request('shopify_tags')=='repeat' ?'selected':'' }}>Repeat Order</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Weight Range (Kg)</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="weight_min" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Min (0)" max="20" value="{{ request('weight_min') }}">
                                <span class="text-gray-400">-</span>
                                <input type="number" name="weight_max" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Min (0)" max="20" value="{{ request('weight_max') }}">
                            </div>
                        </div>
                    </div>
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

    {{-- ============================================================
         BULK ACTION STICKY BAR — FIXED PER TAB (Images 1-5)
    ============================================================ --}}
    @php $currentStatus = request('status', 'NEW'); @endphp

    <div x-data="{ selectedCount: 0, selectedIds: [] }"
         @selection-updated.window="selectedCount = $event.detail.count; selectedIds = $event.detail.ids"
         x-show="selectedCount > 0"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-white border border-gray-200 rounded-xl shadow-md p-3 mb-4 flex flex-wrap items-center justify-between gap-3 sticky top-0 z-50">

        {{-- Counts --}}
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-gray-50 border border-gray-200 rounded-lg text-sm font-bold text-gray-700">
                Total : {{ $orders->total() }}
            </span>
            <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-lg text-sm font-bold">
                <i class="fa fa-check-double mr-1"></i> Selected : <span x-text="selectedCount"></span>
            </span>
        </div>

        {{-- Buttons --}}
        <div class="flex flex-wrap items-center gap-2">

            {{-- ===== NEW ===== --}}
            @if($currentStatus == 'NEW')
                <button @click="window.bulkAction('update_tag', selectedIds)"
                    class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-edit mr-1.5 text-gray-400"></i> Update Tags
                </button>
                {{-- <button @click="window.bulkAction('update_dimension', selectedIds)"
                    class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-ruler-combined mr-1.5 text-gray-400"></i> Update Dimension
                </button> --}}
                {{-- <button @click="window.bulkAction('book_now', selectedIds)"
                    class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-book mr-1.5 text-gray-400"></i> Book Now
                </button> --}}
                {{-- <button @click="window.bulkAction('archive', selectedIds)"
                    class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-archive mr-1.5 text-gray-400"></i> Move To Archive
                </button> --}}
                <button @click="window.bulkAction('cancel', selectedIds)"
                    class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-times mr-1.5"></i> Cancel Order
                </button>
                <button @click="window.bulkAction('clone', selectedIds)"
                    class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-copy mr-1.5 text-gray-400"></i> Clone Order
                </button>
                <button @click="window.bulkAction('upload_bulk_multiple', selectedIds)"
                    class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm flex items-center">
                    <i class="fa fa-file-upload mr-1.5 text-gray-400"></i> Upload Bulk Order (Multiple order)
                </button>
             
             
                <button @click="window.bulkAction('export_excel', selectedIds)"
                    class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-file-csv mr-1.5 text-gray-400"></i> Export CSV
                </button>

            {{-- ===== BOOKED — Image 2: Cancel Shipment | Download Label | Generate Manifest | Export CSV ===== --}}
            @elseif($currentStatus == 'booked')
                <button @click="window.bulkAction('cancel', selectedIds)"
                    class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-times-circle mr-1.5"></i> Cancel Shipment
                </button>
                <button @click="window.bulkAction('download-label', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-download mr-1.5 text-gray-500"></i> Download Label
                </button>
                <button @click="window.bulkAction('manifest', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-file-invoice mr-1.5 text-gray-500"></i> Generate Manifest
                </button>
                <button @click="window.bulkAction('export-excel', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-file-csv mr-1.5 text-gray-500"></i> Export CSV
                </button>

            {{-- ===== MANIFESTED — Image 3: Download Manifest | Download Picklist ===== --}}
            @elseif($currentStatus == 'manifested')
                <button @click="window.bulkAction('download-manifest', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-download mr-1.5 text-gray-500"></i> Download Manifest
                </button>
                <button @click="window.bulkAction('download-picklist', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-list-alt mr-1.5 text-gray-500"></i> Download Picklist
                </button>
                 <button @click="window.bulkAction('cancel', selectedIds)"
                    class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-times-circle mr-1.5"></i> Cancel Shipment
                </button>

            {{-- ===== PICKUPS — Image 4: Download Invoice | Download Label | Download Picklist | Cancel Shipment | Export CSV ===== --}}
            @elseif($currentStatus == 'pickups')
                <!-- <button @click="window.bulkAction('download-invoice', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-file-invoice mr-1.5 text-gray-500"></i> Download Invoice
                </button> -->
                <button @click="window.bulkAction('download-label', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-download mr-1.5 text-gray-500"></i> Download Label
                </button>
                <button @click="window.bulkAction('download-picklist', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-list-alt mr-1.5 text-gray-500"></i> Download Picklist
                </button>
                <button @click="window.bulkAction('cancel', selectedIds)"
                    class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-times-circle mr-1.5"></i> Cancel Shipment
                </button>
                <button @click="window.bulkAction('export-excel', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-file-csv mr-1.5 text-gray-500"></i> Export CSV
                </button>
                 <!-- <button @click="window.bulkAction('cancel', selectedIds)"
                    class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-times-circle mr-1.5"></i> Cancel Shipment
                </button> -->

            {{-- ===== CANCELLED — Image 5: Clone Order | Export CSV ===== --}}
            @elseif($currentStatus == 'cancelled')
                <button @click="window.bulkAction('clone', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-copy mr-1.5 text-gray-400"></i> Clone Order
                </button>
                <button @click="window.bulkAction('export-excel', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-file-csv mr-1.5 text-gray-400"></i> Export CSV
                </button>

            {{-- ===== IN_TRANSIT / OUT_FOR_DELIVERY / DELIVERED / RTO / ALL — Sync Status + Export ===== --}}
            @else
                <button @click="window.bulkAction('export', selectedIds)"
                    class="px-4 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-file-csv mr-1.5 text-gray-400"></i> Export CSV
                </button>
                <button @click="window.bulkAction('sync_live', selectedIds)"
                    class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded shadow-sm uppercase flex items-center">
                    <i class="fa fa-sync-alt mr-1.5"></i> Sync Status
                </button>
            @endif

        </div>
    </div>

    {{-- ============================================================
         BULK DIMENSION MODAL
    ============================================================ --}}
    <div id="bulkDimensionModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="document.getElementById('bulkDimensionModal').classList.add('hidden'); document.body.style.overflow=''"></div>
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 z-10">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-slate-800">
                        Update Dimensions
                        <span class="text-sm text-gray-500 font-normal ml-2">(<span id="bulkDimCountDisplay">0</span> orders)</span>
                    </h3>
                    <button onclick="document.getElementById('bulkDimensionModal').classList.add('hidden'); document.body.style.overflow=''"
                        class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Length (cm)</label>
                        <input type="number" id="bulkLength" min="0" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold" placeholder="e.g. 20">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Width (cm)</label>
                        <input type="number" id="bulkWidth" min="0" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold" placeholder="e.g. 15">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Height (cm)</label>
                        <input type="number" id="bulkHeight" min="0" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold" placeholder="e.g. 10">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Weight (Kg)</label>
                        <input type="number" id="bulkWeight" min="0" step="0.001" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold" placeholder="e.g. 20.000">
                    </div>
                </div>
                <div class="mt-5 flex justify-end gap-3">
                    <button onclick="document.getElementById('bulkDimensionModal').classList.add('hidden'); document.body.style.overflow=''"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Cancel</button>
                    <button onclick="window.saveBulkDimensions()"
                        class="px-6 py-2 text-sm font-bold text-white bg-gradient-gold rounded-lg hover:shadow-lg">Update</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Orders Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row flex-wrap items-start sm:items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                <span class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700">
                    <i class="fa fa-list mr-2 text-gold"></i>Total: <strong>{{ $orders->total() }}</strong>
                </span>
                <!-- <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false" class="w-full sm:w-auto px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:border-gold transition-all flex items-center justify-center">
                        <i class="fa fa-tasks mr-2"></i> Bulk Actions
                        <i class="fa fa-chevron-down ml-2 text-xs transition-transform" :class="{'rotate-180': open}"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="absolute top-full left-0 mt-1 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-20">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" data-bulk-action="manifest"><i class="fa fa-truck mr-2 text-gold"></i> Manifest Selected</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" data-bulk-action="cancel"><i class="fa fa-times mr-2 text-red-500"></i> Cancel Selected</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" data-bulk-action="export"><i class="fa fa-file-export mr-2 text-green-600"></i> Export Selected</a>
                        <hr class="my-1">
                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50" data-bulk-action="delete"><i class="fa fa-trash mr-2"></i> Delete Selected</a>
                    </div>
                </div> -->
            </div>
            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <button id="refreshTable" class="p-2 text-gray-500 hover:text-gold hover:bg-gray-100 rounded-lg transition-all" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                <!-- <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false" class="flex-1 sm:flex-none px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:border-gold transition-all flex items-center justify-center">
                        <i class="fa fa-file-export mr-2"></i><span class="sm:hidden">Export</span><i class="fa fa-chevron-down ml-2 text-xs transition-transform hidden sm:block" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-xl py-1 z-20">
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fa fa-file-csv mr-2 text-green-600"></i> CSV</a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fa fa-file-excel mr-2 text-green-600"></i> Excel</a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fa fa-file-pdf mr-2 text-red-600"></i> PDF</a>
                    </div>
                </div> -->
                <button class="flex-1 sm:flex-none px-3 py-1.5 text-sm font-medium text-white bg-gradient-gold rounded-lg hover:shadow-lg transition-all flex items-center justify-center" data-bs-toggle="modal" data-bs-target="#columnSettingsModal">
                    <i class="fa fa-cog mr-2"></i><span class="hidden sm:inline">Columns</span>
                </button>
                <a href="{{ route('orders.create') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-gradient-gold rounded-lg hover:shadow-lg transition-all">
                    <i class="fa fa-plus mr-2"></i><span class="hidden sm:inline">Create Order</span><span class="sm:hidden">Add</span>
                </a>
            </div>
        </div>

        {{-- Status Tabs --}}
        <div class="px-4 sm:px-6 pt-2">
            <div class="flex items-center gap-1 overflow-x-auto pb-2 scrollbar-hide">
              @php
$tabCounts = [
    'NEW'              => $counts['NEW']              ?? 0,
    'booked'           => $counts['booked']           ?? 0,
    'manifested'       => $counts['manifested']       ?? 0,
    'pickups'          => $counts['pickups']          ?? 0,  // ✅ FIXED: pickups key use karein
    'in_transit'       => $counts['in_transit']       ?? 0,
    'out_for_delivery' => $counts['out_for_delivery'] ?? 0,
    'delivered'        => $counts['delivered']        ?? 0,
    'rto'              => $counts['rto']              ?? 0,
    'cancelled'        => $counts['cancelled']        ?? 0,
    'sync_error'       => $counts['sync_error']       ?? 0,
    'draft'            => $counts['draft']            ?? 0,
    'archived'         => $counts['archived']         ?? 0,
    'self_fulfilled'   => $counts['self_fulfilled']   ?? 0,
    'all'              => $counts['all']              ?? $orders->total(),
];
@endphp
                @foreach([
                    'NEW'              => 'New',
                    'booked'           => 'Booked',
                    'manifested'       => 'Manifested',
                    'pickups'          => 'Pickups',
                    'in_transit'       => 'In Transit',
                    'out_for_delivery' => 'Out For Delivery',
                    'delivered'        => 'Delivered',
                    'rto'              => 'RTO',
                    'cancelled'        => 'Cancelled',
                    'sync_error'       => 'Sync Error',
                    'draft'            => 'Draft / Abandoned',
                    'archived'         => 'Archived',
                    'self_fulfilled'   => 'Self Fulfilled',
                    'all'              => 'All',
                ] as $key => $label)
                @php $isActive = request('status') == $key || ($key == 'NEW' && !request('status')); @endphp
                <a href="{{ route('orders.index', array_merge(request()->except('status','page'), ['status' => $key])) }}"
                   class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-t-lg transition-all whitespace-nowrap {{ $isActive ? 'text-gold border-b-2 border-gold bg-gradient-cream' : 'text-gray-500 hover:text-gray-700' }}">
                    {{ $label }}
                    <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full {{ $isActive ? 'bg-gold text-white' : 'bg-gray-100 text-gray-600' }}">
                        {{ $tabCounts[$key] }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full" id="ordersTable">
                <thead class="bg-gray-50 text-nowrap">
                <tr>
                    <th class="px-4 py-3 text-left">
                        <input type="checkbox" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold" id="selectAll">
                    </th>
                    @php $status = request('status', 'NEW'); @endphp

                    @if($status == 'NEW')
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Action</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Zone</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">AWB</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mobile</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Address</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Weight</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Dimensions</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Actions</th>

                    @elseif($status == 'booked')
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Booked Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Store Tag</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tag</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer Details</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mobile</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Courier</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup Address</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Product Detail</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Dimension & Weight</th>

                    @elseif($status == 'manifested')
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Manifest Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">AWB</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Shipment Count</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup Address</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Courier</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Manifest Details</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Action</th>

                    @elseif($status == 'pickups')
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup Schedule Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Manifest Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup Id</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">AWB</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Provider Pickup ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Store Tag</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tag</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer Details</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mobile No</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Courier</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup Address</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Product Details</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Dimensions & Weight</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Action</th>

                    @elseif($status == 'cancelled')
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Cancelled Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Store Tag</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tag</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer Details</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mobile</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Courier</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup Address</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Product Detail</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Dimension & Weight</th>

                    @elseif($status == 'sync_error')
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-red-600 uppercase">Error Reason</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Action</th>

                    @elseif($status == 'draft')
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order Type</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mobile</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Address</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Weight</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Dimensions</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Action</th>

                    @elseif($status == 'archived')
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Zone</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">AWB</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mobile</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Address</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Weight</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Dimensions</th>

                    @else
                        {{-- DEFAULT: in_transit, out_for_delivery, delivered, rto, all --}}
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">{{ ucfirst(str_replace('_', ' ', $status)) }} Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Store Tag</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tag</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer Details</th>
                        @if($status == 'out_for_delivery')
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Assigned User</th>
                        @endif
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mobile</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Courier</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pickup Address</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Product Detail</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Dimension & Weight</th>
                        @if(in_array($status, ['delivered', 'rto', 'all']))
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Action</th>
                        @endif
                    @endif
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors text-sm">
                    <td class="px-4 py-4 text-center">
                        <input type="checkbox" class="form-checkbox rounded border-gray-300 text-gold order-checkbox" value="{{ $order->id }}">
                    </td>
                    @php $status = request('status', 'NEW'); @endphp

                    {{-- ===== NEW ===== --}}
                    @if($status == 'NEW')
                        <td class="px-4 py-4 text-xs whitespace-nowrap">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d M Y h:i A') : ($order->created_at ? $order->created_at->format('d M Y h:i A') : 'N/A') }}</td>
                        <td class="px-4 py-4">
                            <button onclick="window.openCourierModal({{ $order->id }}, '{{ $order->merchant_order_id }}')" class="bg-indigo-600 text-white px-2 py-1 rounded text-xs hover:bg-indigo-700">Book Now</button>
                        </td>
                        <td class="px-4 py-4 text-xs">{{ $order->zone ?? 'N/A' }}</td>
                        <td class="px-4 py-4 font-bold text-xs">#{{ $order->merchant_order_id }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->waybill ?? 'N/A' }}</td>
                        <td class="px-4 py-4"><span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-bold">{{ strtoupper($order->status ?? 'NEW') }}</span></td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">₹{{ number_format($order->product_subtotal ?? 0, 2) }}</div>
                            <div class="text-[9px] font-bold {{ $order->payment_mode == 1 ? 'text-orange-600' : 'text-blue-600' }}">{{ $order->payment_mode == 1 ? 'COD' : 'PREPAID' }}</div>
                        </td>
                        <td class="px-4 py-4 text-xs">{{ $order->buyer_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->phone_number ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->city ?? '' }}, {{ $order->state ?? '' }} - {{ $order->pincode ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ number_format($order->weight ?? 0, 3) }} Kg</td>
                        <td class="px-4 py-4 text-xs">{{ (int)($order->length ?? 0) }}×{{ (int)($order->width ?? 0) }}×{{ (int)($order->height ?? 0) }} cm</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1">
                                <button onclick="window.openEditOrderModal({{ $order->id }}, '{{ $order->merchant_order_id }}')" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Edit"><i class="fa fa-edit"></i></button>
                                <button onclick="window.openTagModal({{ $order->id }}, '{{ $order->merchant_order_id }}')" class="p-1.5 text-purple-600 hover:bg-purple-50 rounded" title="Tag"><i class="fa fa-tag"></i></button>
                            </div>
                        </td>

                    {{-- ===== BOOKED ===== --}}
                    @elseif($status == 'booked')
                        <td class="px-4 py-4 text-xs whitespace-nowrap">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d M Y') : ($order->created_at ? $order->created_at->format('d M Y') : 'N/A') }}</td>
                        <td class="px-4 py-4 text-xs whitespace-nowrap">
    {{
        ($order->booked_at || $order->updated_at)
            ? \Carbon\Carbon::parse($order->booked_at ?? $order->updated_at)->format('d M Y h:i A')
            : 'N/A'
    }}
</td>
                        <td class="px-4 py-4 font-bold text-xs">#{{ $order->merchant_order_id }}</td>
                        <td class="px-4 py-4"><span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold">{{ strtoupper($order->status ?? 'BOOKED') }}</span></td>
                        <td class="px-4 py-4 text-xs"><span class="bg-gray-50 text-gray-500 px-1.5 py-0.5 rounded border">{{ $order->order_type ?? 'Store' }}</span></td>
                        <td class="px-4 py-4"><div id="tag-display-{{ $order->id }}" class="flex flex-wrap gap-1"></div></td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">₹{{ number_format($order->product_subtotal ?? 0, 2) }}</div>
                            <div class="text-[9px] font-bold {{ $order->payment_mode == 1 ? 'text-orange-600' : 'text-blue-600' }}">{{ $order->payment_mode == 1 ? 'COD' : 'PREPAID' }}</div>
                        </td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">{{ $order->buyer_name ?? 'N/A' }}</div>
                            <div class="text-[10px] text-gray-500">{{ $order->city }}, {{ $order->state }}</div>
                        </td>
                        <td class="px-4 py-4 text-xs">{{ $order->phone_number ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">{{ $order->courier_name ?? 'N/A' }}</div>
                            <div class="text-[9px] text-gray-400 uppercase">{{ $order->service_mode ?? 'Standard' }}</div>
                        </td>
                        <td class="px-4 py-4 text-[10px]">{{ $order->pickupAddress?->warehouse_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-[10px]">
                            @foreach($order->items as $item)
                                <div class="truncate w-32">• {{ $item->product_name }} (x{{ $item->quantity }})</div>
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-[10px] whitespace-nowrap">
                            <div class="font-bold">{{ number_format($order->weight ?? 0, 3) }} Kg</div>
                            <div class="text-gray-400">{{ (int)$order->length }}×{{ (int)$order->width }}×{{ (int)$order->height }} cm</div>
                        </td>

                    {{-- ===== MANIFESTED ===== --}}
                    @elseif($status == 'manifested')
                        <td class="px-4 py-4 text-xs font-bold text-indigo-600">
                            <a href="{{ route('orders.index', ['status'=>'pickups']) }}" class="hover:underline">{{ $order->fship_api_order_id ?? 'N/A' }}</a>
                        </td>
                        <td class="px-4 py-4 text-xs">{{ $order->document?->pickup_date ? \Carbon\Carbon::parse($order->document->pickup_date)->format('d M Y') : 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->document?->last_regenerated_at ? \Carbon\Carbon::parse($order->document->last_regenerated_at)->format('d M Y h:i A') : 'N/A' }}</td>
                        @php
                        $awb = $order->document?->provider_pickup_id ?? $order->pickup_order_id;
                        @endphp

                        <td class="px-4 py-4 text-xs font-bold text-blue-600">
                            @if($awb)
                                     <a target="_blank" href="{{ route('status.index', ['awb' => $awb]) }}">
                         {{ $awb }}
                           </a>
                           @else
                            N/A
                         @endif
                         </td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $order->document?->pickup_status == 'Pickup Completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ strtoupper($order->document?->pickup_status ?? 'PICKUP INITIATED') }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center text-xs font-bold">{{ $order->document?->shipment_count ?? '1' }}</td>
                        <td class="px-4 py-4 text-[10px] max-w-[120px] truncate">{{ $order->pickupAddress?->warehouse_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs font-bold">{{ $order->document?->courier_name ?? $order->courier_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs text-gray-500 italic">
                            {{ $order->document?->remark ?? 'MANIFESTED' }}
                            @if($order->document?->manifest_url || $order->document?->label_url)
                                <br>
                                <a href="#" onclick="window.bulkAction('download-manifest', [{{ $order->id }}])" class="text-blue-600 hover:underline text-[10px] mt-0.5 inline-block">Re-generate</a>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1">
                                @if($order->document?->manifest_url)
                                    <a href="{{ route('manifest.customize', $order->pickup_order_id) }}" target="_blank" class="p-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100" title="Download Manifest"><i class="fa fa-file-pdf"></i></a>
                                @endif
                                @if($order->document?->label_url)
                                    <a href="{{ $order->document->label_url }}" target="_blank" class="p-1.5 bg-green-50 text-green-600 rounded hover:bg-green-100" title="Download Label"><i class="fa fa-barcode"></i></a>
                                @endif
                                @if($order->document?->invoice_url)
                                    <a href="{{ $order->document->invoice_url }}" target="_blank" class="p-1.5 bg-purple-50 text-purple-600 rounded hover:bg-purple-100" title="Download Invoice"><i class="fa fa-file-invoice"></i></a>
                                @endif
                                <button class="p-1.5 bg-gray-50 text-gray-600 rounded hover:bg-gray-100" title="More">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </td>

                    {{-- ===== PICKUPS ===== --}}
                    @elseif($status == 'pickups')
                        <td class="px-4 py-4 text-xs">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d M Y') : 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->document?->pickup_date ? \Carbon\Carbon::parse($order->document->pickup_date)->format('d M Y') : 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->document?->last_regenerated_at ? \Carbon\Carbon::parse($order->document->last_regenerated_at)->format('d M Y h:i A') : 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs font-bold text-indigo-600">#{{ $order->pickup_order_id ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs font-bold">#{{ $order->merchant_order_id ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs font-bold text-blue-600">
        @if($order->waybill)
            <a target="_blank" href="{{ route('status.index', ['awb' => $order->waybill]) }}" class="hover:underline">
                {{ $order->waybill }}
            </a>
            @if($order->courier_name)
                <div class="text-[9px] text-gray-400 uppercase">{{ $order->courier_name }}</div>
            @endif
        @else
            <span class="text-gray-400 italic">Pending</span>
        @endif
    </td>
                        <td class="px-4 py-4 text-xs">{{ $order->document?->provider_pickup_id ?? 'N/A' }}</td>
                        <td class="px-4 py-4"><span class="px-2 py-1 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700">{{ strtoupper($order->document?->pickup_status ?? 'PICKUP INITIATED') }}</span></td>
                        <td class="px-4 py-4 text-xs"><span class="bg-gray-100 px-2 py-0.5 rounded text-gray-600">{{ $order->order_type ?? 'Manual' }}</span></td>
                        <td class="px-4 py-4"><div id="tag-display-{{ $order->id }}" class="flex flex-wrap gap-1"></div></td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">₹{{ number_format($order->product_subtotal ?? 0, 2) }}</div>
                            <div class="text-[9px] font-bold {{ $order->payment_mode == 1 ? 'text-orange-600' : 'text-blue-600' }}">{{ $order->payment_mode == 1 ? 'COD' : 'PREPAID' }}</div>
                        </td>
                        <td class="px-4 py-4 text-xs font-medium">{{ $order->buyer_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">
                            @if($order->phone_number)
                                <a href="tel:{{ $order->phone_number }}" class="text-indigo-600 font-bold hover:underline">{{ $order->phone_number }}</a>
                            @else N/A @endif
                            @if($order->waybill)
                                <div class="text-[9px] text-gray-400">{{ $order->waybill }}<br>{{ $order->courier_name ?? '' }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">{{ $order->courier_name ?? 'N/A' }}</div>
                            <div class="text-[9px] text-gray-400 uppercase">{{ $order->service_mode ?? 'Surface' }}</div>
                        </td>
                        <td class="px-4 py-4 text-[10px] max-w-[120px] truncate">{{ $order->pickupAddress?->warehouse_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-[10px]">
                            @foreach($order->items as $item)
                                <div class="truncate w-32">• {{ $item->product_name }} (x{{ $item->quantity }})</div>
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-[10px]">
                            <div>{{ number_format($order->weight ?? 0, 2) }} Kg</div>
                            <div class="text-gray-400">{{ (int)$order->length }}×{{ (int)$order->width }}×{{ (int)$order->height }} cm</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1">
                               @if($order->waybill)
    <button 
        onclick="window.viewTracking('{{ $order->waybill }}')" 
        class="p-1.5 bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100" 
        title="Track">
        <i class="fa fa-route"></i>
    </button>
@endif
                                @if($order->document?->label_url)
                                    <a href="{{ $order->document->label_url }}" target="_blank" class="p-1.5 bg-gray-50 text-gray-600 rounded hover:bg-gray-100" title="Print Label"><i class="fa fa-print"></i></a>
                                @endif
                            </div>
                        </td>

                    {{-- ===== CANCELLED ===== --}}
                    @elseif($status == 'cancelled')
                        <td class="px-4 py-4 text-xs whitespace-nowrap">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d M Y') : 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs whitespace-nowrap">{{ $order->updated_at ? $order->updated_at->format('d M Y h:i A') : 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs font-bold">#{{ $order->merchant_order_id }}</td>
                        <td class="px-4 py-4"><span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-bold">Order Cancelled</span></td>
                        <td class="px-4 py-4 text-xs"><span class="bg-gray-50 text-gray-500 px-1.5 py-0.5 rounded border">{{ $order->order_type ?? 'Store' }}</span></td>
                        <td class="px-4 py-4"><div id="tag-display-{{ $order->id }}" class="flex flex-wrap gap-1"></div></td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">₹{{ number_format($order->product_subtotal ?? 0, 2) }}</div>
                            <div class="text-[9px] font-bold {{ $order->payment_mode == 1 ? 'text-orange-600' : 'text-blue-600' }}">{{ $order->payment_mode == 1 ? 'COD' : 'PREPAID' }}</div>
                        </td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">{{ $order->buyer_name ?? 'N/A' }}</div>
                            <div class="text-[10px] text-gray-500">{{ $order->city }}, {{ $order->state }}</div>
                        </td>
                        <td class="px-4 py-4 text-xs">{{ $order->phone_number ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">{{ $order->courier_name ?? 'N/A' }}</div>
                            <div class="text-[9px] text-gray-400 uppercase">{{ $order->service_mode ?? '' }}</div>
                        </td>
                        <td class="px-4 py-4 text-[10px]">{{ $order->pickupAddress?->warehouse_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-[10px]">
                            @foreach($order->items as $item)
                                <div class="truncate w-32">• {{ $item->product_name }} (x{{ $item->quantity }})</div>
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-[10px] whitespace-nowrap">
                            <div class="font-bold">{{ number_format($order->weight ?? 0, 2) }} Kg</div>
                            <div class="text-gray-400">{{ (int)$order->length }}×{{ (int)$order->width }}×{{ (int)$order->height }} cm</div>
                        </td>

                    {{-- ===== SYNC_ERROR ===== --}}
                    @elseif($status == 'sync_error')
                        <td class="px-4 py-4 text-xs">{{ $order->order_date }}</td>
                        <td class="px-4 py-4 font-bold text-xs">#{{ $order->merchant_order_id }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->buyer_name }}</td>
                        <td class="px-4 py-4 text-red-600 font-bold text-xs">{{ $order->document->remark ?? 'Sync Failed' }}</td>
                        <td class="px-4 py-4 text-right">
                            <button onclick="window.bulkAction('manifest', [{{ $order->id }}])" class="p-1.5 bg-indigo-50 text-indigo-600 rounded text-xs">Retry</button>
                        </td>

                    {{-- ===== DRAFT ===== --}}
                    @elseif($status == 'draft')
                        <td class="px-4 py-4 text-xs">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d M Y') : ($order->created_at ? $order->created_at->format('d M Y') : 'N/A') }}</td>
                        <td class="px-4 py-4 font-bold text-xs">#{{ $order->merchant_order_id }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->order_type ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">₹{{ number_format($order->product_subtotal ?? 0, 2) }}</div>
                            <div class="text-[9px] font-bold {{ $order->payment_mode == 1 ? 'text-orange-600' : 'text-blue-600' }}">{{ $order->payment_mode == 1 ? 'COD' : 'PREPAID' }}</div>
                        </td>
                        <td class="px-4 py-4 text-xs">{{ $order->buyer_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->phone_number ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->city ?? '' }}, {{ $order->state ?? '' }} - {{ $order->pincode ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ number_format($order->weight ?? 0, 3) }} Kg</td>
                        <td class="px-4 py-4 text-xs">{{ (int)($order->length ?? 0) }}×{{ (int)($order->width ?? 0) }}×{{ (int)($order->height ?? 0) }} cm</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1">
                                <button onclick="window.openEditOrderModal({{ $order->id }}, '{{ $order->merchant_order_id }}')" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Edit"><i class="fa fa-edit"></i></button>
                                <button onclick="window.openCourierModal({{ $order->id }}, '{{ $order->merchant_order_id }}')" class="bg-indigo-600 text-white px-2 py-1 rounded text-xs">Book</button>
                            </div>
                        </td>

                    {{-- ===== ARCHIVED ===== --}}
                    @elseif($status == 'archived')
                        <td class="px-4 py-4 text-xs">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d M Y') : ($order->created_at ? $order->created_at->format('d M Y') : 'N/A') }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->zone ?? 'N/A' }}</td>
                        <td class="px-4 py-4 font-bold text-xs">#{{ $order->merchant_order_id }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->waybill ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->buyer_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->phone_number ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ $order->city ?? '' }}, {{ $order->state ?? '' }} - {{ $order->pincode ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">{{ number_format($order->weight ?? 0, 3) }} Kg</td>
                        <td class="px-4 py-4 text-xs">{{ (int)($order->length ?? 0) }}×{{ (int)($order->width ?? 0) }}×{{ (int)($order->height ?? 0) }} cm</td>

                    {{-- ===== DEFAULT (in_transit, out_for_delivery, delivered, rto, all) ===== --}}
                    @else
                        <td class="px-4 py-4 text-xs whitespace-nowrap">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d M Y') : 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs whitespace-nowrap">{{ $order->updated_at ? $order->updated_at->format('d M Y h:i A') : 'N/A' }}</td>
                        <td class="px-4 py-4">
                            <div class="text-xs font-bold text-gray-800">#{{ $order->merchant_order_id }}</div>
                            @if($order->waybill)
                                <a href="{{ route('status.index', ['awb' => $order->waybill]) }}" class="text-[11px] text-indigo-600 font-bold hover:underline">AWB: {{ $order->waybill }}</a>
                            @else
                                <div class="text-[10px] text-gray-400 italic">AWB: Pending</div>
                            @endif
                        </td>
                        <!--<td class="px-4 py-4">-->
                        <!--    <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $order->status == 'delivered' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">-->
                        <!--        {{ strtoupper(str_replace('_', ' ', $order->status)) }}-->
                        <!--    </span>-->
                        <!--</td>-->
                        <td class="px-4 py-4">
    @php
        if (str_starts_with($order->status, 'rto')) {
            $badgeClass = match($order->status) {
                'rto_delivered' => 'bg-green-100 text-green-700 border border-green-200',
                'rto_in_transit' => 'bg-blue-100 text-blue-700 border border-blue-200',
                default => 'bg-red-100 text-red-700 border border-red-200',
            };
            $statusLabel = match($order->status) {
                'rto_delivered' => 'RTO Delivered',
                'rto_in_transit' => 'RTO In Transit',
                default => 'RTO Initiated',
            };
        } else {
            $badgeClass = $order->status == 'delivered' 
                ? 'bg-green-100 text-green-700 border border-green-200' 
                : 'bg-blue-100 text-blue-700 border border-blue-200';
            $statusLabel = strtoupper(str_replace('_', ' ', $order->status));
        }
    @endphp
    <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $badgeClass }}">
        {{ $statusLabel }}
    </span>
</td>
                        <td class="px-4 py-4 text-xs"><span class="bg-gray-50 text-gray-500 px-1.5 py-0.5 rounded border">{{ $order->order_type ?? 'Store' }}</span></td>
                        <td class="px-4 py-4"><div id="tag-display-{{ $order->id }}" class="flex flex-wrap gap-1"></div></td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold">₹{{ number_format($order->product_subtotal ?? 0, 2) }}</div>
                            <div class="text-[9px] font-bold {{ $order->payment_mode == 1 ? 'text-orange-600' : 'text-blue-600' }}">{{ $order->payment_mode == 1 ? 'COD' : 'PREPAID' }}</div>
                        </td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold text-gray-800">{{ $order->buyer_name ?? 'N/A' }}</div>
                            <div class="text-[10px] text-gray-500">{{ $order->city }}, {{ $order->state }}</div>
                        </td>
                        @if($status == 'out_for_delivery')
                            <td class="px-4 py-4 text-xs font-medium text-indigo-600">{{ $order->reseller_name ?? 'Not Assigned' }}</td>
                        @endif
                        <td class="px-4 py-4 text-xs font-medium">{{ $order->phone_number ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-xs">
                            <div class="font-bold text-gray-700">{{ $order->courier_name ?? 'N/A' }}</div>
                            <div class="text-[9px] text-gray-400 uppercase">{{ $order->service_mode ?? 'Standard' }}</div>
                        </td>
                        <td class="px-4 py-4 text-[10px] max-w-[120px] truncate">{{ $order->pickupAddress?->warehouse_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-[10px]">
                            @foreach($order->items as $item)
                                <div class="truncate w-32 font-medium">• {{ $item->product_name }} (x{{ $item->quantity }})</div>
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-[10px] whitespace-nowrap">
                            <div class="font-bold text-gray-700">{{ number_format($order->weight ?? 0, 2) }} Kg</div>
                            <div class="text-gray-400">{{ (int)$order->length }}×{{ (int)$order->width }}×{{ (int)$order->height }} cm</div>
                        </td>
                        @if(in_array($status, ['delivered', 'rto', 'all']))
                            <td class="px-4 py-4 text-right">
                                @if($order->waybill)
                                    <button onclick="window.viewTracking('{{ $order->waybill }}')" class="p-1.5 bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100" title="Track"><i class="fa fa-route"></i></button>
                                @endif
                            </td>
                        @endif
                    @endif
                </tr>
                @empty
                <tr><td colspan="20" class="text-center py-10 text-gray-500"><i class="fa fa-inbox text-3xl text-gray-300 mb-3 block"></i>No records found</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-4 sm:px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                <select class="form-select px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold w-full sm:w-auto" id="perPageSelect" onchange="window.changePerPage(this.value)">
                    <option value="25"  {{ request('per_page') == 25  ? 'selected' : '' }}>25 per page</option>
                    <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50 per page</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                </select>
                <span class="text-sm text-gray-500">
                    Showing <strong>{{ $orders->firstItem() ?? 0 }}</strong> to <strong>{{ $orders->lastItem() ?? 0 }}</strong> of <strong>{{ $orders->total() }}</strong>
                </span>
            </div>
            <nav class="flex items-center gap-1 w-full sm:w-auto overflow-x-auto">
                <a href="{{ $orders->url(1) }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm text-gray-600 hover:text-gold hover:bg-gray-100 rounded-lg {{ $orders->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">First</a>
                <a href="{{ $orders->previousPageUrl() ?? '#' }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm text-gray-600 hover:text-gold hover:bg-gray-100 rounded-lg {{ $orders->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}"><i class="fa fa-chevron-left"></i></a>
                @for ($i = max(1, $orders->currentPage() - 2); $i <= min($orders->lastPage(), $orders->currentPage() + 2); $i++)
                    <a href="{{ $orders->url($i) }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm rounded-lg {{ $i == $orders->currentPage() ? 'bg-gold text-white font-medium' : 'text-gray-600 hover:text-gold hover:bg-gray-100' }}">{{ $i }}</a>
                @endfor
                <a href="{{ $orders->nextPageUrl() ?? '#' }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm text-gray-600 hover:text-gold hover:bg-gray-100 rounded-lg {{ !$orders->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}"><i class="fa fa-chevron-right"></i></a>
                <a href="{{ $orders->url($orders->lastPage()) }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm text-gray-600 hover:text-gold hover:bg-gray-100 rounded-lg {{ !$orders->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">Last</a>
            </nav>
        </div>
    </div>
</div>

{{-- ========== COLUMN SETTINGS MODAL ========== --}}
<div class="modal fade fixed inset-0 z-[60] overflow-y-auto hidden" id="columnSettingsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered relative w-auto mx-4 pointer-events-none">
        <div class="modal-content relative flex flex-col w-full pointer-events-auto bg-white border border-gray-200 rounded-xl shadow-xl outline-none max-h-[90vh]">
            <div class="modal-header flex items-center justify-between p-4 sm:p-6 border-b border-gray-100">
                <h6 class="modal-title font-semibold text-gray-800 text-base">Customize Columns</h6>
                <button type="button" class="text-gray-400 hover:text-gray-600" data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body p-4 sm:p-6 overflow-y-auto">
                <div class="space-y-2">
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer"><input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="order_id"><span class="text-sm text-gray-700">Order ID</span></label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer"><input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="awb"><span class="text-sm text-gray-700">AWB Number</span></label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer"><input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="customer"><span class="text-sm text-gray-700">Customer Name</span></label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer"><input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="phone"><span class="text-sm text-gray-700">Phone</span></label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer"><input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="product"><span class="text-sm text-gray-700">Product</span></label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer"><input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="payment"><span class="text-sm text-gray-700">Payment</span></label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer"><input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="courier"><span class="text-sm text-gray-700">Dim. & Weight</span></label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer"><input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="status"><span class="text-sm text-gray-700">Status</span></label>
                </div>
            </div>
            <div class="modal-footer flex items-center justify-end gap-3 p-4 sm:p-6 border-t border-gray-100">
                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="px-4 py-2 text-sm font-medium text-white bg-gradient-gold rounded-lg hover:shadow-lg" id="saveColumns">Save Changes</button>
            </div>
        </div>
    </div>
</div>

{{-- ========== TAG MODAL ========== --}}
<div id="tagModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="window.closeTagModal()"></div>
    <div class="flex items-center justify-center min-h-screen px-4 py-6 pointer-events-none">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all scale-95 opacity-0 pointer-events-auto" id="tagModalContent">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-800">Add Order Tag <span id="modalOrderId" class="text-gold font-mono text-base ml-1"></span></h3>
                <button onclick="window.closeTagModal()" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400"><i class="fa fa-times text-lg"></i></button>
            </div>
            <div class="p-6 space-y-5">
                <div class="flex items-center gap-2 text-[13px] text-slate-500 font-medium bg-orange-50/50 p-2 rounded-lg">
                    <i class="fa fa-lightbulb text-orange-400"></i>
                    <span>*Click tags to select multiple or type manually.</span>
                </div>
                <div class="flex flex-wrap gap-2" id="quickTagContainer">
                    <button type="button" onclick="window.toggleTag(this, 'Call Not Answered/Disconnected')" class="tag-option-btn">Call Not Answered/Disconnected</button>
                    <button type="button" onclick="window.setTagValue('Call Back Later')" class="tag-option-btn">Call Back Later</button>
                    <button type="button" onclick="window.toggleTag(this, 'Order Confirmed')" class="tag-option-btn">Order Confirmed</button>
                    <button type="button" onclick="window.toggleTag(this, 'Order Cancelled')" class="tag-option-btn">Order Cancelled</button>
                    <button type="button" onclick="window.toggleTag(this, 'Urgent')" class="tag-option-btn">Urgent</button>
                </div>
                <div class="relative mt-2">
                    <input type="text" id="manualTagInput" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl text-sm focus:border-gold focus:ring-0 focus:bg-white transition-all outline-none" placeholder="Selected tags will appear here..." readonly>
                    <p class="text-[10px] text-gray-400 mt-1.5 ml-1">*Selected tags are saved as an array record.</p>
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50/80 border-t border-gray-100 flex justify-end">
                <button id="saveTagBtn" onclick="window.saveTag()" class="px-10 py-2.5 bg-[#1e1b4b] text-white rounded-lg text-sm font-bold shadow-lg hover:bg-black transition-all">Add Tags</button>
            </div>
        </div>
    </div>
</div>

{{-- ========== COURIER BOOKING MODAL ========== --}}
<div id="courierModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="window.closeCourierModal()"></div>
    <div class="flex items-center justify-end min-h-screen">
        <div class="relative bg-white h-screen w-full max-w-6xl shadow-2xl transform transition-transform duration-300 translate-x-full" id="courierPanel">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white sticky top-0 z-10">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Select Courier Partner</h3>
                    <p class="text-sm text-slate-500 mt-1">Order ID: <span id="courierModalOrderId" class="font-bold text-gold"></span></p>
                </div>
                <button onclick="window.closeCourierModal()" class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100"><i class="fa fa-times text-xl"></i></button>
            </div>
            <div class="flex flex-col lg:flex-row h-full" style="max-height: calc(100vh - 73px);">
                <div class="lg:w-1/4 border-r border-gray-200 p-6 bg-gray-50 overflow-y-auto">
                    <h4 class="font-bold text-gray-800 mb-4 text-xs uppercase tracking-wide border-b pb-2">Order's Detail</h4>
                    <div class="space-y-1" id="orderDetailsContainer"></div>
                </div>
                <div class="lg:w-3/4 p-6 overflow-y-auto bg-slate-50">
                    <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fa fa-map-marker-alt text-gold mr-1"></i> Select Pickup Address</label>
                        <select id="pickupAddressSelect" class="form-select w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold bg-white shadow-sm">
                            <option value="">Loading addresses...</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">*Courier rates will update based on pickup location</p>
                    </div>
                    <div class="flex items-center gap-4 mb-6 border-b border-gray-200 bg-white p-4 rounded-lg">
                        <button onclick="window.filterCouriers('all')" class="courier-tab active pb-2 text-sm font-bold border-b-2 border-gold text-gold" data-tab="all">All</button>
                        <button onclick="window.filterCouriers('air')" class="courier-tab pb-2 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600" data-tab="air">Air</button>
                        <button onclick="window.filterCouriers('surface')" class="courier-tab pb-2 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-gray-600" data-tab="surface">Surface</button>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div id="courierLoading" class="text-center py-20">
                            <i class="fa fa-spinner fa-spin text-4xl text-gold"></i>
                            <p class="mt-4 text-gray-500 font-medium">Finding best rates for you...</p>
                        </div>
                        <div id="courierListContainer" class="hidden">
                            <table class="w-full">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Courier Partner</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Rating</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Expected Pickup</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Estimated Delivery</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Shipment Charges<br><span class="text-[10px] font-normal">(Including GST)</span></th>
                                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100" id="courierTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========== EDIT ORDER MODAL ========== --}}
<div id="editOrderModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="window.closeEditOrderModal()"></div>
    <div class="flex items-center justify-end min-h-screen">
        <div class="relative bg-white h-screen w-full max-w-4xl shadow-2xl transform transition-transform duration-300 translate-x-full" id="editOrderPanel">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white sticky top-0 z-10">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Edit Order</h3>
                    <p class="text-sm text-slate-500 mt-1">Order ID: <span id="editModalOrderId" class="font-bold text-gold"></span></p>
                </div>
                <button onclick="window.closeEditOrderModal()" class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100"><i class="fa fa-times text-xl"></i></button>
            </div>
            <div class="flex-1 overflow-y-auto p-6" style="max-height: calc(100vh - 73px);">
                <form id="editOrderForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="order_id" id="editOrderId">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wide border-b pb-2"><i class="fa fa-shopping-cart text-gold mr-2"></i>Order Details</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Order ID (Read Only)</label><input type="text" id="editMerchantOrderId" class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm" readonly></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Order Date (Read Only)</label><input type="text" id="editOrderDate" class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm" readonly></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Status <span class="text-red-500">*</span></label>
                                <select name="status" id="editStatus" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold">
                                    <option value="new">New</option><option value="booked">Booked</option><option value="manifested">Manifested</option><option value="in_transit">In Transit</option><option value="out_for_delivery">Out for Delivery</option><option value="delivered">Delivered</option><option value="rto">RTO</option><option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Payment Mode</label>
                                <select name="payment_mode" id="editPaymentMode" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold">
                                    <option value="1">COD</option><option value="2">Prepaid</option>
                                </select>
                            </div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Product Subtotal (₹)</label><input type="number" name="product_subtotal" id="editTotalAmount" step="0.01" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wide border-b pb-2"><i class="fa fa-box text-gold mr-2"></i>Product Details</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Product Name</label><input type="text" name="product_name" id="editProductName" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">SKU</label><input type="text" name="sku" id="editSku" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Unit Price</label><input type="number" name="unit_price" id="editUnitPrice" step="0.01" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Quantity</label><input type="number" name="quantity" id="editQuantity" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">HSN</label><input type="text" name="hsn" id="editHsn" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Discount</label><input type="number" name="discount" id="editDiscount" step="0.01" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Shipping (₹)</label><input type="number" name="shipping_charge" id="editShipping" step="0.01" value="0" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Gift Wrap (₹)</label><input type="number" name="gift_wrap_charge" id="editGiftWrap" step="0.01" value="0" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Transaction Fee (₹)</label><input type="number" name="transaction_fee" id="editTransaction" step="0.01" value="0" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wide border-b pb-2"><i class="fa fa-box-open text-gold mr-2"></i>Package & Dimension</h4>
                        <div class="grid grid-cols-3 gap-4">
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Dead Weight (Kg) <span class="text-red-500">*</span></label><input type="number" name="dead_weight" id="editDeadWeight" step="0.001" min="0" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold" placeholder="e.g., 20.000"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Length (cm) <span class="text-red-500">*</span></label><input type="number" name="length" id="editLength" min="0" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold" placeholder="e.g., 30"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Width (cm) <span class="text-red-500">*</span></label><input type="number" name="width" id="editWidth" min="0" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold" placeholder="e.g., 20"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Height (cm) <span class="text-red-500">*</span></label><input type="number" name="height" id="editHeight" min="0" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold" placeholder="e.g., 15"></div>
                        </div>
                        <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200 flex items-center justify-between">
                            <div><p class="text-xs text-blue-800 font-medium"><i class="fa fa-calculator mr-1"></i> Volumetric Weight</p><p class="text-[10px] text-blue-600 mt-0.5">Formula: (L × W × H) ÷ 5000</p></div>
                            <div class="text-right"><span id="volumetricWeight" class="text-lg font-bold text-blue-900">0.000</span><span class="text-xs text-blue-700 ml-1">Kg</span></div>
                        </div>
                        <div class="mt-2 p-2 bg-amber-50 rounded border border-amber-200">
                            <input type="hidden" name="volumetric_weight" id="editVolumetricWeightInput">
                            <p class="text-xs text-amber-800"><i class="fa fa-info-circle mr-1"></i>Billing Weight: <span id="billingWeight" class="font-bold">0.000</span> Kg <span class="text-amber-600 text-[10px]">(Higher of Dead or Volumetric)</span></p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wide border-b pb-2"><i class="fa fa-user text-gold mr-2"></i>Consignee Details</h4>
                        <div class="space-y-3">
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-xs font-medium text-gray-600 mb-1">Full Name <span class="text-red-500">*</span></label><input type="text" name="buyer_name" id="editBuyerName" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                                <div><label class="block text-xs font-medium text-gray-600 mb-1">Phone Number <span class="text-red-500">*</span></label><input type="tel" name="phone_number" id="editPhoneNumber" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold" maxlength="10"></div>
                            </div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Email</label><input type="email" name="email" id="editEmail" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Company Name</label><input type="text" name="company_name" id="editCompanyName" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Complete Address <span class="text-red-500">*</span></label><textarea name="address" id="editAddress" rows="2" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold"></textarea></div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Pincode <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="text" name="pincode" id="editPincode" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold pr-8" maxlength="6" placeholder="6-digit pincode">
                                        <span id="pincodeLoader" class="absolute right-3 top-1/2 -translate-y-1/2 hidden"><i class="fa fa-spinner fa-spin text-gold"></i></span>
                                        <span id="pincodeStatus" class="absolute right-3 top-1/2 -translate-y-1/2 hidden text-xs"></span>
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1">*Auto-fills City/State</p>
                                </div>
                                <div><label class="block text-xs font-medium text-gray-600 mb-1">City</label><input type="text" name="city" id="editCity" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold" placeholder="Auto-filled"></div>
                                <div><label class="block text-xs font-medium text-gray-600 mb-1">State</label><input type="text" name="state" id="editState" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold" placeholder="Auto-filled"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div><label class="block text-xs font-medium text-gray-600 mb-1">Zone</label><span id="editZoneDisplay" class="inline-block px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg text-xs font-bold border border-purple-200">N/A</span></div>
                                <div><label class="block text-xs font-medium text-gray-600 mb-1">COD Status</label><span id="codAvailability" class="inline-block px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-xs font-bold border border-green-200">Available ✓</span></div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-xs font-medium text-gray-600 mb-1">Alternate Phone</label><input type="tel" name="alt_phone_number" id="editAltPhone" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold" placeholder="Optional"></div>
                                <div><label class="block text-xs font-medium text-gray-600 mb-1">Landmark</label><input type="text" name="landmark" id="editLandmark" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gold" placeholder="Nearby landmark"></div>
                            </div>
                            <div><label class="block text-xs font-medium text-gray-600 mb-1">Country</label><input type="text" name="country" id="editCountry" value="India" readonly class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="px-6 py-4 bg-slate-50/80 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0">
                <button type="button" onclick="window.closeEditOrderModal()" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Cancel</button>
                <button type="button" onclick="window.saveEditedOrder()" id="saveEditBtn" class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-gold rounded-lg hover:shadow-lg flex items-center gap-2">
                    <i class="fa fa-save"></i> <span>Update Order</span>
                </button>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
[x-cloak] { display: none !important }
.flatpickr-calendar { border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15); border-radius: 12px; padding: 16px }
.flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange { background: #D4AF37 !important; border-color: #D4AF37 !important }
.flatpickr-day:hover { background: #F5F1E8 !important }
.overflow-x-auto::-webkit-scrollbar { height: 6px }
.overflow-x-auto::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px }
.overflow-x-auto::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 3px }
.form-control:focus, .form-select:focus { outline: none; box-shadow: 0 0 0 3px rgba(212,175,55,0.15) }
#tagModalContent { transition: transform 0.2s ease-out, opacity 0.2s ease-out }
#tagModal:not(.hidden) #tagModalContent { transform: scale(1); opacity: 1 }
#courierPanel, #editOrderPanel { transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); will-change: transform }
#courierModal:not(.hidden) #courierPanel, #editOrderModal:not(.hidden) #editOrderPanel { transform: translateX(0) !important }
.tag-option-btn { background-color: #f1f5f9; color: #475569; padding: 0.5rem 0.8rem; font-size: 11px; font-weight: 600; border-radius: 6px; border: 1px solid #e2e8f0; transition: all 0.2s; cursor: pointer }
.tag-option-btn.selected { background-color: #2563eb; color: white; border-color: #1d4ed8 }
.tag-option-btn:hover:not(.selected) { background-color: #e2e8f0 }
.courier-tab.active { color: #D4AF37 !important; border-bottom-color: #D4AF37 !important }
.order-detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #e2e8f0 }
.order-detail-label { color: #718096; font-size: 12px }
.order-detail-value { color: #2d3748; font-weight: 600; font-size: 12px }
.rating-circle { width: 40px; height: 40px; border-radius: 50%; border: 3px solid #22c55e; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; color: #166534; background: #dcfce7 }
.courier-row:hover { background: #f8fafc }
.toast-notification { position: fixed; bottom: 1rem; right: 1rem; left: 1rem; padding: 0.75rem 1rem; border-radius: 0.5rem; color: white; font-size: 0.875rem; z-index: 9999; display: flex; align-items: center; animation: slideIn 0.3s ease-out, fadeOut 0.3s ease-in 2.7s forwards }
@keyframes slideIn { from { transform: translateY(100%); opacity: 0 } to { transform: translateY(0); opacity: 1 } }
@keyframes fadeOut { from { opacity: 1 } to { opacity: 0 } }
.toast-success { background: #16a34a }
.toast-error { background: #dc2626 }
.toast-info { background: #374151 }
#editPincode.pincode-loading { border-color: #D4AF37 !important; background: #fffbeb }
#editPincode.pincode-success { border-color: #22c55e !important; background: #f0fdf4 }
#editPincode.pincode-error   { border-color: #ef4444 !important; background: #fef2f2 }
</style>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
// ========== GLOBAL STATE ==========
let selectedTags = [], currentTagOrderId = null, currentOrderId = null, currentMerchantId = null;
let allCouriers = [], currentFilter = 'all', userPickupAddresses = [], flatpickrInstances = {};
let pincodeDebounceTimer = null, bulkSelectedIds = [];

// ========== TOAST ==========
function showToast(message, type = 'info') {
    document.querySelectorAll('.toast-notification').forEach(t => t.remove());
    const icons = { success: 'check-circle', error: 'exclamation-circle', info: 'info-circle' };
    const classes = { success: 'toast-success', error: 'toast-error', info: 'toast-info' };
    const toast = document.createElement('div');
    toast.className = `toast-notification ${classes[type] || classes.info}`;
    toast.innerHTML = `<i class="fa fa-${icons[type] || icons.info} mr-2"></i><span>${message}</span>`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// ========== SELECTION ==========
window.updateBulkSelection = function() {
    const ids = Array.from(document.querySelectorAll('.order-checkbox:checked')).map(cb => cb.value);
    window.dispatchEvent(new CustomEvent('selection-updated', { detail: { count: ids.length, ids } }));
};

// ========== VOLUMETRIC WEIGHT ==========
window.calculateVolumetricWeight = function() {
    const L = parseFloat(document.getElementById('editLength')?.value) || 0;
    const W = parseFloat(document.getElementById('editWidth')?.value)  || 0;
    const H = parseFloat(document.getElementById('editHeight')?.value) || 0;
    const dead = parseFloat(document.getElementById('editDeadWeight')?.value) || 0;
    const volumetric = (L * W * H) / 5000;
    const billing = Math.max(dead, volumetric);
    const volEl = document.getElementById('volumetricWeight');
    const billEl = document.getElementById('billingWeight');
    const volInput = document.getElementById('editVolumetricWeightInput');
    if (volEl) volEl.textContent = volumetric.toFixed(3);
    if (billEl) billEl.textContent = billing.toFixed(3);
    if (volInput) volInput.value = volumetric.toFixed(3);
};

// ========== PINCODE API ==========
window.fetchLocationFromPincode = async function(pincode) {
    if (!pincode || !/^\d{6}$/.test(pincode)) return null;
    try {
        const res = await fetch(`{{ route('pincode.check') }}?pincode=${encodeURIComponent(pincode)}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) return null;
        const result = await res.json();
        if (result.status === true) {
            let city = result.city, state = result.state;
            if ((!city || city === '') && result.destination) {
                const parts = result.destination.split(',');
                city = parts[0]?.trim() || '';
                state = parts[1]?.trim() || state;
            }
            return { city, state, zone: result.zone || 'N/A', cod_available: result.cod === true || result.cod === 'Yes' || result.cod === 1, serviceable: result.serviceable ?? true };
        }
        return null;
    } catch (e) { console.error('Pincode fetch error:', e); return null; }
};

window.setupPincodeAutoFill = function() {
    const pincodeInput = document.getElementById('editPincode');
    if (!pincodeInput) return;
    const newInput = pincodeInput.cloneNode(true);
    pincodeInput.parentNode.replaceChild(newInput, pincodeInput);
    newInput.addEventListener('input', function() {
        const pincode = this.value.trim();
        newInput.classList.remove('pincode-loading', 'pincode-success', 'pincode-error');
        document.getElementById('pincodeLoader')?.classList.add('hidden');
        const statusEl = document.getElementById('pincodeStatus');
        if (statusEl) { statusEl.classList.add('hidden'); statusEl.textContent = ''; }
        if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
            newInput.classList.add('pincode-loading');
            document.getElementById('pincodeLoader')?.classList.remove('hidden');
            const cityEl = document.getElementById('editCity');
            const stateEl = document.getElementById('editState');
            if (cityEl) { cityEl.value = ''; cityEl.placeholder = 'Fetching...'; }
            if (stateEl) { stateEl.value = ''; stateEl.placeholder = 'Fetching...'; }
            clearTimeout(pincodeDebounceTimer);
            pincodeDebounceTimer = setTimeout(async () => {
                const loc = await window.fetchLocationFromPincode(pincode);
                newInput.classList.remove('pincode-loading');
                document.getElementById('pincodeLoader')?.classList.add('hidden');
                if (loc) {
                    if (cityEl) { cityEl.value = loc.city; cityEl.placeholder = 'Auto-filled'; }
                    if (stateEl) { stateEl.value = loc.state; stateEl.placeholder = 'Auto-filled'; }
                    const zoneEl = document.getElementById('editZoneDisplay');
                    const codEl = document.getElementById('codAvailability');
                    if (zoneEl) zoneEl.textContent = loc.zone || 'N/A';
                    if (codEl) { codEl.textContent = loc.cod_available ? 'Available ✓' : 'Not Available ✗'; codEl.className = `inline-block px-3 py-1.5 rounded-lg text-xs font-bold border ${loc.cod_available ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200'}`; }
                    newInput.classList.add('pincode-success');
                    showToast(`Location: ${loc.city}, ${loc.state}`, 'success');
                } else {
                    newInput.classList.add('pincode-error');
                    if (cityEl) cityEl.placeholder = 'Enter manually';
                    if (stateEl) stateEl.placeholder = 'Enter manually';
                    showToast('Pincode not serviceable. Enter city/state manually.', 'error');
                }
            }, 500);
        }
    });
};

window.setupDimensionCalculation = function() {
    ['editLength', 'editWidth', 'editHeight', 'editDeadWeight'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', window.calculateVolumetricWeight);
    });
    window.calculateVolumetricWeight();
};

// ========== TAG MODAL ==========
window.toggleTag = function(btn, tagValue) {
    const idx = selectedTags.indexOf(tagValue);
    if (idx > -1) { selectedTags.splice(idx, 1); btn.classList.remove('selected'); }
    else { selectedTags.push(tagValue); btn.classList.add('selected'); }
    const input = document.getElementById('manualTagInput');
    if (input) input.value = selectedTags.join(', ');
};
window.setTagValue = function(tagValue) {
    if (!selectedTags.includes(tagValue)) {
        selectedTags.push(tagValue);
        const input = document.getElementById('manualTagInput');
        if (input) input.value = selectedTags.join(', ');
    }
};
window.openTagModal = function(orderId, merchantId) {
    currentTagOrderId = orderId;
    selectedTags = [];
    const input = document.getElementById('manualTagInput');
    if (input) input.value = '';
    document.querySelectorAll('.tag-option-btn').forEach(b => b.classList.remove('selected'));
    const el = document.getElementById('modalOrderId');
    if (el) el.textContent = '#' + merchantId;
    const modal = document.getElementById('tagModal');
    const content = document.getElementById('tagModalContent');
    if (modal) { modal.classList.remove('hidden'); setTimeout(() => { content?.classList.remove('scale-95', 'opacity-0'); content?.classList.add('scale-100', 'opacity-100'); }, 10); document.body.style.overflow = 'hidden'; }
};
window.closeTagModal = function() {
    const content = document.getElementById('tagModalContent');
    content?.classList.remove('scale-100', 'opacity-100');
    content?.classList.add('scale-95', 'opacity-0');
    setTimeout(() => { document.getElementById('tagModal')?.classList.add('hidden'); document.body.style.overflow = ''; }, 200);
};
window.saveTag = async function() {
    const btn = document.getElementById('saveTagBtn');
    if (!selectedTags.length) { showToast('Please select at least one tag', 'error'); return; }
    if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Saving...'; }
    try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const res = await fetch("{{ route('orders.update-tag') }}", { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }, body: JSON.stringify({ order_id: currentTagOrderId, tag: selectedTags }) });
        const result = await res.json();
        if (result.success) {
            const div = document.getElementById('tag-display-' + (Array.isArray(currentTagOrderId) ? currentTagOrderId[0] : currentTagOrderId));
            if (div) div.innerHTML = selectedTags.map(t => `<span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100">${t}</span>`).join('');
            showToast('Tags updated!', 'success');
            window.closeTagModal();
        } else { showToast(result.message || 'Error saving tags', 'error'); }
    } catch (e) { console.error(e); showToast('Connection error!', 'error'); }
    finally { if (btn) { btn.disabled = false; btn.textContent = 'Add Tags'; } }
};

// ========== COURIER MODAL ==========
window.openCourierModal = async function(orderId, merchantId) {
    currentOrderId = orderId; currentMerchantId = merchantId; currentFilter = 'all';
    const modal = document.getElementById('courierModal');
    const panel = document.getElementById('courierPanel');
    const orderIdEl = document.getElementById('courierModalOrderId');
    if (orderIdEl) orderIdEl.textContent = '#' + merchantId;
    if (modal) { modal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    document.querySelectorAll('.courier-tab').forEach(tab => {
        const isAll = tab.dataset.tab === 'all';
        tab.classList.toggle('active', isAll); tab.classList.toggle('text-gold', isAll); tab.classList.toggle('border-gold', isAll);
        tab.classList.toggle('text-gray-400', !isAll); tab.classList.toggle('border-transparent', !isAll);
    });
    const loader = document.getElementById('courierLoading');
    const container = document.getElementById('courierListContainer');
    if (loader) { loader.style.display = 'block'; loader.innerHTML = '<i class="fa fa-spinner fa-spin text-4xl text-gold"></i><p class="mt-4 text-gray-500 font-medium">Finding best rates for you...</p>'; }
    if (container) container.classList.add('hidden');
    try { await Promise.all([window.fetchPickupAddresses(), window.fetchOrderDetails(orderId)]); await window.fetchCourierRates(orderId); }
    catch (e) { console.error(e); showToast('Error loading data', 'error'); }
    if (panel) setTimeout(() => { panel.classList.remove('translate-x-full'); panel.classList.add('translate-x-0'); }, 50);
};
window.closeCourierModal = function() {
    const panel = document.getElementById('courierPanel');
    if (panel) { panel.classList.remove('translate-x-0'); panel.classList.add('translate-x-full'); }
    setTimeout(() => { document.getElementById('courierModal')?.classList.add('hidden'); document.body.style.overflow = ''; }, 300);
};
// window.fetchOrderDetails = async function(orderId) {
//     const container = document.getElementById('orderDetailsContainer');
//     if (!container) return;
//     container.innerHTML = '<div class="text-center py-4"><i class="fa fa-spinner fa-spin text-gold"></i></div>';
//     try {
//         const res = await fetch(`/seller/orders/${orderId}/details`);
//         const data = await res.json();
//         if (data.success && data.order) {
//             const o = data.order;
//             const itemsHtml = o.items?.length > 0 ? o.items.map(i => `<div class="mb-2 p-2 bg-white rounded border border-gray-100"><div class="text-[11px] font-bold text-gray-800">${i.product_name}</div><div class="text-[10px] text-gray-500">SKU: ${i.sku || 'N/A'} | Qty: ${i.quantity || i.qty}</div></div>`).join('') : '<div class="text-[11px] text-gray-400">No items</div>';
//             container.innerHTML = `
//                 <div class="order-detail-row"><span class="order-detail-label">Order Date:</span><span class="order-detail-value">${o.order_date || o.created_at}</span></div>
//                 <div class="order-detail-row"><span class="order-detail-label">Zone:</span><span class="order-detail-value"><span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded text-xs">${o.zone || 'Local'}</span></span></div>
//                 <div class="order-detail-row"><span class="order-detail-label">Order ID:</span><span class="order-detail-value font-bold">#${o.merchant_order_id}</span></div>
//                 <div class="order-detail-row"><span class="order-detail-label">AWB:</span><span class="order-detail-value">${o.waybill || 'N/A'}</span></div>
//                 <div class="order-detail-row"><span class="order-detail-label">Status:</span><span class="order-detail-value"><span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs">${o.status}</span></span></div>
//                 <div class="order-detail-row mt-2"><span class="order-detail-label">Payment:</span><span class="order-detail-value">₹${parseFloat(o.product_subtotal).toLocaleString()} <span class="${o.payment_mode == 1 ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700'} px-1.5 py-0.5 rounded text-xs">${o.payment_mode == 1 ? 'COD' : 'PREPAID'}</span></span></div>
//                 <div class="mt-4 pb-1 border-b border-gray-200"><h6 class="text-[11px] font-bold uppercase text-gray-400">Customer Details</h6></div>
//                 <div class="py-2 text-[12px]"><div class="font-bold text-gray-800">${o.buyer_name}</div><div class="text-gray-600 leading-tight">${o.complete_address || o.address}</div><div class="text-gray-600">${o.city}, ${o.state} - <strong>${o.pincode}</strong></div><div class="text-yellow-600 font-bold mt-1"><i class="fa fa-phone-alt"></i> ${o.phone_number}</div></div>
//                 <div class="mt-2 pb-1 border-b border-gray-200"><h6 class="text-[11px] font-bold uppercase text-gray-400">Pickup Address</h6></div>
//                 <div class="py-2 text-[12px]"><div class="font-bold text-gray-800">${o.pickup_address?.warehouse_name || 'Default Warehouse'}</div><div class="text-gray-500 text-[11px]">${o.pickup_address?.city || ''} Pincode: ${o.pickup_address?.pincode || o.source_pincode || 'N/A'}</div></div>
//                 <div class="mt-2 pb-1 border-b border-gray-200"><h6 class="text-[11px] font-bold uppercase text-gray-400">Dimension & Weight</h6></div>
//                 <div class="py-2 text-[12px]"><div class="flex justify-between"><span>Dimensions:</span> <strong>${parseInt(o.length)}x${parseInt(o.width)}x${parseInt(o.height)} cm</strong></div><div class="flex justify-between"><span>Entered Weight:</span> <strong>${o.weight} Kg</strong></div><div class="flex justify-between"><span>Volumetric:</span> <strong class="text-blue-600">${o.volumetric_weight || '0.00'} Kg</strong></div></div>
//                 <div class="mt-2 pb-1 border-b border-gray-200"><h6 class="text-[11px] font-bold uppercase text-gray-400">Product Detail</h6></div>
//                 <div class="mt-2">${itemsHtml}</div>`;
//         }
//     } catch (e) { console.error(e); container.innerHTML = '<div class="text-red-500 p-2 text-center text-xs">Failed to load details</div>'; }
// };
window.fetchOrderDetails = async function(orderId) {
    const container = document.getElementById('orderDetailsContainer');
    if (!container) return;
    
    container.innerHTML = '<div class="text-center py-4"><i class="fa fa-spinner fa-spin text-gold"></i></div>';
    
    try {
        const res = await fetch(`/seller/orders/${orderId}/details`);
        const data = await res.json();
        
        if (data.success && data.order) {
            const o = data.order;
            
            // ✅ FIX 1: Safe amount parsing (controller returns formatted string)
            // const rawAmount = o.product_subtotal ?? o.total_amount ?? 0;
            // const amount = parseFloat(rawAmount) || 0;
            // const amountDisplay = amount.toLocaleString('en-IN', { 
            //     minimumFractionDigits: 2, 
            //     maximumFractionDigits: 2 
            // });
            
            // // ✅ FIX 2: Payment mode is already 'COD' or 'PREPAID' string from controller
            // const paymentMode = o.payment_mode; // 'COD' or 'PREPAID'
            // const isCod = paymentMode === 'COD';
            // const paymentLabel = isCod ? 'COD' : 'PREPAID';
            // const paymentClass = isCod 
            //     ? 'bg-orange-100 text-orange-700' 
            //     : 'bg-blue-100 text-blue-700';
            
            const rawAmount = o.product_subtotal ?? o.total_amount ?? 0;
// Remove commas & non-numeric chars before parsing
const cleanAmount = String(rawAmount).replace(/[^0-9.-]/g, '');
const amount = parseFloat(cleanAmount) || 0;
const amountDisplay = amount.toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});

// ✅ FIXED: Handle both String ('COD') & Integer (1/2) from Laravel
const rawPM = o.payment_mode;
const isCod = (rawPM === 1 || rawPM === '1' || String(rawPM).toUpperCase() === 'COD' || rawPM === true);
const paymentLabel = isCod ? 'COD' : 'PREPAID';
const paymentClass = isCod
    ? 'bg-orange-100 text-orange-700'
    : 'bg-blue-100 text-blue-700';
            // ✅ FIX 3: Safe dimension/weight parsing
            const weight = parseFloat(o.weight ?? 0) || 0;
            const length = parseInt(o.length ?? 0) || 0;
            const width = parseInt(o.width ?? 0) || 0;
            const height = parseInt(o.height ?? 0) || 0;
            
            // Items HTML with safe field access
            const itemsHtml = o.items?.length > 0 
                ? o.items.map(i => `
                    <div class="mb-2 p-2 bg-white rounded border border-gray-100">
                        <div class="text-[11px] font-bold text-gray-800">${i.product_name ?? 'N/A'}</div>
                        <div class="text-[10px] text-gray-500">
                            SKU: ${i.sku ?? 'N/A'} | Qty: ${i.quantity ?? i.qty ?? 1}
                        </div>
                    </div>
                `).join('') 
                : '<div class="text-[11px] text-gray-400">No items</div>';
            
            // ✅ Build HTML with all safe values
            container.innerHTML = `
                <div class="order-detail-row">
                    <span class="order-detail-label">Order Date:</span>
                    <span class="order-detail-value">${o.order_date ?? o.created_at ?? 'N/A'}</span>
                </div>
                <div class="order-detail-row">
                    <span class="order-detail-label">Zone:</span>
                    <span class="order-detail-value">
                        <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded text-xs">
                            ${o.zone ?? 'Local'}
                        </span>
                    </span>
                </div>
                <div class="order-detail-row">
                    <span class="order-detail-label">Order ID:</span>
                    <span class="order-detail-value font-bold">#${o.merchant_order_id ?? 'N/A'}</span>
                </div>
                <div class="order-detail-row">
                    <span class="order-detail-label">AWB:</span>
                    <span class="order-detail-value">${o.waybill ?? 'N/A'}</span>
                </div>
                <div class="order-detail-row">
                    <span class="order-detail-label">Status:</span>
                    <span class="order-detail-value">
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs">
                            ${o.status ?? 'NEW'}
                        </span>
                    </span>
                </div>
                
                <!-- ✅ FIXED PAYMENT ROW -->
                <div class="order-detail-row mt-2">
                    <span class="order-detail-label">Payment:</span>
                    <span class="order-detail-value">
                        ₹${amountDisplay} 
                        <span class="${paymentClass} px-1.5 py-0.5 rounded text-xs">
                            ${paymentLabel}
                        </span>
                    </span>
                </div>
                
                <div class="mt-4 pb-1 border-b border-gray-200">
                    <h6 class="text-[11px] font-bold uppercase text-gray-400">Customer Details</h6>
                </div>
                <div class="py-2 text-[12px]">
                    <div class="font-bold text-gray-800">${o.buyer_name ?? 'N/A'}</div>
                    <div class="text-gray-600 leading-tight">${o.complete_address ?? o.address ?? 'N/A'}</div>
                    <div class="text-gray-600">
                        ${o.city ?? ''}, ${o.state ?? ''} - <strong>${o.pincode ?? 'N/A'}</strong>
                    </div>
                    <div class="text-yellow-600 font-bold mt-1">
                        <i class="fa fa-phone-alt"></i> ${o.phone_number ?? 'N/A'}
                    </div>
                </div>
                
                <div class="mt-2 pb-1 border-b border-gray-200">
                    <h6 class="text-[11px] font-bold uppercase text-gray-400">Pickup Address</h6>
                </div>
                <div class="py-2 text-[12px]">
                    <div class="font-bold text-gray-800">
                        ${o.pickup_address?.warehouse_name ?? 'Default Warehouse'}
                    </div>
                    <div class="text-gray-500 text-[11px]">
                        ${o.pickup_address?.city ?? ''} Pincode: ${o.pickup_address?.pincode ?? o.source_pincode ?? 'N/A'}
                    </div>
                </div>
                
                <div class="mt-2 pb-1 border-b border-gray-200">
                    <h6 class="text-[11px] font-bold uppercase text-gray-400">Dimension & Weight</h6>
                </div>
                <div class="py-2 text-[12px] space-y-1">
                    <div class="flex justify-between">
                        <span>Dimensions:</span> 
                        <strong>${length}×${width}×${height} cm</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Entered Weight:</span> 
                        <strong>${weight.toFixed(3)} Kg</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Volumetric:</span> 
                        <strong class="text-blue-600">${o.volumetric_weight ?? '0.000'} Kg</strong>
                    </div>
                </div>
                
                <div class="mt-2 pb-1 border-b border-gray-200">
                    <h6 class="text-[11px] font-bold uppercase text-gray-400">Product Detail</h6>
                </div>
                <div class="mt-2">${itemsHtml}</div>
            `;
            
        } else {
            container.innerHTML = `<div class="text-red-500 p-2 text-center text-xs">${data.message || 'Failed to load order details'}</div>`;
        }
    } catch (e) {
        console.error('Fetch order details error:', e);
        container.innerHTML = '<div class="text-red-500 p-2 text-center text-xs">Failed to load details</div>';
    }
};
window.fetchPickupAddresses = async function() {
    const select = document.getElementById('pickupAddressSelect');
    if (!select) return;
    select.innerHTML = '<option value="">Loading...</option>';
    try {
        const res = await fetch("{{ route('pickup-addresses.index') }}");
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        if (data.success && data.addresses?.length > 0) {
            userPickupAddresses = data.addresses;
            select.innerHTML = userPickupAddresses.map(addr => `<option value="${addr.id}" ${addr.is_default == 1 ? 'selected' : ''}>${addr.warehouse_name} - ${addr.city}, ${addr.pincode} ${addr.is_default == 1 ? '⭐' : ''}</option>`).join('');
            const newSelect = select.cloneNode(true);
            select.parentNode.replaceChild(newSelect, select);
            newSelect.addEventListener('change', function() { if (currentOrderId) window.fetchCourierRates(currentOrderId, this.value); });
        } else { select.innerHTML = `<option value="">${data.message || 'No pickup addresses found'}</option>`; }
    } catch (e) { console.error(e); select.innerHTML = '<option value="">Error loading addresses</option>'; }
};
window.filterCouriers = function(filterType) {
    currentFilter = filterType;
    document.querySelectorAll('.courier-tab').forEach(tab => {
        const active = tab.dataset.tab === filterType;
        tab.classList.toggle('active', active); tab.classList.toggle('text-gold', active); tab.classList.toggle('border-gold', active);
        tab.classList.toggle('text-gray-400', !active); tab.classList.toggle('border-transparent', !active);
    });
    window.renderCouriers(allCouriers);
};
window.renderCouriers = function(couriers) {
    const tableBody = document.getElementById('courierTableBody');
    const loader = document.getElementById('courierLoading');
    const container = document.getElementById('courierListContainer');
    if (!tableBody || !loader || !container) return;
    const filtered = currentFilter === 'all' ? couriers : couriers.filter(c => (c.service_mode || '').toLowerCase().includes(currentFilter));
    if (!filtered.length) { loader.style.display = 'block'; loader.innerHTML = '<p class="text-center text-gray-500 py-10">No courier services available for this selection.</p>'; container.classList.add('hidden'); return; }
    loader.style.display = 'none'; container.classList.remove('hidden'); tableBody.innerHTML = '';
    let baseUrl = "{{ asset('storage/') }}/";
    filtered.forEach(rate => {
        console.log('Courier Rate Object:', rate);
        let logo = rate.logo ? (rate.logo.startsWith('http') ? rate.logo : baseUrl + rate.logo) : rate.logo_url;
        const row = document.createElement('tr');
        row.className = 'courier-row';
        row.innerHTML = `
            <td class="px-6 py-4"><div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-gray-50 flex items-center justify-center overflow-hidden border border-gray-100 p-1">
                    <img src="${logo}" class="w-full h-full object-contain" alt="${rate.courier_name}" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(rate.courier_name)}&background=D4AF37&color=fff'">
                </div>
                <div><div class="font-bold text-gray-800 text-sm">${rate.courier_name}</div><div class="text-[11px] text-gray-500">${rate.service_mode || 'Standard'}</div></div>
            </div></td>
            <td class="px-6 py-4"><div class="rating-circle" style="border-color:${rate.rating >= 4 ? '#22c55e' : '#eab308'}">${rate.rating}</div></td>
            <td class="px-6 py-4"><span class="text-sm text-gray-700 font-medium">${rate.expected_pickup || 'Today'}</span></td>
            <td class="px-6 py-4"><span class="text-sm text-gray-700">${rate.estimated_delivery || '3-5 Days'}</span></td>
            <td class="px-6 py-4"><div class="text-sm"><span class="text-gray-500">Charges: </span><span class="font-bold text-gray-900">₹${parseFloat(rate.shipping_charge).toFixed(2)}</span></div></td>
            <td class="px-6 py-4 text-right"><button onclick="window.finalizeBooking(${currentOrderId},${rate.courier_id}, ${rate.shipping_charge}, ${rate.cod_charge ?? 0}, '${rate.service_mode}','${rate.courier_name}')" class="bg-[#1e1b4b] hover:bg-[#0f0d2a] text-white px-5 py-2 rounded-lg text-sm font-bold transition-all">Book Now</button></td>`;
        tableBody.appendChild(row);
    });
};
// window.fetchCourierRates = async function(orderId, pickupAddressId = null) {
//     const container = document.getElementById('courierListContainer');
//     const loader = document.getElementById('courierLoading');
//     const select = document.getElementById('pickupAddressSelect');
//     if (!pickupAddressId && select) pickupAddressId = select.value || null;
//     if (loader) { loader.style.display = 'block'; loader.innerHTML = '<i class="fa fa-spinner fa-spin text-4xl text-gold"></i><p class="mt-4 text-gray-500 font-medium">Finding best rates for you...</p>'; }
//     if (container) container.classList.add('hidden');
//     try {
//         let url = `/seller/orders/get-rates/${orderId}`;
//         if (pickupAddressId) url += `?pickup_address_id=${pickupAddressId}`;
//         const res = await fetch(url);
//         const data = await res.json();
//         if (data.success && data.rates?.length > 0) { allCouriers = data.rates; window.renderCouriers(allCouriers); }
//         else { if (loader) { loader.style.display = 'block'; loader.innerHTML = '<p class="text-center text-red-500 py-10">No courier services available for this pincode.</p>'; } }
//     } catch (e) { console.error(e); if (loader) { loader.style.display = 'block'; loader.innerHTML = '<p class="text-center text-red-500 py-10">Error fetching rates.</p>'; } showToast('Error fetching rates', 'error'); }
// };
window.fetchCourierRates = async function(orderId, pickupAddressId = null) {
    const container = document.getElementById('courierListContainer');
    const loader = document.getElementById('courierLoading');
    const select = document.getElementById('pickupAddressSelect');
    
    if (!pickupAddressId && select) pickupAddressId = select.value || null;
    
    if (loader) { 
        loader.style.display = 'block'; 
        loader.innerHTML = '<i class="fa fa-spinner fa-spin text-4xl text-gold"></i><p class="mt-4 text-gray-500 font-medium">Finding best rates for you...</p>'; 
    }
    if (container) container.classList.add('hidden');
    
    try {
        let url = `/seller/orders/get-rates/${orderId}`;
        if (pickupAddressId) url += `?pickup_address_id=${pickupAddressId}`;
        
        const res = await fetch(url);
        const data = await res.json();
        
        // ✅ SUCCESS: Rates available
        if (data.success && data.rates?.length > 0) { 
            allCouriers = data.rates; 
            window.renderCouriers(allCouriers); 
        }
        // ❌ ERROR: API se specific error message aaya hai
        else if (data.message) {
            if (loader) { 
                loader.style.display = 'block'; 
                // ✅ Yahan actual error message dikhayein
                loader.innerHTML = `<p class="text-center text-red-500 py-10 font-medium">${data.message}</p>`; 
            }
            // ✅ Toast notification bhi dikhayein
            showToast(data.message, 'error');
        }
        // ❌ Generic fallback (agar message bhi nahi aaya)
        else { 
            if (loader) { 
                loader.style.display = 'block'; 
                loader.innerHTML = '<p class="text-center text-red-500 py-10">No courier services available for this pincode.</p>'; 
            } 
        }
        
    } catch (e) { 
        console.error(e); 
        if (loader) { 
            loader.style.display = 'block'; 
            loader.innerHTML = '<p class="text-center text-red-500 py-10">Error fetching rates. Please try again.</p>'; 
        } 
        showToast('Error fetching rates', 'error'); 
    }
};
window.finalizeBooking = async function(orderId, courierId, shippingCharge, codCharge, serviceMode, courierName) {
    // 1️⃣ Pickup Address validation
    const select = document.getElementById('pickupAddressSelect');
    const pickupAddressId = select?.value || null;
    
    if (!pickupAddressId) { 
        showToast('Please select a pickup address first', 'error'); 
        return; 
    }
    
    // 2️⃣ Confirmation
    if (!confirm('Confirm booking this order with Fleetshyp?')) return;
    
    showToast('Processing booking...', 'info');
    
    try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
        
        // 3️⃣ API Call to bookCourier - Use Blade route helper for correct URL
        const response = await fetch("{{ route('orders.book', ['order' => ':orderId']) }}".replace(':orderId', orderId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                order_id: parseInt(orderId),
                courier_id: parseInt(courierId) || 0,
                pickup_address_id: parseInt(pickupAddressId),
                forward_charge: parseFloat(shippingCharge) || 0,
                cod_charge: parseFloat(codCharge) || 0,
                service_mode: serviceMode || 'surface',
                courier_name: courierName
            })
        });
        
        // 4️⃣ Parse Response
        const result = await response.json();
        
        // 5️⃣ Handle Success/Error
        if (result.success) {
            // ✅ Success: Show AWB + Reload
            showToast(`✅ Booked! AWB: ${result.waybill}`, 'success');
            
            // Reload after 1.5 seconds - Close modal first
            setTimeout(() => {
                if (typeof window.closeCourierModal === 'function') {
                    window.closeCourierModal();
                }
                location.reload();
            }, 1500);
            
        } else {
            // ❌ Error: Show message from API
            showToast(result.message || 'Booking failed', 'error');
        }
        
    } catch (error) {
        console.error('Booking error:', error);
        showToast('Connection error! Please try again.', 'error');
    }
};

// ========== EDIT ORDER MODAL ==========
window.openEditOrderModal = async function(orderId, merchantId) {
    const form = document.getElementById('editOrderForm');
    if (form) form.reset();
    document.getElementById('editOrderId').value = orderId;
    document.getElementById('editModalOrderId').textContent = '#' + merchantId;
    ['volumetricWeight', 'billingWeight'].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = '0.000'; });
    const modal = document.getElementById('editOrderModal');
    const panel = document.getElementById('editOrderPanel');
    const saveBtn = document.getElementById('saveEditBtn');
    if (modal) modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (saveBtn) { saveBtn.disabled = true; saveBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Loading...'; }
    try {
        const res = await fetch(`/seller/orders/${orderId}/edit-data`);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const result = await res.json();
        if (result.success && result.order) {
            const o = result.order;
            const set = (id, val) => { const el = document.getElementById(id); if (el && val != null) el.value = val; };
            set('editMerchantOrderId', o.merchant_order_id); set('editOrderDate', o.order_date || o.created_at);
            set('editStatus', o.status); set('editPaymentMode', o.payment_mode); set('editTotalAmount', o.product_subtotal);
            set('editBuyerName', o.buyer_name); set('editPhoneNumber', o.phone_number); set('editEmail', o.email_id);
            set('editAddress', o.complete_address); set('editPincode', o.pincode); set('editCity', o.city); set('editState', o.state);
            set('editDeadWeight', o.weight); set('editLength', o.length); set('editWidth', o.width); set('editHeight', o.height);
            if (o.items?.length > 0) {
                const item = o.items[0];
                set('editProductName', item.product_name); set('editSku', item.sku); set('editUnitPrice', item.unit_price);
                set('editQuantity', item.quantity); set('editHsn', item.hsn_code); set('editDiscount', item.order_discount);
                set('editShipping', item.shipping_charge); set('editGiftWrap', item.gift_wrap_charge); set('editTransaction', item.transaction_fee);
            }
            if (saveBtn) { saveBtn.disabled = false; saveBtn.innerHTML = '<i class="fa fa-save mr-2"></i>Update Order'; }
            if (panel) setTimeout(() => { panel.classList.remove('translate-x-full'); panel.classList.add('translate-x-0'); }, 50);
            setTimeout(() => {
                window.setupPincodeAutoFill();
                window.setupDimensionCalculation();
                const existingPin = document.getElementById('editPincode')?.value;
                if (existingPin?.length === 6) {
                    window.fetchLocationFromPincode(existingPin).then(loc => {
                        if (!loc) return;
                        const zEl = document.getElementById('editZoneDisplay');
                        const cEl = document.getElementById('codAvailability');
                        if (zEl) zEl.textContent = loc.zone || 'N/A';
                        if (cEl) { cEl.textContent = loc.cod_available ? 'Available ✓' : 'Not Available ✗'; cEl.className = `inline-block px-3 py-1.5 rounded-lg text-xs font-bold border ${loc.cod_available ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200'}`; }
                    });
                }
            }, 150);
        } else { throw new Error(result.message || 'Failed to load order'); }
    } catch (e) { console.error(e); showToast('Error loading order: ' + e.message, 'error'); modal?.classList.add('hidden'); document.body.style.overflow = ''; if (saveBtn) { saveBtn.disabled = false; saveBtn.innerHTML = '<i class="fa fa-save mr-2"></i>Update Order'; } }
};
window.closeEditOrderModal = function() {
    const panel = document.getElementById('editOrderPanel');
    if (panel) { panel.classList.remove('translate-x-0'); panel.classList.add('translate-x-full'); }
    setTimeout(() => { document.getElementById('editOrderModal')?.classList.add('hidden'); document.body.style.overflow = ''; }, 300);
};
window.saveEditedOrder = async function() {
    const orderId = document.getElementById('editOrderId')?.value;
    const saveBtn = document.getElementById('saveEditBtn');
    
    if (!orderId) { 
        showToast('Order ID missing', 'error'); 
        return; 
    }
    
    const g = id => document.getElementById(id)?.value?.trim() || '';
    
    // Validation
    if (!g('editBuyerName'))   { showToast('Customer name is required', 'error'); return; }
    if (!g('editPhoneNumber')) { showToast('Phone number is required', 'error'); return; }
    if (!g('editPincode'))     { showToast('Pincode is required', 'error'); return; }
    
    if (saveBtn) { 
        saveBtn.disabled = true; 
        saveBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Saving...'; 
    }
    
    // ✅ Build payload — sirf wahi keys jo backend expect kar raha hai
    const payload = {
        status:           g('editStatus'),
        payment_mode:     g('editPaymentMode'),
        product_subtotal: g('editTotalAmount'),   // ✅ Fixed key name
        total_amount:     g('editTotalAmount'),   // dono bhej do safe side
        
        // Product / Item
        product_name:     g('editProductName'),
        sku:              g('editSku'),
        unit_price:       g('editUnitPrice'),
        quantity:         g('editQuantity'),
        hsn:              g('editHsn'),
        discount:         g('editDiscount'),
        shipping_charge:  g('editShipping'),
        gift_wrap_charge: g('editGiftWrap'),      // ✅ Added
        transaction_fee:  g('editTransaction'),   // ✅ Added
        
        // Dimensions
        dead_weight:      g('editDeadWeight'),
        length:           g('editLength'),
        width:            g('editWidth'),
        height:           g('editHeight'),
        
        // Customer
        buyer_name:       g('editBuyerName'),
        phone_number:     g('editPhoneNumber'),
        email:            g('editEmail'),
        company_name:     g('editCompanyName'),
        address:          g('editAddress'),
        pincode:          g('editPincode'),
        city:             g('editCity'),
        state:            g('editState'),
        alt_phone:        g('editAltPhone'),
        landmark:         g('editLandmark'),
    };
    
    // ✅ Empty strings ko hata do (taaki "nullable" validation pass ho)
    Object.keys(payload).forEach(k => {
        if (payload[k] === '' || payload[k] === null || payload[k] === undefined) {
            delete payload[k];
        }
    });
    
    console.log('🚀 Sending payload:', payload);
    
    try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
        
        const res = await fetch(`/seller/orders/${orderId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });
        
        // ✅ Response ko text karke pehle dekho
        const responseText = await res.text();
        console.log('📥 Raw Response:', responseText);
        
        let result;
        try {
            result = JSON.parse(responseText);
        } catch (e) {
            console.error('❌ Invalid JSON response:', responseText);
            throw new Error('Server returned invalid response. Check console.');
        }
        
        console.log('📦 Parsed Result:', result);
        
        if (!res.ok) {
            // 422 = Validation error
            if (res.status === 422 && result.errors) {
                const firstError = Object.values(result.errors)[0][0];
                throw new Error(firstError || 'Validation failed');
            }
            throw new Error(result.message || `HTTP ${res.status}`);
        }
        
        if (result.success) {
            showToast('Order updated successfully!', 'success');
            window.closeEditOrderModal();
            setTimeout(() => location.reload(), 1000);
        } else {
            throw new Error(result.message || 'Update failed');
        }
        
    } catch (e) {
        console.error('❌ Update Error:', e);
        showToast('Error: ' + e.message, 'error');
    } finally {
        if (saveBtn) { 
            saveBtn.disabled = false; 
            saveBtn.innerHTML = '<i class="fa fa-save mr-2"></i>Update Order'; 
        }
    }
};

// ========== BULK DIMENSION SAVE ==========
window.saveBulkDimensions = async function() {
    const data = { order_ids: bulkSelectedIds, length: document.getElementById('bulkLength')?.value || null, width: document.getElementById('bulkWidth')?.value || null, height: document.getElementById('bulkHeight')?.value || null, weight: document.getElementById('bulkWeight')?.value || null };
    if (!data.length && !data.width && !data.height && !data.weight) { showToast('Please enter at least one dimension', 'error'); return; }
    try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const res = await fetch("{{ route('orders.bulk-update-dimensions') }}", { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }, body: JSON.stringify(data) });
        const result = await res.json();
        if (result.success) { showToast(result.message, 'success'); document.getElementById('bulkDimensionModal').classList.add('hidden'); document.body.style.overflow = ''; setTimeout(() => location.reload(), 1000); }
        else { showToast(result.message || 'Failed', 'error'); }
    } catch (e) { showToast('Error!', 'error'); }
};

// ========== BULK ACTION ==========
window.bulkAction = async function(type, ids) {
    let targetIds = ids;
    if (type === 'sync_live' && (!targetIds || !targetIds.length)) {
        targetIds = Array.from(document.querySelectorAll('.order-checkbox')).map(cb => cb.value);
    }
    if (!targetIds || !targetIds.length) { showToast('Please select at least one order', 'error'); return; }

    if (type === 'update_tag') { window.openTagModal(ids, "Selected Orders (" + ids.length + ")"); return; }

    if (type === 'update_dimension') {
        bulkSelectedIds = ids;
        const countDisplay = document.getElementById('bulkDimCountDisplay');
        if (countDisplay) countDisplay.textContent = ids.length;
        const modal = document.getElementById('bulkDimensionModal');
        if (modal) { modal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
        return;
    }

    if (type === 'sync_live') {
        showToast(`Syncing ${targetIds.length} orders...`, 'info');
        try {
            const res = await fetch("{{ route('orders.sync-status') }}", { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }, body: JSON.stringify({ order_ids: targetIds }) });
            const result = await res.json();
            if (result.success) { showToast(result.message, 'success'); setTimeout(() => location.reload(), 1500); }
            else { showToast(result.message || 'Sync failed', 'error'); }
        } catch (e) { showToast('System Error!', 'error'); }
        return;
    }

    if (type === 'clone') {
        if (!confirm(`Clone ${ids.length} orders?`)) return;
        showToast('Cloning orders...', 'info');
        try {
            const res = await fetch("{{ route('orders.bulk-clone') }}", { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }, body: JSON.stringify({ order_ids: ids }) });
            const result = await res.json();
            if (result.success) { showToast(result.message, 'success'); setTimeout(() => location.reload(), 1500); }
            else { showToast(result.message, 'error'); }
        } catch (e) { showToast('Cloning failed!', 'error'); }
        return;
    }

    if (type === 'download-label') { window.location.href = `/seller/orders/bulk-print-label/${ids.join(',')}`; return; }

    if (type === 'download-manifest') { window.location.href = `/seller/orders/bulk-download-manifest?ids=${ids.join(',')}`; return; }

    if (type === 'download-picklist') { window.location.href = `/seller/orders/download-picklist/${ids.join(',')}`; return; }

    if (type === 'download-invoice') { window.location.href = `/seller/orders/download-invoice/${ids.join(',')}`; return; }

    if (type === 'export-excel' || type === 'export_excel' || type === 'export') {
        showToast('Generating Excel...', 'info');
        const link = document.createElement('a');
        link.href = `/seller/orders/export-excel?ids=${ids.join(',')}`;
        link.setAttribute('download', `Orders_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        return;
    }

    // manifest / cancel / book_now / archive / assign_user
    let url = '';
    if (type === 'manifest')     url = "{{ route('orders.bulk-manifest') }}";
    else if (type === 'cancel')  url = "{{ route('orders.bulk-cancel') }}";
   
    else if (type === 'archive') url = "#";
    else if (type === 'assign_user') url = "#";
    else if (type === 'book_now') { showToast('Please use individual Book Now buttons', 'info'); return; }

    if (!url) { showToast('Action not configured', 'error'); return; }
    showToast(`Processing ${type}...`, 'info');
    try {
        const res = await fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: JSON.stringify({ order_ids: ids }) });
        const result = await res.json();
        if (result.success) { if (result.download_url) window.open(result.download_url, '_blank'); showToast(result.message, 'success'); setTimeout(() => location.reload(), 1500); }
        else { showToast(result.message || 'Action failed', 'error'); }
    } catch (e) { showToast('System Error!', 'error'); }
};

// ========== UTILITY ==========
window.changePerPage = function(value) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page');
    window.location.href = url.toString();
};
window.viewTracking = function(awb) { window.open(`/tracking/${awb}`, '_blank'); };

// ========== DATE PICKERS ==========
function initDatePickers() {
    ['orderDateRange', 'awbDateRange', 'statusDateRange'].forEach(id => {
        const el = document.getElementById(id);
        if (el && !flatpickrInstances[id]) {
            flatpickrInstances[id] = flatpickr(el, { mode: 'range', dateFormat: 'Y-m-d', locale: { firstDayOfWeek: 1 }, allowInput: true });
        }
    });
}

// ========== COLUMN VISIBILITY ==========
function applyColumnVisibility(columns) {
    document.querySelectorAll('#ordersTable [data-col]').forEach(cell => { cell.style.display = columns.includes(cell.dataset.col) ? '' : 'none'; });
}

// ========== DOM READY ==========
document.addEventListener('DOMContentLoaded', function() {
    // Checkbox Selection
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.order-checkbox');
    if (selectAll) {
        selectAll.addEventListener('change', function() { checkboxes.forEach(cb => cb.checked = this.checked); window.updateBulkSelection(); });
    }
    checkboxes.forEach(cb => cb.addEventListener('change', function() {
        if (selectAll) selectAll.checked = Array.from(checkboxes).every(c => c.checked);
        window.updateBulkSelection();
    }));

    // Filter Toggle
    const filterBody = document.getElementById('filterBody');
    const toggleFilters = document.getElementById('toggleFilters');
    const filterToggleText = document.getElementById('filterToggleText');
    const filterToggleIcon = document.getElementById('filterToggleIcon');
    let isFilterOpen = false;
    if (toggleFilters) {
        toggleFilters.addEventListener('click', function(e) {
            e.preventDefault();
            isFilterOpen = !isFilterOpen;
            filterBody?.classList.toggle('hidden', !isFilterOpen);
            if (filterToggleText) filterToggleText.textContent = isFilterOpen ? 'Hide Filters' : 'Show Filters';
            if (filterToggleIcon) filterToggleIcon.style.transform = isFilterOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            if (isFilterOpen) setTimeout(initDatePickers, 100);
        });
    }
    if (filterBody && !filterBody.classList.contains('hidden')) initDatePickers();

    // Clear Filters
    document.getElementById('clearFilters')?.addEventListener('click', function() { if (confirm('Clear all filters?')) window.location.href = "{{ route('orders.index') }}"; });

    // Refresh
    document.getElementById('refreshTable')?.addEventListener('click', function() { this.querySelector('i')?.classList.add('fa-spin'); window.location.reload(); });

    // Header Bulk Actions dropdown
    document.querySelectorAll('[data-bulk-action]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.bulkAction;
            const ids = Array.from(document.querySelectorAll('.order-checkbox:checked')).map(cb => cb.value);
            window.bulkAction(action, ids);
        });
    });

    // Column Settings
    document.getElementById('saveColumns')?.addEventListener('click', function() {
        const visible = Array.from(document.querySelectorAll('#columnSettingsModal [data-column]:checked')).map(chk => chk.dataset.column);
        localStorage.setItem('orderTableColumns', JSON.stringify(visible));
        applyColumnVisibility(visible);
        showToast('Column settings saved!', 'success');
        const modalEl = document.getElementById('columnSettingsModal');
        if (window.bootstrap && bootstrap.Modal.getInstance(modalEl)) bootstrap.Modal.getInstance(modalEl).hide();
    });
    try {
        const savedCols = localStorage.getItem('orderTableColumns');
        if (savedCols) applyColumnVisibility(JSON.parse(savedCols));
    } catch (e) {}

    // Keyboard Shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.key !== 'Escape') return;
        if (!document.getElementById('courierModal')?.classList.contains('hidden'))   window.closeCourierModal();
        if (!document.getElementById('tagModal')?.classList.contains('hidden'))       window.closeTagModal();
        if (!document.getElementById('editOrderModal')?.classList.contains('hidden')) window.closeEditOrderModal();
        if (!document.getElementById('bulkDimensionModal')?.classList.contains('hidden')) { document.getElementById('bulkDimensionModal').classList.add('hidden'); document.body.style.overflow = ''; }
    });
});

// ========== VIEW TRACKING ==========on pickup tab click

    window.viewTracking = function(awb) {
        if (!awb) return;

        // route generate with query param
        const url = `{{ route('status.index') }}?awb=${awb}`;

        // open in new tab
        window.open(url, '_blank');
    }

</script>

@endsection