@extends('seller.layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Alerts --}}
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <i class="fa fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <i class="fa fa-exclamation-circle text-red-500 mr-3"></i>
            <p class="text-red-700">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    {{-- Filter Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-visible">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-cream flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-gold flex items-center justify-center mr-3">
                    <i class="fa fa-filter text-white text-sm"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Recharge Filters</h3>
            </div>
            <button type="button" onclick="toggleFilters()" class="text-sm text-gray-600 hover:text-gold transition-colors flex items-center gap-2">
                <span id="filterToggleText">Show Filters</span>
                <i id="filterToggleIcon" class="fa fa-chevron-down transition-transform"></i>
            </button>
        </div>

        <div id="filterBody" class="hidden p-6 bg-gray-50">
            <form method="GET" action="{{ route('wallet.recharges') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Date Range --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Date Range</label>
                        <input type="text" name="date_range" id="dateRange"
                            placeholder="Select date range"
                            class="w-full border border-gray-200 p-2.5 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all"
                            value="{{ request('date_range') }}">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-200 p-2.5 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                            <option value="">All Status</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>✅ Success (Credit)</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>❌ Failed (Debit)</option>
                        </select>
                    </div>

                    {{-- Source --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Source</label>
                        <select name="source" class="w-full border border-gray-200 p-2.5 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                            <option value="">All Sources</option>
                            <option value="admin_manual" {{ request('source') == 'admin_manual' ? 'selected' : '' }}>👨‍💼 Admin</option>
                            <option value="razorpay" {{ request('source') == 'razorpay' ? 'selected' : '' }}>💳 Razorpay</option>
                            <option value="stripe" {{ request('source') == 'stripe' ? 'selected' : '' }}>💳 Stripe</option>
                            <option value="fship_refund" {{ request('source') == 'fship_refund' ? 'selected' : '' }}>🔄 Refund</option>
                        </select>
                    </div>

                </div>

                {{-- Apply Button --}}
                <div class="flex items-end mt-4">
                    <button type="submit" class="w-full bg-gradient-gold text-white rounded-lg px-4 py-2.5 text-sm font-medium hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa fa-search"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-visible">

        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gradient-cream">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gold flex items-center justify-center">
                    <i class="fa fa-wallet text-white text-sm"></i>
                </div>
                <div>
                    <strong class="text-gray-800">Total:</strong> 
                    <span class="text-gray-600">{{ $recharges->total() }}</span>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm">
                <i class="fa fa-coins text-gold"></i>
                <span class="text-sm text-gray-600">Balance:</span>
                <span class="font-bold text-gold">₹ {{ number_format(Auth::user()?->wallet?->balance ?? 0, 2) }}</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reference ID</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Source</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Remark</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($recharges as $txn)
                    @php
                        // ✅ FIXED: Admin manual recharge = always success
                        // ✅ Payment gateway recharge = check type (credit=success, debit=failed)
                        $displayStatus = ($txn->source === 'admin_manual') 
                            ? 'success' 
                            : ($txn->type === 'credit' ? 'success' : 'failed');
                        
                        $statusConfig = [
                            'success' => ['class' => 'bg-green-100 text-green-700 border border-green-200', 'label' => '✅ Success'],
                            'pending' => ['class' => 'bg-yellow-100 text-yellow-700 border border-yellow-200', 'label' => '⏳ Pending'],
                            'failed' => ['class' => 'bg-red-100 text-red-700 border border-red-200', 'label' => '❌ Failed'],
                        ];
                        $statusBadge = $statusConfig[$displayStatus] ?? $statusConfig['pending'];
                        
                        // Source badge config
                        $sourceConfig = [
                            'admin_manual' => ['class' => 'bg-blue-100 text-blue-700', 'icon' => 'fa-user-tie', 'label' => 'Admin'],
                            'razorpay' => ['class' => 'bg-indigo-100 text-indigo-700', 'icon' => 'fa-credit-card', 'label' => 'Razorpay'],
                            'stripe' => ['class' => 'bg-indigo-100 text-indigo-700', 'icon' => 'fa-credit-card', 'label' => 'Stripe'],
                            'paytm' => ['class' => 'bg-blue-100 text-blue-700', 'icon' => 'fa-mobile-alt', 'label' => 'Paytm'],
                            'fship_refund' => ['class' => 'bg-amber-100 text-amber-700', 'icon' => 'fa-undo', 'label' => 'Refund'],
                        ];
                        $sourceBadge = $sourceConfig[$txn->source] ?? ['class' => 'bg-gray-100 text-gray-600', 'icon' => 'fa-circle', 'label' => ucfirst($txn->source ?? 'Unknown')];
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">

                        {{-- Date --}}
                        <td class="p-4">
                            <div class="text-gray-800 font-medium">
                                {{ $txn->created_at?->format('d M Y') ?? 'N/A' }}
                            </div>
                            <div class="text-xs text-gray-400">
                                {{ $txn->created_at?->format('h:i A') ?? '' }}
                            </div>
                        </td>

                        {{-- Reference ID (fship_order_id or remark) --}}
                        <td class="p-4 text-blue-600 font-mono text-xs">
                            {{ $txn->fship_order_id ?? $txn->remark ?? 'N/A' }}
                        </td>

                        {{-- Amount --}}
                        <td class="p-4 font-bold {{ $txn->type == 'credit' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $txn->type == 'credit' ? '+' : '-' }}₹{{ number_format($txn->amount ?? 0, 2) }}
                        </td>

                        {{-- Type --}}
                        <td class="p-4">
                            <span class="px-2 py-1 text-[10px] font-bold rounded-full border {{ 
                                $txn->type == 'credit' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' 
                            }}">
                                {{ strtoupper($txn->type) }}
                            </span>
                        </td>

                        {{-- ✅ Source Column --}}
                        <td class="p-4">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium {{ $sourceBadge['class'] }}">
                                <i class="fa {{ $sourceBadge['icon'] }}"></i>
                                {{ $sourceBadge['label'] }}
                            </span>
                        </td>

                        {{-- ✅ Status Column (Fixed Logic) --}}
                        <td class="p-4">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusBadge['class'] }}">
                                {{ $statusBadge['label'] }}
                            </span>
                        </td>

                        {{-- Remark --}}
                        <td class="p-4 text-xs text-gray-600 max-w-[200px] truncate" title="{{ $txn->remark }}">
                            {{ $txn->remark ?? '-' }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center p-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="fa fa-wallet text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 font-medium">No recharge history found</p>
                            <p class="text-sm text-gray-400 mt-1">Your wallet transactions will appear here</p>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($recharges->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <span class="text-sm text-gray-500">
                Showing {{ $recharges->firstItem() ?? 0 }} to {{ $recharges->lastItem() ?? 0 }} of {{ $recharges->total() }}
            </span>
            <div>
                {{ $recharges->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
        @endif

    </div>
</div>

{{-- Flatpickr CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
// Toggle Filters
function toggleFilters(){
    const filterBody = document.getElementById('filterBody');
    const toggleText = document.getElementById('filterToggleText');
    const toggleIcon = document.getElementById('filterToggleIcon');
    
    if(!filterBody || !toggleText || !toggleIcon) return;
    
    filterBody.classList.toggle('hidden');
    
    if(filterBody.classList.contains('hidden')) {
        toggleText.textContent = 'Show Filters';
        toggleIcon.classList.remove('fa-chevron-up');
        toggleIcon.classList.add('fa-chevron-down');
    } else {
        toggleText.textContent = 'Hide Filters';
        toggleIcon.classList.remove('fa-chevron-down');
        toggleIcon.classList.add('fa-chevron-up');
    }
}

// Date Range Picker
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('dateRange');
    if(dateInput && typeof flatpickr !== 'undefined') {
        flatpickr(dateInput, {
            mode: "range",
            dateFormat: "Y-m-d",
            maxDate: "today",
            allowInput: true
        });
    }
});

// Show Details (optional)
function showDetails(refId, remark){
    alert("Reference: " + refId + "\nRemark: " + remark);
}
</script>

@endsection