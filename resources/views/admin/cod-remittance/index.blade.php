@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">COD Remittance Management</h1>
            <p class="text-sm text-gray-500 mt-1">Process seller COD payments and track remittances</p>
        </div>
        <button onclick="openBulkProcessModal()" class="px-4 py-2 bg-gold text-white rounded-lg hover:bg-gold-dark transition-all flex items-center gap-2">
            <i class="fa fa-check-circle"></i> Bulk Process Payments
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-orange-100 to-pink-100 rounded-bl-full opacity-50"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-600">Total COD Amount</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($totalCod ?? 0, 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-100 to-emerald-100 rounded-bl-full opacity-50"></div>
            <div class="relative">
                <p class="text-sm font-medium text-green-600">Total Paid</p>
                <p class="text-2xl font-bold text-green-600 mt-2">₹{{ number_format($totalPaid ?? 0, 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-bl-full opacity-50"></div>
            <div class="relative">
                <p class="text-sm font-medium text-blue-600">Pending Payments</p>
                <p class="text-2xl font-bold text-blue-600 mt-2">₹{{ number_format($totalPending ?? 0, 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('codRemittance.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Seller</label>
                <select name="user_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold">
                    <option value="">All Sellers</option>
                    @foreach($sellers as $seller)
                        <option value="{{ $seller->id }}" {{ request('user_id') == $seller->id ? 'selected' : '' }}>
                            {{ $seller->name }} ({{ $seller->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="remittance_status" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold">
                    <option value="">All</option>
                    <option value="pending" {{ request('remittance_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('remittance_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-gold text-white rounded-lg hover:bg-gold-dark transition-all">Filter</button>
                <a href="{{ route('codRemittance.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-all">Reset</a>
            </div>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" class="rounded border-gray-300 text-gold focus:ring-gold">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Waybill</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Seller</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">COD Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Payment Ref</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        @php
                            $subtotal = $order->product_subtotal ?? 0;
                            $forwardCharge = $order->forward_charge ?? 0;
                            $walletDeduction = $order->wallet_deduction_amount ?? 0;
                            $netAmount = max($subtotal - $forwardCharge - $walletDeduction, 0);
                            $lastPayment = $order->remittancePayments->where('status', 'paid')->last();
                            $isRemitted = $order->is_remitted ?? false;
                            $waybill = $order->waybill ?? $order->id;
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors {{ $isRemitted ? 'bg-gray-50' : '' }}">
                            <td class="px-4 py-3">
                                @if(!$isRemitted)
                                    <input type="checkbox" 
                                           class="order-checkbox rounded border-gray-300 text-gold focus:ring-gold" 
                                           value="{{ $order->id }}" 
                                           data-waybill="{{ $waybill }}"
                                           data-amount="{{ number_format($netAmount, 2, '.', '') }}">
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 font-medium">{{ $waybill }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $order->updated_at ? $order->updated_at->format('d-m-Y') : '-' }}</td>
                            <td class="px-4 py-3 text-sm font-semibold">₹{{ number_format($subtotal, 2) }}</td>

                            <td class="px-4 py-3">
                                @if($isRemitted)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Paid</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $lastPayment ? $lastPayment->payment_reference : '-' }}</td>
                            <td class="px-4 py-3">
                                @if(!$isRemitted)
                                    <button type="button" 
                                            onclick="openPaymentProcessModal({{ $order->id }}, '{{ $waybill }}', {{ $netAmount }})" 
                                            class="px-3 py-1.5 bg-[#684BE0] text-white rounded-lg text-xs hover:bg-opacity-90 transition-all flex items-center gap-1 shadow-sm font-medium">
                                        <i class="fa fa-check text-[10px]"></i> Process
                                    </button>
                                @else
                                    <button type="button" 
                                            onclick="viewPaymentDetail('{{ addslashes($waybill) }}')" 
                                            class="px-3 py-1.5 bg-white border-2 border-black text-black rounded-lg text-xs hover:bg-black hover:text-white transition-all flex items-center gap-1 shadow-sm font-medium">
                                        <i class="fa fa-eye text-[10px]"></i> View
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                <i class="fa fa-inbox text-4xl text-gray-300 mb-3 block"></i>
                                <p class="text-gray-600">No COD orders found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting your filters</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $orders->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Payment Process Modal --}}
<div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 hidden" id="paymentProcessModal" role="dialog" aria-modal="true">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between flex-shrink-0">
            <h2 class="text-xl font-bold text-gray-800" id="modalTitle">Process Payment</h2>
            <button onclick="closePaymentProcessModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-full hover:bg-gray-100" aria-label="Close modal">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>
        
        <form id="paymentProcessForm" class="flex-1 overflow-y-auto p-6 space-y-4">
            <input type="hidden" name="order_ids" id="processOrderIds">
            
            {{-- Waybill Display (Read-Only) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Waybill Number(s)</label>
                <div id="displayOrderIds" class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-600 min-h-[40px] font-mono"></div>
            </div>
            
            {{-- 💰 Amount to Pay --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-200">
                <h4 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fa fa-rupee text-green-600"></i>
                    Payment Amount
                </h4>
                
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">₹</span>
                    <input type="number" name="amount_to_pay" id="amountToPay" 
                           step="0.01" min="0" required placeholder="Enter amount to pay"
                           class="w-full pl-8 pr-3 py-2 border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all font-semibold text-lg">
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fa fa-info-circle mr-1"></i>
                    Enter any amount you want to pay (full/partial)
                </p>
            </div>
            
            {{-- 💸 Convenience Fee --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Convenience Fee (₹) <span class="text-gray-400 font-normal">- Optional</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">₹</span>
                    <input type="number" name="convenience_fee" id="convenienceFee" 
                           step="0.01" min="0" value="0" placeholder="0.00"
                           class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#684BE0] focus:border-[#684BE0] transition-all">
                </div>
                <p class="text-xs text-gray-500 mt-1">Enter fee amount in ₹ (if applicable)</p>
            </div>
            
            {{-- Payment Reference --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Reference *</label>
                <input type="text" name="payment_reference" required placeholder="e.g., CMS56658793904" 
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#684BE0] focus:border-[#684BE0] transition-all">
            </div>
            
            {{-- Bank Details --}}
            <div class="border-t border-gray-200 pt-4 mt-2">
                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fa fa-university text-[#684BE0]"></i> Bank Details
                </h4>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                        <input type="text" name="bank_name" placeholder="e.g., HDFC Bank, SBI, ICICI" 
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#684BE0] focus:border-[#684BE0] transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                        <input type="text" name="bank_account" placeholder="e.g., 50200012345678" 
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#684BE0] focus:border-[#684BE0] transition-all">
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date *</label>
                    <input type="date" name="payment_date" required value="{{ date('Y-m-d') }}" 
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#684BE0] focus:border-[#684BE0] transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Mode</label>
                    <select name="payment_mode" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#684BE0] focus:border-[#684BE0] transition-all">
                        <option value="">Select Mode</option>
                        <option value="NEFT">NEFT</option>
                        <option value="RTGS">RTGS</option>
                        <option value="UPI">UPI</option>
                        <option value="IMPS">IMPS</option>
                        <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                <textarea name="remarks" rows="2" placeholder="Optional notes..." 
                          class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#684BE0] focus:border-[#684BE0] transition-all resize-none"></textarea>
            </div>
            
            <div id="formErrors" class="hidden bg-red-50 border border-red-200 rounded-lg p-3">
                <ul id="errorList" class="text-sm text-red-600 space-y-1"></ul>
            </div>
            
            <div class="flex gap-3 pt-4 border-t border-gray-100 sticky bottom-0 bg-white pb-2">
                <button type="submit" id="submitBtn" class="flex-1 px-4 py-2.5 bg-[#684BE0] text-white rounded-lg hover:opacity-90 transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed font-medium">
                    <i class="fa fa-check"></i> 
                    <span id="submitText">Process Payment</span>
                    <i class="fa fa-spinner fa-spin hidden" id="loadingIcon"></i>
                </button>
                <button type="button" onclick="closePaymentProcessModal()" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-all font-medium">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Payment Detail Modal --}}
<div class="fixed inset-0 bg-black bg-opacity-50 z-[60] flex items-center justify-center p-4 hidden" id="paymentDetailModal" role="dialog" aria-modal="true">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">Payment Details</h3>
            <button onclick="closePaymentDetailModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100" aria-label="Close">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>
        
        <div class="p-6" id="paymentDetailContent">
            <div id="detailLoading" class="text-center py-8">
                <i class="fa fa-spinner fa-spin text-3xl text-[#684BE0]"></i>
                <p class="text-gray-500 mt-2">Loading details...</p>
            </div>
            
            <div id="detailError" class="hidden text-center py-8">
                <i class="fa fa-exclamation-circle text-3xl text-red-500"></i>
                <p id="detailErrorMessage" class="text-gray-600 mt-2"></p>
                <button onclick="closePaymentDetailModal()" class="mt-4 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200">Close</button>
            </div>
            
            <div id="detailSuccess" class="hidden space-y-6">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-[#684BE0]">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa fa-calculator text-[#684BE0]"></i>
                        Amount Breakdown
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center bg-white rounded-lg p-3 shadow-sm">
                            <span class="text-gray-700 font-medium">Product Subtotal:</span>
                            <span id="detailSubtotal" class="font-bold text-gray-800 text-lg"></span>
                        </div>
                        <div class="flex justify-between items-center bg-white rounded-lg p-3 shadow-sm">
                            <span class="text-gray-700 font-medium">Convenience Fee:</span>
                            <span id="detailConvenienceFee" class="font-bold text-orange-600 text-lg"></span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fa fa-receipt text-[#684BE0]"></i>
                        Payment Information
                    </h4>
                    <div id="paymentsList" class="space-y-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let selectedOrders = [];
let selectedWaybills = [];
let totalAmount = 0;

function toggleSelectAll(source) {
    document.querySelectorAll('.order-checkbox:not(:disabled)').forEach(cb => cb.checked = source.checked);
    updateBulkSelection();
}

function updateBulkSelection() {
    const checkboxes = document.querySelectorAll('.order-checkbox:checked');
    selectedOrders = Array.from(checkboxes).map(cb => cb.value);
    selectedWaybills = Array.from(checkboxes).map(cb => cb.dataset.waybill);
    totalAmount = Array.from(checkboxes).reduce((sum, cb) => sum + parseFloat(cb.dataset.amount || 0), 0);
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.order-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            updateBulkSelection();
            const all = document.querySelectorAll('.order-checkbox:not(:disabled)');
            const checked = document.querySelectorAll('.order-checkbox:checked');
            document.getElementById('selectAll').checked = all.length > 0 && all.length === checked.length;
        });
    });
});

function openPaymentProcessModal(dbOrderId = null, waybill = null, amount = null) {
    const modal = document.getElementById('paymentProcessModal');
    const modalTitle = document.getElementById('modalTitle');
    const orderIdsInput = document.getElementById('processOrderIds');
    const displayOrderIds = document.getElementById('displayOrderIds');
    
    // Reset form
    document.getElementById('paymentProcessForm').reset();
    document.getElementById('formErrors').classList.add('hidden');
    document.getElementById('errorList').innerHTML = '';
    document.getElementById('submitBtn').disabled = false;
    document.getElementById('loadingIcon').classList.add('hidden');
    document.getElementById('submitText').textContent = 'Process Payment';
    
    if (dbOrderId) {
        modalTitle.textContent = 'Process Payment';
        selectedOrders = [dbOrderId];
        selectedWaybills = [waybill || dbOrderId];
        totalAmount = parseFloat(amount) || 0;
        displayOrderIds.textContent = '#' + selectedWaybills[0];
    } else {
        const checkboxes = document.querySelectorAll('.order-checkbox:checked');
        selectedOrders = Array.from(checkboxes).map(cb => cb.value);
        selectedWaybills = Array.from(checkboxes).map(cb => cb.dataset.waybill);
        totalAmount = Array.from(checkboxes).reduce((sum, cb) => sum + parseFloat(cb.dataset.amount || 0), 0);
        
        if (selectedOrders.length === 0) { 
            alert('Please select at least one order to process'); 
            return; 
        }
        
        modalTitle.textContent = `Bulk Process (${selectedOrders.length} Orders)`;
        displayOrderIds.textContent = '#' + selectedWaybills.join(', #');
    }
    
    orderIdsInput.value = selectedOrders.join(',');
    document.querySelector('input[name="payment_date"]').value = new Date().toISOString().split('T')[0];
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Focus on amount field for quick entry
    setTimeout(() => document.getElementById('amountToPay')?.focus(), 100);
}

function openBulkProcessModal() { 
    openPaymentProcessModal(); 
}

function closePaymentProcessModal() {
    document.getElementById('paymentProcessModal').classList.add('hidden');
    document.body.style.overflow = '';
    document.getElementById('paymentProcessForm').reset();
    document.getElementById('formErrors').classList.add('hidden');
}

function viewPaymentDetail(waybill) {
    const modal = document.getElementById('paymentDetailModal');
    const loading = document.getElementById('detailLoading');
    const error = document.getElementById('detailError');
    const success = document.getElementById('detailSuccess');
    const errorMsg = document.getElementById('detailErrorMessage');
    
    loading.classList.remove('hidden');
    error.classList.add('hidden');
    success.classList.add('hidden');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    const url = '/admin/payment-detail/' + encodeURIComponent(waybill) + '?t=' + Date.now();
    
    fetch(url, {
        headers: { 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'Cache-Control': 'no-cache'
        },
        cache: 'no-store'
    })
    .then(async response => {
        const text = await response.text();
        if (!response.ok) {
            try {
                const err = JSON.parse(text);
                throw new Error(err.message || 'Order not found');
            } catch(e) {
                throw new Error('Server error: ' + response.status);
            }
        }
        return JSON.parse(text);
    })
    .then(data => {
        if (data.success) {
            // ✅ Amount Breakdown - Convenience Fee from database field
            document.getElementById('detailSubtotal').textContent = '₹' + parseFloat(data.order.product_subtotal || 0).toFixed(2);
            
            // ✅ FIXED: Use convenience_fee field properly with formatting
            const convenienceFee = parseFloat(data.payments[0]?.convenience_fee ?? 0).toFixed(2);
            document.getElementById('detailConvenienceFee').textContent = '₹' + convenienceFee;
            
            const paymentsList = document.getElementById('paymentsList');
            
            if (data.payments && data.payments.length > 0) {
                const p = data.payments[0];
                const amountPaid = parseFloat(p.remitted_amount ?? p.amount_paid ?? 0).toFixed(2);
                const fee = parseFloat(p.convenience_fee ?? 0).toFixed(2);
                
                paymentsList.innerHTML = `
                    <div class="bg-white border-2 border-[#684BE0] rounded-xl p-6 space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b-2 border-[#684BE0]">
                            <span class="text-gray-600 font-semibold">Payment Reference:</span>
                            <span class="text-2xl font-bold text-[#684BE0]">${p.payment_reference}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 block text-xs font-medium mb-1"><i class="fa fa-university text-[#684BE0] mr-1"></i> Bank Name</span>
                                <p class="font-medium text-gray-800">${p.bank_name || '-'}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 block text-xs font-medium mb-1"><i class="fa fa-credit-card text-[#684BE0] mr-1"></i> Account Number</span>
                                <p class="font-medium text-gray-800">${p.bank_account || '-'}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 block text-xs font-medium mb-1"><i class="fa fa-truck text-[#684BE0] mr-1"></i> Waybill Number</span>
                                <p class="font-medium text-gray-800">${data.order.waybill}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 block text-xs font-medium mb-1"><i class="fa fa-calendar text-[#684BE0] mr-1"></i> Payment Date</span>
                                <p class="font-medium text-gray-800">${p.payment_date}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 block text-xs font-medium mb-1"><i class="fa fa-money text-[#684BE0] mr-1"></i> Payment Mode</span>
                                <p class="font-medium text-gray-800">${p.payment_mode || '-'}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 block text-xs font-medium mb-1"><i class="fa fa-tag text-[#684BE0] mr-1"></i> Amount Paid</span>
                                <p class="font-bold text-green-600">₹${amountPaid}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 block text-xs font-medium mb-1"><i class="fa fa-percent text-[#684BE0] mr-1"></i> Convenience Fee</span>
                                <p class="font-bold text-orange-600">₹${fee}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 block text-xs font-medium mb-1">Seller</span>
                                <p class="font-medium text-gray-800">${data.order.seller_name}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-gray-500 block text-xs font-medium mb-1">Status</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full ${p.status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}">${p.status.toUpperCase()}</span>
                            </div>
                        </div>
                        ${p.remarks ? `
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                <span class="text-yellow-700 text-xs font-medium block mb-1"><i class="fa fa-sticky-note mr-1"></i> Remarks</span>
                                <p class="text-sm text-gray-700">${p.remarks}</p>
                            </div>
                        ` : ''}
                        <div class="text-xs text-gray-400 pt-3 border-t border-gray-200 flex justify-between">
                            <span>Processed by: ${p.processed_by || 'Admin'}</span>
                            <span>${p.created_at || ''}</span>
                        </div>
                    </div>
                `;
            } else {
                paymentsList.innerHTML = `<div class="text-center py-8 text-gray-500"><i class="fa fa-inbox text-4xl mb-3"></i><p class="font-medium">No payment records found</p><p class="text-sm mt-1">This order has not been processed yet</p></div>`;
            }
            
            loading.classList.add('hidden');
            success.classList.remove('hidden');
        } else {
            throw new Error(data.message);
        }
    })
    .catch(err => {
        console.error('❌ Error:', err);
        loading.classList.add('hidden');
        error.classList.remove('hidden');
        errorMsg.textContent = err.message;
    });
}

function closePaymentDetailModal() {
    document.getElementById('paymentDetailModal').classList.add('hidden');
    document.body.style.overflow = '';
}

document.getElementById('paymentProcessForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingIcon = document.getElementById('loadingIcon');
    
    submitBtn.disabled = true; 
    submitText.textContent = 'Processing...'; 
    loadingIcon.classList.remove('hidden');
    document.getElementById('formErrors').classList.add('hidden');
    
    const formData = new FormData(this);
    
    fetch('{{ route("processPayment") }}', {
        method: 'POST',
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}', 
            'X-Requested-With': 'XMLHttpRequest' 
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) { 
            alert('Payment processed successfully!'); 
            closePaymentProcessModal(); 
            location.reload(); 
        } else { 
            alert('Error: ' + data.message); 
        }
    })
    .catch(error => { 
        alert('Error processing payment. Please try again.'); 
        console.error('Error:', error); 
    })
    .finally(() => { 
        submitBtn.disabled = false; 
        submitText.textContent = 'Process Payment'; 
        loadingIcon.classList.add('hidden'); 
    });
});

document.getElementById('paymentProcessModal').addEventListener('click', function(e) { 
    if (e.target === this) closePaymentProcessModal(); 
});
document.getElementById('paymentDetailModal').addEventListener('click', function(e) { 
    if (e.target === this) closePaymentDetailModal(); 
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('paymentProcessModal').classList.contains('hidden')) closePaymentProcessModal();
        if (!document.getElementById('paymentDetailModal').classList.contains('hidden')) closePaymentDetailModal();
    }
});
</script>
@endpush
@endsection