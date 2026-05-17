@extends('seller.layouts.app')

@section('title', 'Create Order')

@push('styles')
<style>
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #F5F1E8;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-title i { color: #D4AF37; }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.375rem;
    }
    .form-label .required { color: #ef4444; margin-left: 2px; }
    .form-input {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s;
        background-color: #ffffff;
    }
    .form-input:focus {
        outline: none;
        border-color: #D4AF37;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }
    .form-input::placeholder { color: #9ca3af; }
    .form-input[readonly] { background-color: #f3f4f6; cursor: not-allowed; }
    /* Validation states */
    .form-input.is-valid   { border-color: #22c55e !important; }
    .form-input.is-invalid { border-color: #ef4444 !important; }
    .field-error {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 0.25rem;
        display: none;
    }
    .field-error.show { display: block; }
    .field-hint { font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem; }
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.875rem;
        color: #374151;
        margin: 1rem 0;
    }
    .checkbox-label input[type="checkbox"],
    .checkbox-label input[type="radio"] {
        width: 1.125rem;
        height: 1.125rem;
        border: 2px solid #e5e7eb;
        border-radius: 4px;
        cursor: pointer;
        accent-color: #D4AF37;
    }
    .checkbox-label input[type="radio"] { border-radius: 50%; }
    .btn-primary {
        background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(212,175,55,0.4); }
    .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
    .btn-secondary {
        background: white;
        color: #374151;
        font-weight: 500;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .btn-secondary:hover { background: #f9fafb; border-color: #d1d5db; }
    .product-row {
        background: #fafafa;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
    }
    .remove-product {
        position: absolute;
        top: 1rem;
        right: 1rem;
        color: #ef4444;
        cursor: pointer;
        padding: 0.25rem;
        font-size: 1.25rem;
        line-height: 1;
    }
    .radio-group { display: flex; gap: 1.5rem; margin-bottom: 1rem; }
    .radio-label { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; color: #374151; }
    .payment-field { margin-bottom: 0.75rem; }
    .payment-field label { display: block; font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem; }
    .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; }
    .grid-5 { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; }
    @media (max-width: 768px) { .grid-2,.grid-3,.grid-4,.grid-5 { grid-template-columns: 1fr; } }
    .text-gold { color: #D4AF37; }
    .hidden { display: none !important; }
    /* Shield */
    .shield-section {
        background: linear-gradient(135deg, #f8f4ff 0%, #ffffff 100%);
        border: 2px solid #e9d5ff;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .shield-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
    .shield-title { display: flex; align-items: center; gap: 0.75rem; font-size: 1.125rem; font-weight: 600; color: #1f2937; }
    .shield-title i { color: #7c3aed; font-size: 1.5rem; }
    .shield-toggle { display: flex; align-items: center; gap: 0.75rem; }
    .shield-toggle-label { font-size: 0.875rem; font-weight: 500; color: #374151; }
    .toggle-switch { position: relative; width: 48px; height: 24px; background-color: #d1d5db; border-radius: 9999px; cursor: pointer; transition: background-color 0.3s; }
    .toggle-switch.active { background-color: #7c3aed; }
    .toggle-switch::after { content:''; position:absolute; top:2px; left:2px; width:20px; height:20px; background:white; border-radius:50%; transition:transform 0.3s; box-shadow:0 2px 4px rgba(0,0,0,0.1); }
    .toggle-switch.active::after { transform: translateX(24px); }
    .shield-features { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 1rem; }
    @media (max-width: 768px) { .shield-features { grid-template-columns: 1fr; } }
    .shield-feature { background:white; border-radius:8px; padding:1rem; display:flex; align-items:flex-start; gap:0.75rem; border:1px solid #e9d5ff; }
    .shield-feature-icon { width:40px; height:40px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .shield-feature-icon.purple { background:#f3e8ff; color:#7c3aed; }
    .shield-feature-icon.yellow { background:#fef3c7; color:#d97706; }
    .shield-feature-content h4 { font-size:0.875rem; font-weight:600; color:#1f2937; margin-bottom:0.25rem; }
    .shield-feature-content p  { font-size:0.75rem; color:#6b7280; }
    .shield-terms { display:flex; align-items:flex-start; gap:0.5rem; font-size:0.75rem; color:#6b7280; padding-top:1rem; border-top:1px solid #e9d5ff; }
    .shield-terms i { color:#7c3aed; margin-top:0.125rem; }
    .shield-terms a { color:#7c3aed; text-decoration:underline; }
    /* Toast */
    #toast {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        z-index: 9999;
        padding: 0.875rem 1.25rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 500;
        color: white;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        transform: translateY(120%);
        transition: transform 0.3s ease;
        max-width: 380px;
    }
    #toast.show { transform: translateY(0); }
    #toast.toast-success { background: #16a34a; }
    #toast.toast-error   { background: #dc2626; }
    #toast.toast-warning { background: #d97706; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Toast notification -->
    <div id="toast"></div>

    <!-- Page Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Create Order</h1>
            <p class="text-gray-500 text-sm mt-1">Create a new order for shipment via RapidShyp</p>
        </div>
        <a href="{{ route('rapidshyp.b2c.orders.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to Orders
        </a>
    </div>

    <form id="orderForm" onsubmit="return false;" novalidate>
        @csrf

        {{-- ========== ORDER DETAILS ========== --}}
        <div class="form-section">
            <div class="section-title"><i class="fas fa-file-invoice"></i> Order Details</div>
            <div class="grid-3">
                <div>
                    <label class="form-label">Order ID <span class="required">*</span></label>
                    <input type="text" name="orderId" id="orderId" class="form-input"
                           value="{{ $orderId ?? old('orderId') }}" readonly required>
                    <p class="field-hint">Auto-generated unique Order ID</p>
                </div>
                <div>
                    <label class="form-label">Order Date <span class="required">*</span></label>
                    <input type="date" name="orderDate" id="orderDate" class="form-input"
                           value="{{ old('orderDate', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}" required>
                    <p class="field-error" id="err-orderDate">Please select a valid order date.</p>
                </div>
                <div>
                    <label class="form-label">Store Name <span class="required">*</span></label>
                    <input type="text" name="storeName" id="storeName" class="form-input"
                           value="{{ old('storeName', 'DEFAULT') }}" placeholder="DEFAULT" required>
                    <p class="field-error" id="err-storeName">Store name is required.</p>
                </div>
            </div>
        </div>

        {{-- ========== BUYER'S INFO ========== --}}
        <div class="form-section">
            <div class="section-title"><i class="fas fa-user"></i> Buyer's Info</div>

            {{-- Shipping Address --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Shipping Address</h3>

                <div class="grid-5">
                    <div>
                        <label class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" name="shippingAddress[fullName]" id="s_fullName" class="form-input"
                               placeholder="Enter Full Name" maxlength="75" required
                               value="{{ old('shippingAddress.fullName') }}"
                               oninput="validateFullName(this,'err-s_fullName')">
                        {{-- API: firstName+lastName combined 3-75 chars --}}
                        <p class="field-error" id="err-s_fullName">Name must be 3–75 characters.</p>
                    </div>
                    <div>
                        <label class="form-label">Mobile No <span class="required">*</span></label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+91</span>
                            <input type="tel" name="shippingAddress[phone]" id="s_phone" class="form-input rounded-l-none"
                                   placeholder="9876543210" maxlength="10" required
                                   value="{{ old('shippingAddress.phone') }}"
                                   oninput="validatePhone(this,'err-s_phone')">
                        </div>
                        {{-- API: phone must start 6/7/8/9, 10 digits --}}
                        <p class="field-error" id="err-s_phone">Must be 10 digits starting with 6-9.</p>
                    </div>
                    <div>
                        <label class="form-label">Alternate Mobile (Optional)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+91</span>
                            <input type="tel" name="shippingAddress[alternatePhone]" class="form-input rounded-l-none"
                                   placeholder="9876543210" maxlength="10"
                                   value="{{ old('shippingAddress.alternatePhone') }}"
                                   oninput="validatePhoneOptional(this,'err-s_altPhone')">
                        </div>
                        <p class="field-error" id="err-s_altPhone">Must be 10 digits starting with 6-9.</p>
                    </div>
                    <div>
                        <label class="form-label">Email ID (Optional)</label>
                        <input type="email" name="shippingAddress[email]" class="form-input"
                               placeholder="abc@gmail.com"
                               value="{{ old('shippingAddress.email') }}"
                               oninput="validateEmailOptional(this,'err-s_email')">
                        <p class="field-error" id="err-s_email">Enter a valid email address.</p>
                    </div>
                    <div>
                        <label class="form-label">Customer GSTIN (Optional)</label>
                        <input type="text" name="shippingAddress[gstin]" class="form-input"
                               placeholder="Enter GSTIN" maxlength="15"
                               value="{{ old('shippingAddress.gstin') }}">
                    </div>
                </div>

                <div class="grid-2 mt-3">
                    <div>
                        <label class="form-label">Address Line 1 <span class="required">*</span></label>
                        <textarea name="shippingAddress[addressLine1]" id="s_addr1" rows="2" class="form-input"
                                  placeholder="House/Floor No., Building, Street, Locality"
                                  minlength="3" maxlength="100" required
                                  oninput="validateAddressLine(this,'err-s_addr1')">{{ old('shippingAddress.addressLine1') }}</textarea>
                        {{-- API: addressLine1 must be 3-100 chars --}}
                        <p class="field-error" id="err-s_addr1">Address must be 3–100 characters.</p>
                    </div>
                    <div>
                        <label class="form-label">Address Line 2 (Optional)</label>
                        <textarea name="shippingAddress[addressLine2]" id="s_addr2" rows="2" class="form-input"
                                  placeholder="Landmark, Area etc."
                                  minlength="3" maxlength="100"
                                  oninput="validateAddressLineOptional(this,'err-s_addr2')">{{ old('shippingAddress.addressLine2') }}</textarea>
                        <p class="field-error" id="err-s_addr2">If entered, must be 3–100 characters.</p>
                    </div>
                </div>

                <div class="grid-4 mt-3">
                    <div>
                        <label class="form-label">Pin Code <span class="required">*</span></label>
                        <input type="text" name="shippingAddress[pinCode]" id="shippingPincode" class="form-input"
                               placeholder="6-digit pincode" maxlength="6" required
                               value="{{ old('shippingAddress.pinCode') }}"
                               oninput="handlePincodeInput(this,'shippingCity','shippingState','shippingPincodeHint','err-s_pincode')">
                        <p class="field-hint" id="shippingPincodeHint"></p>
                        <p class="field-error" id="err-s_pincode">Enter a valid 6-digit pincode.</p>
                    </div>
                    <div>
                        <label class="form-label">City <span class="required">*</span></label>
                        <input type="text" name="shippingAddress[city]" id="shippingCity" class="form-input bg-gray-50"
                               placeholder="Auto-filled" readonly required>
                    </div>
                    <div>
                        <label class="form-label">State <span class="required">*</span></label>
                        <input type="text" name="shippingAddress[state]" id="shippingState" class="form-input bg-gray-50"
                               placeholder="Auto-filled" readonly required>
                    </div>
                    <div>
                        <label class="form-label">Country</label>
                        <input type="text" name="shippingAddress[country]" class="form-input" value="INDIA" readonly>
                    </div>
                </div>
            </div>

            {{-- Billing same as shipping --}}
            <label class="checkbox-label">
                <input type="checkbox" id="sameAsShipping" name="billingIsShipping" value="1"
                       checked onchange="toggleBillingAddress()">
                <span>Billing address same as shipping address</span>
            </label>

            {{-- Billing Address --}}
            <div id="billingAddressSection" class="hidden mt-6 pt-6 border-t border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Billing Address</h3>

                <div class="grid-5">
                    <div>
                        <label class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" name="billingAddress[fullName]" id="b_fullName" class="form-input"
                               placeholder="Enter Full Name" maxlength="75"
                               value="{{ old('billingAddress.fullName') }}"
                               oninput="validateFullName(this,'err-b_fullName')">
                        <p class="field-error" id="err-b_fullName">Name must be 3–75 characters.</p>
                    </div>
                    <div>
                        <label class="form-label">Mobile No <span class="required">*</span></label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+91</span>
                            <input type="tel" name="billingAddress[phone]" id="b_phone" class="form-input rounded-l-none"
                                   placeholder="9876543210" maxlength="10"
                                   value="{{ old('billingAddress.phone') }}"
                                   oninput="validatePhone(this,'err-b_phone')">
                        </div>
                        <p class="field-error" id="err-b_phone">Must be 10 digits starting with 6-9.</p>
                    </div>
                    <div>
                        <label class="form-label">Alternate Mobile (Optional)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+91</span>
                            <input type="tel" name="billingAddress[alternatePhone]" class="form-input rounded-l-none"
                                   placeholder="9876543210" maxlength="10"
                                   value="{{ old('billingAddress.alternatePhone') }}"
                                   oninput="validatePhoneOptional(this,'err-b_altPhone')">
                        </div>
                        <p class="field-error" id="err-b_altPhone">Must be 10 digits starting with 6-9.</p>
                    </div>
                    <div>
                        <label class="form-label">Email ID <span class="required">*</span></label>
                        <input type="email" name="billingAddress[email]" id="b_email" class="form-input"
                               placeholder="abc@gmail.com"
                               value="{{ old('billingAddress.email') }}"
                               oninput="validateEmail(this,'err-b_email')">
                        <p class="field-error" id="err-b_email">Enter a valid email address.</p>
                    </div>
                    <div>
                        <label class="form-label">Customer GSTIN (Optional)</label>
                        <input type="text" name="billingAddress[gstin]" class="form-input"
                               placeholder="Enter GSTIN" maxlength="15"
                               value="{{ old('billingAddress.gstin') }}">
                    </div>
                </div>

                <div class="grid-2 mt-3">
                    <div>
                        <label class="form-label">Address Line 1 <span class="required">*</span></label>
                        <textarea name="billingAddress[addressLine1]" id="b_addr1" rows="2" class="form-input"
                                  placeholder="House/Floor No., Building, Street, Locality"
                                  minlength="3" maxlength="100"
                                  oninput="validateAddressLine(this,'err-b_addr1')">{{ old('billingAddress.addressLine1') }}</textarea>
                        <p class="field-error" id="err-b_addr1">Address must be 3–100 characters.</p>
                    </div>
                    <div>
                        <label class="form-label">Address Line 2 (Optional)</label>
                        <textarea name="billingAddress[addressLine2]" id="b_addr2" rows="2" class="form-input"
                                  placeholder="Landmark, Area etc."
                                  minlength="3" maxlength="100"
                                  oninput="validateAddressLineOptional(this,'err-b_addr2')">{{ old('billingAddress.addressLine2') }}</textarea>
                        <p class="field-error" id="err-b_addr2">If entered, must be 3–100 characters.</p>
                    </div>
                </div>

                <div class="grid-4 mt-3">
                    <div>
                        <label class="form-label">Pin Code <span class="required">*</span></label>
                        <input type="text" name="billingAddress[pinCode]" id="billingPincode" class="form-input"
                               placeholder="6-digit pincode" maxlength="6"
                               value="{{ old('billingAddress.pinCode') }}"
                               oninput="handlePincodeInput(this,'billingCity','billingState','billingPincodeHint','err-b_pincode')">
                        <p class="field-hint" id="billingPincodeHint"></p>
                        <p class="field-error" id="err-b_pincode">Enter a valid 6-digit pincode.</p>
                    </div>
                    <div>
                        <label class="form-label">City</label>
                        <input type="text" name="billingAddress[city]" id="billingCity" class="form-input bg-gray-50"
                               placeholder="Auto-filled" readonly>
                    </div>
                    <div>
                        <label class="form-label">State</label>
                        <input type="text" name="billingAddress[state]" id="billingState" class="form-input bg-gray-50"
                               placeholder="Auto-filled" readonly>
                    </div>
                    <div>
                        <label class="form-label">Country</label>
                        <input type="text" name="billingAddress[country]" class="form-input" value="INDIA" readonly>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== PRODUCT DETAILS ========== --}}
        <div class="form-section">
            <div class="section-title"><i class="fas fa-box"></i> Product Details</div>
            <div id="productsContainer"></div>
            <button type="button" onclick="addProduct()" class="btn-secondary mt-2">
                <i class="fas fa-plus mr-2"></i> Add Product
            </button>
        </div>

        {{-- ========== PAYMENT DETAILS ========== --}}
        <div class="form-section">
            <div class="section-title"><i class="fas fa-credit-card"></i> Payment Details</div>

            <div class="radio-group mb-4">
                <label class="radio-label">
                    <input type="radio" name="paymentMethod" value="PREPAID"
                           {{ old('paymentMethod') == 'PREPAID' ? 'checked' : '' }} onchange="togglePaymentFields()">
                    <span>Prepaid</span>
                </label>
                <label class="radio-label">
                    <input type="radio" name="paymentMethod" value="COD"
                           {{ old('paymentMethod', 'COD') == 'COD' ? 'checked' : '' }} onchange="togglePaymentFields()">
                    <span>Cash On Delivery</span>
                </label>
            </div>

            <div class="mb-4">
                <label class="checkbox-label" style="margin:0;">
                    <input type="checkbox" id="toggleOptionalCharges" onchange="toggleOptionalChargesFields()">
                    <span class="text-sm font-medium" id="toggleLabel">
                        + Add Shipping Charges, Gift Wrap, Transaction Fee <span class="text-gray-500">(Optional)</span>
                    </span>
                </label>
            </div>

            <div id="optionalChargesSection" class="hidden mb-4">
                <div class="grid-4">
                    <div class="payment-field">
                        <label>Shipping Charges</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-purple-50 text-purple-700 text-sm">₹</span>
                            <input type="number" name="shippingCharges" id="shippingCharges" step="0.01"
                                   class="form-input rounded-l-none" placeholder="0" min="0"
                                   value="{{ old('shippingCharges', 0) }}" onchange="calculateTotals()">
                        </div>
                    </div>
                    <div class="payment-field">
                        <label>Transaction Fee</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-purple-50 text-purple-700 text-sm">₹</span>
                            <input type="number" name="transactionCharges" id="transactionCharges" step="0.01"
                                   class="form-input rounded-l-none" placeholder="0" min="0"
                                   value="{{ old('transactionCharges', 0) }}" onchange="calculateTotals()">
                        </div>
                    </div>
                    <div class="payment-field">
                        <label>Gift Wrap</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-purple-50 text-purple-700 text-sm">₹</span>
                            <input type="number" name="giftWrapCharges" id="giftWrapCharges" step="0.01"
                                   class="form-input rounded-l-none" placeholder="0" min="0"
                                   value="{{ old('giftWrapCharges', 0) }}" onchange="calculateTotals()">
                        </div>
                    </div>
                    <div class="payment-field">
                        <label>Discount</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-purple-50 text-purple-700 text-sm">₹</span>
                            <input type="number" name="totalDiscount" id="totalDiscount" step="0.01"
                                   class="form-input rounded-l-none" placeholder="0" min="0"
                                   value="{{ old('totalDiscount', 0) }}" onchange="calculateTotals()">
                        </div>
                    </div>
                </div>
                <div id="codSpecificFields" class="grid-2 mt-3 hidden">
                    <div class="payment-field">
                        <label>Prepaid Amount (Partial Payment for COD)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-purple-50 text-purple-700 text-sm">₹</span>
                            <input type="number" name="prepaidAmount" id="prepaidAmount" step="0.01"
                                   class="form-input rounded-l-none" placeholder="0" min="0"
                                   value="{{ old('prepaidAmount', 0) }}" onchange="calculateTotals()">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg overflow-hidden">
                <table class="w-full">
                    <tbody>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">Sub-total for Product(s)</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">₹<span id="subtotal">0.00</span></td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">Shipping Charges</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">+ ₹<span id="shippingDisplay">0.00</span></td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">Transaction Fee</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">+ ₹<span id="transactionDisplay">0.00</span></td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">Gift Wrap</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">+ ₹<span id="giftWrapDisplay">0.00</span></td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-3 text-sm text-gray-700">Discount</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">- ₹<span id="discountDisplay">0.00</span></td>
                        </tr>
                        <tr class="border-b border-gray-200 bg-white">
                            <td class="px-4 py-3 text-base font-semibold text-gray-900">Total Order Value <span class="required">*</span></td>
                            <td class="px-4 py-3 text-base font-bold text-gold text-right">₹<span id="totalOrderValueDisplay">0.00</span></td>
                        </tr>
                        <tr id="collectableRow" class="hidden">
                            <td class="px-4 py-3 text-base font-semibold text-gray-900">Total Collectable Value (COD)</td>
                            <td class="px-4 py-3 text-base font-bold text-gold text-right">₹<span id="collectableValueDisplay">0.00</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ========== RAPIDSHYP SHIELD ========== --}}
        <div id="rapidShypShieldSection" class="shield-section hidden">
            <div class="shield-header">
                <div class="shield-title">
                    <i class="fas fa-shield-alt"></i>
                    <span>Your Shipment Is Covered Under RapidShyp Shield!</span>
                </div>
                <div class="shield-toggle">
                    <span class="shield-toggle-label">Shield Your Shipment</span>
                    <div class="toggle-switch" id="shieldToggle" onclick="toggleShield()"></div>
                </div>
            </div>
            <p class="shield-message" style="font-size:.875rem;color:#6b7280;margin-bottom:1.25rem;">
                You have successfully opted for security coverage on your order(s)
            </p>
            <div class="shield-features">
                <div class="shield-feature">
                    <div class="shield-feature-icon purple"><i class="fas fa-shield-alt fa-lg"></i></div>
                    <div class="shield-feature-content"><h4>Up to ₹500000</h4><p>Security Coverage</p></div>
                </div>
                <div class="shield-feature">
                    <div class="shield-feature-icon yellow"><i class="fas fa-clock fa-lg"></i></div>
                    <div class="shield-feature-content"><h4>Within 7-Days</h4><p>Claim Settlement</p></div>
                </div>
                <div class="shield-feature">
                    <div class="shield-feature-icon purple"><i class="fas fa-boxes fa-lg"></i></div>
                    <div class="shield-feature-content"><h4>10,000+</h4><p>Shipments Shielded</p></div>
                </div>
            </div>
            <div class="shield-terms">
                <i class="fas fa-info-circle"></i>
                <span>
                    <a href="#" class="font-medium">Terms And Condition</a>
                    *Applicable for all shipments greater than ₹2500. Without RapidShyp Shield, shipment damage and loss liability is limited to ₹2500 only.
                </span>
            </div>
            <input type="hidden" name="rapidShypShield" id="rapidShypShieldInput" value="0">
        </div>

        {{-- Hidden totals --}}
        <input type="hidden" name="totalOrderValue" id="totalOrderValueHidden" value="0">
        <input type="hidden" name="collectableAmount" id="collectableAmountHidden" value="0">

        <div class="flex gap-4 justify-end pb-8">
            <button type="button" onclick="window.history.back()" class="btn-secondary">
                <i class="fas fa-times mr-2"></i> Cancel
            </button>
            <button type="submit" class="btn-primary" id="submitBtn" onclick="submitOrder()">
                <i class="fas fa-check mr-2"></i> Create Order
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let productCount  = 0;
let isShieldEnabled = false;
const warehouses  = @json($warehouses ?? []);

// ============================================================
// REAL-TIME VALIDATION FUNCTIONS (per API docs constraints)
// ============================================================

/** Full name: combined firstName+lastName must be 3-75 chars (API docs) */
function validateFullName(input, errId) {
    const val = input.value.trim();
    const ok  = val.length >= 3 && val.length <= 75;
    setFieldState(input, errId, ok || val.length === 0, ok || val.length === 0);
    return ok;
}

/** Phone: must start 6-9, exactly 10 digits (API docs) */
function validatePhone(input, errId) {
    const val = input.value.replace(/\D/g, '');
    input.value = val; // strip non-digits live
    const ok  = /^[6-9][0-9]{9}$/.test(val);
    const empty = val.length === 0;
    setFieldState(input, errId, empty ? false : ok, !empty && ok);
    return ok;
}

function validatePhoneOptional(input, errId) {
    const val = input.value.replace(/\D/g, '');
    input.value = val;
    if (val.length === 0) { clearFieldState(input, errId); return true; }
    const ok = /^[6-9][0-9]{9}$/.test(val);
    setFieldState(input, errId, ok, ok);
    return ok;
}

/** Email required */
function validateEmail(input, errId) {
    const val = input.value.trim();
    const ok  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
    setFieldState(input, errId, val.length === 0 ? false : ok, ok);
    return ok;
}

function validateEmailOptional(input, errId) {
    const val = input.value.trim();
    if (!val) { clearFieldState(input, errId); return true; }
    const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
    setFieldState(input, errId, ok, ok);
    return ok;
}

/** Address line 1: 3-100 chars (API docs) */
function validateAddressLine(input, errId) {
    const val = input.value.trim();
    const ok  = val.length >= 3 && val.length <= 100;
    setFieldState(input, errId, val.length === 0 ? false : ok, ok);
    return ok;
}

/** Address line 2: optional, but if filled must be 3-100 (API docs) */
function validateAddressLineOptional(input, errId) {
    const val = input.value.trim();
    if (!val) { clearFieldState(input, errId); return true; }
    const ok = val.length >= 3 && val.length <= 100;
    setFieldState(input, errId, ok, ok);
    return ok;
}

/** itemName: 3-200 chars (API docs) */
function validateItemName(input, errId) {
    const val = input.value.trim();
    const ok  = val.length >= 3 && val.length <= 200;
    setFieldState(input, errId, val.length === 0 ? false : ok, ok);
    return ok;
}

/** unitPrice: > 0 (API docs) */
function validateUnitPrice(input, errId) {
    const val = parseFloat(input.value);
    const ok  = !isNaN(val) && val > 0;
    setFieldState(input, errId, input.value === '' ? false : ok, ok);
    return ok;
}

/** units: integer >= 1 (API docs) */
function validateUnits(input, errId) {
    const val = parseInt(input.value);
    const ok  = !isNaN(val) && val >= 1;
    setFieldState(input, errId, input.value === '' ? false : ok, ok);
    return ok;
}

/** productWeight: optional but if entered >= 0 */
function validateWeight(input, errId) {
    const val = parseFloat(input.value);
    if (input.value === '' || input.value === null) { clearFieldState(input, errId); return true; }
    const ok = !isNaN(val) && val >= 0;
    setFieldState(input, errId, ok, ok);
    return ok;
}

// ── Helpers ──────────────────────────────────────────────────────────────────

function setFieldState(input, errId, valid, showValid) {
    const errEl = document.getElementById(errId);
    if (valid) {
        input.classList.remove('is-invalid');
        if (showValid) input.classList.add('is-valid');
        if (errEl) errEl.classList.remove('show');
    } else {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        if (errEl) errEl.classList.add('show');
    }
}

function clearFieldState(input, errId) {
    input.classList.remove('is-valid', 'is-invalid');
    const errEl = document.getElementById(errId);
    if (errEl) errEl.classList.remove('show');
}

// ── Pincode auto-fill ─────────────────────────────────────────────────────────

const _pincodeTimers = {};

function handlePincodeInput(input, cityId, stateId, hintId, errId) {
    const val    = input.value.replace(/\D/g, '');
    input.value  = val;
    const hintEl = document.getElementById(hintId);
    const errEl  = document.getElementById(errId);

    if (val.length < 6) {
        clearFieldState(input, errId);
        if (hintEl) hintEl.textContent = '';
        return;
    }

    if (!/^\d{6}$/.test(val)) {
        setFieldState(input, errId, false, false);
        return;
    }

    if (hintEl) { hintEl.textContent = 'Verifying…'; hintEl.style.color = '#6b7280'; }
    clearTimeout(_pincodeTimers[hintId]);
    _pincodeTimers[hintId] = setTimeout(() => fetchPincode(val, input, cityId, stateId, hintId, errId), 500);
}

async function fetchPincode(pincode, input, cityId, stateId, hintId, errId) {
    const hintEl = document.getElementById(hintId);
    try {
        const res  = await fetch(`https://api.postalpincode.in/pincode/${pincode}`);
        const data = await res.json();
        if (data[0]?.Status === 'Success' && data[0].PostOffice?.length) {
            const po = data[0].PostOffice[0];
            const cityEl  = document.getElementById(cityId);
            const stateEl = document.getElementById(stateId);
            if (cityEl)  cityEl.value  = po.District || '';
            if (stateEl) stateEl.value = po.State    || '';
            if (hintEl)  { hintEl.textContent = `✓ ${po.District}, ${po.State}`; hintEl.style.color = '#22c55e'; }
            setFieldState(input, errId, true, true);
        } else {
            if (hintEl) { hintEl.textContent = '✗ Invalid pincode'; hintEl.style.color = '#ef4444'; }
            setFieldState(input, errId, false, false);
        }
    } catch {
        if (hintEl) { hintEl.textContent = '⚠ Could not verify'; hintEl.style.color = '#f59e0b'; }
    }
}

// ============================================================
// TOGGLE FUNCTIONS
// ============================================================

function toggleBillingAddress() {
    const isSame  = document.getElementById('sameAsShipping').checked;
    const section = document.getElementById('billingAddressSection');
    isSame ? section.classList.add('hidden') : section.classList.remove('hidden');
}

function toggleOptionalChargesFields() {
    const checked = document.getElementById('toggleOptionalCharges').checked;
    const section = document.getElementById('optionalChargesSection');
    if (checked) {
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
        ['shippingCharges','transactionCharges','giftWrapCharges','totalDiscount','prepaidAmount']
            .forEach(id => { const el = document.getElementById(id); if (el) el.value = 0; });
    }
    calculateTotals();
}

function togglePaymentFields() {
    const isCOD = document.querySelector('[name="paymentMethod"][value="COD"]').checked;
    const codEl = document.getElementById('codSpecificFields');
    const rowEl = document.getElementById('collectableRow');
    const label = document.getElementById('toggleLabel');

    if (isCOD) {
        codEl?.classList.remove('hidden');
        rowEl?.classList.remove('hidden');
        label.innerHTML = '+ Add Shipping Charges, Gift Wrap, Transaction Fee, Prepaid Amount <span class="text-gray-500">(Optional)</span>';
    } else {
        codEl?.classList.add('hidden');
        rowEl?.classList.add('hidden');
        label.innerHTML = '+ Add Shipping Charges, Gift Wrap, Transaction Fee <span class="text-gray-500">(Optional)</span>';
        const pa = document.getElementById('prepaidAmount');
        if (pa) pa.value = 0;
    }
    calculateTotals();
}

function toggleShield() {
    isShieldEnabled = !isShieldEnabled;
    const toggle = document.getElementById('shieldToggle');
    const input  = document.getElementById('rapidShypShieldInput');
    toggle.classList.toggle('active', isShieldEnabled);
    input.value = isShieldEnabled ? '1' : '0';
}

// ============================================================
// PRODUCT FUNCTIONS
// ============================================================

function addProduct() {
    productCount++;
    const container   = document.getElementById('productsContainer');
    const productRow  = document.createElement('div');
    productRow.className = 'product-row';
    productRow.id        = `product-${productCount}`;

    let warehouseOptions = '<option value="">— Use Order Level Pickup —</option>';
    if (warehouses?.length) {
        warehouses.forEach(w => {
            const name = w.warehouse_name || w.address_name || '';
            if (name) warehouseOptions += `<option value="${name}">${name}</option>`;
        });
    }

    const idx = productCount;
    productRow.innerHTML = `
        <button type="button" onclick="removeProduct(${idx})" class="remove-product" title="Remove">
            <i class="fas fa-times"></i>
        </button>
        <h4 class="text-sm font-semibold text-gray-700 mb-3">Product #${idx}</h4>

        <div class="grid-4">
            <div>
                <label class="form-label">Product Name <span class="required">*</span></label>
                <input type="text" name="orderItems[${idx}][itemName]" class="form-input item-name"
                       placeholder="Min 3 characters" minlength="3" maxlength="200" required
                       oninput="validateItemName(this,'err-item-${idx}-name')">
                <p class="field-error" id="err-item-${idx}-name">Name must be 3–200 characters.</p>
            </div>
            <div>
                <label class="form-label">SKU</label>
                <input type="text" name="orderItems[${idx}][sku]" class="form-input"
                       placeholder="SKU code" maxlength="200">
            </div>
            <div>
                <label class="form-label">Qty <span class="required">*</span></label>
                <input type="number" name="orderItems[${idx}][units]" class="form-input product-qty"
                       placeholder="1" min="1" value="1" required
                       oninput="validateUnits(this,'err-item-${idx}-qty'); calculateProductTotal(document.getElementById('product-${idx}'))">
                <p class="field-error" id="err-item-${idx}-qty">Quantity must be at least 1.</p>
            </div>
            <div>
                <label class="form-label">Selling Price (₹) <span class="required">*</span></label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">₹</span>
                    <input type="number" name="orderItems[${idx}][unitPrice]" step="0.01"
                           class="form-input rounded-l-none product-price" placeholder="0.00" min="0.01" required
                           oninput="validateUnitPrice(this,'err-item-${idx}-price'); calculateProductTotal(document.getElementById('product-${idx}'))">
                </div>
                <p class="field-error" id="err-item-${idx}-price">Price must be greater than 0.</p>
            </div>
        </div>

        <div class="grid-4 mt-3">
            <div>
                <label class="form-label">Tax % <span class="required">*</span></label>
                <div class="flex">
                    <input type="number" name="orderItems[${idx}][tax]" step="0.01"
                           class="form-input rounded-r-none" placeholder="0" min="0" max="100" value="0" required>
                    <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">%</span>
                </div>
            </div>
            <div>
                <label class="form-label">HSN Code</label>
                <input type="text" name="orderItems[${idx}][hsn]" class="form-input" placeholder="HSN Code" maxlength="50">
            </div>
            <div>
                <label class="form-label">Weight (kg) <small class="text-gray-500">e.g. 0.5 = 500g</small></label>
                <input type="number" name="orderItems[${idx}][productWeight]" step="0.001"
                       class="form-input product-weight" placeholder="0.500" min="0"
                       oninput="validateWeight(this,'err-item-${idx}-wt'); calculateProductTotal(document.getElementById('product-${idx}'))">
                <p class="field-error" id="err-item-${idx}-wt">Weight must be 0 or greater.</p>
            </div>
            <div>
                <label class="form-label">Pickup Location</label>
                <select name="orderItems[${idx}][pickupAddressName]" class="form-input">
                    ${warehouseOptions}
                </select>
            </div>
        </div>

        <div class="grid-3 mt-3">
            <div>
                <label class="form-label">Length (cm)</label>
                <input type="number" name="orderItems[${idx}][productLength]" step="0.1" class="form-input" placeholder="0" min="0">
            </div>
            <div>
                <label class="form-label">Breadth (cm)</label>
                <input type="number" name="orderItems[${idx}][productBreadth]" step="0.1" class="form-input" placeholder="0" min="0">
            </div>
            <div>
                <label class="form-label">Height (cm)</label>
                <input type="number" name="orderItems[${idx}][productHeight]" step="0.1" class="form-input" placeholder="0" min="0">
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Description</label>
            <textarea name="orderItems[${idx}][description]" rows="2" class="form-input" placeholder="Product description" maxlength="500"></textarea>
        </div>

        <div class="grid-2 mt-3">
            <div>
                <label class="form-label">Brand</label>
                <input type="text" name="orderItems[${idx}][brand]" class="form-input" placeholder="Brand Name" maxlength="100">
            </div>
            <div>
                <label class="form-label">Country of Origin</label>
                <input type="text" name="orderItems[${idx}][countryOfOrigin]" class="form-input" placeholder="India" value="India">
            </div>
        </div>

        <div class="flex gap-4 mt-3">
            <label class="checkbox-label" style="margin:0;">
                <input type="checkbox" name="orderItems[${idx}][isFragile]" value="1">
                <span>Fragile Item</span>
            </label>
            <label class="checkbox-label" style="margin:0;">
                <input type="checkbox" name="orderItems[${idx}][isPersonalisable]" value="1">
                <span>Personalisable</span>
            </label>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="grid-2">
                <div>
                    <label class="form-label">Line Total</label>
                    <input type="text" class="form-input bg-gray-100 product-total" readonly value="₹0.00">
                </div>
            </div>
        </div>
    `;
    container.appendChild(productRow);
}

function removeProduct(id) {
    document.getElementById(`product-${id}`)?.remove();
    calculateTotals();
}

function calculateProductTotal(row) {
    if (!row) return;
    const price = parseFloat(row.querySelector('.product-price')?.value) || 0;
    const qty   = parseFloat(row.querySelector('.product-qty')?.value)   || 0;
    const total = price * qty;
    const el    = row.querySelector('.product-total');
    if (el) el.value = `₹${total.toFixed(2)}`;
    calculateTotals();
}

function calculateTotals() {
    let subtotal = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        const p = parseFloat(row.querySelector('.product-price')?.value) || 0;
        const q = parseFloat(row.querySelector('.product-qty')?.value)   || 0;
        subtotal += p * q;
    });

    const toggle = document.getElementById('toggleOptionalCharges');
    const on     = toggle?.checked;
    const shipping    = on ? (parseFloat(document.getElementById('shippingCharges')?.value)    || 0) : 0;
    const transaction = on ? (parseFloat(document.getElementById('transactionCharges')?.value) || 0) : 0;
    const giftWrap    = on ? (parseFloat(document.getElementById('giftWrapCharges')?.value)    || 0) : 0;
    const discount    = on ? (parseFloat(document.getElementById('totalDiscount')?.value)      || 0) : 0;
    const prepaid     = on ? (parseFloat(document.getElementById('prepaidAmount')?.value)      || 0) : 0;

    const totalOrderValue  = subtotal + shipping + transaction + giftWrap - discount;
    const isCOD            = document.querySelector('[name="paymentMethod"][value="COD"]')?.checked;
    const collectableValue = isCOD ? Math.max(0, totalOrderValue - prepaid) : 0;

    const set = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val.toFixed(2); };
    set('subtotal',              subtotal);
    set('shippingDisplay',       shipping);
    set('transactionDisplay',    transaction);
    set('giftWrapDisplay',       giftWrap);
    set('discountDisplay',       discount);
    set('totalOrderValueDisplay',totalOrderValue);
    set('collectableValueDisplay',collectableValue);

    const hv = document.getElementById('totalOrderValueHidden');
    const cv = document.getElementById('collectableAmountHidden');
    if (hv) hv.value = totalOrderValue.toFixed(2);
    if (cv) cv.value = collectableValue.toFixed(2);

    // Shield
    const shield = document.getElementById('rapidShypShieldSection');
    if (shield) {
        if (totalOrderValue >= 2500) shield.classList.remove('hidden');
        else { shield.classList.add('hidden'); if (isShieldEnabled) toggleShield(); }
    }
}

// ============================================================
// FORM SUBMIT
// ============================================================

function submitOrder() {
    // ── 1. Basic product check ────────────────────────────────────────────
    if (document.querySelectorAll('.product-row').length === 0) {
        showToast('Please add at least one product.', 'error');
        return;
    }

    // ── 2. Validate all required fields ──────────────────────────────────
    let hasErrors = false;

    // Full name
    const sName = document.getElementById('s_fullName');
    if (sName && !validateFullName(sName, 'err-s_fullName')) hasErrors = true;

    // Shipping phone
    const sPhone = document.getElementById('s_phone');
    if (sPhone && !validatePhone(sPhone, 'err-s_phone')) hasErrors = true;

    // Shipping address
    const sAddr1 = document.getElementById('s_addr1');
    if (sAddr1 && !validateAddressLine(sAddr1, 'err-s_addr1')) hasErrors = true;

    // Shipping pincode
    const sPincode = document.getElementById('shippingPincode');
    if (sPincode && !/^\d{6}$/.test(sPincode.value)) {
        setFieldState(sPincode, 'err-s_pincode', false, false);
        hasErrors = true;
    }

    // Billing (when not same)
    if (!document.getElementById('sameAsShipping').checked) {
        const bName  = document.getElementById('b_fullName');
        const bPhone = document.getElementById('b_phone');
        const bEmail = document.getElementById('b_email');
        const bAddr1 = document.getElementById('b_addr1');
        const bPincode = document.getElementById('billingPincode');
        if (bName  && !validateFullName(bName,  'err-b_fullName'))    hasErrors = true;
        if (bPhone && !validatePhone(bPhone,    'err-b_phone'))        hasErrors = true;
        if (bEmail && !validateEmail(bEmail,    'err-b_email'))        hasErrors = true;
        if (bAddr1 && !validateAddressLine(bAddr1, 'err-b_addr1'))     hasErrors = true;
        if (bPincode && !/^\d{6}$/.test(bPincode.value)) {
            setFieldState(bPincode, 'err-b_pincode', false, false);
            hasErrors = true;
        }
    }

    // Products
    document.querySelectorAll('.product-row').forEach((row, i) => {
        const idx       = i + 1;
        const nameInput = row.querySelector('.item-name');
        const priceInput= row.querySelector('.product-price');
        const qtyInput  = row.querySelector('.product-qty');
        if (nameInput  && !validateItemName(nameInput,  `err-item-${nameInput.name.match(/\[(\d+)\]/)?.[1]}-name`))  hasErrors = true;
        if (priceInput && !validateUnitPrice(priceInput,`err-item-${priceInput.name.match(/\[(\d+)\]/)?.[1]}-price`))hasErrors = true;
        if (qtyInput   && !validateUnits(qtyInput,      `err-item-${qtyInput.name.match(/\[(\d+)\]/)?.[1]}-qty`))    hasErrors = true;
    });

    if (hasErrors) {
        showToast('Please fix the highlighted errors before submitting.', 'error');
        // scroll to first error
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    // ── 3. Build package dimensions from products ─────────────────────────
    let totalWeight = 0, totalLength = 0, totalBreadth = 0, totalHeight = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        const weight  = parseFloat(row.querySelector('.product-weight')?.value) || 0;
        const qty     = parseInt(row.querySelector('.product-qty')?.value)       || 1;
        const length  = parseFloat(row.querySelector('[name$="[productLength]"]')?.value)  || 0;
        const breadth = parseFloat(row.querySelector('[name$="[productBreadth]"]')?.value) || 0;
        const height  = parseFloat(row.querySelector('[name$="[productHeight]"]')?.value)  || 0;
        totalWeight += weight * qty;
        if (length  > totalLength)  totalLength  = length;
        if (breadth > totalBreadth) totalBreadth = breadth;
        if (height  > totalHeight)  totalHeight  = height;
    });

    if (totalWeight <= 0) {
        showToast('Please enter product weight (kg) for at least one product.', 'error');
        return;
    }

    // ── 4. Build payload ──────────────────────────────────────────────────
    const sameShipping = document.getElementById('sameAsShipping').checked;
    const fullNameVal  = document.querySelector('[name="shippingAddress[fullName]"]').value.trim();
    const nameParts    = fullNameVal.split(' ');

    const payload = {
        orderId:          document.querySelector('[name="orderId"]').value,
        orderDate:        document.querySelector('[name="orderDate"]').value,
        storeName:        document.querySelector('[name="storeName"]').value,
        billingIsShipping: sameShipping,

        shippingAddress: {
            firstName:    nameParts[0] || '',
            lastName:     nameParts.slice(1).join(' ') || '',
            addressLine1: document.querySelector('[name="shippingAddress[addressLine1]"]').value,
            addressLine2: document.querySelector('[name="shippingAddress[addressLine2]"]')?.value || '',
            pinCode:      document.querySelector('[name="shippingAddress[pinCode]"]').value,
            city:         document.getElementById('shippingCity').value,
            state:        document.getElementById('shippingState').value,
            country:      'INDIA',
            email:        document.querySelector('[name="shippingAddress[email]"]')?.value || '',
            phone:        document.querySelector('[name="shippingAddress[phone]"]').value,
        },

        orderItems: Array.from(document.querySelectorAll('.product-row')).map(row => ({
            itemName:         row.querySelector('[name$="[itemName]"]').value,
            sku:              row.querySelector('[name$="[sku]"]')?.value          || '',
            description:      row.querySelector('[name$="[description]"]')?.value || '',
            units:            parseInt(row.querySelector('[name$="[units]"]').value),
            unitPrice:        parseFloat(row.querySelector('[name$="[unitPrice]"]').value),
            tax:              parseFloat(row.querySelector('[name$="[tax]"]')?.value) || 0,
            hsn:              row.querySelector('[name$="[hsn]"]')?.value          || '',
            productLength:    parseFloat(row.querySelector('[name$="[productLength]"]')?.value)  || 0,
            productBreadth:   parseFloat(row.querySelector('[name$="[productBreadth]"]')?.value) || 0,
            productHeight:    parseFloat(row.querySelector('[name$="[productHeight]"]')?.value)  || 0,
            productWeight:    parseFloat(row.querySelector('[name$="[productWeight]"]')?.value)  || 0,
            brand:            row.querySelector('[name$="[brand]"]')?.value        || '',
            imageURL:         '',
            isFragile:        row.querySelector('[name$="[isFragile]"]')?.checked  || false,
            isPersonalisable: row.querySelector('[name$="[isPersonalisable]"]')?.checked || false,
            pickupAddressName:row.querySelector('[name$="[pickupAddressName]"]')?.value || '',
        })),

        paymentMethod:     document.querySelector('[name="paymentMethod"]:checked').value,
        shippingCharges:   parseFloat(document.getElementById('shippingCharges')?.value)    || 0,
        giftWrapCharges:   parseFloat(document.getElementById('giftWrapCharges')?.value)    || 0,
        transactionCharges:parseFloat(document.getElementById('transactionCharges')?.value) || 0,
        totalDiscount:     parseFloat(document.getElementById('totalDiscount')?.value)      || 0,
        totalOrderValue:   parseFloat(document.getElementById('totalOrderValueHidden').value),
        prepaidAmount:     parseFloat(document.getElementById('prepaidAmount')?.value)      || 0,
        collectableAmount: parseFloat(document.getElementById('collectableAmountHidden').value),

        packageDetails: {
            packageLength:  totalLength,
            packageBreadth: totalBreadth,
            packageHeight:  totalHeight,
            packageWeight:  parseFloat(totalWeight.toFixed(3)), // KG — per API docs
        },
    };

    // Billing only when different
    if (!sameShipping) {
        const bFull = document.querySelector('[name="billingAddress[fullName]"]')?.value.trim() || '';
        const bParts = bFull.split(' ');
        payload.billingAddress = {
            firstName:    bParts[0] || '',
            lastName:     bParts.slice(1).join(' ') || '',
            addressLine1: document.querySelector('[name="billingAddress[addressLine1]"]')?.value || '',
            addressLine2: document.querySelector('[name="billingAddress[addressLine2]"]')?.value || '',
            pinCode:      document.querySelector('[name="billingAddress[pinCode]"]')?.value      || '',
            city:         document.getElementById('billingCity')?.value  || '',
            state:        document.getElementById('billingState')?.value || '',
            country:      'INDIA',
            email:        document.querySelector('[name="billingAddress[email]"]')?.value  || '',
            phone:        document.querySelector('[name="billingAddress[phone]"]')?.value  || '',
        };
    }

    // ── 5. Disable button ─────────────────────────────────────────────────
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creating Order…';
    }
    const resetBtn = () => {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i> Create Order';
        }
    };

    // ── 6. POST to controller ─────────────────────────────────────────────
    fetch("{{ route('rapidshyp.b2c.orders.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept':       'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
        },
        body: JSON.stringify(payload),
    })
    .then(res => res.json().then(data => ({ status: res.status, data })))
    .then(({ status, data }) => {
        if (data.success) {
            showToast(data.message || 'Order created successfully!', 'success');
            setTimeout(() => window.location.href = data.redirectUrl || "{{ route('rapidshyp.b2c.orders.index') }}", 1200);
        } else if (data.api_failed && data.redirectUrl) {
            // Order saved locally, API issue — redirect with warning
            showToast(data.message, 'warning');
            setTimeout(() => window.location.href = data.redirectUrl, 2000);
        } else if (data.errors) {
            const msgs = Object.values(data.errors).flat().join('\n');
            showToast('Validation errors:\n' + msgs, 'error');
            resetBtn();
        } else {
            showToast(data.message || 'Order creation failed.', 'error');
            resetBtn();
        }
    })
    .catch(err => {
        console.error('Fetch error:', err);
        showToast('Network error. Please try again.', 'error');
        resetBtn();
    });
}

// ============================================================
// TOAST
// ============================================================

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = message;
    toast.className   = `show toast-${type}`;
    setTimeout(() => toast.classList.remove('show'), type === 'success' ? 3000 : 5000);
}

// ============================================================
// INIT
// ============================================================

window.addEventListener('DOMContentLoaded', function () {
    addProduct();
    togglePaymentFields();
    calculateTotals();

    @if(old('shippingAddress.city'))
        document.getElementById('shippingCity').value = "{{ old('shippingAddress.city') }}";
    @endif
    @if(old('shippingAddress.state'))
        document.getElementById('shippingState').value = "{{ old('shippingAddress.state') }}";
    @endif
});
</script>
@endpush