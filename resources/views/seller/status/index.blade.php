@extends('seller.layouts.app')

@section('title', 'Track Order')

@section('content')
<div class="space-y-6" id="printableArea">

    {{-- ✅ API Response check: Aapke data mein direct 'summary' key hai --}}
    @if(isset($trackingData['status']) && $trackingData['status'] == true && isset($trackingData['summary']))
        @php 
            $summary = $trackingData['summary']; 
            $activities = $trackingData['trackingdata'] ?? [];
            
            // Status color logic
            $statusStr = strtolower($summary['status'] ?? '');
            $statusColor = match(true) {
                str_contains($statusStr, 'delivered') => 'bg-green-100 text-green-700',
                str_contains($statusStr, 'cancelled') => 'bg-red-100 text-red-700',
                str_contains($statusStr, 'transit') => 'bg-blue-100 text-blue-700',
                default => 'bg-yellow-100 text-yellow-700'
            };
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Order Status</h3>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                        {{ $summary['status'] }}
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ $summary['status'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Last Update: {{ \Carbon\Carbon::parse($summary['lastscandate'])->format('d M, h:i A') }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-medium text-gray-600 mb-2">Expected Delivery</h3>
                <p class="text-2xl font-bold text-gray-800">
                    {{ isset($summary['expectedDeliveryDate']) ? \Carbon\Carbon::parse($summary['expectedDeliveryDate'])->format('l, d M Y') : 'TBA' }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fas fa-clock mr-1"></i> Standard Delivery Window
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Tracking ID</h3>
                    <button class="text-gold-600 hover:text-gold-700 text-sm" onclick="copyToClipboard('{{ $summary['waybill'] }}')">
                        <i class="fas fa-copy mr-1"></i> Copy
                    </button>
                </div>
                <p class="text-2xl font-bold text-gray-800 font-mono">{{ $summary['waybill'] }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $summary['fulfilledby'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-gray-800 uppercase">Journey Details</h3>
                    <span class="text-xs font-medium text-gray-500">AWB: {{ $summary['waybill'] }}</span>
                </div>

                <div class="p-6 max-h-[500px] overflow-y-auto">
                    <div class="relative space-y-0">
                        @forelse($activities as $index => $activity)
                            <div class="flex items-start space-x-4 pb-8 relative">
                                <div class="flex flex-col items-center">
                                    <div class="w-4 h-4 rounded-full {{ $index === 0 ? 'bg-green-500' : 'bg-gray-300' }} border-2 border-white shadow z-10"></div>
                                    @if(!$loop->last)
                                        <div class="w-0.5 h-full bg-gray-100 absolute top-4 left-2"></div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $activity['status'] }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-map-marker-alt mr-1 text-red-400"></i> 
                                                {{ $activity['location'] ?: 'Location processing' }}
                                            </p>
                                            <p class="text-[11px] text-gray-400 italic">{{ $activity['remark'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs font-bold text-gray-700">{{ \Carbon\Carbon::parse($activity['dateandTime'])->format('d M') }}</p>
                                            <p class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($activity['dateandTime'])->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No scan details found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="relative aspect-video bg-gray-900">
                        <video class="w-full h-full object-cover" controls autoplay muted loop>
                            <source src="{{ asset('assets/img/channel/video.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-box mr-2 text-gold-500"></i> Shipment Details
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-600">Order ID</span>
                            <span class="text-sm font-bold text-gray-800">{{ $summary['orderid'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-600">Ordered On</span>
                            <span class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($summary['orderedon'])->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600">Courier Partner</span>
                            <span class="text-sm font-semibold text-gold-600">{{ $summary['fulfilledby'] }}</span>
                        </div>
                    </div>
                    @if($trackingData['labelurl'])
                        <a href="{{ $trackingData['labelurl'] }}" target="_blank" class="w-full mt-6 inline-block text-center py-2.5 text-sm font-medium text-white bg-gradient-gold rounded-lg">
                            <i class="fas fa-download mr-2"></i> Download Label
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @else
        {{-- ❌ Error State --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-20 text-center">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search-location text-3xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Tracking Data Not Ready</h2>
            <p class="text-gray-500 mt-2">Humne AWB <b>{{ $waybill }}</b> ke liye data fetch karne ki koshish ki, lekin abhi system mein koi scan details nahi mili hain.</p>
            <a href="{{ route('orders.index') }}" class="mt-6 inline-block px-6 py-2 bg-gold-600 text-white rounded-lg hover:bg-gold-700">Back to Orders</a>
        </div>
    @endif
</div>
@endsection