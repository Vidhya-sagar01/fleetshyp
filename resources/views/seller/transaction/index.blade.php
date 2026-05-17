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
        {{-- Filter Header --}}
        <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gradient-cream">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-gold flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fa fa-wallet text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Filters</h3>
                        <p class="text-xs text-gray-500 hidden sm:block">Refine your transaction search</p>
                    </div>
                </div>
                <button type="button" id="toggleFilters" class="flex items-center text-sm text-gray-600 hover:text-gold transition-colors focus:outline-none flex-shrink-0">
                    <span id="filterToggleText" class="hidden sm:inline">Show Filters</span>
                    <i id="filterToggleIcon" class="fa fa-chevron-down ml-2 transition-transform duration-200"></i>
                </button>
            </div>
        </div>

        {{-- Filter Body --}}
        <div id="filterBody" class="hidden">
            <div class="p-4 sm:p-6">
                <form action="{{ route('transactions.index') }}" method="GET" id="filterForm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        
                        {{-- Date Filter --}}
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Date</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" name="date" class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Select date" value="{{ request('date') }}" id="datePicker">
                            </div>
                        </div>

                        {{-- Transaction Type --}}
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Type</label>
                            <select name="type" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Types</option>
                                <option value="credit" {{ request('type')=='credit'?'selected':'' }}>💰 Credit</option>
                                <option value="debit" {{ request('type')=='debit'?'selected':'' }}>💸 Debit</option>
                            </select>
                        </div>

                        {{-- Charge Type Filter --}}
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Charge Type</label>
                            <select name="status" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Types</option>
                                <option value="forward" {{ request('status')=='forward'?'selected':'' }}>📦 Forward</option>
                                <option value="cod" {{ request('status')=='cod'?'selected':'' }}>💰 COD</option>
                                <option value="rto" {{ request('status')=='rto'?'selected':'' }}>↩️ RTO</option>
                                <option value="tax" {{ request('status')=='tax'?'selected':'' }}>🧾 Tax</option>
                                <option value="recharge" {{ request('status')=='recharge'?'selected':'' }}>🔋 Recharge</option>
                                <option value="adjustment" {{ request('status')=='adjustment'?'selected':'' }}>⚙️ Adjustment</option>
                            </select>
                        </div>

                        {{-- Source Filter --}}
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Source</label>
                            <select name="source" class="form-control w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all bg-white">
                                <option value="">All Sources</option>
                                <option value="admin_manual" {{ request('source')=='admin_manual'?'selected':'' }}>👨‍💼 Admin</option>
                                <option value="razorpay" {{ request('source')=='razorpay'?'selected':'' }}>💳 Razorpay</option>
                                <option value="fship_booking" {{ request('source')=='fship_booking'?'selected':'' }}>📦 FShip</option>
                                <option value="fship_refund" {{ request('source')=='fship_refund'?'selected':'' }}>🔄 Refund</option>
                            </select>
                        </div>

                        {{-- Search Filter --}}
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Search</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="AWB or Order ID" value="{{ request('search') }}">
                            </div>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
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

    {{-- Main Content Area --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        {{-- Top Controls --}}
        <div class="px-4 sm:px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row flex-wrap items-start sm:items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                <span class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700">
                    <i class="fa fa-list mr-2 text-gold"></i>Total: <strong>{{ $transactions->total() }}</strong>
                </span>
                
                {{-- Balance Card --}}
                <span class="px-3 py-1.5 bg-gradient-gold text-white rounded-lg text-sm font-bold shadow-sm">
                    <i class="fa fa-wallet mr-2"></i>Current Balance: <strong>₹ {{ number_format(Auth::user()?->wallet?->balance ?? 0, 2) }}</strong>
                </span>
            </div>
            
            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                {{-- Refresh --}}
                <button id="refreshTable" class="p-2 text-gray-500 hover:text-gold hover:bg-gray-100 rounded-lg transition-all" title="Refresh">
                    <i class="fa fa-sync-alt"></i>
                </button>
                
                {{-- Export Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false" class="flex-1 sm:flex-none px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:border-gold transition-all flex items-center justify-center">
                        <i class="fa fa-file-export mr-2"></i>
                        <span class="sm:hidden">Export</span>
                        <i class="fa fa-chevron-down ml-2 text-xs transition-transform hidden sm:block" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-xl py-1 z-50">
                        <a href="{{ route('transactions.download', array_merge(request()->query(), ['format' => 'csv'])) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fa fa-file-csv mr-2 text-green-600"></i> CSV
                        </a>
                        <a href="{{ route('transactions.download', array_merge(request()->query(), ['format' => 'excel'])) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fa fa-file-excel mr-2 text-green-600"></i> Excel
                        </a>
                    </div>
                </div>
                
                {{-- Column Settings --}}
                <button class="flex-1 sm:flex-none px-3 py-1.5 text-sm font-medium text-white bg-gradient-gold rounded-lg hover:shadow-lg transition-all flex items-center justify-center" data-bs-toggle="modal" data-bs-target="#columnSettingsModal">
                    <i class="fa fa-cog mr-2"></i>
                    <span class="hidden sm:inline">Columns</span>
                </button>
            </div>
        </div>

        {{-- Status Tabs --}}
        <div class="px-4 sm:px-6 pt-2">
            <div class="flex items-center gap-1 overflow-x-auto pb-2 scrollbar-hide">
                @php
                $tabCounts = [
                    'all' => $transactions->total(),
                    'credit' => $counts['credit'] ?? 0,
                    'debit' => $counts['debit'] ?? 0,
                    'forward' => $counts['forward'] ?? 0,
                    'cod' => $counts['cod'] ?? 0,
                    'rto' => $counts['rto'] ?? 0,
                    'recharge' => $counts['recharge'] ?? 0,
                ];
                @endphp
                
                @foreach(['all'=>'All','credit'=>'💰 Credit','debit'=>'💸 Debit','forward'=>'📦 Forward','cod'=>'💰 COD','rto'=>'↩️ RTO','recharge'=>'🔋 Recharge'] as $key => $label)
                @php 
                    $isActive = (request('status') == $key) || ($key == 'all' && !request('status'));
                    $url = route('transactions.index', array_merge(request()->except('status','page','type'), ['status' => $key === 'all' ? '' : $key]));
                @endphp
                <a href="{{ $url }}" 
                   class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-t-lg transition-all whitespace-nowrap {{ $isActive ? 'text-gold border-b-2 border-gold bg-gradient-cream' : 'text-gray-500 hover:text-gray-700' }}">
                    {{ $label }}
                    <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full {{ $isActive ? 'bg-gold text-white' : 'bg-gray-100 text-gray-600' }}">
                        {{ $tabCounts[$key] }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Data Table --}}
        <div class="overflow-x-auto">
            <table class="w-full" id="transactionsTable">
                <thead class="bg-gray-50 text-nowrap">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-column="date">Date & Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-column="awb">AWB / Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-column="amount">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-column="type">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-column="charge_type">Charge Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-column="source">💡 Source</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-column="balance">Balance</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider" data-column="remark">Remark</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($transactions as $txn)
                    <tr class="hover:bg-gray-50 transition-colors text-sm">
                        
                        {{-- Date & Time --}}
                        <td class="px-4 py-4 whitespace-nowrap" data-column="date">
                            <div class="text-gray-800 font-medium">{{ $txn->created_at?->format('d M Y') }}</div>
                            <div class="text-[10px] text-gray-400">{{ $txn->created_at?->format('h:i A') }}</div>
                        </td>

                        {{-- AWB / Order ID --}}
                        <td class="px-4 py-4" data-column="awb">
                            @if($txn->fship_order_id)
                                <div class="font-mono text-xs text-blue-600 font-bold">{{ $txn->fship_order_id }}</div>
                                <div class="text-[10px] text-gray-400">AWB</div>
                            @else
                                <span class="text-[10px] text-gray-400 italic">N/A</span>
                            @endif
                        </td>

                        {{-- Amount --}}
                        <td class="px-4 py-4" data-column="amount">
                            <div class="font-bold text-gray-900">₹{{ number_format($txn->amount, 2) }}</div>
                            <span class="text-[10px] {{ $txn->type == 'credit' ? 'text-green-600' : 'text-red-600' }} font-bold">
                                {{ $txn->type == 'credit' ? '▲ Added' : '▼ Deducted' }}
                            </span>
                        </td>

                        {{-- Transaction Type --}}
                        <td class="px-4 py-4" data-column="type">
                            <span class="px-2 py-1 text-[10px] font-bold rounded-full border {{ 
                                $txn->type == 'credit' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' 
                            }}">
                                {{ strtoupper($txn->type) }}
                            </span>
                        </td>

                        {{-- Charge Type --}}
                        <td class="px-4 py-4" data-column="charge_type">
                            <span class="px-2 py-1 text-[10px] font-bold rounded bg-gray-100 text-gray-700">
                                {{ ucfirst(str_replace('_', ' ', $txn->charge_type ?? 'N/A')) }}
                            </span>
                        </td>

                        {{-- ✅ Source Column with Badge --}}
                        <td class="px-4 py-4" data-column="source">
                            @php
                                $sourceConfig = [
                                    'admin_manual' => ['class' => 'bg-blue-100 text-blue-700', 'icon' => 'fa-user-tie', 'label' => 'Admin'],
                                    'razorpay' => ['class' => 'bg-indigo-100 text-indigo-700', 'icon' => 'fa-credit-card', 'label' => 'Razorpay'],
                                    'fship_booking' => ['class' => 'bg-gray-100 text-gray-700', 'icon' => 'fa-truck', 'label' => 'FShip'],
                                    'fship_refund' => ['class' => 'bg-amber-100 text-amber-700', 'icon' => 'fa-undo', 'label' => 'Refund'],
                                    'forward' => ['class' => 'bg-orange-100 text-orange-700', 'icon' => 'fa-shipping-fast', 'label' => 'Forward'],
                                    'cod' => ['class' => 'bg-yellow-100 text-yellow-700', 'icon' => 'fa-money-bill', 'label' => 'COD'],
                                    'rto' => ['class' => 'bg-red-100 text-red-700', 'icon' => 'fa-undo', 'label' => 'RTO'],
                                    'recharge' => ['class' => 'bg-green-100 text-green-700', 'icon' => 'fa-plus-circle', 'label' => 'Recharge'],
                                    'adjustment' => ['class' => 'bg-gray-100 text-gray-600', 'icon' => 'fa-cog', 'label' => 'Adjust'],
                                ];
                                $config = $sourceConfig[$txn->source] ?? ['class' => 'bg-gray-100 text-gray-600', 'icon' => 'fa-circle', 'label' => ucfirst($txn->source ?? 'Unknown')];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium {{ $config['class'] }}">
                                <i class="fa {{ $config['icon'] }}"></i>
                                {{ $config['label'] }}
                            </span>
                        </td>

                        {{-- Balance --}}
                        <td class="px-4 py-4" data-column="balance">
                            <div class="text-xs text-gray-500">Open: ₹{{ number_format($txn->opening_balance, 2) }}</div>
                            <div class="font-bold text-gray-800">Close: ₹{{ number_format($txn->closing_balance, 2) }}</div>
                        </td>

                        {{-- Remark --}}
                        <td class="px-4 py-4" data-column="remark">
                            <div class="text-xs text-gray-700 leading-tight max-w-[200px] truncate" title="{{ $txn->remark }}">
                                {{ $txn->remark ?? 'No description' }}
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-20 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fa fa-wallet text-4xl text-gray-300 mb-3"></i>
                                <p class="font-medium">No transactions found</p>
                                <p class="text-sm text-gray-400">Try adjusting your filters</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-4 sm:px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                <select class="form-select px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold w-full sm:w-auto" id="perPageSelect" onchange="changePerPage(this.value)">
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                </select>
                <span class="text-sm text-gray-500 text-center sm:text-left">
                    Showing <strong>{{ $transactions->firstItem() ?? 0 }}</strong> to <strong>{{ $transactions->lastItem() ?? 0 }}</strong> of <strong>{{ $transactions->total() }}</strong>
                </span>
            </div>
            
            <nav class="flex items-center gap-1 w-full sm:w-auto overflow-x-auto">
                <a href="{{ $transactions->url(1) }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm text-gray-600 hover:text-gold hover:bg-gray-100 rounded-lg transition-all {{ $transactions->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">First</a>
                <a href="{{ $transactions->previousPageUrl() ?? '#' }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm text-gray-600 hover:text-gold hover:bg-gray-100 rounded-lg transition-all {{ $transactions->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
                    <i class="fa fa-chevron-left"></i>
                </a>
                
                @for ($i = max(1, $transactions->currentPage() - 2); $i <= min($transactions->lastPage(), $transactions->currentPage() + 2); $i++)
                <a href="{{ $transactions->url($i) }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm rounded-lg transition-all {{ $i == $transactions->currentPage() ? 'bg-gold text-white font-medium' : 'text-gray-600 hover:text-gold hover:bg-gray-100' }}">
                    {{ $i }}
                </a>
                @endfor
                
                <a href="{{ $transactions->nextPageUrl() ?? '#' }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm text-gray-600 hover:text-gold hover:bg-gray-100 rounded-lg transition-all {{ !$transactions->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
                    <i class="fa fa-chevron-right"></i>
                </a>
                <a href="{{ $transactions->url($transactions->lastPage()) }}" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm text-gray-600 hover:text-gold hover:bg-gray-100 rounded-lg transition-all {{ !$transactions->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">Last</a>
            </nav>
        </div>
    </div>
</div>

{{-- Column Settings Modal --}}
<div class="modal fade fixed inset-0 z-50 overflow-y-auto hidden" id="columnSettingsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered relative w-auto mx-4 pointer-events-none">
        <div class="modal-content relative flex flex-col w-full pointer-events-auto bg-white border border-gray-200 rounded-xl shadow-xl outline-none max-h-[90vh]">
            <div class="modal-header flex items-center justify-between p-4 sm:p-6 border-b border-gray-100">
                <h6 class="modal-title font-semibold text-gray-800 text-base sm:text-lg">Customize Columns</h6>
                <button type="button" class="btn-close text-gray-400 hover:text-gray-600" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-4 sm:p-6 overflow-y-auto">
                <div class="space-y-2">
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="date">
                        <span class="text-sm text-gray-700">Date & Time</span>
                    </label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="awb">
                        <span class="text-sm text-gray-700">AWB / Order ID</span>
                    </label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="amount">
                        <span class="text-sm text-gray-700">Amount</span>
                    </label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="type">
                        <span class="text-sm text-gray-700">Transaction Type</span>
                    </label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="charge_type">
                        <span class="text-sm text-gray-700">Charge Type</span>
                    </label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="source">
                        <span class="text-sm text-gray-700">Source</span>
                    </label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="balance">
                        <span class="text-sm text-gray-700">Balance</span>
                    </label>
                    <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold mr-3" type="checkbox" checked data-column="remark">
                        <span class="text-sm text-gray-700">Remark</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer flex flex-col sm:flex-row items-center justify-end gap-3 p-4 sm:p-6 border-t border-gray-100">
                <button type="button" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-gradient-gold rounded-lg hover:shadow-lg transition-all" id="saveColumns">Save Changes</button>
            </div>
        </div>
    </div>
</div>

{{-- CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    [x-cloak] { display: none !important }
    .flatpickr-calendar {
        border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        border-radius: 12px; padding: 16px;
    }
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
        background: #D4AF37 !important; border-color: #D4AF37 !important;
    }
    .overflow-x-auto::-webkit-scrollbar { height: 6px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #D4AF37; border-radius: 3px; }
    .form-control:focus, .form-select:focus {
        outline: none; box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    }
    #filterBody { transition: all 0.3s ease-in-out; }
    #filterBody.hidden { display: none; opacity: 0; }
    #filterBody:not(.hidden) { display: block; opacity: 1; }
    
    @media (max-width: 640px) {
        .table-responsive-stack tr {
            display: flex; flex-direction: column;
            margin-bottom: 1rem; border: 1px solid #e5e7eb;
            border-radius: 0.5rem; padding: 0.75rem;
        }
        .table-responsive-stack td {
            display: flex; justify-content: space-between;
            align-items: center; padding: 0.5rem 0; border: none;
            border-bottom: 1px solid #f3f4f6;
        }
        .table-responsive-stack td:last-child { border-bottom: none; }
        .table-responsive-stack td::before {
            content: attr(data-label);
            font-weight: 600; color: #6b7280; margin-right: 1rem;
        }
    }
    @media (max-width: 768px) {
        button, a { min-height: 44px; }
        input, select { min-height: 44px; }
    }
</style>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== FILTER TOGGLE ==========
    const filterBody = document.getElementById('filterBody');
    const toggleFilters = document.getElementById('toggleFilters');
    const filterToggleText = document.getElementById('filterToggleText');
    const filterToggleIcon = document.getElementById('filterToggleIcon');
    let isFilterOpen = false;
    
    function toggleFilterSection() {
        isFilterOpen = !isFilterOpen;
        if (isFilterOpen) {
            filterBody?.classList.remove('hidden');
            if(filterToggleText) filterToggleText.textContent = 'Hide Filters';
            if(filterToggleIcon) {
                filterToggleIcon.classList.remove('fa-chevron-down');
                filterToggleIcon.classList.add('fa-chevron-up');
            }
            setTimeout(() => initDatePickers(), 100);
        } else {
            filterBody?.classList.add('hidden');
            if(filterToggleText) filterToggleText.textContent = 'Show Filters';
            if(filterToggleIcon) {
                filterToggleIcon.classList.remove('fa-chevron-up');
                filterToggleIcon.classList.add('fa-chevron-down');
            }
        }
    }
    if(toggleFilters) toggleFilters.addEventListener('click', (e) => { e.preventDefault(); toggleFilterSection(); });
    
    // ========== DATE PICKER ==========
    function initDatePickers() {
        const el = document.getElementById('datePicker');
        if (el && !el._flatpickr) {
            el._flatpickr = flatpickr(el, { dateFormat: "Y-m-d", locale: { firstDayOfWeek: 1 }, allowInput: true });
        }
    }
    
    // ========== CLEAR FILTERS ==========
    document.getElementById('clearFilters')?.addEventListener('click', () => {
        if(confirm('Clear all filters?')) window.location.href = "{{ route('transactions.index') }}";
    });
    
    // ========== PER PAGE CHANGE ==========
    window.changePerPage = function(value) {
        const url = new URL(window.location);
        url.searchParams.set('per_page', value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    };
    
    // ========== REFRESH ==========
    document.getElementById('refreshTable')?.addEventListener('click', function() {
        this.querySelector('i')?.classList.add('fa-spin');
        setTimeout(() => window.location.reload(), 500);
    });
    
    // ========== COLUMN SETTINGS ==========
    document.getElementById('saveColumns')?.addEventListener('click', function() {
        const visible = Array.from(document.querySelectorAll('#columnSettingsModal [data-column]:checked')).map(c => c.dataset.column);
        localStorage.setItem('txnTableColumns', JSON.stringify(visible));
        applyColumnVisibility(visible);
        document.getElementById('columnSettingsModal')?.classList.add('hidden');
        showToast('Columns updated!', 'success');
    });
    
    // Apply column visibility
    function applyColumnVisibility(columns) {
        document.querySelectorAll('#transactionsTable th, #transactionsTable td').forEach(cell => {
            const col = cell.dataset.column;
            if(col) cell.style.display = columns.includes(col) ? '' : 'none';
        });
    }
    
    // Load saved columns on page load
    const saved = localStorage.getItem('txnTableColumns');
    if(saved) {
        try {
            const cols = JSON.parse(saved);
            applyColumnVisibility(cols);
        } catch(e) {}
    }
    
    // ========== TOAST ==========
    function showToast(msg, type='info') {
        // Remove existing toasts
        document.querySelectorAll('.toast-notification').forEach(t => t.remove());
        
        const icons = { success: 'check-circle', error: 'exclamation-circle', info: 'info-circle' };
        const classes = { success: 'toast-success', error: 'toast-error', info: 'toast-info' };
        
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed bottom-4 right-4 px-4 py-3 rounded-lg shadow-lg text-white text-sm z-50 ${classes[type] || classes.info}`;
        toast.innerHTML = `<i class="fa fa-${icons[type] || icons.info} mr-2"></i><span>${msg}</span>`;
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => { 
            toast.style.opacity = '0'; 
            toast.style.transition = 'opacity 0.3s';
            setTimeout(() => toast.remove(), 300); 
        }, 3000);
    }
});
</script>

{{-- CSRF Token --}}
@if(!request()->headers->has('X-CSRF-TOKEN'))
<meta name="csrf-token" content="{{ csrf_token() }}">
@endif

@endsection