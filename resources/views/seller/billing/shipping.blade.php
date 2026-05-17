@extends('seller.layouts.app')

@section('content')

<div class="p-6 bg-gray-100 min-h-screen">

    <div class="flex justify-end mb-4">
        <button class="border px-4 py-2 rounded-lg text-sm bg-white shadow-sm hover:bg-gray-50 transition-all">
            <i class="fa fa-filter mr-2"></i> Filter
        </button>
    </div>

    <div class="flex justify-between items-center mb-3">
        <span class="text-sm bg-gray-200 px-3 py-1 rounded font-medium text-gray-700">
            Total Shipments: {{ $orders->total() }}
        </span>

        <button id="exportCsvBtn" class="border px-3 py-1 rounded text-sm bg-white shadow-sm hover:bg-gray-50 transition-all">
            <i class="fa fa-file-csv mr-1 text-green-600"></i> Export CSV
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
      @php
    $cards = [
        ['title' => 'Total Freight Charges', 'value' => '₹ ' . ($cardStats['total_freight'] ?? '0.00')],
        ['title' => 'Billed Freight Charges', 'value' => '₹ ' . ($cardStats['billed_freight'] ?? '0.00')],
        ['title' => 'Unbilled Freight Charges', 'value' => '₹ ' . ($cardStats['unbilled_freight'] ?? '0.00')],
        ['title' => 'Total Excess Weight', 'value' => '₹ ' . ($cardStats['excess_weight'] ?? '0.00')],
        ['title' => 'Invoice Due Amount', 'value' => '₹ ' . ($cardStats['invoice_due'] ?? '0.00')],
    ];
