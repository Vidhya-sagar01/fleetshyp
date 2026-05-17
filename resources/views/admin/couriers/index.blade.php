@extends('admin.layouts.app')

@section('title', 'Courier Management')

@push('styles')
<style>
    .courier-table thead th {
        padding: 0.75rem 1rem;
        font-size: 0.7rem;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
    }
    .courier-table td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .courier-table tr:hover { background: #faf9fe; }
    .courier-logo {
        width: 48px; height: 48px; border-radius: 10px;
        object-fit: contain; background: #f8fafc;
        border: 1px solid #e2e8f0; padding: 4px;
    }
    .rating-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 0.7rem; font-weight: 600;
    }
    .rating-high { background: #dcfce7; color: #166534; }
    .rating-medium { background: #fef9c3; color: #854d0e; }
    .rating-low { background: #fee2e2; color: #991b1b; }
    .status-badge {
        padding: 4px 12px; border-radius: 20px;
        font-size: 0.7rem; font-weight: 600;
    }
    .status-active { background: #dcfce7; color: #166534; }
    .status-inactive { background: #f1f5f9; color: #64748b; }
    .action-btn {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.2s; border: none; cursor: pointer;
    }
    .action-btn.edit { background: #dbeafe; color: #1d4ed8; }
    .action-btn.edit:hover { background: #bfdbfe; }
    .action-btn.delete { background: #fee2e2; color: #dc2626; }
    .action-btn.delete:hover { background: #fecaca; }
    .top-bar {
        display: flex; justify-content: space-between; align-items: center;
        padding: 1rem 1.5rem; background: white;
        border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 12px;
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
    .btn-primary {
        background: #4c1d95; color: white; padding: 8px 20px;
        border-radius: 40px; font-size: 0.8rem; font-weight: 500;
        border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
        transition: all 0.2s;
    }
    .btn-primary:hover { background: #5b21b6; transform: translateY(-1px); }
    .btn-secondary {
        padding: 0.5rem 1.25rem; border: 1px solid #cbd5e1;
        background: white; color: #334155; border-radius: 8px;
        font-size: 0.8rem; cursor: pointer; transition: all 0.2s;
    }
    .btn-secondary:hover { background: #f1f5f9; }
    .table-wrapper {
        overflow-x: auto; border-radius: 12px;
        border: 1px solid #e2e8f0; background: white;
    }
    .empty-state { text-align: center; padding: 4rem 2rem; color: #64748b; }
    .empty-state i { font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem; }
    .modal { display: none; position: fixed; inset: 0; z-index: 100; }
    .modal.active { display: block; }
    .modal-backdrop {
        position: absolute; inset: 0;
        background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
    }
    .modal-content {
        position: absolute; top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 95%; max-width: 600px; max-height: 90vh;
        background: white; border-radius: 16px;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        overflow: hidden;
    }
    .modal-header {
        padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0;
        display: flex; justify-content: space-between; align-items: center;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
    }
    .modal-header h3 { color: white; font-size: 1.1rem; font-weight: 600; }
    .modal-close {
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: white; background: rgba(255,255,255,0.2);
        border: none; cursor: pointer; transition: all 0.2s;
    }
    .modal-close:hover { background: rgba(255,255,255,0.3); }
    .modal-body {
        padding: 1.5rem; overflow-y: auto;
        max-height: calc(90vh - 140px);
    }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label {
        display: block; font-size: 0.8rem; font-weight: 500;
        color: #334155; margin-bottom: 0.4rem;
    }
    .form-group label .required { color: #ef4444; margin-left: 2px; }
    .form-control {
        width: 100%; padding: 0.5rem 0.75rem;
        border: 1px solid #cbd5e1; border-radius: 8px;
        font-size: 0.85rem; transition: all 0.2s;
    }
    .form-control:focus {
        outline: none; border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .logo-preview {
        width: 80px; height: 80px; border-radius: 12px;
        border: 2px dashed #cbd5e1; display: flex;
        align-items: center; justify-content: center;
        background: #f8fafc; margin-bottom: 0.5rem; overflow: hidden;
    }
    .logo-preview img {
        width: 100%; height: 100%; object-fit: contain; padding: 8px;
    }
    .logo-preview.empty {
        color: #94a3b8; font-size: 0.7rem;
        flex-direction: column; gap: 4px;
    }
    .rating-inputs { display: grid; grid-template-columns: repeat(5, 1fr); gap: 0.5rem; }
    .rating-input { text-align: center; }
    .rating-input input { width: 100%; text-align: center; }
    .rating-input label { font-size: 0.65rem; color: #64748b; margin-top: 0.2rem; }
    .modal-footer {
        padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;
        background: #f8fafc; display: flex; justify-content: flex-end; gap: 0.75rem;
    }
    .btn-save {
        padding: 0.5rem 1.25rem; background: #4c1d95; color: white;
        border: none; border-radius: 8px; font-size: 0.8rem;
        font-weight: 500; cursor: pointer; transition: all 0.2s;
    }
    .btn-save:hover { background: #5b21b6; }
    .pagination {
        display: flex; justify-content: center; align-items: center;
        gap: 4px; padding: 1rem; background: white;
        border-top: 1px solid #e2e8f0;
    }
    .pagination a, .pagination span {
        padding: 6px 12px; border-radius: 6px; font-size: 0.8rem;
        color: #64748b; text-decoration: none; transition: all 0.2s;
    }
    .pagination a:hover { background: #f1f5f9; color: #4c1d95; }
    .pagination .active { background: #4c1d95; color: white; font-weight: 500; }
    .pagination .disabled { opacity: 0.5; cursor: not-allowed; }
    .hidden { display: none !important; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                <i class="fas fa-truck text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Courier Management</h1>
                <p class="text-sm text-slate-500">Manage courier partners & settings</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            {{-- ✅ Safe route check - works with your existing routes --}}
            @if(Route::has('couriers.sync') || Route::has('sync'))
                <a href="{{ Route::has('couriers.sync') ? route('couriers.sync') : route('sync') }}" class="btn-secondary" title="Sync from API">
                    <i class="fas fa-sync-alt"></i> Sync API
                </a>
            @endif
            <button type="button" onclick="openModal()" class="btn-primary">
                <i class="fas fa-plus"></i> Add Courier
            </button>
        </div>
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

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            <span class="font-medium text-red-800">{{ session('error') }}</span>
        </div>
        <button onclick="this.closest('div').remove()" class="text-red-600 hover:text-red-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
        <div class="flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
            <div>
                <p class="font-medium text-red-800">Please fix the following errors:</p>
                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Main Container --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        {{-- Top Bar with Search --}}
        <div class="top-bar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search couriers..." onkeyup="filterTable()">
            </div>
            <div class="flex items-center gap-2">
                <button class="btn-secondary" onclick="exportCouriers()">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-wrapper">
            <table class="courier-table w-full">
                <thead>
                    <tr>
                        <th style="text-align: left; padding-left: 1.5rem;">Courier</th>
                        <th>Fship Courier ID</th> {{-- ✅ Fixed typo: "corrirar" → "Courier" --}}
                        <th>Ratings</th>
                        <th>Pickup / Delivery</th>
                        <th>Status</th>
                        <th style="text-align: right; padding-right: 1.5rem;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($couriers as $courier)
                    <tr class="courier-row" data-name="{{ strtolower($courier->name) }}">
                        {{-- Courier Info Column --}}
                        <td style="padding-left: 1.5rem;">
                            <div class="flex items-center gap-3">
                                @if($courier->logo)
                                    <img src="{{ asset('storage/' . $courier->logo) }}" alt="{{ $courier->name }}" class="courier-logo">
                                @elseif($courier->logo_url)
                                    <img src="{{ $courier->logo_url }}" alt="{{ $courier->name }}" class="courier-logo" onerror="this.parentElement.innerHTML='<div class=\'courier-logo flex items-center justify-center text-slate-400\'><i class=\'fas fa-truck\'></i></div>'">
                                @else
                                    <div class="courier-logo flex items-center justify-center text-slate-400">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $courier->name }}</div>
                                    @if($courier->logo_url && !$courier->logo)
                                        <div class="text-xs text-slate-500 truncate max-w-[150px]">{{ Str::limit($courier->logo_url, 30) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- ✅ Fship Courier ID Column (Alag <td>) --}}
                        <td>
                            @if($courier->fship_courier_id)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    <i class="fas fa-hashtag mr-1"></i>{{ $courier->fship_courier_id }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400 italic">Not mapped</span>
                            @endif
                        </td>

                        {{-- Ratings --}}
                        <td>
                            @php
                                $ratings = collect([
                                    $courier->rating_pickup,
                                    $courier->rating_delivery, 
                                    $courier->rating_ndr,
                                    $courier->rating_weight,
                                    $courier->rating_tat
                                ])->filter(fn($v) => $v !== null && $v > 0);
                                $avgRating = $ratings->isNotEmpty() ? $ratings->avg() : 0;
                                $ratingClass = $avgRating >= 4 ? 'rating-high' : ($avgRating >= 3 ? 'rating-medium' : 'rating-low');
                            @endphp
                            <span class="rating-badge {{ $ratingClass }}">
                                <i class="fas fa-star"></i>
                                {{ $avgRating > 0 ? number_format($avgRating, 1) : 'N/A' }}/5
                            </span>
                        </td>

                        {{-- Pickup/Delivery --}}
                        <td>
                            <div class="text-sm text-slate-700">
                                @if($courier->expected_pickup)
                                    <div><i class="fas fa-clock text-slate-400 mr-1"></i>{{ $courier->expected_pickup }}</div>
                                @endif
                                @if($courier->estimated_delivery)
                                    <div class="text-slate-500"><i class="fas fa-truck text-slate-300 mr-1"></i>{{ $courier->estimated_delivery }}</div>
                                @endif
                            </div>
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="status-badge {{ $courier->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $courier->is_active ? '✅ Active' : '⏸️ Inactive' }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td style="text-align: right; padding-right: 1.5rem;">
                            <div class="flex items-center justify-end gap-2">
                                <button class="action-btn edit" onclick="editCourier({{ $courier->id }})" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="action-btn delete" onclick="deleteCourier({{ $courier->id }}, '{{ addslashes($courier->name) }}')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    {{-- ✅ Empty state: colspan 6 (6 columns ab) --}}
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-truck"></i>
                                <h3 class="text-lg font-semibold text-slate-800 mb-2">No Couriers Found</h3>
                                <p class="mb-4">Get started by adding your first courier partner.</p>
                                <div class="flex items-center justify-center gap-2">
                                    @if(Route::has('couriers.sync') || Route::has('sync'))
                                        <a href="{{ Route::has('couriers.sync') ? route('couriers.sync') : route('sync') }}" class="btn-secondary">
                                            <i class="fas fa-sync-alt"></i> Sync from API
                                        </a>
                                    @endif
                                    <button type="button" onclick="openModal()" class="btn-primary">
                                        <i class="fas fa-plus"></i> Add Courier
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($couriers->hasPages())
        <div class="pagination">
            @if($couriers->onFirstPage())
                <span class="disabled"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $couriers->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
            @endif

            @foreach($couriers->getUrlRange(1, $couriers->lastPage()) as $page => $url)
                @if($page == $couriers->currentPage())
                    <span class="active">{{ $page }}</span>
                @elseif($page >= $couriers->currentPage() - 2 && $page <= $couriers->currentPage() + 2)
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($couriers->hasMorePages())
                <a href="{{ $couriers->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
            @else
                <span class="disabled"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
        @endif
    </div>
</div>

{{-- CREATE/EDIT MODAL --}}
<div id="courierModal" class="modal">
    <div class="modal-backdrop" onclick="closeModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">➕ Add New Courier</h3>
            <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        
        <form id="courierForm" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="hidden" id="courierId" name="id">
            
            <div class="modal-body">
                {{-- Courier Name & Logo --}}
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Select Courier Partner <span class="required">*</span></label>
                        <select name="name" id="courierName" class="form-control" required onchange="handleCourierSelect(this)">
                            <option value="">-- Choose Courier --</option>
                            @isset($apiCouriers)
                                @foreach($apiCouriers as $api)
                                    {{-- ✅ Added data-fship-id attribute --}}
                                    <option value="{{ $api['courierName'] ?? $api['name'] ?? '' }}" 
                                            data-logo="{{ $api['logoUrl'] ?? $api['logo'] ?? '' }}"
                                            data-fship-id="{{ $api['courierId'] ?? '' }}">
                                        {{ $api['courierName'] ?? $api['name'] ?? 'Unknown' }}
                                        @if(isset($api['courierId'])) (ID: {{ $api['courierId'] }}) @endif
                                    </option>
                                @endforeach
                            @endisset
                            <option value="custom">Other (Manual Entry)</option>
                        </select>
                        <input type="text" id="manualCourierName" class="form-control mt-2 hidden" placeholder="Type Courier Name manually...">
                    </div>

                     <div class="form-group">
                        <label>Fship Courier ID</label>
                        <input type="number" name="fship_courier_id" id="fshipCourierId" class="form-control" placeholder="e.g., 59, 64, 88" min="1">
                        <p class="text-xs text-slate-500 mt-1">*Fship API se mila actual courier ID</p>
                    </div>
                    
                    <div class="form-group">
                        <label>Courier Logo</label>
                        <div id="logoPreview" class="logo-preview empty">
                            <i class="fas fa-image fa-2x"></i>
                            <span>No logo</span>
                        </div>
                        <input type="file" name="logo" id="courierLogo" class="form-control" accept="image/*" onchange="previewLogo(this)">
                        <input type="hidden" name="logo_url" id="logoUrl">
                    </div>

                    <div class="form-group">
                        <label>Logo URL (Optional)</label>
                        <input type="url" name="logo_url_input" class="form-control" placeholder="https://..." onchange="loadLogoFromUrl(this.value)">
                        <p class="text-xs text-slate-500 mt-1">Or paste logo URL</p>
                    </div>
                </div>

                {{-- Ratings --}}
                <div class="form-group">
                    <label>Performance Ratings (1-5)</label>
                    <div class="rating-inputs">
                        <div class="rating-input">
                            <input type="number" name="rating_pickup" class="form-control" min="0" max="5" step="0.1" placeholder="0">
                            <label>Pickup</label>
                        </div>
                        <div class="rating-input">
                            <input type="number" name="rating_delivery" class="form-control" min="0" max="5" step="0.1" placeholder="0">
                            <label>Delivery</label>
                        </div>
                        <div class="rating-input">
                            <input type="number" name="rating_ndr" class="form-control" min="0" max="5" step="0.1" placeholder="0">
                            <label>NDR</label>
                        </div>
                        <div class="rating-input">
                            <input type="number" name="rating_weight" class="form-control" min="0" max="5" step="0.1" placeholder="0">
                            <label>Weight</label>
                        </div>
                        <div class="rating-input">
                            <input type="number" name="rating_tat" class="form-control" min="0" max="5" step="0.1" placeholder="0">
                            <label>TAT</label>
                        </div>
                    </div>
                </div>

                {{-- Timing Info --}}
                <div class="form-grid">
                    <div class="form-group">
                        <label>Expected Pickup</label>
                        <input type="text" name="expected_pickup" class="form-control" placeholder="e.g., Same Day, Next Day">
                    </div>
                    <div class="form-group">
                        <label>Estimated Delivery</label>
                        <input type="text" name="estimated_delivery" class="form-control" placeholder="e.g., 2-3 Days">
                    </div>
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label>Status <span class="required">*</span></label>
                    <select name="is_active" class="form-control" required>
                        <option value="1">✅ Active</option>
                        <option value="0">⏸️ Inactive</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-save" id="saveBtn">
                    <i class="fas fa-save mr-1"></i> <span id="saveBtnText">Save Courier</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
let isEditing = false;

function openModal(courier = null) {
    const modal = document.getElementById('courierModal');
    const form = document.getElementById('courierForm');
    const fshipIdInput = document.getElementById('fshipCourierId');
    const title = document.getElementById('modalTitle');
    const saveBtnText = document.getElementById('saveBtnText');
    const logoUrlVisibleInput = document.querySelector('input[name="logo_url_input"]');
    
    form.reset();
    document.getElementById('courierId').value = '';
    document.getElementById('logoPreview').className = 'logo-preview empty';
    document.getElementById('logoPreview').innerHTML = '<i class="fas fa-image fa-2x"></i><span>No logo</span>';
    document.getElementById('logoUrl').value = '';
    if(logoUrlVisibleInput) logoUrlVisibleInput.value = '';
    
    if (courier) {
        isEditing = true;
        title.textContent = '✏️ Edit Courier';
        saveBtnText.textContent = 'Update Courier';
        document.getElementById('courierId').value = courier.id;
        document.getElementById('courierName').value = courier.name;

        // ✅ LOGO LOADING LOGIC
        if (courier.logo) {
            showLogoPreview('{{ asset("storage") }}/' + courier.logo);
        } else if (courier.logo_url) {
            showLogoPreview(courier.logo_url);
            document.getElementById('logoUrl').value = courier.logo_url;
            if(logoUrlVisibleInput) logoUrlVisibleInput.value = courier.logo_url;
        }
        // ✅ Fship ID set karein
        if (fshipIdInput && courier.fship_courier_id) {
            fshipIdInput.value = courier.fship_courier_id;
        }
        
        // Set ratings
        ['pickup', 'delivery', 'ndr', 'weight', 'tat'].forEach(field => {
            const val = courier['rating_' + field];
            if (val !== null && val !== undefined) {
                document.querySelector(`[name="rating_${field}"]`).value = val;
            }
        });
        
        document.querySelector('[name="expected_pickup"]').value = courier.expected_pickup || '';
        document.querySelector('[name="estimated_delivery"]').value = courier.estimated_delivery || '';
        document.querySelector('[name="is_active"]').value = courier.is_active ? '1' : '0';
    } else {
        isEditing = false;
        title.textContent = '➕ Add New Courier';
        saveBtnText.textContent = 'Save Courier';
    }
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('courierName')?.focus(), 100);
}

function closeModal() {
    const modal = document.getElementById('courierModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
    isEditing = false;
}

function showLogoPreview(src) {
    if (!src) return;
    const preview = document.getElementById('logoPreview');
    preview.className = 'logo-preview';
    preview.innerHTML = `<img src="${src}" alt="Logo" onerror="this.parentElement.className='logo-preview empty';this.parentElement.innerHTML='<i class=\\'fas fa-image fa-2x\\'></i><span>Load failed</span>'">`;
}

function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) { showLogoPreview(e.target.result); };
        reader.readAsDataURL(input.files[0]);
    }
}

function loadLogoFromUrl(url) {
    if (url && url.trim() !== '') {
        document.getElementById('logoUrl').value = url;
        showLogoPreview(url);
    }
}

// ✅ Handle courier dropdown selection with auto logo & fship_id fill
function handleCourierSelect(select) {
    const selectedOption = select.options[select.selectedIndex];
    const logoUrlFromApi = selectedOption.getAttribute('data-logo');
    const fshipIdFromApi = selectedOption.getAttribute('data-fship-id'); 
    const manualInput = document.getElementById('manualCourierName');
    const logoUrlHidden = document.getElementById('logoUrl');
    const logoUrlVisibleInput = document.querySelector('input[name="logo_url_input"]');
    const fshipIdInput = document.getElementById('fshipCourierId');

    if (select.value === 'custom') {
        manualInput.classList.remove('hidden');
        manualInput.focus();
        logoUrlHidden.value = '';
        if(logoUrlVisibleInput) logoUrlVisibleInput.value = '';
        if(fshipIdInput) fshipIdInput.value = '';
        const preview = document.getElementById('logoPreview');
        preview.className = 'logo-preview empty';
        preview.innerHTML = '<i class="fas fa-image fa-2x"></i><span>No logo</span>';
    } else {
        manualInput.classList.add('hidden');
        
        if (logoUrlFromApi && logoUrlFromApi !== 'null' && logoUrlFromApi.trim() !== '') {
            showLogoPreview(logoUrlFromApi);
            logoUrlHidden.value = logoUrlFromApi;
            if(logoUrlVisibleInput) logoUrlVisibleInput.value = logoUrlFromApi;
        }

        // ✅ Fship ID auto-fill
        if (fshipIdFromApi && fshipIdFromApi !== 'null' && fshipIdFromApi.trim() !== '') {
            if(fshipIdInput) fshipIdInput.value = fshipIdFromApi;
        }
    }
}

document.getElementById('courierForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = this;
    const saveBtn = document.getElementById('saveBtn');
    const saveBtnText = document.getElementById('saveBtnText');
    const id = document.getElementById('courierId').value;
    
    saveBtn.disabled = true;
    saveBtnText.textContent = 'Saving...';
    
    const formData = new FormData(form);
    const url = id ? `/admin/couriers/${id}` : '/admin/couriers';
    const method = 'POST';
    
    if (id) formData.append('_method', 'PUT');
    
    try {
        const response = await fetch(url, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            closeModal();
            showToast('Courier saved successfully!', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            const error = await response.json().catch(() => ({}));
            alert('Error: ' + (error.message || 'Something went wrong'));
        }
    } catch (err) {
        console.error(err);
        alert('Network error. Please try again.');
    } finally {
        saveBtn.disabled = false;
        saveBtnText.textContent = isEditing ? 'Update Courier' : 'Save Courier';
    }
});

function editCourier(id) {
    fetch(`/admin/couriers/${id}/edit`)
        .then(res => res.json())
        .then(data => {
            if (data.success) openModal(data.data);
            else alert('Error loading courier data');
        })
        .catch(err => { console.error(err); alert('Error loading courier data'); });
}

function deleteCourier(id, name) {
    if (!confirm(`Are you sure you want to delete "${name}"?`)) return;
    
    fetch(`/admin/couriers/${id}`, {
        method: 'DELETE', 
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json' 
        }
    })
    .then(async res => {
        if (res.ok) {
            window.location.reload();
        } else {
            const data = await res.json();
            alert('Error: ' + (data.message || 'Could not delete'));
        }
    })
    .catch(err => console.error('Error:', err));
}

function filterTable() {
    const search = document.getElementById('searchInput')?.value.toLowerCase() || '';
    document.querySelectorAll('#tableBody tr.courier-row').forEach(row => {
        const name = row.dataset.name || '';
        row.classList.toggle('hidden', search && !name.includes(search));
    });
}

function exportCouriers() { showToast('Export feature coming soon!', 'info'); }

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-4 py-3 rounded-lg shadow-lg text-white text-sm z-[200] transition-all transform ${
        type === 'success' ? 'bg-emerald-500' : type === 'error' ? 'bg-red-500' : 'bg-slate-700'
    }`;
    toast.innerHTML = `<div class="flex items-center gap-2"><i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>${message}</div>`;
    document.body.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; toast.style.transform = 'translateY(10px)'; setTimeout(() => toast.remove(), 300); }, 3000);
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
document.getElementById('courierModal')?.addEventListener('click', e => { if (e.target === this) closeModal(); });
document.addEventListener('DOMContentLoaded', () => { filterTable(); });
</script>
@endpush