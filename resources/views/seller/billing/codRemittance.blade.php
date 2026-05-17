@extends('seller.layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-600">
            Total : {{ $orders->total() }}
        </div>
        <div class="flex items-center gap-3">
            <button onclick="toggleFilter()" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gold hover:text-gold transition-all flex items-center gap-2">
                <i class="fa fa-filter"></i> Filter
            </button>
            <button onclick="exportCSV()" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gold hover:text-gold transition-all flex items-center gap-2">
                <i class="fa fa-file-export"></i> Export CSV
            </button>
        </div>
    </div>

    {{-- Filter Section --}}
    <div id="filterSection" class="{{ request()->has('from_date') ? '' : 'hidden' }} bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('seller.billing.codRemittance') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" 
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" 
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                    <select name="payment_status" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-gold text-white rounded-lg hover:bg-gold-dark transition-all">
                        Apply Filter
                    </button>
                    <a href="{{ route('seller.billing.codRemittance') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200">Reset</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Row 1 --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-orange-100 to-pink-100 rounded-bl-full opacity-50"></div>
            <div class="relative text-center">
                <p class="text-sm font-medium text-gray-600">Total COD Amount</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($summary['total_cod_collected'] ?? 0, 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-100 to-emerald-100 rounded-bl-full opacity-50"></div>
            <div class="relative text-center">
                <p class="text-sm font-medium text-green-600">Remitted Till Date</p>
                <p class="text-2xl font-bold text-green-600 mt-2">₹{{ number_format($summary['remitted_amount'] ?? 0, 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-bl-full opacity-50"></div>
            <div class="relative text-center">
                <p class="text-sm font-medium text-blue-600">Total Remittance Due</p>
                {{-- ✅ FIXED: Simple calculation - Total COD - Remitted Amount --}}
                <p class="text-2xl font-bold text-blue-600 mt-2">
                    ₹{{ number_format((($summary['total_cod_collected'] ?? 0) - ($summary['remitted_amount'] ?? 0)), 2) }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    (₹{{ number_format($summary['total_cod_collected'] ?? 0, 2) }} - ₹{{ number_format($summary['remitted_amount'] ?? 0, 2) }})
                </p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-100 to-pink-100 rounded-bl-full opacity-50"></div>
            <div class="relative text-center">
                <p class="text-sm font-medium text-gray-600">Last Remittance Amount</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($summary['last_remittance_amount'] ?? 0, 2) }}</p>
            </div>
        </div>

        {{-- Row 2 --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-bl-full opacity-50"></div>
            <div class="relative text-center">
                <p class="text-sm font-medium text-gray-600">Next Remittance Due</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($summary['next_remittance_due'] ?? 0, 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-red-100 to-pink-100 rounded-bl-full opacity-50"></div>
            <div class="relative text-center">
                <p class="text-sm font-medium text-gray-600">Delivered RTO Amount</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($summary['delivered_rto_amount'] ?? 0, 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-bl-full opacity-50"></div>
            <div class="relative text-center">
                <p class="text-sm font-medium text-gray-600">Total Recharge From COD</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($summary['recharge_from_cod'] ?? 0, 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-bl-full opacity-50"></div>
            <div class="relative text-center">
                <p class="text-sm font-medium text-gray-600">Surcharge Amount</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($summary['surcharge_amount'] ?? 0, 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full" id="remittanceTable">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">AWB no</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">COD Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">COD Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Freight Deduction</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Final Payable Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Recharge From COD</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Delivered RTO Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Surcharge Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Convenience Fee</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Remarks</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Payment No.</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        @php
                            // ✅ Get payment data from cod_remittance_payments table
                            $payment = $order->latestPayment;
                            
                            // Order amounts
                            $productSubtotal = (float) ($order->product_subtotal ?? 0);
                            $freight = (float) ($order->forward_charge ?? 0);
                            $wallet = (float) ($order->wallet_deduction_amount ?? 0);
                            $codFee = (float) ($order->cod_charge ?? 0);
                            
                            // ✅ Payment-based values (from cod_remittance_payments table)
                            $codStatus = $payment ? $payment->status : 'pending';
                            $convenienceFee = $payment ? $payment->convenience_fee : 0;
                            $finalPayable = $payment ? $payment->remitted_amount : max($productSubtotal - $freight - $wallet - $codFee, 0);
                            $paymentReference = $payment ? $payment->payment_reference : '-';
                            $paymentDate = $payment ? ($payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') : '-') : '-';
                            $paymentMode = $payment ? $payment->payment_mode : '-';
                            $paymentRemarks = $payment ? $payment->remarks : '';
                            
                            // Status badge based on payment status
                            if ($codStatus === 'paid') {
                                $statusBadge = '<span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Paid</span>';
                                $remarks = $paymentRemarks ?: 'Remitted';
                            } elseif ($codStatus === 'processed') {
                                $statusBadge = '<span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Processed</span>';
                                $remarks = $paymentRemarks ?: 'Processing';
                            } elseif (strtolower(trim($order->status)) === 'rto delivered') {
                                $statusBadge = '<span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">RTO</span>';
                                $remarks = 'RTO Delivered';
                            } else {
                                $statusBadge = '<span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Pending</span>';
                                $remarks = ($order->remaining_working_days ?? 3) . ' WD remaining';
                            }
                        @endphp

                        <tr class="hover:bg-gray-50 transition-colors {{ $codStatus === 'paid' ? 'bg-green-50' : '' }}">
                            <td class="px-4 py-3 text-sm text-gray-700 font-medium">{{ $order->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 font-medium">{{ $order->waybill ?? $order->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $order->updated_at ? $order->updated_at->format('d-m-Y') : '-' }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">₹{{ number_format($productSubtotal, 2) }}</td>
                            
                            {{-- ✅ COD Status - FROM cod_remittance_payments.status --}}
                            <td class="px-4 py-3">{!! $statusBadge !!}</td>
                            
                            <td class="px-4 py-3 text-sm text-gray-700">₹{{ number_format($freight, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">₹{{ number_format($payment ? $payment->remitted_amount : 0, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">₹0.00</td>
                            <td class="px-4 py-3 text-sm text-gray-700">₹0.00</td>
                            <td class="px-4 py-3 text-sm text-gray-700">₹0.00</td>
                            
                            {{-- ✅ Convenience Fee - FROM cod_remittance_payments.convenience_fee --}}
                            <td class="px-4 py-3 text-sm text-gray-700">₹{{ number_format($convenienceFee, 2) }}</td>
                             
                            
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $remarks }}</td>
                            
                            {{-- ✅ Payment Reference - FROM cod_remittance_payments.payment_reference --}}
                            <td class="px-4 py-3 text-sm text-gray-600 font-mono">{{ $paymentReference }}</td>
                            
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <button onclick="viewPaymentDetail('{{ addslashes($order->waybill ?? $order->id) }}')" 
                                            class="px-3 py-1 bg-white border border-gray-200 rounded text-xs hover:border-gold hover:text-gold transition-all">
                                        View
                                    </button>
                                    <button onclick="exportOrderCSV({{ $order->id }})" 
                                            class="px-3 py-1 bg-white border border-gray-200 rounded text-xs hover:border-gold hover:text-gold transition-all flex items-center gap-1">
                                        <i class="fa fa-file-export"></i> Export
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="px-6 py-12 text-center text-gray-500">
                                <i class="fa fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <p>No COD orders found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting your filters</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <select id="perPage" onchange="changePerPage(this.value)" class="px-3 py-1 border border-gray-200 rounded-lg text-sm bg-gray-100 focus:ring-2 focus:ring-gold focus:border-gold">
                    <option value="25" {{ request('per_page', 50) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page', 50) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page', 50) == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span class="text-sm text-gray-600">
                    Showing : {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}
                </span>
            </div>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1 border border-gray-200 rounded bg-white text-sm hover:bg-gray-50" {{ !$orders->onFirstPage() ? '' : 'disabled' }}>First</button>
                <button class="px-3 py-1 border border-gray-200 rounded bg-white text-sm hover:bg-gray-50" onclick="previousPage()" {{ !$orders->onFirstPage() ? '' : 'disabled' }}>&lt;</button>
                <span class="px-3 py-1 bg-gold text-white rounded text-sm">{{ $orders->currentPage() }}</span>
                <button class="px-3 py-1 border border-gray-200 rounded bg-white text-sm hover:bg-gray-50" onclick="nextPage()" {{ !$orders->hasMorePages() ? 'disabled' : '' }}>&gt;</button>
                <button class="px-3 py-1 border border-gray-200 rounded bg-white text-sm hover:bg-gray-50" {{ !$orders->hasMorePages() ? '' : 'disabled' }}>Last</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Toggle filter section
function toggleFilter() { 
    document.getElementById('filterSection').classList.toggle('hidden'); 
}

// Change items per page
function changePerPage(value) { 
    const url = new URL(window.location); 
    url.searchParams.set('per_page', value); 
    window.location.href = url.toString(); 
}

// ✅ FIXED: Export CSV with proper route and filters
function exportCSV() {
    // ✅ Use Laravel route helper to generate correct URL
    const baseUrl = '{{ route("codRemittance.export") }}';
    const url = new URL(baseUrl, window.location.origin);
    
    // ✅ Add current filters to export URL
    const fromDate = document.querySelector('input[name="from_date"]')?.value;
    const toDate = document.querySelector('input[name="to_date"]')?.value;
    const paymentStatus = document.querySelector('select[name="payment_status"]')?.value;
    
    if (fromDate) url.searchParams.set('from_date', fromDate);
    if (toDate) url.searchParams.set('to_date', toDate);
    if (paymentStatus) url.searchParams.set('payment_status', paymentStatus);
    
    console.log('📤 Exporting to:', url.toString());
    
    // ✅ Trigger download
    window.location.href = url.toString();
}

// ✅ Export single order CSV
function exportOrderCSV(orderId) {
    const baseUrl = '{{ route("codRemittance.export") }}';
    const url = new URL(baseUrl, window.location.origin);
    url.searchParams.set('order_id', orderId);
    window.location.href = url.toString();
}

// Pagination functions
function previousPage() { 
    const url = new URL(window.location); 
    const currentPage = parseInt(url.searchParams.get('page') || 1); 
    if (currentPage > 1) { 
        url.searchParams.set('page', currentPage - 1); 
        window.location.href = url.toString(); 
    } 
}

function nextPage() { 
    const url = new URL(window.location); 
    const currentPage = parseInt(url.searchParams.get('page') || 1); 
    url.searchParams.set('page', currentPage + 1); 
    window.location.href = url.toString(); 
}

// ✅ View Payment Detail Modal - FIXED with correct URL
function viewPaymentDetail(waybill) {
    const modal = document.getElementById('paymentDetailModal');
    const loading = document.getElementById('detailLoading');
    const error = document.getElementById('detailError');
    const success = document.getElementById('detailSuccess');
    
    loading.classList.remove('hidden');
    error.classList.add('hidden');
    success.classList.add('hidden');
    modal.classList.remove('hidden');
    
    // ✅ Use correct URL based on routes
    const url = '/seller/payment-detail/' + encodeURIComponent(waybill) + '?t=' + Date.now();
    console.log('🔗 Fetching:', url);
    
    fetch(url, {
        headers: { 
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async response => {
        console.log('📡 Status:', response.status);
        
        if (!response.ok) {
            const text = await response.text();
            console.error('❌ Error response:', text);
            throw new Error('Failed to load details');
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ Response:', data);
        
        // ✅ Handle both 'payment' (singular) and 'payments' (array) responses
        let payment = null;
        if (data.payment) {
            payment = data.payment;
        } else if (data.payments && data.payments.length > 0) {
            payment = data.payments[0];
        }
        
        if (data.success && payment) {
            // Populate modal content
            document.getElementById('detailWaybill').textContent = data.order.waybill || '-';
            document.getElementById('detailReference').textContent = payment.payment_reference || '-';
            document.getElementById('detailAmount').textContent = '₹' + parseFloat(payment.remitted_amount || 0).toFixed(2);
            document.getElementById('detailFee').textContent = '₹' + parseFloat(payment.convenience_fee || 0).toFixed(2);
            document.getElementById('detailStatus').textContent = (payment.status || 'pending').toUpperCase();
            document.getElementById('detailDate').textContent = payment.payment_date || '-';
            document.getElementById('detailMode').textContent = payment.payment_mode || '-';
            document.getElementById('detailBank').textContent = payment.bank_name || '-';
            document.getElementById('detailAccount').textContent = payment.bank_account || '-';
            document.getElementById('detailRemarks').textContent = payment.remarks || '-';
            
            loading.classList.add('hidden');
            success.classList.remove('hidden');
        } else {
            console.error('❌ No payment data:', data);
            document.getElementById('detailError').querySelector('p').textContent = 
                data.message || 'No payment record found for this order';
            error.classList.remove('hidden');
            loading.classList.add('hidden');
        }
    })
    .catch(err => {
        console.error('❌ Fetch error:', err);
        document.getElementById('detailError').querySelector('p').textContent = 
            'Error: ' + err.message;
        error.classList.remove('hidden');
        loading.classList.add('hidden');
    });
}

// Close payment detail modal
function closePaymentDetailModal() {
    document.getElementById('paymentDetailModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('paymentDetailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentDetailModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePaymentDetailModal();
    }
});
</script>

{{-- Payment Detail Modal --}}
<div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 hidden" id="paymentDetailModal" role="dialog" aria-modal="true">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">Payment Details</h3>
            <button onclick="closePaymentDetailModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100" aria-label="Close">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>
        <div class="p-6">
            {{-- Loading State --}}
            <div id="detailLoading" class="text-center py-8">
                <i class="fa fa-spinner fa-spin text-3xl text-gold"></i>
                <p class="text-gray-500 mt-2">Loading details...</p>
            </div>
            
            {{-- Error State --}}
            <div id="detailError" class="hidden text-center py-8">
                <i class="fa fa-exclamation-circle text-3xl text-red-500"></i>
                <p id="detailErrorMessage" class="text-gray-600 mt-2">Failed to load details</p>
                <button onclick="closePaymentDetailModal()" class="mt-4 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm">Close</button>
            </div>
            
            {{-- Success Content --}}
            <div id="detailSuccess" class="hidden space-y-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 block text-xs">Waybill</span>
                        <p class="font-medium text-gray-800" id="detailWaybill"></p>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Reference</span>
                        <p class="font-medium text-gray-800" id="detailReference"></p>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Amount</span>
                        <p class="font-bold text-green-600" id="detailAmount"></p>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Convenience Fee</span>
                        <p class="font-medium text-orange-600" id="detailFee"></p>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Status</span>
                        <p class="font-medium" id="detailStatus"></p>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Date</span>
                        <p class="font-medium text-gray-800" id="detailDate"></p>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Mode</span>
                        <p class="font-medium text-gray-800" id="detailMode"></p>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Bank</span>
                        <p class="font-medium text-gray-800" id="detailBank"></p>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-500 block text-xs">Account Number</span>
                        <p class="font-medium text-gray-800 font-mono" id="detailAccount"></p>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-500 block text-xs">Remarks</span>
                        <p class="text-sm text-gray-700" id="detailRemarks"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-right">
            <button onclick="closePaymentDetailModal()" class="px-4 py-2 bg-gold text-white rounded-lg hover:bg-gold-dark transition-all text-sm">
                Close
            </button>
        </div>
    </div>
</div>
@endpush
@endsection