@endphp

        @foreach($cards as $card)
        <div class="bg-white p-4 rounded-xl shadow text-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-[#D4AF37] via-[#1E3A8A] to-[#FFFFFF] opacity-5 group-hover:opacity-10 transition-opacity"></div>
            <div class="relative z-10">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ $card['title'] }}</p>
                <h2 class="text-xl font-bold mt-1 text-gray-800">{{ $card['value'] }}</h2>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-200">
        
        <div class="overflow-x-auto hide-scrollbar" id="tableContainer">
            <table class="min-w-[1600px] w-full text-sm text-left" id="shipmentTable">
                <thead class="bg-gray-50 text-gray-600 border-b">
                    <tr>
                        <th class="p-4 font-semibold uppercase text-xs">Order Id</th>
                        <th class="p-4 font-semibold uppercase text-xs">AWB No</th>
                        <th class="p-4 font-semibold uppercase text-xs">Service Provider</th>
                        <th class="p-4 font-semibold uppercase text-xs">Status</th>
                        <th class="p-4 font-semibold uppercase text-xs">AWB Assigned Date</th>
                        <th class="p-4 font-semibold uppercase text-xs">Zone</th>
                        <th class="p-4 font-semibold uppercase text-xs">Applied Charges</th>
                        <th class="p-4 font-semibold uppercase text-xs">Excess Weight Charges</th>
                        <th class="p-4 font-semibold uppercase text-xs text-blue-800">Total Freight</th>
                        <th class="p-4 font-semibold uppercase text-xs">Entered Wt & Dim</th>
                        <th class="p-4 font-semibold uppercase text-xs">Charged Wt & Dim</th>
                        <th class="p-4 font-semibold uppercase text-xs">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-medium text-blue-600">#{{ $order->merchant_order_id }}</td>
                        <td class="p-4 font-mono text-gray-700">{{ $order->waybill ?? 'Pending' }}</td>
                        <td class="p-4">
                            <div class="font-medium">{{ $order->courier_name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $order->service_mode }}</div>
                        </td>
                        <td class="p-4">
                            @php
                                $statusClass = match($order->status) {
                                    'Delivered' => 'bg-green-100 text-green-700',
                                    'Cancelled' => 'bg-red-100 text-red-700',
                                    'Picked Up' => 'bg-indigo-100 text-indigo-700',
                                    'In Transit' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-yellow-100 text-yellow-700',
                                };
                            @endphp
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-full {{ $statusClass }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-500">
                            {{ $order->booked_at ? date('d-M-Y', strtotime($order->booked_at)) : 'N/A' }}
                        </td>
                        <td class="p-4">
                            <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-semibold">{{ $order->zone ?? 'N/A' }}</span>
                        </td>
                        <td class="p-4 text-xs space-y-1">
                            <div>Fwd: ₹{{ number_format($order->forward_charge, 2) }}</div>
                            <div>COD: ₹{{ number_format($order->cod_charge, 2) }}</div>
                        </td>
                        <td class="p-4 text-xs font-medium text-red-500">₹0.00</td>
                        <td class="p-4 font-bold text-gray-800">
                            ₹{{ number_format($order->forward_charge + $order->cod_charge, 2) }}
                        </td>
                        <td class="p-4 text-xs">
                            <div class="font-semibold">{{ $order->weight }} Kg</div>
                            <div class="text-gray-400">{{ (float)$order->length }} x {{ (float)$order->width }} x {{ (float)$order->height }} cm</div>
                        </td>
                        <td class="p-4 text-xs">
                            <div class="font-semibold">{{ $order->weight }} Kg</div>
                            <div class="text-gray-400">Vol: {{ $order->volumetric_weight ?? '0' }}</div>
                        </td>
                        <td class="p-4">
                            <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-all" title="View Details">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="p-20 text-center">
                            <i class="fa fa-box-open text-4xl text-gray-300 mb-3 block"></i>
                            <p class="text-gray-500 font-medium">No shipments found in billing records.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t bg-white">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3 text-sm text-gray-500">
                    <select class="border px-2 py-1 rounded-lg focus:ring-1 focus:ring-[#D4AF37]" onchange="window.location.href=this.value">
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                    </select>
                    <span>Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}</span>
                </div>

                <div class="pagination-custom">
                    {{ $orders->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>

        <div class="overflow-x-auto custom-scroll border-t" id="bottomScroll">
            <div class="min-w-[1600px] h-1"></div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableContainer = document.getElementById('tableContainer');
        const bottomScroll = document.getElementById('bottomScroll');

        // Sync scroll from bottom fake scrollbar to real table
        bottomScroll.addEventListener('scroll', () => {
            tableContainer.scrollLeft = bottomScroll.scrollLeft;
        });

        // Sync scroll from real table to bottom fake scrollbar
        tableContainer.addEventListener('scroll', () => {
            bottomScroll.scrollLeft = tableContainer.scrollLeft;
        });

        // Dynamic CSV Export
        document.getElementById('exportCsvBtn').addEventListener('click', function() {
            const table = document.getElementById('shipmentTable');
            let csv = [];
            const rows = table.querySelectorAll('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = [];
                const cols = rows[i].querySelectorAll('td, th');
                
                // j < cols.length - 1 to skip the "View" button column
                for (let j = 0; j < cols.length - 1; j++) {
                    let data = cols[j].innerText.trim().replace(/(\r\n|\n|\r)/gm, ' ').replace(/,/g, '');
                    row.push(data);
                }
                csv.push(row.join(','));
            }

            const csvContent = csv.join('\n');
            const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', 'billing_shipments_' + new Date().toISOString().slice(0,10) + '.csv');
            link.click();
        });
    });
</script>

<style>
/* Hide scrollbar for table container */
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

/* Custom scrollbar styling */
.custom-scroll::-webkit-scrollbar { height: 8px; }
.custom-scroll::-webkit-scrollbar-track { background: #f8fafc; }
.custom-scroll::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 10px; }
.custom-scroll::-webkit-scrollbar-thumb:hover { background: #b08d28; }

/* Fixed Header for Pagination spacing */
.pagination-custom nav svg { width: 20px; display: inline; }
</style>

@endsection