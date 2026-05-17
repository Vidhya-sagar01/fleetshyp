@extends('seller.layouts.app')

@section('title', 'Manage Pickup Address')

@push('styles')
<style>
    :root {
        --rapid-gold: #D4AF37;
        --rapid-gold-dark: #B8941F;
        --error-red: #ef4444;
        --error-bg: #fef2f2;
        --success-green: #10b981;
    }

    .modal-backdrop {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }
    
    .form-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        line-height: 1.25rem;
        color: #374151;
        transition: all 0.2s;
        background-color: #ffffff;
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--rapid-gold);
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
    }
    
    .form-input:disabled {
        background-color: #f9fafb;
        color: #9ca3af;
        cursor: not-allowed;
    }
    
    .form-input::placeholder {
        color: #9ca3af;
        font-size: 0.875rem;
    }
    
    .form-input.error {
        border-color: var(--error-red) !important;
        background-color: var(--error-bg);
        animation: shake 0.3s ease-in-out;
    }
    
    .form-input.error:focus {
        box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
    }
    
    .form-input.success {
        border-color: var(--success-green);
        background-color: #f0fdf4;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }
    
    .error-message {
        display: none;
        color: var(--error-red);
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: 0.25rem;
        padding-left: 2px;
    }
    
    .error-message.show {
        display: block;
        animation: fadeIn 0.2s ease-in;
    }

    .input-wrapper {
        position: relative;
    }
    
    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .required::after {
        content: '*';
        color: var(--error-red);
        margin-left: 2px;
    }
    
    .btn-gold {
        background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    .btn-gold:hover {
        background: linear-gradient(135deg, #B8941F 0%, #9a7b1a 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.3);
    }
    
    .btn-purple {
        background-color: #3b0764;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    .btn-purple:hover {
        background-color: #4c1d95;
    }

    .modal-content {
        transition: all 0.3s ease-out;
        transform: scale(0.95);
        opacity: 0;
    }
    #addressModal:not(.hidden) .modal-content {
        transform: scale(1);
        opacity: 1;
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .section-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .space-y-1 > * + * {
        margin-top: 0.25rem;
    }
    .grid {
        gap: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .form-input.pl-12 {
        padding-left: 3rem; 
    }
    
    .validation-dot {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: none;
    }
    .validation-dot.error { background: var(--error-red); display: block; }
    .validation-dot.success { background: var(--success-green); display: block; }

    /* Submit button loading state */
    .btn-gold:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
</style>
@endpush

@section('content')

@if ($errors->any())
    <div class="max-w-7xl mx-auto px-6 mb-4">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center gap-2 text-red-700 font-medium mb-2">
                <i class="fas fa-exclamation-circle"></i>
                <span>Validation Errors</span>
            </div>
            <ul class="text-sm text-red-600 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="max-w-7xl mx-auto px-6 mb-4">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center gap-2 text-green-700 font-medium">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    </div>
@endif

<div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800" style="font-family: 'Inter', sans-serif;">Pickup Addresses</h1>
            <p class="text-gray-500 text-sm mt-1">Manage your shipping pickup locations</p>
        </div>
        <button id="openAddModalBtn" class="btn-gold flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Pickup Address
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="md:col-span-3">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="searchAddresses()" 
                       class="form-input pl-10" placeholder="Search by name, city or pincode...">
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between">
            <span class="text-sm text-gray-600 font-medium">Total Addresses</span>
            <span class="text-xl font-bold" style="color: var(--rapid-gold);">{{ count($warehouses) }}</span>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Location Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Address Details</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact POC</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="addressesTableBody">
                    @forelse($warehouses as $warehouse)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $warehouse->warehouse_name }}</div>
                            @if($warehouse->is_primary)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">PRIMARY</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">{{ $warehouse->address_line_1 }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $warehouse->city }}, {{ $warehouse->state }} - {{ $warehouse->pincode }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $warehouse->contact_person }}</div>
                            <div class="text-xs text-gray-500 mt-1"><i class="fas fa-phone mr-1"></i> {{ $warehouse->contact_number }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($warehouse->dropship_location)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">DROPSHIP</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">STANDARD</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button data-warehouse-id="{{ $warehouse->id }}" onclick="editAddress(this.dataset.warehouseId)" 
                                        title="Edit Address"
                                        class="text-gray-400 hover:text-yellow-600 transition-colors p-1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button data-warehouse-id="{{ $warehouse->id }}" onclick="setPrimary(this.dataset.warehouseId, this)" 
                                        title="{{ $warehouse->is_primary ? 'Primary Address' : 'Set as Primary' }}"
                                        class="{{ $warehouse->is_primary ? 'text-yellow-500' : 'text-gray-300 hover:text-yellow-500' }} transition-colors p-1">
                                    <i class="fas fa-star"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            No pickup addresses found. Add your first warehouse to start shipping.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Address Modal -->
<div id="addressModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 modal-backdrop transition-opacity" id="modalBackdrop"></div>
        
        <div class="relative bg-white rounded-lg shadow-xl w-[92vw] max-w-[1300px] overflow-hidden modal-content z-10">
            <!-- Modal Header -->
            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800" id="modal-title" style="font-family: 'Inter', sans-serif;">Add Pickup Address</h3>
                <button id="closeModalBtn" type="button" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            {{-- 
                FIX: Form action aur method dynamically set hote hain JS se.
                Add ke liye: action = warehouses.store, method = POST
                Edit ke liye: action = warehouses.update/{id}, method = POST + _method=PUT
            --}}
            <form id="addressForm" method="POST" action="{{ route('warehouses.store') }}" 
                  class="p-6 max-h-[88vh] overflow-y-auto" novalidate>
                @csrf
                {{-- FIX: _method field — edit ke waqt JS isko PUT set karta hai --}}
                <input type="hidden" name="_method" id="form_method" value="POST">
                <input type="hidden" id="warehouseId" name="warehouse_id">
                
                <!-- ===== PICKUP ADDRESS SECTION ===== -->
                <div class="mb-6">
                    <div class="section-title">Pickup Address Details</div>

                    <!-- Row 1: address_name, contact_name, contact_number, email -->
                    <div class="grid grid-cols-2 gap-3 mb-4 mt-4">

                        <!-- API Field: address_name | min:3 max:75 required -->
                        <div class="space-y-1">
                            <label class="form-label required">Address Name</label>
                            <div class="input-wrapper">
                                <input type="text" name="address_name" id="address_name" 
                                       class="form-input" placeholder="Ex. Home or Warehouse"
                                       autocomplete="off">
                                <span class="validation-dot"></span>
                            </div>
                            <span class="error-message" id="address_name_error"></span>
                        </div>
                        
                        <!-- API Field: contact_name | alpha only required -->
                        <div class="space-y-1">
                            <label class="form-label required">Contact Name</label>
                            <div class="input-wrapper">
                                <input type="text" name="contact_name" id="contact_name" 
                                       class="form-input" placeholder="Enter Contact Name"
                                       autocomplete="off">
                                <span class="validation-dot"></span>
                            </div>
                            <span class="error-message" id="contact_name_error"></span>
                        </div>
                        
                        <!-- API Field: contact_number | starts 6,7,8,9 | 10 digits required -->
                        <div class="space-y-1">
                            <label class="form-label required">Contact No.</label>
                            <div class="relative input-wrapper">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">+91</span>
                                <input type="tel" name="contact_number" id="contact_number"
                                       class="form-input pl-10" placeholder="9876543210" maxlength="10"
                                       autocomplete="off">
                                <span class="validation-dot"></span>
                            </div>
                            <span class="error-message" id="contact_number_error"></span>
                        </div>
                        
                        <!-- API Field: email | valid email (non-mandatory per API but good practice) -->
                        <div class="space-y-1">
                            <label class="form-label">Email</label>
                            <div class="input-wrapper">
                                <input type="email" name="email" id="email"
                                       class="form-input" placeholder="abc@gmail.com"
                                       autocomplete="off">
                                <span class="validation-dot"></span>
                            </div>
                            <span class="error-message" id="email_error"></span>
                        </div>
                    </div>

                    <!-- Row 2: address_line, address_line2 -->
                    <div class="grid grid-cols-2 mb-4">
                        <!-- API Field: address_line | min:3 max:100 required -->
                        <div class="space-y-1">
                            <label class="form-label required">Address Line 1</label>
                            <div class="input-wrapper">
                                <textarea name="address_line" id="address_line" rows="2"
                                          class="form-input" 
                                          placeholder="House/Floor No. Building Name or Street, Locality"></textarea>
                                <span class="validation-dot"></span>
                            </div>
                            <span class="error-message" id="address_line_error"></span>
                        </div>
                        
                        <!-- API Field: address_line2 | min:3 max:100 non-mandatory -->
                        <div class="space-y-1">
                            <label class="form-label">Address Line 2 <span class="text-gray-400 font-normal normal-case">(optional)</span></label>
                            <div class="input-wrapper">
                                <textarea name="address_line2" id="address_line2" rows="2"
                                          class="form-input"
                                          placeholder="House/Floor No. Building Name or Street, Locality"></textarea>
                                <span class="validation-dot"></span>
                            </div>
                            <span class="error-message" id="address_line2_error"></span>
                        </div>
                    </div>

                    <!-- Row 3: pincode, city, state, country -->
                    <div class="grid grid-cols-4 gap-4 mb-4">
                        <!-- API Field: pincode | 6 digit required -->
                        <div class="space-y-1">
                            <label class="form-label required">Pin Code</label>
                            <div class="input-wrapper">
                                <input type="text" name="pincode" id="pincode" 
                                       class="form-input" placeholder="Enter Pincode" maxlength="6"
                                       autocomplete="off">
                                <span class="validation-dot"></span>
                            </div>
                            <span class="error-message" id="pincode_error"></span>
                        </div>
                        
                        <!-- Auto-filled from pincode API -->
                        <div class="space-y-1">
                            <label class="form-label required">City</label>
                            <input type="text" name="city" id="city"
                                   class="form-input bg-gray-50" placeholder="Auto-filled" readonly>
                        </div>
                        
                        <!-- Auto-filled from pincode API -->
                        <div class="space-y-1">
                            <label class="form-label required">State</label>
                            <input type="text" name="state" id="state"
                                   class="form-input bg-gray-50" placeholder="Auto-filled" readonly>
                        </div>
                        
                        <!-- Auto-filled -->
                        <div class="space-y-1">
                            <label class="form-label required">Country</label>
                            <input type="text" name="country" id="country"
                                   class="form-input bg-gray-50" value="INDIA" readonly>
                        </div>
                    </div>

                    <!-- Row 4: warehousing_system, gstin, latitude, longitude -->
                    <div class="grid grid-cols-4 gap-4">
                        <div class="space-y-1">
                            <label class="form-label">Warehousing System</label>
                            <select name="warehousing_system" id="warehousing_system" class="form-input">
                                <option value="">Select Warehousing System</option>
                                <option value="own">Own Warehouse</option>
                                <option value="third_party">Third Party</option>
                            </select>
                        </div>
                        
                        <!-- API Field: gstin | valid GSTIN format non-mandatory -->
                        <div class="space-y-1">
                            <label class="form-label">GSTIN <span class="text-gray-400 font-normal normal-case">(optional)</span></label>
                            <div class="input-wrapper">
                                <input type="text" name="gstin" id="gstin"
                                       class="form-input" placeholder="24AAACO4716C1ZZ"
                                       autocomplete="off" maxlength="15">
                                <span class="validation-dot"></span>
                            </div>
                            <span class="error-message" id="gstin_error"></span>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="latitude"
                                   class="form-input" placeholder="e.g. 28.6139">
                        </div>
                        
                        <div class="space-y-1">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="longitude"
                                   class="form-input" placeholder="e.g. 77.2090">
                        </div>
                    </div>

                    <!-- API Field: dropship_location | boolean non-mandatory -->
                    <div class="mt-4">
                        <label class="flex items-center cursor-pointer gap-2">
                            <input type="checkbox" name="dropship_location" id="dropship_location" value="1"
                                   class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                            <span class="text-sm text-gray-700">Dropship Location</span>
                        </label>
                    </div>
                </div>

                <!-- ===== RTO ADDRESS SECTION ===== -->
                <div class="border-t border-gray-200 pt-6 mt-4 mb-4">
                    <!-- API Field: use_alt_rto_address | boolean mandatory -->
                    <div class="mb-4">
                        <label class="flex items-center cursor-pointer gap-2">
                            <input type="checkbox" name="use_alt_rto_address" id="use_alt_rto_address" value="1"
                                   onchange="toggleRTOSection()"
                                   class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                            <span class="text-sm font-medium text-gray-700">Use a different address as RTO address</span>
                        </label>
                    </div>

                    <div id="rtoAddressSection" class="hidden">
                        <!-- Mode 1: Select Existing RTO (API Field: rto_address) -->
                        <div id="rtoSelectMode">
                            <div class="mb-4">
                                <label class="form-label required">Select Existing Pickup Address as RTO</label>
                                <div class="flex gap-3 items-center">
                                    <!-- API Field: rto_address | existing warehouse id -->
                                    <select name="rto_address" id="rto_address" class="form-input flex-1">
                                        <option value="">-- Select pickup address --</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">
                                                {{ $warehouse->warehouse_name }} - {{ $warehouse->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-gray-400 text-sm whitespace-nowrap">or</span>
                                    <button type="button" onclick="switchToNewAddressMode()" class="btn-purple whitespace-nowrap">
                                        <i class="fas fa-plus mr-1"></i> Add New RTO Address
                                    </button>
                                </div>
                                <span class="error-message" id="rto_address_error"></span>
                            </div>
                        </div>

                        <!-- Mode 2: Create New RTO Address (API Field: create_rto_address object) -->
                        <div id="rtoNewAddressMode" class="hidden">
                            <div class="mb-4">
                                <label class="form-label">Or Select Existing Instead</label>
                                <div class="flex gap-3 items-center">
                                    <select id="rto_address_select" class="form-input flex-1" disabled>
                                        <option value="">-- Select pickup address --</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">
                                                {{ $warehouse->warehouse_name }} - {{ $warehouse->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-gray-400 text-sm whitespace-nowrap">or</span>
                                    <button type="button" onclick="switchToSelectMode()" class="btn-gold whitespace-nowrap">
                                        <i class="fas fa-check mr-1"></i> Use Existing Address
                                    </button>
                                </div>
                            </div>

                            <div class="section-title mt-6">New RTO Address Details</div>
                            
                            <!-- RTO Row 1: rto_address_name, rto_contact_name, rto_contact_number, rto_email -->
                            <div class="grid grid-cols-4 gap-4 mb-4">
                                <!-- API Field: create_rto_address.rto_address_name | min:1 required -->
                                <div class="space-y-1">
                                    <label class="form-label required">Address Name</label>
                                    <div class="input-wrapper">
                                        <input type="text" name="rto_address_name" id="rto_address_name"
                                               class="form-input" placeholder="Ex. Home or Warehouse"
                                               autocomplete="off">
                                        <span class="validation-dot"></span>
                                    </div>
                                    <span class="error-message" id="rto_address_name_error"></span>
                                </div>
                                
                                <!-- API Field: create_rto_address.rto_contact_name | alpha only required -->
                                <div class="space-y-1">
                                    <label class="form-label required">Contact Name</label>
                                    <div class="input-wrapper">
                                        <input type="text" name="rto_contact_name" id="rto_contact_name"
                                               class="form-input" placeholder="Enter Contact Name"
                                               autocomplete="off">
                                        <span class="validation-dot"></span>
                                    </div>
                                    <span class="error-message" id="rto_contact_name_error"></span>
                                </div>
                                
                                <!-- API Field: create_rto_address.rto_contact_number | starts 6,7,8,9 | 10 digits -->
                                <div class="space-y-1">
                                    <label class="form-label required">Contact No.</label>
                                    <div class="relative input-wrapper">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">+91</span>
                                        <input type="tel" name="rto_contact_number" id="rto_contact_number"
                                               class="form-input pl-10" placeholder="9876543210" maxlength="10"
                                               autocomplete="off">
                                        <span class="validation-dot"></span>
                                    </div>
                                    <span class="error-message" id="rto_contact_number_error"></span>
                                </div>
                                
                                <!-- API Field: create_rto_address.rto_email | non-mandatory -->
                                <div class="space-y-1">
                                    <label class="form-label">Email <span class="text-gray-400 font-normal normal-case">(optional)</span></label>
                                    <div class="input-wrapper">
                                        <input type="email" name="rto_email" id="rto_email"
                                               class="form-input" placeholder="abc@gmail.com"
                                               autocomplete="off">
                                        <span class="validation-dot"></span>
                                    </div>
                                    <span class="error-message" id="rto_email_error"></span>
                                </div>
                            </div>

                            <!-- RTO Row 2: rto_address_line, rto_address_line2 -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <!-- API Field: create_rto_address.rto_address_line | min:3 max:100 required -->
                                <div class="space-y-1">
                                    <label class="form-label required">Address Line 1</label>
                                    <div class="input-wrapper">
                                        <textarea name="rto_address_line" id="rto_address_line" rows="2"
                                                  class="form-input"
                                                  placeholder="House/Floor No. Building Name or Street, Locality"></textarea>
                                        <span class="validation-dot"></span>
                                    </div>
                                    <span class="error-message" id="rto_address_line_error"></span>
                                </div>
                                
                                <!-- API Field: create_rto_address.rto_address_line2 | min:3 max:100 non-mandatory -->
                                <div class="space-y-1">
                                    <label class="form-label">Address Line 2 <span class="text-gray-400 font-normal normal-case">(optional)</span></label>
                                    <div class="input-wrapper">
                                        <textarea name="rto_address_line2" id="rto_address_line2" rows="2"
                                                  class="form-input"
                                                  placeholder="House/Floor No. Building Name or Street, Locality"></textarea>
                                        <span class="validation-dot"></span>
                                    </div>
                                    <span class="error-message" id="rto_address_line2_error"></span>
                                </div>
                            </div>

                            <!-- RTO Row 3: rto_pincode, rto_city, rto_state, rto_country -->
                            <div class="grid grid-cols-4 gap-4 mb-4">
                                <!-- API Field: create_rto_address.rto_pincode | 6 digit required -->
                                <div class="space-y-1">
                                    <label class="form-label required">Pin Code</label>
                                    <div class="input-wrapper">
                                        <input type="text" name="rto_pincode" id="rto_pincode"
                                               class="form-input" placeholder="Enter Pincode" maxlength="6"
                                               autocomplete="off">
                                        <span class="validation-dot"></span>
                                    </div>
                                    <span class="error-message" id="rto_pincode_error"></span>
                                </div>
                                
                                <div class="space-y-1">
                                    <label class="form-label required">City</label>
                                    <input type="text" name="rto_city" id="rto_city"
                                           class="form-input bg-gray-50" placeholder="Auto-filled" readonly>
                                </div>
                                
                                <div class="space-y-1">
                                    <label class="form-label required">State</label>
                                    <input type="text" name="rto_state" id="rto_state"
                                           class="form-input bg-gray-50" placeholder="Auto-filled" readonly>
                                </div>
                                
                                <div class="space-y-1">
                                    <label class="form-label required">Country</label>
                                    <input type="text" name="rto_country" id="rto_country"
                                           class="form-input bg-gray-50" value="INDIA" readonly>
                                </div>
                            </div>

                            <!-- RTO Row 4: rto_gstin, rto_latitude, rto_longitude -->
                            <div class="grid grid-cols-4 gap-4">
                                <!-- API Field: create_rto_address.rto_gstin | valid GSTIN non-mandatory -->
                                <div class="space-y-1">
                                    <label class="form-label">GSTIN <span class="text-gray-400 font-normal normal-case">(optional)</span></label>
                                    <div class="input-wrapper">
                                        <input type="text" name="rto_gstin" id="rto_gstin"
                                               class="form-input" placeholder="24AAACO4716C1ZZ"
                                               autocomplete="off" maxlength="15">
                                        <span class="validation-dot"></span>
                                    </div>
                                    <span class="error-message" id="rto_gstin_error"></span>
                                </div>
                                
                                <div class="space-y-1">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" name="rto_latitude" id="rto_latitude"
                                           class="form-input" placeholder="e.g. 28.6139">
                                </div>
                                
                                <div class="space-y-1">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" name="rto_longitude" id="rto_longitude"
                                           class="form-input" placeholder="e.g. 77.2090">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RTO Note -->
                <div id="rtoNote" class="hidden mt-2 bg-yellow-50 border border-yellow-200 rounded-md p-3">
                    <p class="text-xs text-gray-700">
                        <span class="font-semibold">Note:</span> Ekart, Blue Dart, Velex &amp; Blitz currently do not support alternate addresses for RTO.
                    </p>
                </div>

                <!-- Footer Buttons -->
                <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancelBtn" 
                            class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="btn-gold">
                        <i class="fas fa-save mr-2"></i>
                        <span id="submitBtnText">Save Address</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ================================================================
// RAPIDSHYP API — VALIDATION RULES (Pickup Location API compliant)
// API Docs: address_name min:3 max:75, contact_name alpha,
//           contact_number starts 6/7/8/9 10 digits, pincode 6 digits,
//           address_line min:3 max:100, gstin valid format
// ================================================================
const validationRules = {
    // ===== PICKUP ADDRESS =====
    address_name:      { required: true,  minLength: 3, maxLength: 75,  pattern: null,                                              message: "Address name must be 3-75 characters" },
    contact_name:      { required: true,  minLength: 1, maxLength: 100, pattern: /^[A-Za-z\s]+$/,                                   message: "Only alphabets allowed" },
    contact_number:    { required: true,  minLength: 10,maxLength: 10,  pattern: /^[6-9]\d{9}$/,                                    message: "Must be 10 digits starting with 6, 7, 8 or 9" },
    email:             { required: false, minLength: 0, maxLength: 200, pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,                      message: "Enter valid email address" },
    address_line:      { required: true,  minLength: 3, maxLength: 100, pattern: null,                                              message: "Address must be 3-100 characters" },
    address_line2:     { required: false, minLength: 3, maxLength: 100, pattern: null,                                              message: "Address must be 3-100 characters if entered" },
    pincode:           { required: true,  minLength: 6, maxLength: 6,   pattern: /^\d{6}$/,                                         message: "Must be 6 digit valid pincode" },
    gstin:             { required: false, minLength: 15,maxLength: 15,  pattern: /^[0-9]{2}[A-Z]{5}[A-Z0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/, message: "Enter valid GSTIN (e.g. 24AAACO4716C1ZZ)" },

    // ===== RTO ADDRESS (create_rto_address object) =====
    rto_address_name:   { required: true,  minLength: 3, maxLength: 75,  pattern: null,                                              message: "Address name must be 3-75 characters" },
    rto_contact_name:   { required: true,  minLength: 1, maxLength: 100, pattern: /^[A-Za-z\s]+$/,                                   message: "Only alphabets allowed" },
    rto_contact_number: { required: true,  minLength: 10,maxLength: 10,  pattern: /^[6-9]\d{9}$/,                                    message: "Must be 10 digits starting with 6, 7, 8 or 9" },
    rto_email:          { required: false, minLength: 0, maxLength: 200, pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,                      message: "Enter valid email address" },
    rto_address_line:   { required: true,  minLength: 3, maxLength: 100, pattern: null,                                              message: "Address must be 3-100 characters" },
    rto_address_line2:  { required: false, minLength: 3, maxLength: 100, pattern: null,                                              message: "Address must be 3-100 characters if entered" },
    rto_pincode:        { required: true,  minLength: 6, maxLength: 6,   pattern: /^\d{6}$/,                                         message: "Must be 6 digit valid pincode" },
    rto_gstin:          { required: false, minLength: 15,maxLength: 15,  pattern: /^[0-9]{2}[A-Z]{5}[A-Z0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/, message: "Enter valid GSTIN (e.g. 24AAACO4716C1ZZ)" },
};

// ================================================================
// VALIDATION HELPERS
// ================================================================
function getFieldEls(fieldId) {
    return {
        field:  document.getElementById(fieldId),
        errorEl: document.getElementById(fieldId + '_error'),
        dotEl:  document.getElementById(fieldId)
                    ?.closest('.input-wrapper')
                    ?.querySelector('.validation-dot')
    };
}

function clearFieldState(fieldId) {
    const { field, errorEl, dotEl } = getFieldEls(fieldId);
    field?.classList.remove('error', 'success');
    dotEl?.classList.remove('error', 'success');
    if (errorEl) { errorEl.textContent = ''; errorEl.classList.remove('show'); }
}

function showFieldError(fieldId, message) {
    const { field, errorEl, dotEl } = getFieldEls(fieldId);
    field?.classList.add('error');
    field?.classList.remove('success');
    dotEl?.classList.add('error');
    dotEl?.classList.remove('success');
    if (errorEl) { errorEl.textContent = message; errorEl.classList.add('show'); }
}

function showFieldSuccess(fieldId) {
    const { field, errorEl, dotEl } = getFieldEls(fieldId);
    field?.classList.add('success');
    field?.classList.remove('error');
    dotEl?.classList.add('success');
    dotEl?.classList.remove('error');
    if (errorEl) { errorEl.classList.remove('show'); }
}

/**
 * Validate a single field.
 * Returns true = valid, false = invalid.
 */
function validateField(fieldId, value) {
    const rules = validationRules[fieldId];
    if (!rules) return true;

    clearFieldState(fieldId);

    const trimmed = (value || '').trim();

    // Empty + not required = pass (no indicator shown)
    if (!trimmed && !rules.required) return true;

    // Required + empty = fail
    if (rules.required && !trimmed) {
        showFieldError(fieldId, rules.message);
        return false;
    }

    // Email: only validate if non-empty
    if (!trimmed) return true;

    // Pattern check
    if (rules.pattern && !rules.pattern.test(trimmed)) {
        showFieldError(fieldId, rules.message);
        return false;
    }

    // Min length
    if (rules.minLength && trimmed.length < rules.minLength) {
        showFieldError(fieldId, rules.message);
        return false;
    }

    // Max length
    if (rules.maxLength && trimmed.length > rules.maxLength) {
        showFieldError(fieldId, rules.message);
        return false;
    }

    showFieldSuccess(fieldId);
    return true;
}

// ================================================================
// REAL-TIME VALIDATION — attach listeners
// ================================================================
function setupRealTimeValidation() {
    // Attach to all inputs/textareas that have a matching rule
    Object.keys(validationRules).forEach(function(fieldId) {
        const el = document.getElementById(fieldId);
        if (!el) return;

        // Remove old listeners by cloning (safe for modal reuse)
        const clone = el.cloneNode(true);
        el.parentNode.replaceChild(clone, el);
        const fresh = document.getElementById(fieldId);

        const eventType = (fresh.tagName === 'TEXTAREA') ? 'input' : 'input';

        fresh.addEventListener(eventType, function() {
            validateField(fieldId, this.value);
        });

        // Extra blur for pincode to trigger location fetch
        if (fieldId === 'pincode') {
            fresh.addEventListener('blur', function() {
                if (this.value.length === 6) fetchLocationDetails();
            });
        }
        if (fieldId === 'rto_pincode') {
            fresh.addEventListener('blur', function() {
                if (this.value.length === 6) fetchRTOLocationDetails();
            });
        }
    });
}

// ================================================================
// FORM-LEVEL VALIDATION (called on submit)
// ================================================================
function validateForm() {
    let isValid = true;
    const isRTOEnabled  = document.getElementById('use_alt_rto_address').checked;
    const isNewRTOMode  = !document.getElementById('rtoNewAddressMode').classList.contains('hidden');

    // --- Pickup Address required fields ---
    ['address_name', 'contact_name', 'contact_number', 'address_line', 'pincode'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el && !validateField(id, el.value)) isValid = false;
    });

    // --- Optional pickup fields: only validate if filled ---
    ['email', 'address_line2', 'gstin'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el && el.value.trim() && !validateField(id, el.value)) isValid = false;
    });

    // --- Pincode must have auto-filled city ---
    const city = document.getElementById('city');
    if (city && !city.value.trim()) {
        showFieldError('pincode', 'Please enter a valid pincode to auto-fill city');
        isValid = false;
    }

    // --- RTO validation ---
    if (isRTOEnabled) {
        if (isNewRTOMode) {
            // New RTO address required fields
            ['rto_address_name', 'rto_contact_name', 'rto_contact_number', 'rto_address_line', 'rto_pincode'].forEach(function(id) {
                const el = document.getElementById(id);
                if (el && !validateField(id, el.value)) isValid = false;
            });

            // Optional RTO fields: only validate if filled
            ['rto_email', 'rto_address_line2', 'rto_gstin'].forEach(function(id) {
                const el = document.getElementById(id);
                if (el && el.value.trim() && !validateField(id, el.value)) isValid = false;
            });

            // RTO pincode must have auto-filled city
            const rtoCity = document.getElementById('rto_city');
            if (rtoCity && !rtoCity.value.trim()) {
                showFieldError('rto_pincode', 'Please enter a valid pincode to auto-fill RTO city');
                isValid = false;
            }
        } else {
            // Select mode: must pick an existing address
            const rtoSelect = document.getElementById('rto_address');
            const rtoErrorEl = document.getElementById('rto_address_error');
            if (rtoSelect && !rtoSelect.value) {
                if (rtoErrorEl) { rtoErrorEl.textContent = 'Please select an RTO address'; rtoErrorEl.classList.add('show'); }
                isValid = false;
            } else {
                if (rtoErrorEl) rtoErrorEl.classList.remove('show');
            }
        }
    }

    return isValid;
}

// ================================================================
// CLEAR ALL VALIDATION STATES
// ================================================================
function clearAllValidation() {
    document.querySelectorAll('.form-input').forEach(function(el) {
        el.classList.remove('error', 'success');
    });
    document.querySelectorAll('.error-message').forEach(function(el) {
        el.textContent = '';
        el.classList.remove('show');
    });
    document.querySelectorAll('.validation-dot').forEach(function(el) {
        el.classList.remove('error', 'success');
    });
}

// ================================================================
// MODAL OPEN / CLOSE
// ================================================================
const modal   = document.getElementById('addressModal');
const form    = document.getElementById('addressForm');
const storeRoute = "{{ route('warehouses.store') }}";

function openAddModal() {
    form.reset();
    // Reset form to ADD mode
    form.action = storeRoute;
    document.getElementById('form_method').value = 'POST';
    document.getElementById('warehouseId').value = '';
    document.getElementById('modal-title').innerText = 'Add Pickup Address';
    document.getElementById('country').value = 'INDIA';

    // Clear validation
    clearAllValidation();

    // Reset RTO
    document.getElementById('use_alt_rto_address').checked = false;
    toggleRTOSection();
    switchToSelectMode();

    modal.classList.remove('hidden');
    setupRealTimeValidation();
}

function closeModal() {
    modal.classList.add('hidden');
}

document.getElementById('openAddModalBtn').addEventListener('click', openAddModal);
document.getElementById('closeModalBtn').addEventListener('click', closeModal);
document.getElementById('cancelBtn').addEventListener('click', closeModal);
document.getElementById('modalBackdrop').addEventListener('click', closeModal);

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
});

// ================================================================
// RTO SECTION TOGGLE
// ================================================================
function toggleRTOSection() {
    const isChecked = document.getElementById('use_alt_rto_address').checked;
    const section   = document.getElementById('rtoAddressSection');
    const note      = document.getElementById('rtoNote');

    if (isChecked) {
        section.classList.remove('hidden');
        section.classList.add('animate-fadeIn');
        note.classList.remove('hidden');
        // Re-attach validation listeners for newly visible RTO fields
        setupRealTimeValidation();
    } else {
        section.classList.add('hidden');
        note.classList.add('hidden');
        switchToSelectMode();
    }
}

function switchToNewAddressMode() {
    document.getElementById('rtoSelectMode').classList.add('hidden');
    document.getElementById('rtoNewAddressMode').classList.remove('hidden');
    document.getElementById('rtoNewAddressMode').classList.add('animate-fadeIn');
    document.getElementById('rto_address_select').disabled = true;
    document.getElementById('rto_address').value = '';
    document.getElementById('rto_address_error').classList.remove('show');
    // Attach validation to RTO fields
    setupRealTimeValidation();
}

function switchToSelectMode() {
    document.getElementById('rtoNewAddressMode').classList.add('hidden');
    document.getElementById('rtoSelectMode').classList.remove('hidden');
    document.getElementById('rtoSelectMode').classList.add('animate-fadeIn');
    document.getElementById('rto_address').disabled = false;
    // Clear RTO new address validation states
    ['rto_address_name','rto_contact_name','rto_contact_number','rto_email',
     'rto_address_line','rto_address_line2','rto_pincode','rto_gstin'].forEach(clearFieldState);
}

// ================================================================
// EDIT ADDRESS — load existing data
// ================================================================
function editAddress(id) {
    fetch('/seller/warehouses/' + id + '/edit', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(res) {
        if (!res.ok) throw new Error('Server error: ' + res.status);
        return res.json();
    })
    .then(function(data) {
        // Clear states before populating
        clearAllValidation();

        // Set form to UPDATE mode
        form.action = '/seller/warehouses/' + id;
        document.getElementById('form_method').value = 'PUT';
        document.getElementById('warehouseId').value = data.id;
        document.getElementById('modal-title').innerText = 'Edit Pickup Address';

        // ---- Pickup Address Fields (map DB columns → API field names) ----
        setVal('address_name',       data.warehouse_name    || data.address_name    || '');
        setVal('contact_name',       data.contact_person    || data.contact_name    || '');
        setVal('contact_number',     data.contact_number    || '');
        setVal('email',              data.email_id          || data.email           || '');
        setVal('address_line',       data.address_line_1    || data.address_line    || '');
        setVal('address_line2',      data.address_line_2    || data.address_line2   || '');
        setVal('pincode',            data.pincode           || '');
        setVal('city',               data.city              || '');
        setVal('state',              data.state             || '');
        setVal('country',            data.country           || 'INDIA');
        setVal('gstin',              data.gstin             || '');
        setVal('latitude',           data.latitude          || '');
        setVal('longitude',          data.longitude         || '');
        setDropdown('warehousing_system', data.warehousing_system || '');
        setCheckbox('dropship_location',  !!data.dropship_location);

        // ---- RTO Address ----
        const useRTO = !!data.use_alt_rto_address;
        setCheckbox('use_alt_rto_address', useRTO);

        if (useRTO) {
            // Existing RTO warehouse selected?
            if (data.rto_warehouse_id || data.rto_address) {
                setDropdown('rto_address', data.rto_warehouse_id || data.rto_address || '');
                switchToSelectMode();
            } else {
                // New RTO address data
                setVal('rto_address_name',   data.rto_warehouse_name || data.rto_address_name   || '');
                setVal('rto_contact_name',   data.rto_contact_person || data.rto_contact_name   || '');
                setVal('rto_contact_number', data.rto_contact_number || '');
                setVal('rto_email',          data.rto_email_id       || data.rto_email          || '');
                setVal('rto_address_line',   data.rto_address_line_1 || data.rto_address_line   || '');
                setVal('rto_address_line2',  data.rto_address_line_2 || data.rto_address_line2  || '');
                setVal('rto_pincode',        data.rto_pincode        || '');
                setVal('rto_city',           data.rto_city           || '');
                setVal('rto_state',          data.rto_state          || '');
                setVal('rto_country',        data.rto_country        || 'INDIA');
                setVal('rto_gstin',          data.rto_gstin          || '');
                switchToNewAddressMode();
            }
        }

        toggleRTOSection();
        modal.classList.remove('hidden');
        setupRealTimeValidation();
    })
    .catch(function(err) {
        console.error('editAddress error:', err);
        alert('Could not load address data. Please try again.');
    });
}

// ================================================================
// SET PRIMARY ADDRESS
// ================================================================
// function setPrimary(id, btn) {
//     if (!confirm('Is address ko primary set karna chahte hain?')) return;

//     // Disable button to prevent double-click
//     if (btn) btn.disabled = true;

//     const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
//                    || document.querySelector('input[name="_token"]')?.value
//                    || '';

//     fetch('/seller/warehouses/' + id + '/set-primary', {
//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN':      csrfToken,
//             'X-Requested-With':  'XMLHttpRequest',
//             'Content-Type':      'application/json'
//         }
//     })
//     .then(function(res) {
//         if (!res.ok) throw new Error('Server error: ' + res.status);
//         return res.json();
//     })
//     .then(function(data) {
//         if (data.success) {
//             window.location.reload();
//         } else {
//             alert('Error: ' + (data.message || 'Something went wrong'));
//             if (btn) btn.disabled = false;
//         }
//     })
//     .catch(function(err) {
//         console.error('setPrimary error:', err);
//         alert('Network error. Please try again.');
//         if (btn) btn.disabled = false;
//     });
// }
// ================================================================
// SET PRIMARY ADDRESS - FIXED VERSION
// ================================================================
function setPrimary(id, btn) {
    if (!confirm('Are you sure you want to set this as your primary pickup address?\n\nThis will be the default location for all new shipments.')) return;
    
    // Visual feedback: button disable + loading state
    const originalIcon = btn.innerHTML;
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.classList.add('opacity-50');
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content 
                   || document.querySelector('input[name="_token"]')?.value 
                   || '';

    fetch('/seller/warehouses/' + id + '/set-primary', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'  // ✅ Sirf Accept header, Content-Type hatao
            // ❌ 'Content-Type': 'application/json' REMOVE KARO (body empty hai)
        }
    })
    .then(async function(res) {
        // ✅ Handle both JSON and HTML responses (fallback safety)
        const contentType = res.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return res.json();
        } else {
            // Agar server ne HTML bheja (error page), toh manually reload
            console.warn('Server returned HTML, forcing reload...');
            window.location.reload();
            return { success: true };
        }
    })
    .then(function(data) {
        if (data.success) {
            // ✅ Smooth UI update without full reload (optional enhancement)
            updatePrimaryUI(id);
            
            // Fallback: 500ms baad full reload agar UI update fail ho
            setTimeout(() => window.location.reload(), 500);
        } else {
            alert('❌ Error: ' + (data.message || 'Something went wrong'));
            // Restore button
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalIcon;
                btn.classList.remove('opacity-50');
            }
        }
    })
    .catch(function(err) {
        console.error('setPrimary error:', err);
        alert('⚠️ Network error. Reloading page...');
        // Force reload on error
        window.location.reload();
    });
}

