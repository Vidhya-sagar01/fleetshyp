@extends('seller.layouts.app')

@section('content')
<div class="space-y-5 pb-10">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Create Reverse Order</h1>
            <p class="text-sm text-gray-500 mt-1">Initiate return pickup for customer orders</p>
        </div>
        <a href="{{ route('index') }}"
           class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center text-sm shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-center">
        <i class="fa fa-exclamation-triangle text-red-500 mr-3"></i>
        <p class="text-red-700 text-sm">{{ session('error') }}</p>
    </div>
    @endif
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center">
        <i class="fa fa-check-circle text-green-500 mr-3"></i>
        <p class="text-green-700 text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <form id="reverseOrderForm" action="{{ route('store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- ===== TOGGLE OPTIONS ===== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- QC Toggle --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-clipboard-check text-[#D4AF37] mr-1"></i> Quality Check
                    </label>
                    <div class="flex items-center gap-6 bg-gray-50 rounded-xl p-3 border border-gray-100">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="qc_option" value="qc" id="qcYes"
                                   class="h-4 w-4 text-[#D4AF37] border-gray-300 focus:ring-[#D4AF37]" checked>
                            <span class="text-sm font-medium text-gray-700">With QC</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="qc_option" value="without_qc" id="qcNo"
                                   class="h-4 w-4 text-[#D4AF37] border-gray-300 focus:ring-[#D4AF37]">
                            <span class="text-sm font-medium text-gray-700">Without QC</span>
                        </label>
                    </div>
                    <input type="hidden" name="is_qc_required" id="isQcRequired" value="1">
                </div>

                {{-- Order Type Toggle --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag text-[#D4AF37] mr-1"></i> Order Type
                    </label>
                    <div class="flex items-center gap-6 bg-gray-50 rounded-xl p-3 border border-gray-100">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="order_type" value="internal" id="typeInternal"
                                   class="h-4 w-4 text-[#D4AF37] border-gray-300 focus:ring-[#D4AF37]" checked>
                            <span class="text-sm font-medium text-gray-700">Internal</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="order_type" value="external" id="typeExternal"
                                   class="h-4 w-4 text-[#D4AF37] border-gray-300 focus:ring-[#D4AF37]">
                            <span class="text-sm font-medium text-gray-700">External</span>
                        </label>
                    </div>
                    <input type="hidden" name="return_type" id="returnType" value="0">
                </div>
            </div>
        </div>

        {{-- ===== AWB SEARCH (Internal only) ===== --}}
        <div id="awbSearchSection" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">
            <h3 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-barcode mr-2 text-[#D4AF37]"></i> Search by AWB
            </h3>
            <div class="flex gap-3 max-w-lg">
                <input type="text" id="awbSearch" name="awb_no"
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="Enter AWB number (e.g. FSHIP123456789)">
                <button type="button" id="searchAwbBtn"
                        class="px-5 py-2.5 bg-[#D4AF37] text-white rounded-lg hover:bg-[#B8941F] transition text-sm font-medium flex items-center gap-2 whitespace-nowrap">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
            <p class="text-xs text-gray-400 mt-2">auto filled</p>
        </div>

        {{-- ===== BUYER DETAILS ===== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">
            <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user mr-2 text-[#D4AF37]"></i> Buyer / Consignee Details
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Buyer Name <span class="text-red-500">*</span></label>
                    <input type="text" name="consignee_name" id="buyerName" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="Full name">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Phone Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="consignee_phone" id="buyerPhone" required maxlength="10" pattern="[0-9]{10}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="10-digit mobile">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Alternate Phone</label>
                    <input type="tel" name="buyer_alt_phone" id="buyerAltPhone" maxlength="10"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="Optional">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                    <input type="email" name="consignee_email" id="buyerEmail"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="buyer@email.com">
                </div>
            </div>
        </div>

        {{-- ===== PICKUP ADDRESS ===== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">
            <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-map-marker-alt mr-2 text-[#D4AF37]"></i> Pickup Address
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Complete Address <span class="text-red-500">*</span></label>
                    <textarea name="pickup_address" id="buyerAddress" required rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none resize-none"
                              placeholder="House/Flat no, Street, Area, Colony..."></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Landmark</label>
                    <input type="text" name="pickup_landmark" id="buyerLandmark"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="Near school, temple, hospital...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Pincode <span class="text-red-500">*</span></label>
                    <input type="text" name="pickup_pincode" id="buyerPincode" required maxlength="6" pattern="\d{6}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="6-digit pincode">
                        <p id="pincodeError" class="text-red-500 text-xs mt-1 hidden">Valid 6-digit pincode required</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">City <span class="text-red-500">*</span></label>
                    <input type="text" name="pickup_city" id="buyerCity" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="City name">
                </div>
                <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">State <span class="text-red-500">*</span></label>
            {{-- ✅ FIXED: Added state options --}}
            <select name="pickup_state" id="buyerState" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none bg-white">
                <option value="">Select State</option>
                @foreach(['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Delhi'] as $state)
                    <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
            </select>
        </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Address Type</label>
                    <select name="pickup_address_type"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none bg-white">
                        <option value="Home" selected>Home</option>
                        <option value="Office">Office</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <input type="hidden" name="buyer_country" value="India">
            </div>

            {{-- Billing same as pickup --}}
            <div class="mt-4 pt-4 border-t border-gray-100">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" id="sameAsBilling" name="same_as_billing" value="1" checked
                           class="h-4 w-4 text-[#D4AF37] border-gray-300 rounded focus:ring-[#D4AF37]">
                    <span class="text-sm text-gray-600">Billing address same as Pickup address</span>
                </label>
            </div>

            {{-- Separate Billing Address --}}
            <div id="billingAddressSection" class="hidden mt-4 pt-4 border-t border-gray-100">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-file-invoice mr-2 text-[#D4AF37]"></i> Billing Address
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Billing Address</label>
                        <textarea name="billing_address" rows="2"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none resize-none"
                                  placeholder="Billing address..."></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Billing Pincode</label>
                        <input type="text" name="billing_pincode" maxlength="6"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                               placeholder="6-digit pincode">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Billing City</label>
                        <input type="text" name="billing_city"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                               placeholder="City">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Billing State</label>
                        <select name="billing_state"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none bg-white">
                            <option value="">Select State</option>
                            @foreach(['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Delhi'] as $state)
                                <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== PACKAGE DIMENSIONS ===== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">
            <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-box mr-2 text-[#D4AF37]"></i> Package Dimensions
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Weight (Kg) <span class="text-red-500">*</span></label>
                    <input type="number" name="shipment_weight" id="weight" step="0.001" min="0.001" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="0.500">
                    <p class="text-xs text-gray-400 mt-1">Min: 0.50 Kg</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Length (cm) <span class="text-red-500">*</span></label>
                    <input type="number" name="shipment_length" id="length" step="0.01" min="1" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="cm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Width (cm) <span class="text-red-500">*</span></label>
                    <input type="number" name="shipment_width" id="width" step="0.01" min="1" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="cm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Height (cm) <span class="text-red-500">*</span></label>
                    <input type="number" name="shipment_height" id="height" step="0.01" min="1" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="cm">
                </div>
            </div>
            <div class="mt-4 flex items-center gap-3">
                <span class="text-sm font-medium text-gray-600">Volumetric Weight:</span>
                <div class="flex items-center gap-2 bg-[#D4AF37]/10 border border-[#D4AF37]/30 rounded-lg px-4 py-2">
                    <i class="fas fa-weight-hanging text-[#D4AF37] text-sm"></i>
                    <span id="volumetricWeightDisplay" class="text-sm font-semibold text-[#B8941F]">0.00 Kg</span>
                </div>
                <input type="hidden" name="volumetric_weight" id="volumetricWeightHidden" value="0">
            </div>
        </div>

        {{-- ===== ORDER DETAILS ===== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">
            <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-receipt mr-2 text-[#D4AF37]"></i> Order Details
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Order ID <span class="text-xs text-gray-400">(Auto)</span></label>
                    <input type="text" name="order_id" id="orderId" readonly
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 text-gray-500 font-mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Invoice Number</label>
                    <input type="text" name="invoice_number" id="invoiceNumber"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="INV-XXXXX">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Order Date <span class="text-xs text-gray-400">(Auto)</span></label>
                    <input type="text" name="order_date" id="orderDate" readonly
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 text-gray-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Payment Mode</label>
                    <select name="payment_mode" id="paymentMode"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none bg-white">
                        <option value="COD" selected>COD</option>
                        <option value="Prepaid">Prepaid</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Notes</label>
                    <input type="text" name="notes"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                           placeholder="Any special instructions...">
                </div>
            </div>
        </div>

        {{-- ===== PRODUCT DETAILS ===== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-boxes mr-2 text-[#D4AF37]"></i> Product Details
                </h3>
                <button type="button" id="addProduct"
                        class="px-4 py-2 bg-[#D4AF37] text-white rounded-lg hover:bg-[#B8941F] transition text-sm font-medium flex items-center gap-2">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>
            <div id="productsContainer" class="space-y-4"></div>
            <p class="text-xs text-gray-400 mt-3">At least one product is required.</p>
        </div>

        {{-- ===== RETURN REASON (QC only) ===== --}}
        <div id="reasonSection" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">
            <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-exclamation-circle mr-2 text-[#D4AF37]"></i> Return Reason
            </h3>
            <div class="flex flex-wrap gap-4 mb-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="reason_type" value="wrong_missing" checked
                           class="h-4 w-4 text-[#D4AF37] border-gray-300 focus:ring-[#D4AF37]">
                    <span class="text-sm font-medium text-gray-700">Wrong / Missing Item</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="reason_type" value="damaged"
                           class="h-4 w-4 text-[#D4AF37] border-gray-300 focus:ring-[#D4AF37]">
                    <span class="text-sm font-medium text-gray-700">Damaged Item</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="reason_type" value="not_required"
                           class="h-4 w-4 text-[#D4AF37] border-gray-300 focus:ring-[#D4AF37]">
                    <span class="text-sm font-medium text-gray-700">Not Required</span>
                </label>
            </div>
            <textarea name="return_reason" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none resize-none"
                      placeholder="Describe the issue in detail..."></textarea>
        </div>

        {{-- ===== QC PARAMETERS (QC only) ===== --}}
        <div id="qcParametersSection" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-clipboard-list mr-2 text-[#D4AF37]"></i> QC Parameters
                </h3>
                <button type="button" id="addQcParameter"
                        class="px-4 py-2 bg-[#D4AF37]/10 text-[#B8941F] border border-[#D4AF37]/30 rounded-lg hover:bg-[#D4AF37]/20 transition text-sm font-medium flex items-center gap-2">
                    <i class="fas fa-plus"></i> Add Parameter
                </button>
            </div>
            <div id="qcParametersContainer" class="space-y-3"></div>
            <p class="text-xs text-gray-400 mt-3">Select questions from dropdown. Answer must be Yes/No.</p>
        </div>

        {{-- ===== FINANCIAL DETAILS (External only) ===== --}}
        <div id="financialSection" class="hidden mb-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calculator mr-2 text-[#D4AF37]"></i> Financial Details
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Shipping Charge (Rs.)</label>
                        <input type="number" name="shipping_charge" id="shippingCharge" step="0.01" min="0" value="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Gift Wrap (Rs.)</label>
                        <input type="number" name="gift_wrap" id="giftWrap" step="0.01" min="0" value="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Transaction Fee (Rs.)</label>
                        <input type="number" name="transaction_fee" id="transactionFee" step="0.01" min="0" value="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Discounts (Rs.)</label>
                        <input type="number" name="discounts" id="discounts" step="0.01" min="0" value="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none">
                    </div>
                </div>
                <input type="hidden" name="order_amount"  id="hiddenOrderAmount"  value="0">
                <input type="hidden" name="tax_amount"    id="hiddenTaxAmount"    value="0">
                <input type="hidden" name="extra_charges" id="hiddenExtraCharges" value="0">
                <input type="hidden" name="total_amount"  id="hiddenTotalAmount"  value="0">
                <input type="hidden" name="cod_amount"    id="hiddenCodAmount"    value="0">
            </div>

            {{-- DARK FINAL AMOUNT BAR --}}
            <div class="mt-3 bg-gray-900 rounded-xl p-5 text-white">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-1">Sub Total</p>
                        <p class="text-xl font-bold" id="subTotal">Rs.0.00</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-1">Other Charges</p>
                        <p class="text-xl font-bold" id="otherCharges">Rs.0.00</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-1">Discounts</p>
                        <p class="text-xl font-bold text-red-400" id="totalDiscount">-Rs.0.00</p>
                    </div>
                    <div class="text-center border-l border-gray-700 pl-4">
                        <p class="text-xs text-gray-400 mb-1">Final Amount</p>
                        <p class="text-2xl font-extrabold text-[#D4AF37]" id="totalOrderValue">Rs.0.00</p>
                    </div>
                </div>
                <div class="border-t border-gray-700 pt-3 flex items-center justify-between text-xs text-gray-400">
                    <span><i class="fas fa-info-circle mr-1"></i> All amounts in INR</span>
                    <span>COD Amount: <span id="codDisplay" class="text-white font-semibold">Rs.0.00</span></span>
                </div>
            </div>
        </div>

        {{-- ===== WAREHOUSE SELECTION ===== --}}
<input type="hidden" name="selected_warehouse_id" id="selectedWarehouseId" value="">
<input type="hidden" name="selected_warehouse_pincode" id="selectedWarehousePincode" value="">

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3" id="warehouseContainer">
    @forelse($warehouses as $index => $wh)
    <div class="warehouse-card relative border-2 rounded-xl p-4 cursor-pointer transition-all duration-200
        {{ $index === 0 ? 'border-[#D4AF37] bg-amber-50 shadow-md is-selected' : 'border-gray-200 bg-white hover:border-[#D4AF37]' }}"
        data-id="{{ $wh->pick_address_ID }}"
        data-pincode="{{ $wh->pincode }}"
        data-city="{{ $wh->city }}"
        onclick="selectWarehouse(this)">

        <div class="wh-check absolute top-3 right-3 w-5 h-5 rounded-full bg-[#D4AF37] flex items-center justify-center {{ $index === 0 ? '' : 'hidden' }}">
            <i class="fas fa-check text-white" style="font-size:9px"></i>
        </div>
        <div class="pr-6">
            <h4 class="font-semibold text-sm mb-1 wh-name {{ $index === 0 ? 'text-[#B8941F]' : 'text-gray-800' }}">
                {{ $wh->warehouse_name }}
            </h4>
            <p class="text-xs text-gray-500 leading-relaxed mb-1">{{ $wh->address_line1 }}</p>
            <p class="text-xs text-gray-400 mt-1">
                <i class="fas fa-map-pin mr-1 text-[#D4AF37]"></i>{{ $wh->city }}, {{ $wh->pincode }}
            </p>
        </div>
    </div>
    @empty
    <div class="col-span-full p-8 text-center bg-gray-50 rounded-xl border-2 border-dashed">
        <p class="text-gray-500">No warehouse found. <a href="{{ route('warehouses.index') }}" class="text-[#D4AF37] font-bold underline">Add Now</a></p>
    </div>
    @endforelse
</div>
       

        {{-- ===== ACTION BUTTONS ===== --}}
        <div class="flex justify-between items-center pt-2">
            <a href="{{ url()->previous() }}"
               class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center gap-2 text-sm shadow-sm">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
            <button type="submit" id="submitBtn"
                    class="px-8 py-2.5 bg-[#D4AF37] text-white rounded-lg hover:bg-[#B8941F] transition font-semibold flex items-center gap-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-paper-plane"></i> Create Reverse Order
            </button>
        </div>

    </form>
</div>

{{-- ==================== TEMPLATES ==================== --}}

<template id="productRowTemplate">
    <div class="product-row border border-gray-200 rounded-xl p-4 bg-gray-50/70">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Product Name <span class="text-red-500">*</span></label>
                <input type="text" name="products[__IDX__][name]" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="Product name">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Quantity <span class="text-red-500">*</span></label>
                <input type="number" name="products[__IDX__][quantity]" required min="1" value="1"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none product-qty">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Unit Price (Rs.) <span class="text-red-500">*</span></label>
                <input type="number" name="products[__IDX__][unit_price]" required step="0.01" min="0" value="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none product-price">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Category</label>
                <input type="text" name="products[__IDX__][category]"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="Category">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">SKU</label>
                <input type="text" name="products[__IDX__][sku]"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="SKU code">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">HSN Code</label>
                <input type="text" name="products[__IDX__][hsn]"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="HSN">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Tax Rate (%)</label>
                <input type="number" name="products[__IDX__][tax_rate]" step="0.01" min="0" value="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none product-tax">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Discount (Rs.)</label>
                <input type="number" name="products[__IDX__][discount]" step="0.01" min="0" value="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none product-discount">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Brand <span class="text-red-500">*</span></label>
                <input type="text" name="products[__IDX__][brand]" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="Brand">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Color <span class="text-red-500">*</span></label>
                <input type="text" name="products[__IDX__][color]" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="Color">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Size</label>
                <input type="text" name="products[__IDX__][size]"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="Size">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Barcode / EAN</label>
                <input type="text" name="products[__IDX__][barcode]"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="Barcode">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Serial Number</label>
                <input type="text" name="products[__IDX__][serial_number]"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="Serial">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">IMEI</label>
                <input type="text" name="products[__IDX__][imei]"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none"
                       placeholder="IMEI">
            </div>
            <div class="flex items-end pb-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="products[__IDX__][is_fragile]" value="1"
                           class="h-4 w-4 text-[#D4AF37] border-gray-300 rounded focus:ring-[#D4AF37]">
                    <span class="text-xs font-medium text-gray-600">Fragile</span>
                </label>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Images</label>
                <input type="file" name="products[__IDX__][images][]" multiple accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-xs outline-none">
            </div>
        </div>
        <div class="mt-3 flex justify-end">
            <button type="button"
                    class="remove-product px-3 py-1.5 bg-red-50 text-red-500 border border-red-200 rounded-lg hover:bg-red-100 transition text-xs font-medium flex items-center gap-1">
                <i class="fas fa-trash-alt"></i> Remove
            </button>
        </div>
    </div>
</template>

<template id="qcParameterTemplate">
    <div class="qc-parameter-row border border-gray-200 rounded-lg p-4 bg-gray-50/70">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-6">
                <label class="block text-xs font-semibold text-gray-500 mb-1">QC Question</label>
                <select name="qc_parameters[__IDX__][questionId]" required
                        class="qc-question-select w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none bg-white">
                    <option value="">Select Question</option>
                    <option value="Take_Picture">Take a Picture of the Item you are collecting</option>
                    <option value="Validate_Product_Image">Does the product match the images?</option>
                    <option value="Check_Usage">Not used - check for usage marks on collar, sides and front</option>
                    <option value="Check_Damage">No visible cut or defect or damage - check for holes or stitching</option>
                    <option value="Check_Brand">Is Brand Matching? - Check on the product</option>
                    <option value="Check_Colour">Is the Colour matching with the product?</option>
                    <option value="Check_Size">Check product size</option>
                    <option value="Check_Serial_Number">Is Serial Number Correct?</option>
                </select>
                <input type="hidden" name="qc_parameters[__IDX__][question]" class="qc-question-text">
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Answer</label>
                <select name="qc_parameters[__IDX__][value]" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] outline-none bg-white">
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="md:col-span-2 flex items-center">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="qc_parameters[__IDX__][is_mandatory]" value="1" checked
                           class="h-4 w-4 text-[#D4AF37] border-gray-300 rounded focus:ring-[#D4AF37]">
                    <span class="text-xs font-medium text-gray-600">Mandatory</span>
                </label>
            </div>
            <div class="md:col-span-1 flex justify-end">
                <button type="button"
                        class="remove-qc-param w-8 h-8 flex items-center justify-center bg-red-50 text-red-500 border border-red-200 rounded-lg hover:bg-red-100 transition">
                    <i class="fas fa-trash text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    let productIdx = 0;
    let qcIdx = 0;

    // ================================
    // INIT
    // ================================
    function init() {
        document.getElementById('orderId').value = 'REV' + Date.now();
        document.getElementById('orderDate').value = new Date().toISOString().split('T')[0];

        const firstWh = document.querySelector('.warehouse-card');
        if (firstWh) selectWarehouse(firstWh);

        addProductRow();
        syncToggleSections();
        syncQcSections();

        // QC toggle
        document.querySelectorAll('input[name="qc_option"]').forEach(r => {
            r.addEventListener('change', syncQcSections);
        });

        // Order type toggle
        document.querySelectorAll('input[name="order_type"]').forEach(r => {
            r.addEventListener('change', syncToggleSections);
        });

        // Add Product button
        document.getElementById('addProduct').addEventListener('click', addProductRow);

        // Add QC Parameter button
        document.getElementById('addQcParameter').addEventListener('click', addQcRow);

        // Billing same as pickup
        document.getElementById('sameAsBilling').addEventListener('change', function () {
            document.getElementById('billingAddressSection').classList.toggle('hidden', this.checked);
        });

        // AWB Search button
        document.getElementById('searchAwbBtn').addEventListener('click', searchAWB);

        // Volumetric weight calc
        ['length', 'width', 'height'].forEach(id => {
            document.getElementById(id).addEventListener('input', calculateVolumetricWeight);
        });

        // Pincode auto-check on blur
        document.getElementById('buyerPincode').addEventListener('blur', function () {
            if (this.value.length === 6) window.triggerPincodeCheck();
        });

        // Financial inputs live listeners
        ['shippingCharge', 'giftWrap', 'transactionFee', 'discounts'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', recalcFinancials);
        });

        document.getElementById('paymentMode').addEventListener('change', recalcFinancials);
    }

    // ================================
    // SYNC TOGGLE SECTIONS
    // ================================
    function syncToggleSections() {
        const isInternal = document.getElementById('typeInternal').checked;
        document.getElementById('returnType').value = isInternal ? '0' : '1';
        document.getElementById('awbSearchSection').classList.toggle('hidden', !isInternal);
        document.getElementById('financialSection').classList.toggle('hidden', isInternal);
    }

    // ================================
    // SYNC QC SECTIONS
    // ================================
    function syncQcSections() {
        const isQc = document.getElementById('qcYes').checked;
        document.getElementById('isQcRequired').value = isQc ? '1' : '0';
        document.getElementById('reasonSection').classList.toggle('hidden', !isQc);
        document.getElementById('qcParametersSection').classList.toggle('hidden', !isQc);
    }

    // ================================
    // ADD PRODUCT ROW
    // ================================
    function addProductRow() {
        const template = document.getElementById('productRowTemplate');
        const container = document.getElementById('productsContainer');

        const clone = template.content.cloneNode(true);

        clone.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace('__IDX__', productIdx);
        });

        productIdx++;

        const wrapper = document.createElement('div');
        wrapper.appendChild(clone);
        const row = wrapper.firstElementChild;
        container.appendChild(row);

        row.querySelector('.remove-product').addEventListener('click', () => {
            if (document.querySelectorAll('.product-row').length > 1) {
                row.remove();
                recalcFinancials();
            } else {
                toast('At least one product is required', 'error');
            }
        });

        row.querySelectorAll('.product-qty, .product-price, .product-tax, .product-discount').forEach(el => {
            el.addEventListener('input', recalcFinancials);
        });

        return row;
    }

    // ================================
    // ADD QC PARAMETER ROW
    // ================================
    function addQcRow() {
        const template = document.getElementById('qcParameterTemplate');
        const container = document.getElementById('qcParametersContainer');

        const clone = template.content.cloneNode(true);

        clone.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace('__IDX__', qcIdx);
        });

        qcIdx++;

        const wrapper = document.createElement('div');
        wrapper.appendChild(clone);
        const row = wrapper.firstElementChild;
        container.appendChild(row);

        row.querySelector('.remove-qc-param').addEventListener('click', () => {
            row.remove();
        });

        const qSelect = row.querySelector('.qc-question-select');
        const qText   = row.querySelector('.qc-question-text');
        if (qSelect && qText) {
            qSelect.addEventListener('change', function () {
                qText.value = this.options[this.selectedIndex].text;
            });
        }

        return row;
    }

    // ================================
    // SEARCH AWB
    // ================================
    async function searchAWB() {
        const awb = document.getElementById('awbSearch').value.trim();
        if (!awb) return toast('Please enter the AWB number', 'error');

        const btn = document.getElementById('searchAwbBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';

        try {
            const res = await fetch("{{ route('search-awb') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ awb })
            });

            const result = await res.json();

            if (!result.success) {
                toast('Order not found', 'error');
                return;
            }

            const d = result.data;

            // ===== BUYER DETAILS =====
            fillField('buyerName',     d.buyer_name);
            fillField('buyerPhone',    d.buyer_phone);
            fillField('buyerEmail',    d.buyer_email);
            fillField('buyerPincode',  d.buyer_pincode);
            fillField('buyerCity',     d.buyer_city);
            fillField('buyerLandmark', d.buyer_landmark || '');

            // Textarea
            const addrEl = document.getElementById('buyerAddress');
            if (addrEl) {
                addrEl.value = ((d.buyer_address_1 || '') + ' ' + (d.buyer_address_2 || '')).trim();
                addrEl.classList.add('bg-gray-100');
            }

            // State select — case-insensitive match
            const stateEl = document.getElementById('buyerState');
            if (stateEl && d.buyer_state) {
                let matched = false;
                for (let opt of stateEl.options) {
                    if (opt.value.toLowerCase() === d.buyer_state.toLowerCase()) {
                        stateEl.value = opt.value;
                        matched = true;
                        break;
                    }
                }
                if (!matched) {
                    for (let opt of stateEl.options) {
                        if (opt.value.toLowerCase().includes(d.buyer_state.toLowerCase())) {
                            stateEl.value = opt.value;
                            break;
                        }
                    }
                }
                stateEl.disabled = true;
                stateEl.classList.add('bg-gray-100');
            }

            // ===== ORDER DETAILS =====
            fillField('orderId',       d.order_id,       true);
            fillField('invoiceNumber', d.invoice_number);
            fillField('orderDate',     d.order_date,     true);

            const pmEl = document.getElementById('paymentMode');
            if (pmEl && d.payment_mode) pmEl.value = d.payment_mode;

            // ===== DIMENSIONS =====
            fillField('weight', d.weight || 0.5);
            fillField('length', d.length || 1);
            fillField('width',  d.width  || 1);
            fillField('height', d.height || 1);
            calculateVolumetricWeight();

            // ===== PRODUCTS =====
            const container = document.getElementById('productsContainer');
            container.innerHTML = '';
            productIdx = 0;

            if (d.products && d.products.length > 0) {
                d.products.forEach(p => {
                    const row = addProductRow();
                    const idx = productIdx - 1;
                    row.querySelector(`[name="products[${idx}][name]"]`).value       = p.name     || '';
                    row.querySelector(`[name="products[${idx}][quantity]"]`).value   = p.quantity || 1;
                    row.querySelector(`[name="products[${idx}][unit_price]"]`).value = p.price    || 0;
                    row.querySelector(`[name="products[${idx}][sku]"]`).value        = p.sku      || '';
                });
            } else {
                addProductRow();
            }

            recalcFinancials();
            toast('Order data loaded!', 'success');
            setTimeout(() => window.triggerPincodeCheck(), 300);

        } catch (e) {
            console.error(e);
            toast('Error occurred while fetching order data', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-search"></i> Search';
        }
    }

    // ================================
    // VOLUMETRIC WEIGHT
    // ================================
    function calculateVolumetricWeight() {
        const l = parseFloat(document.getElementById('length').value) || 0;
        const w = parseFloat(document.getElementById('width').value)  || 0;
        const h = parseFloat(document.getElementById('height').value) || 0;
        const vol = (l * w * h) / 5000;
        document.getElementById('volumetricWeightDisplay').innerText = vol.toFixed(2) + ' Kg';
        document.getElementById('volumetricWeightHidden').value = vol.toFixed(2);
    }

    // ================================
    // FINANCIAL RECALC
    // ================================
    function recalcFinancials() {
        let subTotal = 0;

        document.querySelectorAll('.product-row').forEach(row => {
            const qty      = parseFloat(row.querySelector('.product-qty')?.value)      || 0;
            const price    = parseFloat(row.querySelector('.product-price')?.value)    || 0;
            const tax      = parseFloat(row.querySelector('.product-tax')?.value)      || 0;
            const discount = parseFloat(row.querySelector('.product-discount')?.value) || 0;
            subTotal += (qty * price) + ((qty * price) * tax / 100) - discount;
        });

        const shipping   = parseFloat(document.getElementById('shippingCharge')?.value)  || 0;
        const giftWrap   = parseFloat(document.getElementById('giftWrap')?.value)         || 0;
        const txnFee     = parseFloat(document.getElementById('transactionFee')?.value)   || 0;
        const discount   = parseFloat(document.getElementById('discounts')?.value)        || 0;
        const otherTotal = shipping + giftWrap + txnFee;
        const finalAmt   = subTotal + otherTotal - discount;
        const codAmt     = document.getElementById('paymentMode')?.value === 'COD' ? finalAmt : 0;

        const fmt  = v => 'Rs.' + v.toFixed(2);
        const safe = (id, val) => { const el = document.getElementById(id); if (el) el.innerText = val; };
        safe('subTotal',        fmt(subTotal));
        safe('otherCharges',    fmt(otherTotal));
        safe('totalDiscount',   '-' + fmt(discount));
        safe('totalOrderValue', fmt(finalAmt));
        safe('codDisplay',      fmt(codAmt));

        const setH = (id, val) => { const el = document.getElementById(id); if (el) el.value = val.toFixed(2); };
        setH('hiddenOrderAmount',  subTotal);
        setH('hiddenTaxAmount',    0);
        setH('hiddenExtraCharges', otherTotal);
        setH('hiddenTotalAmount',  finalAmt);
        setH('hiddenCodAmount',    codAmt);
    }

    // ================================
    // HELPERS
    // ================================
    function fillField(id, val, lock = false) {
        const el = document.getElementById(id);
        if (!el || val === undefined || val === null || val === '') return;
        el.value = val;
        el.classList.add('bg-gray-100');
        if (lock) el.readOnly = true;
    }

    function toast(msg, type) {
        // Purana toast hata do agar already hai
        document.querySelectorAll('.fship-toast').forEach(t => t.remove());
        const el = document.createElement('div');
        el.className = `fship-toast fixed bottom-6 right-6 z-50 px-5 py-3 text-white text-sm rounded-lg shadow-lg ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
        el.innerText = msg;
        document.body.appendChild(el);
        setTimeout(() => el.remove(), 3000);
    }

    // ================================
    // WAREHOUSE SELECT (Global)
    // ================================
    window.selectWarehouse = function (card) {
        if (!card) return;

        document.querySelectorAll('.warehouse-card').forEach(c => {
            c.classList.remove('is-selected');
            c.style.borderColor = '#e5e7eb';
            c.style.backgroundColor = 'white';
            const check = c.querySelector('.wh-check');
            if (check) check.classList.add('hidden');
            const name = c.querySelector('.wh-name');
            if (name) { name.classList.remove('text-[#B8941F]'); name.classList.add('text-gray-800'); }
        });

        card.classList.add('is-selected');
        card.style.borderColor = '#D4AF37';
        card.style.backgroundColor = '#fffbeb';
        const currentCheck = card.querySelector('.wh-check');
        if (currentCheck) currentCheck.classList.remove('hidden');
        const currentName = card.querySelector('.wh-name');
        if (currentName) { currentName.classList.add('text-[#B8941F]'); currentName.classList.remove('text-gray-800'); }

        const input = document.getElementById('selectedWarehouseId');
        if (input) input.value = card.dataset.id;

        // Warehouse badlne par pincode re-check
        window.triggerPincodeCheck();
    };

    // ================================
    // PINCODE SERVICEABILITY CHECK (Global)
    // ================================
    window.triggerPincodeCheck = async function () {
        const custPinEl = document.getElementById('buyerPincode');
        const errEl     = document.getElementById('pincodeError');
        const custPin   = custPinEl ? custPinEl.value.trim() : '';
        const activeWh  = document.querySelector('.warehouse-card.is-selected');

        // Validation
        if (!custPin || custPin.length !== 6 || !/^\d{6}$/.test(custPin)) {
            if (errEl) errEl.classList.remove('hidden');
            return;
        }
        if (errEl) errEl.classList.add('hidden');

        if (!activeWh) return;

        // Warehouse pincode extract karo card ke text se
        const whPinMatch = activeWh.innerText.match(/\b\d{6}\b/);
        const whPin      = whPinMatch ? whPinMatch[0] : null;
        if (!whPin) return;

        try {
            const res  = await fetch(`{{ route('pincode.details') }}?pincode=${custPin}&pickupPincode=${whPin}`);
            const data = await res.json();

            if (data.status === true || data.status === 'success' || data.serviceable === true) {
                const cEl = document.getElementById('buyerCity');
                const sEl = document.getElementById('buyerState');

                let city  = data.city  || '';
                let state = data.state || '';

                // Destination field se parse karo agar city/state empty hain
                if ((!city || !state) && data.destination) {
                    const parts = data.destination.split(',').map(s => s.trim());
                    if (parts.length >= 1) city  = parts[0];
                    if (parts.length >= 2) state = parts[1];
                }

                // City update
                if (cEl && city) {
                    cEl.value = city;
                    cEl.classList.remove('border-red-500');
                    cEl.classList.add('bg-gray-100');
                }

                // State select update — exact + partial match
                if (sEl && state) {
                    sEl.disabled = false; // temporarily enable to set value
                    let matched = false;
                    for (let opt of sEl.options) {
                        if (opt.value.toLowerCase() === state.toLowerCase()) {
                            sEl.value = opt.value;
                            matched = true;
                            break;
                        }
                    }
                    if (!matched) {
                        for (let opt of sEl.options) {
                            if (opt.value.toLowerCase().includes(state.toLowerCase())) {
                                sEl.value = opt.value;
                                break;
                            }
                        }
                    }
                    sEl.classList.add('bg-gray-100');
                }

                toast('✓ Serviceable: ' + city + ', ' + state, 'success');

            } else {
                toast('⚠ Not Serviceable: ' + (data.message || 'Invalid route'), 'error');
            }

        } catch (e) {
            console.error('Pincode check error:', e);
            toast('⚠ Pincode check failed', 'error');
        }
    };

    // ================================
    // START
    // ================================
    init();

})();
</script>
@endpush