@extends('admin.layouts.app')

@section('title', 'Rate Card Management')

@push('styles')
<style>
    .rates-table thead th {
        padding: 0.75rem 0.5rem;
        font-size: 0.7rem;
        background: #f8fafc;
        border-bottom: 1px solid var(--border);
        font-weight: 600;
    }
    .zone-header {
        background: #f1f5f9 !important;
        color: var(--text-secondary) !important;
        min-width: 140px;
        text-align: center;
    }
    .zone-sub {
        display: block;
        font-size: 0.6rem;
        font-weight: normal;
        color: #64748b;
        margin-top: 2px;
    }
    .rate-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4px 8px;
        text-align: center;
        padding: 4px 0;
    }
    .rate-item {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
        background: #ffffff;
        border-radius: 4px;
        padding: 2px 4px;
    }
    .rate-value {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.75rem;
    }
    .rate-label {
        font-size: 0.6rem;
        color: #64748b;
        text-transform: none;
        font-weight: 500;
    }
    .courier-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .courier-info h4 {
        font-size: 0.85rem;
        font-weight: 700;
        margin: 0;
        color: #0f172a;
    }
    .courier-info p {
        font-size: 0.65rem;
        color: #475569;
        margin: 0;
    }
    .mode-icon-box {
        width: 40px;
        height: 40px;
        background: #f1f5f9;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #334155;
        margin: 0 auto;
        font-size: 0.7rem;
        font-weight: 500;
    }
    .mode-icon-box i { font-size: 1rem; margin-bottom: 2px; }
    .mode-icon-box span { font-size: 0.6rem; }
    .table-wrapper {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: white;
    }
    .rates-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.75rem;
    }
    .rates-table td {
        padding: 12px 8px;
        border-bottom: 1px solid #eef2ff;
        vertical-align: top;
    }
    .rates-table tr:hover { background: #faf9fe; }
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: white;
        border-bottom: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 12px;
    }
    .search-box { position: relative; min-width: 280px; }
    .search-box i {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); color: #94a3b8;
    }
    .search-box input {
        width: 100%; padding: 8px 12px 8px 36px;
        border: 1px solid #cbd5e1; border-radius: 40px;
        font-size: 0.8rem; outline: none; transition: all 0.2s;
    }
    .search-box input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
    }
    .top-actions .btn {
        background: #4c1d95; color: white; padding: 6px 16px;
        border-radius: 40px; font-size: 0.8rem; font-weight: 500;
        border: none; cursor: pointer;
    }
    .tabs-container {
        padding: 0 1.5rem;
        background: white;
        border-bottom: 1px solid #e2e8f0;
    }
    .tabs { display: flex; gap: 24px; }
    .tab {
        padding: 12px 0; font-size: 0.85rem; font-weight: 600;
        color: #64748b; cursor: pointer;
        border-bottom: 2px solid transparent; transition: all 0.2s;
    }
    .tab.active { color: #4f46e5; border-bottom-color: #4f46e5; }
    .filter-bar {
        padding: 1rem 1.5rem; background: white;
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #e2e8f0;
    }
    .plan-select {
        padding: 6px 12px; border: 1px solid #cbd5e1;
        border-radius: 8px; font-size: 0.8rem; background: white;
    }
    .filter-actions .btn-outline {
        border: 1px solid #cbd5e1; background: white;
        padding: 6px 16px; border-radius: 40px;
        font-size: 0.8rem; cursor: pointer;
    }
    .gst-note {
        padding: 10px 1.5rem; background: #fef9e3;
        border-bottom: 1px solid #fde68a;
        font-size: 0.7rem; color: #92400e;
        display: flex; align-items: center; gap: 8px;
    }
    .empty-state { text-align: center; padding: 3rem; color: #64748b; }
    .hidden { display: none !important; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                <i class="fas fa-list text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Rate Card</h1>
                <p class="text-sm text-slate-500">Manage shipping rates & pricing</p>
            </div>
        </div>
        <button type="button" onclick="openCreateModal()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Rate Card
        </button>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <span class="font-medium text-emerald-800">{{ session('success') }}</span>
        </div>
        <button onclick="this.closest('div').remove()" class="text-emerald-600 hover:text-emerald-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    {{-- Main Rate Card Container --}}
    <div class="rate-card-container">
        
        {{-- Top Bar with Search --}}
        <div class="top-bar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search AWB, Shipment ID, Order ID, Phone Number, Email" onkeyup="filterTable()">
            </div>
            <div class="top-actions">
                <button class="btn btn-primary" style="background: #4c1d95;">
                    <i class="fas fa-download"></i> Download Rates
                </button>
            </div>
        </div>

        {{-- Breadcrumb --}}
        <div style="padding: 0.75rem 1.5rem; border-bottom: 1px solid var(--border);">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-1">
                    <i class="fas fa-home"></i> Home
                </a>
                <i class="fas fa-chevron-right text-slate-400 text-xs"></i>
                <span class="font-medium text-slate-800">Rate Card</span>
            </nav>
        </div>

        {{-- Tabs --}}
        <div class="tabs-container">
            <div class="tabs">
                <div class="tab active" onclick="switchTab('MINI', this)">Mini Card</div>
                <div class="tab" onclick="switchTab('B2C', this)">B2C Card</div>
                <div class="tab" onclick="switchTab('B2B', this)">B2B Card</div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="filter-bar">
            <select class="plan-select" id="planFilter" onchange="filterTable()">
                <option value="">All Plans</option>
                <option value="Starter">Starter</option>
                <option value="Growth">Growth</option>
                <option value="Professional">Professional</option>
                <option value="Enterprise">Enterprise</option>
            </select>
            <div class="filter-actions">
                <button class="btn btn-outline"><i class="fas fa-calculator"></i> Calculate Rates</button>
            </div>
        </div>

        {{-- GST Note --}}
        <div class="gst-note">
            <i class="fas fa-info-circle"></i>
            <strong>Note:</strong> Rates are exclusive of GST; applicable GST charges will be added.
        </div>

        {{-- Table --}}
        <div class="table-wrapper">
            <table class="rates-table">
                <thead>
                    <tr>
                        <th style="text-align: left; padding-left: 1.5rem;">COURIERS</th>
                        <th style="width: 80px;">MODE</th>
                        @foreach(['A' => 'Within City', 'B' => 'Within State', 'C' => 'Metro to Metro', 'D' => 'Rest of India', 'E' => 'Special Zones'] as $key => $sub)
                            <th class="zone-header">ZONE {{ $key }}<span class="zone-sub">({{ $sub }})</span></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($rateCards as $userGroup)
                        @foreach($userGroup['cards'] as $rate)
                        @php 
                            // ✅ Use Eloquent model properties (not array)
                            $courier = $rate->courier;
                            $courierName = $courier ? $courier->name : ($rate->courier_name ?? 'N/A');
                            $modeText = $rate->mode ?? 'surface';
                            $modeIcon = match($modeText) {
                                'air' => 'fa-plane',
                                'express' => 'fa-bolt',
                                default => 'fa-truck'
                            };
                            $modeLabel = ucfirst($modeText);
                        @endphp
                        <tr class="rate-row" 
                            data-type="{{ strtoupper($rate->type ?? '') }}" 
                            data-plan="{{ $rate->plan_name ?? '' }}"
                            data-courier="{{ strtolower($courierName) }}">
                            
                            {{-- 1. Courier Column - Using Relationship --}}
                            <td style="padding-left: 1.5rem;">
                                <div class="courier-info">
                                    <div class="flex items-center gap-3">
                                        {{-- Logo Priority Logic --}}
                                        <div class="w-10 h-10 rounded border bg-white flex items-center justify-center overflow-hidden">
                                            @if($courier && $courier->logo_url)
                                                {{-- Priority 1: Courier table logo_url (API) --}}
                                                <img src="{{ $courier->logo_url }}" alt="{{ $courier->name }}" class="w-full h-full object-contain" onerror="this.src='{{ asset('images/default-courier.png') }}'">
                                            @elseif($courier && $courier->logo)
                                                {{-- Priority 2: Courier table logo (uploaded) --}}
                                                <img src="{{ asset('storage/' . $courier->logo) }}" alt="{{ $courier->name }}" class="w-full h-full object-contain">
                                            @elseif(!empty($rate->courier_logo_url))
                                                {{-- Priority 3: RateCard table legacy field --}}
                                                <img src="{{ $rate->courier_logo_url }}" alt="Logo" class="w-full h-full object-contain" onerror="this.src='{{ asset('images/default-courier.png') }}'">
                                            @elseif(!empty($rate->courier_logo))
                                                {{-- Priority 4: RateCard table legacy uploaded --}}
                                                <img src="{{ asset('storage/' . $rate->courier_logo) }}" alt="Logo" class="w-full h-full object-contain">
                                            @else
                                                {{-- Fallback --}}
                                                <img src="{{ asset('images/default-courier.png') }}" alt="Default" class="w-full h-full object-contain opacity-20">
                                            @endif
                                        </div>
                                        <div>
                                            {{-- Courier Name from relationship --}}
                                            <h4>{{ $courierName }}</h4>
                                            <p>(extra weight: {{ $rate->weight_info ?? '500' }})</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- 2. Mode (Icon + Text) --}}
                            <td>
                                <div class="mode-icon-box">
                                    <i class="fas {{ $modeIcon }}"></i>
                                    <span>{{ $modeLabel }}</span>
                                </div>
                            </td>

                            {{-- 3. Zones (A, B, C, D, E) --}}
                            @foreach(['a','b','c','d','e'] as $z)
                            <td>
                                <div class="rate-grid">
                                    <div class="rate-item">
                                        <span class="rate-value">₹{{ number_format($rate->{'zone_'.$z.'_forward'} ?? 0, 2) }}</span>
                                        <span class="rate-label">Forward</span>
                                    </div>
                                    <div class="rate-item">
                                        <span class="rate-value">₹{{ number_format($rate->{'zone_'.$z.'_rto'} ?? 0, 2) }}</span>
                                        <span class="rate-label">RTO</span>
                                    </div>
                                    <div class="rate-item">
                                        <span class="rate-value">₹{{ number_format($rate->{'zone_'.$z.'_add_forward'} ?? 0, 2) }}</span>
                                        <span class="rate-label">Add. Forward</span>
                                    </div>
                                    <div class="rate-item">
                                        <span class="rate-value">₹{{ number_format($rate->{'zone_'.$z.'_add_rto'} ?? 0, 2) }}</span>
                                        <span class="rate-label">Add. RTO</span>
                                    </div>
                                    <div class="rate-item">
                                        <span class="rate-value">₹{{ number_format($rate->{'zone_'.$z.'_cod_charge'} ?? 0, 2) }}</span>
                                        <span class="rate-label">COD Charges</span>
                                    </div>
                                    <div class="rate-item">
                                        <span class="rate-value">{{ number_format($rate->{'zone_'.$z.'_cod_percent'} ?? 0, 2) }}%</span>
                                        <span class="rate-label">COD %</span>
                                    </div>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-box-open fa-2x mb-3"></i>
                                    <h3 class="text-lg font-semibold text-slate-800 mb-2">No Rate Cards Found</h3>
                                    <p class="mb-4">Get started by creating your first shipping rate configuration.</p>
                                    <button type="button" onclick="openCreateModal()" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add Rate Card
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CREATE/EDIT MODAL --}}
<div id="createModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-6xl mx-4 max-h-[90vh] overflow-hidden">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-bold text-white" id="modalTitle">➕ Add New Rate Card</h3>
                <button type="button" onclick="closeCreateModal()" class="w-8 h-8 rounded-lg hover:bg-white/20 flex items-center justify-center text-white"><i class="fas fa-times"></i></button>
            </div>
            <form id="createRateForm" enctype="multipart/form-data" class="p-6 overflow-y-auto max-h-[65vh]">
                @csrf
                <input type="hidden" id="editRateId" name="id">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Select User <span class="text-red-500">*</span></label>
                        <select name="user_id" id="modalUserId" required class="w-full rounded-lg border-slate-300 p-2 text-sm">
                            <option value="">Choose User</option>
                            @foreach($users as $user)<option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Card Type <span class="text-red-500">*</span></label>
                        <select name="type" id="modalType" required class="w-full rounded-lg border-slate-300 p-2 text-sm">
                            <option value="MINI">📦 MINI</option>
                            <option value="B2C">🛒 B2C</option>
                            <option value="B2B">🏢 B2B</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Plan</label>
                        <select name="plan_name" class="w-full rounded-lg border-slate-300 p-2 text-sm">
                            <option value="Starter">Starter</option>
                            <option value="Growth">Growth</option>
                            <option value="Professional">Professional</option>
                            <option value="Enterprise">Enterprise</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="is_active" required class="w-full rounded-lg border-slate-300 p-2 text-sm">
                            <option value="1">✅ Active</option>
                            <option value="0">⏸️ Inactive</option>
                        </select>
                    </div>
                </div>

                {{-- ✅ Courier Selection with Eloquent models --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 p-4 bg-slate-50 rounded-xl">
                  <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Courier Name <span class="text-red-500">*</span></label>
                    <select name="courier_name" id="modalCourierName" required class="w-full rounded-lg border-slate-300 p-2 text-sm">
                        <option value="">-- Select Courier --</option>
                        
                        {{-- ✅ $couriers is Eloquent collection --}}
                        @foreach($couriers as $courier)
                            <option value="{{ $courier->name }}" 
                                    data-logo="{{ $courier->logo_url ?? '' }}" 
                                    data-id="{{ $courier->id }}">
                                {{ $courier->name }}
                            </option>
                        @endforeach

                        <option value="custom">Other (Manual Entry)</option>
                    </select>
                    <input type="text" id="manualCourierInput" class="w-full mt-2 rounded-lg border-slate-300 p-2 text-sm hidden" placeholder="Type Courier Name...">
                </div>

                    {{-- Hidden field to store logo URL --}}
                    <input type="hidden" name="courier_logo_url" id="courierLogoUrl" value="">
                    <input type="hidden" name="courier_id" id="modalCourierId" value="">

                    {{-- Logo Preview + Upload Section --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Courier Logo</label>
                        
                        {{-- Preview Container --}}
                        <div id="logoPreviewContainer" class="hidden mb-2">
                            <div class="relative inline-block">
                                <img id="logoPreview" src="" alt="Courier Logo" class="h-16 w-auto rounded-lg border border-slate-200 bg-white p-1 object-contain">
                                <button type="button" onclick="clearLogo()" class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600" title="Remove logo">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <p class="text-xs text-emerald-600 mt-1"><i class="fas fa-check-circle"></i> Logo auto-loaded</p>
                        </div>

                        {{-- File Upload Container --}}
                        <div id="logoUploadContainer">
                            <input type="file" name="courier_logo" id="modalCourierLogo" accept="image/*" class="w-full rounded-lg border-slate-300 text-sm p-2">
                            <p class="text-xs text-slate-500 mt-1">Or upload custom logo</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Weight</label>
                        <input type="text" name="weight_info" class="w-full rounded-lg border-slate-300 p-2 text-sm" placeholder="e.g., 20.000">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Weight Extra</label>
                        <input type="text" name="add_weight" class="w-full rounded-lg border-slate-300 p-2 text-sm" placeholder="e.g., 20.000">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Shipping Mode <span class="text-red-500">*</span></label>
                    <select name="mode" id="modalMode" required class="w-full rounded-lg border-slate-300 p-2 text-sm">
                        <option value="surface">🚛 Surface</option>
                        <option value="air">✈️ Air</option>
                        <option value="express">🚀 Express</option>
                    </select>
                </div>

                {{-- Zone-wise Rates --}}
                <div class="border-t border-slate-200 pt-4">
                    <h4 class="text-md font-semibold text-slate-800 mb-4">🗺️ Zone-wise Rates (₹)</h4>
                    @php $zoneLabels = ['zone_a'=>['name'=>'Zone A','desc'=>'Within City'],'zone_b'=>['name'=>'Zone B','desc'=>'Within State'],'zone_c'=>['name'=>'Zone C','desc'=>'Metro to Metro'],'zone_d'=>['name'=>'Zone D','desc'=>'Rest of India'],'zone_e'=>['name'=>'Zone E','desc'=>'Special Zones']]; @endphp
                    <div class="space-y-3">
                        @foreach($zoneLabels as $zoneKey => $zoneInfo)
                        <div class="bg-slate-50 rounded-lg p-3 border border-slate-200">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-6 h-6 rounded bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-700">{{ strtoupper(substr($zoneKey, -1)) }}</span>
                                <span class="text-sm font-medium text-slate-800">{{ $zoneInfo['name'] }}</span>
                                <span class="text-xs text-slate-500">({{ $zoneInfo['desc'] }})</span>
                            </div>
                            <div class="grid grid-cols-3 md:grid-cols-6 gap-2">
                                <div><label class="text-xs text-slate-500 block mb-1">Forward</label><input type="number" step="0.01" min="0" name="{{ $zoneKey }}_forward" class="w-full rounded border-slate-300 text-xs p-1.5" value="0"></div>
                                <div><label class="text-xs text-slate-500 block mb-1">RTO</label><input type="number" step="0.01" min="0" name="{{ $zoneKey }}_rto" class="w-full rounded border-slate-300 text-xs p-1.5" value="0"></div>
                                <div><label class="text-xs text-slate-500 block mb-1">Add. Forward</label><input type="number" step="0.01" min="0" name="{{ $zoneKey }}_add_forward" class="w-full rounded border-slate-300 text-xs p-1.5" value="0"></div>
                                <div><label class="text-xs text-slate-500 block mb-1">Add. RTO</label><input type="number" step="0.01" min="0" name="{{ $zoneKey }}_add_rto" class="w-full rounded border-slate-300 text-xs p-1.5" value="0"></div>
                                <div><label class="text-xs text-slate-500 block mb-1">COD ₹</label><input type="number" step="0.01" min="0" name="{{ $zoneKey }}_cod_charge" class="w-full rounded border-slate-300 text-xs p-1.5" value="0"></div>
                                <div><label class="text-xs text-slate-500 block mb-1">COD %</label><input type="number" step="0.01" min="0" max="100" name="{{ $zoneKey }}_cod_percent" class="w-full rounded border-slate-300 text-xs p-1.5" value="0"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </form>
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-100 text-sm">Cancel</button>
                <button type="button" onclick="saveRateCard()" id="saveRateBtn" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i><span id="saveBtnText">Save Rate Card</span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Global currentTab variable
window.currentTab = 'MINI';

/**
 * 1. Open Create/Edit Modal
 */
window.openCreateModal = function(editData = null) {
    const form = document.getElementById('createRateForm');
    if (form) form.reset();

    const modalTitle = document.getElementById('modalTitle');
    const saveBtnText = document.getElementById('saveBtnText');
    const editRateId = document.getElementById('editRateId');
    const modal = document.getElementById('createModal');
    const previewContainer = document.getElementById('logoPreviewContainer');
    const uploadContainer = document.getElementById('logoUploadContainer');

    if (!editData) {
        modalTitle.textContent = '➕ Add New Rate Card';
        saveBtnText.textContent = 'Save Rate Card';
        if (editRateId) editRateId.value = '';
        if (previewContainer) previewContainer.classList.add('hidden');
        if (uploadContainer) uploadContainer.classList.remove('hidden');
    } else {
        modalTitle.textContent = '✏️ Edit Rate Card';
        saveBtnText.textContent = 'Update Rate Card';
    }

    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
};

/**
 * 2. Close Modal
 */
window.closeCreateModal = function() {
    const modal = document.getElementById('createModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
};

/**
 * 3. Save Rate Card
 */
window.saveRateCard = function() {
    const form = document.getElementById('createRateForm');
    const saveBtn = document.getElementById('saveRateBtn');
    const saveBtnText = document.getElementById('saveBtnText');
    const id = document.getElementById('editRateId').value;

    const formData = new FormData(form);
    let url = id ? `/admin/rate-cards/${id}/update` : `/admin/rate-cards/store`;

    if (saveBtn) saveBtn.disabled = true;
    if (saveBtnText) saveBtnText.textContent = 'Saving...';

    fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Validation failed');
                if (saveBtn) saveBtn.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            if (saveBtn) saveBtn.disabled = false;
        });
};

/**
 * 4. Tab Switching
 */
window.switchTab = function(tabName, el) {
    window.currentTab = tabName.toUpperCase();
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    if (el) el.classList.add('active');
    window.filterTable();
};

/**
 * 5. Table Filtering
 */
window.filterTable = function() {
    const searchInput = document.getElementById('searchInput');
    const planFilter = document.getElementById('planFilter');
    
    const search = searchInput ? searchInput.value.toLowerCase() : '';
    const plan = planFilter ? planFilter.value : '';

    document.querySelectorAll('#tableBody tr.rate-row').forEach(row => {
        const rowType = row.dataset.type;
        const rowPlan = row.dataset.plan;
        const rowCourier = row.dataset.courier;

        const matchesTab = rowType === window.currentTab;
        const matchesPlan = !plan || rowPlan === plan;
        const matchesSearch = !search || rowCourier.includes(search);

        row.classList.toggle('hidden', !(matchesTab && matchesPlan && matchesSearch));
    });
};

/**
 * 6. DOM Ready Event Listeners
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initial Filter
    if(typeof window.filterTable === 'function') window.filterTable();

    // Courier Select Auto-Logo Capture + Auto-Mode Detection
    const courierSelect = document.getElementById('modalCourierName');
    
    if (courierSelect) {
        courierSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (!selected) return;

            const logoUrl = selected.getAttribute('data-logo');
            const courierId = selected.getAttribute('data-id');
            const name = this.value;
            const nameLower = name.toLowerCase();

            // Elements references
            const previewImg = document.getElementById('logoPreview');
            const previewContainer = document.getElementById('logoPreviewContainer');
            const uploadContainer = document.getElementById('logoUploadContainer');
            const hiddenUrlInput = document.getElementById('courierLogoUrl');
            const hiddenIdInput = document.getElementById('modalCourierId'); 
            const modeSelect = document.getElementById('modalMode');
            const manualInput = document.getElementById('manualCourierInput');

            if (name === 'custom' || !name) {
                // Reset state
                if (previewContainer) previewContainer.classList.add('hidden');
                if (uploadContainer) uploadContainer.classList.remove('hidden');
                if (hiddenUrlInput) hiddenUrlInput.value = '';
                if (hiddenIdInput) hiddenIdInput.value = '';
                
                // Custom Name box handling
                if (name === 'custom' && manualInput) {
                    manualInput.classList.remove('hidden');
                    manualInput.focus();
                } else if (manualInput) {
                    manualInput.classList.add('hidden');
                }
            } else {
                // 1. UI update
                if (manualInput) manualInput.classList.add('hidden');

                // 2. Logo Handling
                if (previewImg) {
                    previewImg.src = logoUrl || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random&color=fff`;
                    previewImg.onerror = function() {
                        this.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}`;
                    };
                }
                
                if (previewContainer) previewContainer.classList.remove('hidden');
                if (uploadContainer) uploadContainer.classList.add('hidden');
                
                // 3. Hidden Fields Fill
                if (hiddenUrlInput) hiddenUrlInput.value = logoUrl || '';
                if (hiddenIdInput) hiddenIdInput.value = courierId || '';

                // 4. ✅ Auto-Detection of Mode (Surface/Air/Express)
                if (modeSelect) {
                    if (nameLower.includes('air') || nameLower.includes('prime') || nameLower.includes('flight')) {
                        modeSelect.value = 'air';
                    } else if (nameLower.includes('surface') || nameLower.includes('ground') || nameLower.includes('road') || nameLower.includes('ecom')) {
                        modeSelect.value = 'surface';
                    } else if (nameLower.includes('express') || nameLower.includes('bolt') || nameLower.includes('fast') || nameLower.includes('ndd')) {
                        modeSelect.value = 'express';
                    }
                    
                    // Highlight animation for feedback
                    modeSelect.classList.add('ring-2', 'ring-indigo-500', 'transition-all');
                    setTimeout(() => modeSelect.classList.remove('ring-2', 'ring-indigo-500'), 1000);
                }
            }
        });
    }
});
</script>
@endpush