// ✅ NEW: Inline UI update (instant feedback without reload)
function updatePrimaryUI(newPrimaryId) {
    // 1. Sabhi stars ko reset karo
    document.querySelectorAll('#addressesTableBody button[onclick*="setPrimary"]').forEach(function(btn) {
        const onclick = btn.getAttribute('onclick') || '';
        const match = onclick.match(/setPrimary\((\d+)/);
        if (match) {
            const warehouseId = parseInt(match[1]);
            const starIcon = btn.querySelector('i');
            const title = btn.getAttribute('title');
            
            if (warehouseId === newPrimaryId) {
                // ✅ New primary: yellow star + "Primary Address"
                btn.classList.remove('text-gray-300', 'hover:text-yellow-500');
                btn.classList.add('text-yellow-500');
                btn.setAttribute('title', 'Primary Address');
                if (starIcon) starIcon.classList.add('fa-solid'); // Solid star
            } else {
                // ❌ Others: gray star + "Set as Primary"
                btn.classList.remove('text-yellow-500');
                btn.classList.add('text-gray-300', 'hover:text-yellow-500');
                btn.setAttribute('title', 'Set as Primary');
                if (starIcon) starIcon.classList.remove('fa-solid');
            }
        }
    });
    
    // 2. PRIMARY badges update karo
    document.querySelectorAll('#addressesTableBody tr').forEach(function(row) {
        const editBtn = row.querySelector('button[onclick*="editAddress"]');
        if (editBtn) {
            const onclick = editBtn.getAttribute('onclick') || '';
            const match = onclick.match(/editAddress\((\d+)/);
            if (match) {
                const warehouseId = parseInt(match[1]);
                let badge = row.querySelector('.bg-yellow-100.text-yellow-800');
                
                if (warehouseId === newPrimaryId) {
                    // ✅ Add PRIMARY badge if not exists
                    if (!badge) {
                        const nameCell = row.querySelector('td:first-child');
                        if (nameCell) {
                            badge = document.createElement('span');
                            badge.className = 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mt-1';
                            badge.textContent = 'PRIMARY';
                            nameCell.appendChild(badge);
                        }
                    }
                } else {
                    // ❌ Remove PRIMARY badge from others
                    if (badge) badge.remove();
                }
            }
        }
    });
}

// ================================================================
// PINCODE AUTO-FILL (postalpincode.in API)
// ================================================================
function fetchLocationDetails() {
    const pincode = (document.getElementById('pincode').value || '').trim();
    if (!/^\d{6}$/.test(pincode)) {
        showFieldError('pincode', 'Must be 6 digit valid pincode');
        clearPickupLocation();
        return;
    }

    fetch('https://api.postalpincode.in/pincode/' + pincode)
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data[0]?.Status === 'Success' && data[0].PostOffice?.length) {
                const po = data[0].PostOffice[0];
                setVal('city',    po.District || '');
                setVal('state',   po.State    || '');
                setVal('country', 'INDIA');
                showFieldSuccess('pincode');
            } else {
                showFieldError('pincode', 'Invalid or unserviceable pincode');
                clearPickupLocation();
            }
        })
        .catch(function() {
            showFieldError('pincode', 'Error fetching pincode details');
            clearPickupLocation();
        });
}

