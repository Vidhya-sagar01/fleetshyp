@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F1E8] py-6 px-4 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- 🔔 Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fa fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fa fa-exclamation-circle text-red-500 mr-3"></i>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Header Section -->
        <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-[#E8E4DA]">
            <div>
                <h2 class="text-2xl font-bold text-[#2C3E50] flex items-center">
                    Welcome, {{ Auth::user()->name ?? 'Seller' }} 
                    <span class="ml-2 text-xl text-[#D4AF37]">✨</span>
                </h2>
                <p class="text-gray-500 text-sm mt-1">Here's your shipping overview</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-400 font-medium">Showing Data For:</span>
                <form method="GET" class="flex items-center space-x-2">
                    <input type="date" name="start_date" value="{{ $startDate ?? date('Y-m-d', strtotime('-30 days')) }}" 
                           class="border border-[#D4AF37]/30 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                    <span class="text-gray-400">to</span>
                    <input type="date" name="end_date" value="{{ $endDate ?? date('Y-m-d') }}" 
                           class="border border-[#D4AF37]/30 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                    <button type="submit" class="bg-[#D4AF37] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#B8941F] transition-colors">
                        Apply
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="text-[#D4AF37] hover:text-red-500 transition-colors" title="Reset">
                        <i class="fa-solid fa-rotate-right"></i>
                    </a>
                </form>
                <div class="flex items-center space-x-2 bg-gray-50 px-3 py-2 rounded-lg">
                    <div class="w-10 h-5 bg-[#D4AF37]/20 rounded-full relative cursor-pointer">
                        <div class="w-5 h-5 bg-[#D4AF37] rounded-full absolute left-0 top-0 shadow-md transition-all hover:scale-110"></div>
                    </div>
                    <span class="text-sm text-gray-600 font-medium">New Dashboard (Beta)</span>
                </div>
            </div>
        </div>

        <!-- Top Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Today's Order - Clickable --}}
            <a href="{{ route('orders.index') }}?date=today" class="bg-white rounded-2xl p-6 shadow-sm border border-[#E8E4DA] relative overflow-hidden group hover:shadow-lg transition-all block">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-100/50 to-transparent rounded-full -mr-10 -mt-10 transition-all group-hover:scale-110"></div>
                <div class="relative z-10">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Today's Order</p>
                    <h3 class="text-5xl font-light text-orange-400">{{ number_format($shipmentStats['today_orders'] ?? 0) }}</h3>
                </div>
            </a>

            {{-- Today's Revenue --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#E8E4DA] relative overflow-hidden group hover:shadow-lg transition-all">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-100/50 to-transparent rounded-full -mr-10 -mt-10 transition-all group-hover:scale-110"></div>
                <div class="relative z-10">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Today's Revenue</p>
                    <h3 class="text-5xl font-light text-cyan-400 flex items-center">
                        <span class="text-4xl mr-1">₹</span> {{ number_format($shipmentStats['today_revenue'] ?? 0, 2) }}
                    </h3>
                </div>
            </div>

            {{-- Average Shipment --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#E8E4DA] relative overflow-hidden group hover:shadow-lg transition-all">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-100/50 to-transparent rounded-full -mr-10 -mt-10 transition-all group-hover:scale-110"></div>
                <div class="relative z-10">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Average Shipment</p>
                    <h3 class="text-5xl font-light text-gray-600">{{ number_format($shipmentStats['avg_shipment'] ?? 0) }}</h3>
                </div>
            </div>
        </div>

        <!-- Shipment Status Bar - All Clickable -->
        <div class="bg-white rounded-2xl shadow-sm border border-[#E8E4DA] overflow-hidden">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 divide-x divide-gray-100">
                <a href="{{ route('orders.index') }}" class="p-5 hover:bg-[#F5F1E8] transition-colors cursor-pointer group block">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Total Shipments</p>
                    <h4 class="text-3xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">{{ number_format($shipmentStats['total'] ?? 0) }}</h4>
                </a>
                <a href="{{ route('orders.index') }}?status=pickup" class="p-5 hover:bg-[#F5F1E8] transition-colors cursor-pointer group block">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pickups</p>
                    <h4 class="text-3xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">{{ number_format($shipmentStats['pickups'] ?? 0) }}</h4>
                </a>
                <a href="{{ route('orders.index') }}?status=in_transit" class="p-5 hover:bg-[#F5F1E8] transition-colors cursor-pointer group block">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">In-Transit</p>
                    <h4 class="text-3xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">{{ number_format($shipmentStats['in_transit'] ?? 0) }}</h4>
                </a>
                <a href="{{ route('orders.index') }}?status=delivered" class="p-5 hover:bg-[#F5F1E8] transition-colors cursor-pointer group block">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Delivered</p>
                    <h4 class="text-3xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">{{ number_format($shipmentStats['delivered'] ?? 0) }}</h4>
                </a>
                {{-- NDR Pending - Links to NDR Page --}}
                <a href="{{ route('fship.ndr.action') }}" class="p-5 hover:bg-[#F5F1E8] transition-colors cursor-pointer group block">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">NDR Pending</p>
                    <h4 class="text-3xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">{{ number_format($shipmentStats['ndr_pending'] ?? 0) }}</h4>
                </a>
                <a href="{{ route('orders.index') }}?status=rto" class="p-5 hover:bg-[#F5F1E8] transition-colors cursor-pointer group block">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">RTO</p>
                    <h4 class="text-3xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">{{ number_format($shipmentStats['rto'] ?? 0) }}</h4>
                </a>
            </div>
        </div>

        <!-- NDR Stats - All Clickable to NDR Page -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <a href="{{ route('fship.ndr.action') }}?tab=all" class="bg-gradient-to-br from-[#1E2A3A] to-[#2C3E50] rounded-2xl shadow-lg p-6 text-white relative overflow-hidden group hover:shadow-xl transition-all block">
                <div class="absolute top-0 right-0 w-24 h-24 bg-[#D4AF37]/20 rounded-full -mr-8 -mt-8 transition-all group-hover:scale-150"></div>
                <div class="relative z-10">
                    <div class="w-10 h-10 rounded-lg bg-[#D4AF37]/20 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-headset text-[#D4AF37]"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-300 uppercase tracking-wider mb-1">Total NDR</p>
                    <h4 class="text-3xl font-light">{{ number_format($ndrStats['total_ndr'] ?? 0) }}</h4>
                </div>
            </a>
            <a href="{{ route('fship.ndr.action') }}?tab=action-taken" class="bg-white p-5 rounded-2xl shadow-sm border border-[#E8E4DA] hover:shadow-md transition-all cursor-pointer group block">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Your Reattempt Request</p>
                <h4 class="text-3xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">{{ number_format($ndrStats['your_reattempt'] ?? 0) }}</h4>
            </a>
            <a href="{{ route('fship.ndr.action') }}?tab=action-required" class="bg-white p-5 rounded-2xl shadow-sm border border-[#E8E4DA] hover:shadow-md transition-all cursor-pointer group block">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Buyer Reattempt Request</p>
                <h4 class="text-3xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">{{ number_format($ndrStats['buyer_reattempt'] ?? 0) }}</h4>
            </a>
            <a href="{{ route('fship.ndr.action') }}?tab=delivered" class="bg-white p-5 rounded-2xl shadow-sm border border-[#E8E4DA] hover:shadow-md transition-all cursor-pointer group block">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">NDR Delivered</p>
                <h4 class="text-3xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">{{ number_format($ndrStats['ndr_delivered'] ?? 0) }}</h4>
            </a>
        </div>

        <!-- COD Stats - All Clickable to Billing Page -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <a href="{{ route('seller.billing.codRemittance') }}" class="bg-gradient-to-br from-[#D4AF37] to-[#B8941F] rounded-2xl shadow-lg p-6 text-white relative overflow-hidden group hover:shadow-xl transition-all block">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full -mr-8 -mt-8 transition-all group-hover:scale-150"></div>
                <div class="relative z-10">
                    <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-wallet text-white"></i>
                    </div>
                    <p class="text-xs font-semibold text-white/80 uppercase tracking-wider mb-1">Total COD</p>
                    <h4 class="text-2xl font-light">₹ {{ number_format($codStats['total_cod'] ?? 0, 2) }}</h4>
                </div>
            </a>
            <a href="{{ route('seller.billing.codRemittance') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-[#E8E4DA] hover:shadow-md transition-all cursor-pointer group block">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">COD Remitted</p>
                <h4 class="text-2xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">₹ {{ number_format($codStats['cod_remitted'] ?? 0, 2) }}</h4>
            </a>
            <a href="{{ route('seller.billing.codRemittance') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-[#E8E4DA] hover:shadow-md transition-all cursor-pointer group block">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Last COD Remitted</p>
                <h4 class="text-2xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">₹ {{ number_format($codStats['last_cod_remitted'] ?? 0, 2) }}</h4>
            </a>
            <a href="{{ route('seller.billing.codRemittance') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-[#E8E4DA] hover:shadow-md transition-all cursor-pointer group block">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Next COD Available</p>
                <h4 class="text-2xl font-light text-gray-700 group-hover:text-[#D4AF37] transition-colors">₹ {{ number_format($codStats['next_cod_available'] ?? 0, 2) }}</h4>
            </a>
        </div>

        <!-- Analytics Tabs with Dynamic Data -->
        <div class="bg-white rounded-2xl shadow-sm border border-[#E8E4DA] overflow-hidden">
            <div class="flex space-x-1 text-sm font-semibold text-gray-500 border-b border-gray-100 overflow-x-auto" id="analyticsTabs">
                <button class="analytics-tab pb-4 px-6 border-b-2 border-[#D4AF37] text-[#D4AF37] cursor-pointer transition-colors whitespace-nowrap pt-4 active" data-target="shipment">
                    <i class="fa-solid fa-chart-pie mr-2"></i>Shipment Analytics
                </button>
                <button class="analytics-tab pb-4 px-6 border-b-2 border-transparent hover:text-[#D4AF37] hover:border-[#D4AF37] cursor-pointer transition-colors whitespace-nowrap pt-4" data-target="courier">
                    <i class="fa-solid fa-truck mr-2"></i>Courier Analytics
                </button>
                <button class="analytics-tab pb-4 px-6 border-b-2 border-transparent hover:text-[#D4AF37] hover:border-[#D4AF37] cursor-pointer transition-colors whitespace-nowrap pt-4" data-target="zone">
                    <i class="fa-solid fa-map-marked-alt mr-2"></i>Zone Analytics
                </button>
                <button class="analytics-tab pb-4 px-6 border-b-2 border-transparent hover:text-[#D4AF37] hover:border-[#D4AF37] cursor-pointer transition-colors whitespace-nowrap pt-4" data-target="product">
                    <i class="fa-solid fa-boxes mr-2"></i>Product Analytics
                </button>
                <button class="analytics-tab pb-4 px-6 border-b-2 border-transparent hover:text-[#D4AF37] hover:border-[#D4AF37] cursor-pointer transition-colors whitespace-nowrap pt-4" data-target="daily">
                    <i class="fa-solid fa-calendar-day mr-2"></i>Daily Summary
                </button>
            </div>
            
            <!-- Charts Section -->
            <div class="p-6">
                {{-- Shipment Analytics Tab --}}
                <div id="shipment-tab" class="analytics-content active">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Overall Delivery Vs RTO -->
                        <div class="bg-gray-50/50 rounded-xl p-6 border border-gray-100">
                            <h4 class="text-sm font-semibold text-gray-700 mb-6">Overall Delivery Vs RTO</h4>
                            <div class="flex items-center justify-center h-64">
                                @php
                                    $delivered = $analytics['delivery_vs_rto']['delivered'] ?? 0;
                                    $rto = $analytics['delivery_vs_rto']['rto'] ?? 0;
                                    $total = $delivered + $rto;
                                    $deliveredPercent = $total > 0 ? round(($delivered / $total) * 100) : 0;
                                    $rtoPercent = $total > 0 ? round(($rto / $total) * 100) : 0;
                                @endphp
                                <div class="relative w-48 h-48">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                        <path class="text-gray-200" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                                        <path class="text-[#D4AF37]" stroke-dasharray="{{ $deliveredPercent }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                                        <path class="text-red-400" stroke-dasharray="{{ $rtoPercent }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" stroke-dashoffset="{{ -$deliveredPercent }}" />
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-2xl font-bold text-[#D4AF37]">{{ $deliveredPercent }}%</span>
                                        <span class="text-xs text-gray-400">Delivered</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center gap-6 mt-4 text-sm">
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-[#D4AF37] mr-2"></span>
                                    <span class="text-gray-600">Delivered: {{ number_format($delivered) }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-red-400 mr-2"></span>
                                    <span class="text-gray-600">RTO: {{ number_format($rto) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Overall Shipment Status -->
                        <div class="bg-gray-50/50 rounded-xl p-6 border border-gray-100">
                            <h4 class="text-sm font-semibold text-gray-700 mb-6">Overall Shipment Status</h4>
                            <div class="space-y-4">
                                @php
                                    $statuses = [
                                        'booked' => ['label' => 'Booked', 'color' => 'bg-blue-400'],
                                        'manifested' => ['label' => 'Manifested', 'color' => 'bg-purple-400'],
                                        'in_transit' => ['label' => 'In Transit', 'color' => 'bg-yellow-400'],
                                        'delivered' => ['label' => 'Delivered', 'color' => 'bg-green-400'],
                                        'rto' => ['label' => 'RTO', 'color' => 'bg-red-400']
                                    ];
                                    $shipmentStatus = $analytics['shipment_status'] ?? [];
                                    $maxValue = max(array_values($shipmentStatus)) ?: 1;
                                @endphp
                                @foreach($statuses as $key => $status)
                                    @php
                                        $value = $shipmentStatus[$key] ?? 0;
                                        $width = $maxValue > 0 ? round(($value / $maxValue) * 100) : 0;
                                    @endphp
                                    <div>
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="text-gray-600">{{ $status['label'] }}</span>
                                            <span class="font-semibold text-gray-700">{{ number_format($value) }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="{{ $status['color'] }} h-2 rounded-full transition-all duration-500" style="width: {{ $width }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Courier Analytics Tab --}}
                <div id="courier-tab" class="analytics-content hidden">
                    <div class="text-center py-12 text-gray-400">
                        <i class="fa-solid fa-truck text-4xl mb-4"></i>
                        <p>Courier-wise analytics data will appear here</p>
                        <p class="text-sm mt-2">Select a date range to view detailed courier performance</p>
                    </div>
                </div>

                {{-- Zone Analytics Tab --}}
                <div id="zone-tab" class="analytics-content hidden">
                    <div class="text-center py-12 text-gray-400">
                        <i class="fa-solid fa-map text-4xl mb-4"></i>
                        <p>Zone-wise delivery analytics will appear here</p>
                    </div>
                </div>

                {{-- Product Analytics Tab --}}
                <div id="product-tab" class="analytics-content hidden">
                    <div class="text-center py-12 text-gray-400">
                        <i class="fa-solid fa-boxes text-4xl mb-4"></i>
                        <p>Product-wise shipping analytics will appear here</p>
                    </div>
                </div>

                {{-- Daily Summary Tab --}}
                <div id="daily-tab" class="analytics-content hidden">
                    <div class="text-center py-12 text-gray-400">
                        <i class="fa-solid fa-calendar-day text-4xl mb-4"></i>
                        <p>Daily summary report will appear here</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-[#E8E4DA] p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('orders.create') }}" class="flex items-center justify-center p-4 border-2 border-dashed border-[#D4AF37]/30 rounded-xl hover:border-[#D4AF37] hover:bg-[#F5F1E8] transition-all group">
                    <i class="fa-solid fa-plus text-[#D4AF37] mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-[#D4AF37]">Create Order</span>
                </a>
                <a href="{{ route('label.index') }}" class="flex items-center justify-center p-4 border-2 border-dashed border-[#D4AF37]/30 rounded-xl hover:border-[#D4AF37] hover:bg-[#F5F1E8] transition-all group">
                    <i class="fa-solid fa-print text-[#D4AF37] mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-[#D4AF37]">Print Labels</span>
                </a>
                <a href="{{ route('fship.ndr.action') }}" class="flex items-center justify-center p-4 border-2 border-dashed border-[#D4AF37]/30 rounded-xl hover:border-[#D4AF37] hover:bg-[#F5F1E8] transition-all group">
                    <i class="fa-solid fa-headset text-[#D4AF37] mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-[#D4AF37]">Manage NDR</span>
                </a>
                <a href="{{ route('create') }}" class="flex items-center justify-center p-4 border-2 border-dashed border-[#D4AF37]/30 rounded-xl hover:border-[#D4AF37] hover:bg-[#F5F1E8] transition-all group">
                    <i class="fa-solid fa-rotate-left text-[#D4AF37] mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-[#D4AF37]">Reverse Order</span>
                </a>
            </div>
        </div>

    </div>
</div>

<style>
    .analytics-tab.active {
        border-bottom-color: #D4AF37 !important;
        color: #D4AF37 !important;
    }
    .analytics-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    .analytics-content.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Analytics Tab Switching
        document.querySelectorAll('.analytics-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.analytics-tab').forEach(t => {
                    t.classList.remove('active');
                    t.classList.add('border-transparent');
                    t.classList.remove('border-[#D4AF37]', 'text-[#D4AF37]');
                });
                
                // Add active class to clicked tab
                this.classList.add('active');
                this.classList.remove('border-transparent');
                this.classList.add('border-[#D4AF37]', 'text-[#D4AF37]');
                
                // Hide all content
                document.querySelectorAll('.analytics-content').forEach(content => {
                    content.classList.remove('active');
                    content.classList.add('hidden');
                });
                
                // Show target content
                const target = this.dataset.target;
                const targetContent = document.getElementById(target + '-tab');
                if(targetContent) {
                    targetContent.classList.remove('hidden');
                    targetContent.classList.add('active');
                }
            });
        });

        // Auto-refresh stats every 5 minutes (optional)
        // setInterval(() => {
        //     fetch('{{ route('seller.dashboard') }}?ajax=true')
        //         .then(res => res.json())
        //         .then(data => {
        //             // Update stats dynamically
        //             console.log('Stats refreshed:', data);
        //         });
        // }, 300000);
    });
</script>
@endsection