function clearPickupLocation() {
    setVal('city', '');
    setVal('state', '');
}

function fetchRTOLocationDetails() {
    const pincode = (document.getElementById('rto_pincode').value || '').trim();
    if (!/^\d{6}$/.test(pincode)) {
        showFieldError('rto_pincode', 'Must be 6 digit valid pincode');
        clearRTOLocation();
        return;
    }

    fetch('https://api.postalpincode.in/pincode/' + pincode)
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data[0]?.Status === 'Success' && data[0].PostOffice?.length) {
                const po = data[0].PostOffice[0];
                setVal('rto_city',    po.District || '');
                setVal('rto_state',   po.State    || '');
                setVal('rto_country', 'INDIA');
                showFieldSuccess('rto_pincode');
            } else {
                showFieldError('rto_pincode', 'Invalid or unserviceable pincode');
                clearRTOLocation();
            }
        })
        .catch(function() {
            showFieldError('rto_pincode', 'Error fetching RTO pincode details');
            clearRTOLocation();
        });
}

function clearRTOLocation() {
    setVal('rto_city', '');
    setVal('rto_state', '');
}

// ================================================================
// SEARCH TABLE
// ================================================================
function searchAddresses() {
    const val  = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#addressesTableBody tr');
    rows.forEach(function(row) {
        row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
    });
}

// ================================================================
// FORM SUBMIT — validate then submit
// ================================================================
form.addEventListener('submit', function(e) {
    e.preventDefault();

    if (!validateForm()) {
        // Scroll to first error
        const firstError = document.querySelector('.form-input.error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
        return;
    }

    // Disable submit button to prevent double submit
    const submitBtn  = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitBtnText');
    submitBtn.disabled = true;
    if (submitText) submitText.textContent = 'Saving...';

    // Native form submit
    this.submit();
});

// ================================================================
// UTILITY HELPERS
// ================================================================
function setVal(id, value) {
    const el = document.getElementById(id);
    if (el) {
        if (el.tagName === 'TEXTAREA' || el.tagName === 'INPUT') {
            el.value = value;
        }
    }
}

function setDropdown(id, value) {
    const el = document.getElementById(id);
    if (el) el.value = value;
}

function setCheckbox(id, checked) {
    const el = document.getElementById(id);
    if (el) el.checked = !!checked;
}

// ================================================================
// INIT on page load
// ================================================================
document.addEventListener('DOMContentLoaded', function() {
    setupRealTimeValidation();
});
</script>
@endpush