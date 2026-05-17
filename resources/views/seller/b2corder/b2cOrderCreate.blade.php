@extends('seller.layouts.app')
@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    {{-- Alert Messages --}}
    @if (session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm mb-6">
        <div class="flex items-center">
            <i class="fa fa-exclamation-triangle text-red-500 mr-3"></i>
            <div><strong class="text-red-700">Error:</strong> <span class="text-red-600">{{ session('error') }}</span></div>
        </div>
    </div>
    @endif
    
    @if ($errors->any())
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-md shadow-sm mb-6">
        <div class="flex">
            <i class="fa fa-list-ul text-yellow-500 mr-3 mt-1"></i>
            <div>
                <strong class="text-yellow-700">Please fix the following issues:</strong>
                <ul class="list-disc list-inside mt-2 text-sm text-yellow-600">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    
    @if (session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm mb-6">
        <div class="flex items-center">
            <i class="fa fa-check-circle text-green-500 mr-3"></i>
            <div class="text-green-700">{{ session('success') }}</div>
        </div>
    </div>
    @endif

    <form action="{{ route('b2c.order.store') }}" method="POST" id="b2cOrderForm">
        @csrf
        {{-- Hidden Input for Pickup Address ID (Default Warehouse) --}}
        <input type="hidden" name="pick_address_ID" id="selected_pickup_id" value="{{ old('pick_address_ID') }}">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3 space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Buyer Details</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Buyer Name <span class="text-red-500">*</span></label>
                            <input type="text" name="buyer_name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('buyer_name') border-red-500 @enderror" placeholder="Enter Buyer's Name" value="{{ old('buyer_name') }}" required>
                            @error('buyer_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" name="phone_number" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('phone_number') border-red-500 @enderror" placeholder="Enter Phone Number" value="{{ old('phone_number') }}" maxlength="10" required>
                            @error('phone_number') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alternate Phone</label>
                            <input type="text" name="alt_phone_number" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="Enter Alternate Number" value="{{ old('alt_phone_number') }}" maxlength="10">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Id</label>
                            <input type="email" name="email_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('email_id') border-red-500 @enderror" placeholder="Enter Email Id" value="{{ old('email_id') }}">
                            @error('email_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Buyer Address</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Complete Address <span class="text-red-500">*</span></label>
                            <textarea name="complete_address" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('complete_address') border-red-500 @enderror" placeholder="Enter Complete Address" required>{{ old('complete_address') }}</textarea>
                            @error('complete_address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Landmark</label>
                            <textarea name="landmark" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="Enter Landmark">{{ old('landmark') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pincode <span class="text-red-500">*</span></label>
                            <input type="text" name="pincode" id="pincodeInput" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('pincode') border-red-500 @enderror" placeholder="Enter 6-digit Pincode" value="{{ old('pincode') }}" maxlength="6" required>
                            @error('pincode') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            <span id="pincodeStatus" class="text-xs mt-1 block"></span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                            <input type="text" name="city" id="cityInput" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('city') border-red-500 @enderror" placeholder="Enter City" value="{{ old('city') }}" required>
                            @error('city') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">State <span class="text-red-500">*</span></label>
                            <input type="text" name="state" id="stateInput" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('state') border-red-500 @enderror" placeholder="Enter State" value="{{ old('state') }}" required>
                            @error('state') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                            <select name="country" id="countryInput" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" required>
                                <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Name (Optional)</label>
                            <input type="text" name="company_name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="Enter Company Name" value="{{ old('company_name') }}">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">GSTIN Number (Optional)</label>
                            <input type="text" name="gstin_number" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="Enter GSTIN Number" value="{{ old('gstin_number') }}">
                        </div>
                        <div class="md:col-span-3">
                            <div class="flex items-center">
                                <input class="h-4 w-4 text-[#D4AF37] border-gray-300 rounded focus:ring-[#D4AF37]" type="checkbox" id="sameAddress" name="same_billing_address" value="1" {{ old('same_billing_address', true) ? 'checked' : '' }}>
                                <label class="ml-2 block text-sm text-gray-700" for="sameAddress">Billing address same as Shipping address</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Package Dimensions</h5>
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 items-end">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Weight (Kg) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.001" name="weight" oninput="validateWeight(this)" max="20" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('weight') border-red-500 @enderror" placeholder="0" value="{{ old('weight') }}" required>
                            @error('weight') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            <span class="text-xs text-gray-400 mt-1 block">Max: 20 Kg (20kg)</span>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Length (cm) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.001" name="length" oninput="calculateVolumetric()" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('length') border-red-500 @enderror" placeholder="0" value="{{ old('length') }}" required>
                            @error('length') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <input type="hidden" name="volumetric_weight" id="hiddenVolumetric">
                        <div class="col-span-2 md:col-span-1 text-center font-bold text-gray-400 pb-2">X</div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Width (cm) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.001" name="width" oninput="calculateVolumetric()" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('width') border-red-500 @enderror" placeholder="0" value="{{ old('width') }}" required>
                            @error('width') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-2 md:col-span-1 text-center font-bold text-gray-400 pb-2">X</div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Height (cm) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.001" name="height" oninput="calculateVolumetric()" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('height') border-red-500 @enderror" placeholder="0" value="{{ old('height') }}" required>
                            @error('height') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">(Max 3 digits after decimal place)<br>Note: The minimum chargeable weight is 20 Kg</div>
                    <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                        <h6 class="text-sm font-semibold text-gray-700">Package Details</h6>
                        <div class="mt-2 flex items-center">
                            <span class="text-xs text-gray-500 mr-2">Volumetric Weight:</span>
                            <span class="font-bold text-[#D4AF37]" id="volumetricWeight">0 Kg</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Order Details</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Order Id <span class="text-red-500">*</span></label>
                            <input type="text" name="merchant_order_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('merchant_order_id') border-red-500 @enderror" value="{{ old('merchant_order_id', date('YmdHis')) }}" required>
                            @error('merchant_order_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Order Type <span class="text-red-500">*</span></label>
                            <select name="order_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('order_type') border-red-500 @enderror">
                                <option value="Essential" {{ old('order_type') == 'Essential' ? 'selected' : '' }}>Essential</option>
                                <option value="Non Essential" {{ old('order_type') == 'Non Essential' ? 'selected' : '' }}>Non Essential</option>
                            </select>
                            @error('order_type') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Order Date <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="order_date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2 @error('order_date') border-red-500 @enderror" value="{{ old('order_date', date('Y-m-d\TH:i')) }}" required>
                            @error('order_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h5 class="text-lg font-bold text-gray-800">Product Details</h5>
                        <button type="button" class="btn btn-sm bg-[#D4AF37] hover:bg-[#B8941F] text-white px-3 py-1.5 rounded-lg text-sm transition-colors" id="addProductBtn"><i class="fa fa-plus mr-1"></i> Add More</button>
                    </div>
                    <div id="productFields" class="space-y-4">
                        <div class="product-row grid grid-cols-1 md:grid-cols-12 gap-4 pb-4 border-b border-dashed border-gray-200 last:border-0">
                            <div class="md:col-span-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Product Name <span class="text-red-500">*</span></label>
                                <input type="text" name="products[0][name]" class="product-name w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="Name" value="{{ old('products.0.name') }}" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Qty <span class="text-red-500">*</span></label>
                                <input type="number" name="products[0][quantity]" class="product-qty w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="Qty" value="{{ old('products.0.quantity') }}" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Unit Price <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="products[0][unit_price]" class="product-price w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="Price" value="{{ old('products.0.unit_price') }}" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Category</label>
                                <input type="text" name="products[0][category]" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="Cat" value="{{ old('products.0.category') }}">
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">SKU</label>
                                <input type="text" name="products[0][sku]" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="SKU" value="{{ old('products.0.sku') }}">
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">HSN</label>
                                <input type="text" name="products[0][hsn_code]" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="HSN" value="{{ old('products.0.hsn_code') }}">
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Tax %</label>
                                <input type="number" name="products[0][tax_rate]" class="product-tax w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm px-3 py-2" placeholder="0" readonly value="{{ old('products.0.tax_rate') }}">
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Disc</label>
                                <input type="number" name="products[0][discount]" class="product-discount w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="0" value="{{ old('products.0.discount') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Payments</h5>
                    <div class="mb-4">
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="payment_mode" value="1" {{ old('payment_mode', '1') == '1' ? 'checked' : '' }} class="cod-radio"> <span class="ml-2 text-gray-700">COD</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="payment_mode" value="2" {{ old('payment_mode') == '2' ? 'checked' : '' }} class="prepaid-radio"> <span class="ml-2 text-gray-700">Prepaid</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Charges</label>
                            <input type="number" step="0.01" name="shipping_charge" class="calc-trigger w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="0.00" value="{{ old('shipping_charge') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gift Wrap</label>
                            <input type="number" step="0.01" name="gift_wrap_charge" class="calc-trigger w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="0.00" value="{{ old('gift_wrap_charge') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Trans. Fee</label>
                            <input type="number" step="0.01" name="transaction_fee" class="calc-trigger w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="0.00" value="{{ old('transaction_fee') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discounts</label>
                            <input type="number" step="0.01" name="order_discount" class="calc-trigger w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="0.00" value="{{ old('order_discount') }}">
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 max-w-md ml-auto">
                        <ul class="space-y-2 text-sm">
                            <li class="flex justify-between"><span class="text-gray-600">Sub-total (Products)</span><span class="font-medium" id="subTotal">₹0.00</span></li>
                            <li class="flex justify-between"><span class="text-gray-600">Other Charges</span><span class="font-medium" id="otherCharges">₹0.00</span></li>
                            <li class="flex justify-between"><span class="text-gray-600">Discount</span><span class="font-medium text-red-500" id="totalDiscount">-₹0.00</span></li>
                            <li class="flex justify-between border-t pt-2 font-bold text-gray-800 text-base"><span>Total Order Value</span><span class="text-[#D4AF37]" id="grandTotal">₹0.00</span></li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Pickup Address</h5>
                    <div class="relative mb-4">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fa fa-search text-gray-400"></i></div>
                        <input type="text" id="pickupSearch" class="pl-10 pr-3 py-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm" placeholder="Search Pickup Address">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="addressList">
                        @forelse($addresses as $addr)
                        <div class="address-card-wrapper">
                            <div class="address-card h-full cursor-pointer rounded-lg border border-gray-200 hover:shadow-md transition-all duration-200 {{ old('pick_address_ID') == $addr->id || ($addr->is_default ?? false) ? 'selected ring-2 ring-[#D4AF37] border-transparent bg-yellow-50' : '' }}" onclick="selectAddress(this, {{ $addr->id }})">
                                <div class="p-4">
                                    <h6 class="font-semibold text-gray-800">{{ $addr->warehouse_name ?? 'Warehouse' }} {!! $addr->is_default ?? false ? '<span class="text-xs text-green-600">(Default)</span>' : '' !!}</h6>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $addr->address_line1 }}{{ $addr->address_line2 ? ', ' . $addr->address_line2 : '' }}</p>
                                    <p class="text-xs text-gray-400 mt-2 flex items-center"><i class="fa fa-map-marker-alt mr-1"></i>{{ $addr->city }} - {{ $addr->pincode }}</p>
                                    <p class="text-xs text-gray-400 mt-1 flex items-center"><i class="fa fa-phone mr-1"></i> {{ $addr->phone_number }}</p>
                                </div>
                                <div class="px-4 py-2 bg-gray-50 border-t border-gray-100 rounded-b-lg">
                                    <button type="button" class="select-btn w-full text-xs font-medium py-1.5 rounded transition-colors {{ old('pick_address_ID') == $addr->id || ($addr->is_default ?? false) ? 'bg-[#D4AF37] text-white' : 'bg-white text-gray-600 border border-gray-300 hover:bg-gray-100' }}">{{ old('pick_address_ID') == $addr->id || ($addr->is_default ?? false) ? 'Selected' : 'Select' }}</button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-8">
                            <div class="inline-block p-4 bg-gray-50 rounded-full mb-2"><i class="fa fa-box-open text-3xl text-gray-300"></i></div>
                            <p class="text-gray-500 text-sm">No pickup addresses found.</p>
                            <a href="{{ route('add.whereHouse') }}" class="text-[#D4AF37] text-sm font-medium hover:underline mt-1 inline-block">Add New Address</a>
                        </div>
                        @endforelse
                    </div>
                    @error('pick_address_ID') <p class="mt-3 text-sm text-red-500 flex items-center"><i class="fa fa-exclamation-circle mr-1"></i> {{ $message }}</p> @enderror
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Other Details</h5>
                    <div class="max-w-xs">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reseller Name (Optional)</label>
                        <input type="text" name="reseller_name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] sm:text-sm px-3 py-2" placeholder="Enter Reseller Name" value="{{ old('reseller_name') }}">
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('orders.index') }}" class="px-6 py-2.5 bg-gray-800 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors shadow-sm">Back</a>
                    <button type="submit" class="px-8 py-2.5 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-lg font-medium transition-colors shadow-md transform active:scale-95">Submit Order</button>
                </div>
                <div class="text-center text-gray-400 text-xs mt-8 mb-4">Copyright &copy; {{ date('Y') }} Fixfeels Technologies Private Limited. All Rights Reserved.</div>
            </div>

            <div class="hidden lg:block lg:col-span-1">
                <div class="bg-white/60 backdrop-blur-sm rounded-xl border border-[#D4AF37]/20 p-6 sticky top-6">
                    <h6 class="font-bold text-gray-800 mb-3 flex items-center"><i class="fa fa-info-circle text-[#D4AF37] mr-2"></i> Add Buyer Details</h6>
                    <p class="text-sm text-gray-600 mb-4 leading-relaxed">Ensure phone number and email are correct for future communication.</p>
                    <h6 class="font-bold text-gray-800 mb-3 flex items-center"><i class="fa fa-map-marker-alt text-[#D4AF37] mr-2"></i> Address Info</h6>
                    <p class="text-sm text-gray-600 mb-2">Enter complete address including landmark.</p>
                    <p class="text-sm text-gray-600 mb-2">Mention company name for B2B orders.</p>
                    <p class="text-sm text-gray-600 mb-4">Check "Billing same as Shipping" if applicable.</p>
                    <h6 class="font-bold text-gray-800 mb-3 flex items-center"><i class="fa fa-truck text-[#D4AF37] mr-2"></i> Review</h6>
                    <p class="text-sm text-gray-600 mb-2">Select Hyperlocal for local orders.</p>
                    <p class="text-sm text-gray-600 mb-4">Use landmarks to find addresses on the map.</p>
                    <a href="#" class="text-sm text-[#D4AF37] hover:text-[#B8941F] font-medium flex items-center transition-colors"><i class="fa fa-question-circle mr-1"></i> Need help?</a>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.address-card.selected { background-color: #fffbeb; }
.product-row { animation: fadeIn 0.3s ease-in-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

/* Pincode status icons */
#pincodeStatus { font-weight: 600; }
#pincodeStatus.success { color: #22c55e; }
#pincodeStatus.error { color: #ef4444; }
#pincodeStatus.loading { color: #3b82f6; }
</style>

@push('scripts')
<script>
// Pickup Address Selection
function selectAddress(element, id) {
    document.querySelectorAll('.address-card').forEach(card => {
        card.classList.remove('selected', 'ring-2', 'ring-[#D4AF37]', 'border-transparent');
        card.classList.add('border-gray-200');
        const btn = card.querySelector('.select-btn');
        btn.classList.remove('bg-[#D4AF37]', 'text-white');
        btn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-300');
        btn.innerText = 'Select';
    });
    element.classList.add('selected', 'ring-2', 'ring-[#D4AF37]', 'border-transparent');
    element.classList.remove('border-gray-200');
    const btn = element.querySelector('.select-btn');
    btn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-300');
    btn.classList.add('bg-[#D4AF37]', 'text-white');
    btn.innerText = 'Selected';
    document.getElementById('selected_pickup_id').value = id;
}

// Volumetric Weight Calculation
function calculateVolumetric() {
    let l = parseFloat(document.querySelector('[name="length"]')?.value) || 0;
    let w = parseFloat(document.querySelector('[name="width"]')?.value) || 0;
    let h = parseFloat(document.querySelector('[name="height"]')?.value) || 0;
    let actualWeight = parseFloat(document.querySelector('[name="weight"]')?.value) || 0;
    let volumetric = (l * w * h) / 5000;
    let finalWeight = Math.max(actualWeight, volumetric);
    const display = document.getElementById('volumetricWeight');
    const hidden = document.getElementById('hiddenVolumetric');
    const submitBtn = document.querySelector('button[type="submit"]');
    if (display) display.innerText = finalWeight.toFixed(3) + ' Kg';
    if (hidden) hidden.value = finalWeight.toFixed(3);
    if (finalWeight > 20) { display.classList.add('text-red-600'); submitBtn.disabled = true; submitBtn.classList.add('opacity-50'); }
    else { display.classList.remove('text-red-600'); submitBtn.disabled = false; submitBtn.classList.remove('opacity-50'); }
    calculateTotals();
}

function calculateTotals() {
    let subTotal = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        let qty = parseFloat(row.querySelector('.product-qty')?.value) || 0;
        let price = parseFloat(row.querySelector('.product-price')?.value) || 0;
        let discount = parseFloat(row.querySelector('.product-discount')?.value) || 0;
        subTotal += (qty * price) - discount;
    });
    let shipping = parseFloat(document.querySelector('[name="shipping_charge"]')?.value) || 0;
    let giftWrap = parseFloat(document.querySelector('[name="gift_wrap_charge"]')?.value) || 0;
    let transaction = parseFloat(document.querySelector('[name="transaction_fee"]')?.value) || 0;
    let orderDiscount = parseFloat(document.querySelector('[name="order_discount"]')?.value) || 0;
    let otherCharges = shipping + giftWrap + transaction;
    let grandTotal = subTotal + otherCharges - orderDiscount;
    document.getElementById('subTotal').innerText = '₹' + subTotal.toFixed(2);
    document.getElementById('otherCharges').innerText = '₹' + otherCharges.toFixed(2);
    document.getElementById('totalDiscount').innerText = '-₹' + orderDiscount.toFixed(2);
    document.getElementById('grandTotal').innerText = '₹' + grandTotal.toFixed(2);
    checkOrderLimit(grandTotal);
}

function checkOrderLimit(grandTotal) {
    const submitBtn = document.querySelector('button[type="submit"]');
    const totalDisplay = document.getElementById('grandTotal');
    if (grandTotal >= 50000) {
        totalDisplay.classList.remove('text-[#D4AF37]'); totalDisplay.classList.add('text-red-600');
        if (!document.getElementById('limitAlert')) {
            let alertDiv = document.createElement('div'); alertDiv.id = 'limitAlert'; alertDiv.className = 'mt-2 text-xs text-red-600 font-bold';
            alertDiv.innerText = '⚠️ Maximum allowed order value is ₹50,000.'; totalDisplay.parentNode.appendChild(alertDiv);
        }
        submitBtn.disabled = true; submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        totalDisplay.classList.add('text-[#D4AF37]'); totalDisplay.classList.remove('text-red-600');
        const existingAlert = document.getElementById('limitAlert'); if (existingAlert) existingAlert.remove();
        submitBtn.disabled = false; submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

// Add More Product Row
document.getElementById('addProductBtn')?.addEventListener('click', function() {
    let container = document.getElementById('productFields');
    let index = container.querySelectorAll('.product-row').length;
    let firstRow = container.querySelector('.product-row');
    let newRow = firstRow.cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => {
        let name = input.name.replace(/\[\d+\]/, '[' + index + ']'); input.name = name; input.value = ''; input.classList.remove('border-red-500');
    });
    let removeCol = document.createElement('div'); removeCol.className = 'md:col-span-12 text-right -mt-8 mb-2';
    removeCol.innerHTML = '<button type="button" class="remove-product text-red-500 hover:text-red-700 text-sm font-medium"><i class="fa fa-trash mr-1"></i> Remove Row</button>';
    newRow.appendChild(removeCol); container.appendChild(newRow); calculateTotals();
});

// Remove Product Row
document.getElementById('productFields')?.addEventListener('click', function(e) {
    if (e.target.closest('.remove-product')) {
        let row = e.target.closest('.product-row');
        if (document.querySelectorAll('.product-row').length > 1) { row.remove(); calculateTotals(); }
        else { alert("At least one product is required."); }
    }
});

// Search Filter for Addresses
document.getElementById('pickupSearch')?.addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    document.querySelectorAll('.address-card-wrapper').forEach(wrapper => {
        let text = wrapper.innerText.toLowerCase(); wrapper.style.display = text.includes(filter) ? '' : 'none';
    });
});

// Weight Validation - 20kg (20kg) limit
function validateWeight(input) { 
    let value = parseFloat(input.value) || 0; 
    if (value > 20) { 
        alert("Maximum allowed weight is 20 Kg (500g)"); 
        input.value = 20; 
    } 
    calculateVolumetric(); 
}

// ============ HELPER FUNCTIONS ============
function setVal(fieldId, value) {
    const el = document.getElementById(fieldId + 'Input') || document.querySelector('[name="' + fieldId + '"]');
    if (el) el.value = value;
}

function showFieldSuccess(fieldId) {
    const status = document.getElementById(fieldId + 'Status');
    if (status) {
        status.innerHTML = '✓';
        status.className = 'text-xs mt-1 block success';
    }
}

function showFieldError(fieldId, msg) {
    const status = document.getElementById(fieldId + 'Status');
    if (status) {
        status.innerHTML = '✗';
        status.className = 'text-xs mt-1 block error';
    }
}

function showFieldLoading(fieldId) {
    const status = document.getElementById(fieldId + 'Status');
    if (status) {
        status.innerHTML = '⏳';
        status.className = 'text-xs mt-1 block loading';
    }
}

// ============ PINCODE AUTO-FILL (REQUESTED STYLE) ============
document.addEventListener('DOMContentLoaded', function() {
    const pincodeInput = document.getElementById('pincodeInput');
    if (!pincodeInput) return;

    let debounceTimer;
    function debounce(func, delay) {
        return function(...args) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(this, args), delay);
        };
    }

    const fetchPincodeData = debounce(function() {
        let pincode = pincodeInput.value.trim();
        
        // Sirf 6 digit number check
        if (pincode.length !== 6 || !/^\d{6}$/.test(pincode)) return;

        // Show loading
        showFieldLoading('pincode');
        pincodeInput.disabled = true;

        // API Call - Aapke requested style mein
        fetch('https://api.postalpincode.in/pincode/' + pincode)
        .then(function(res) { return res.json(); })
        .then(function(data) {
            pincodeInput.disabled = false;
            
            if (data[0]?.Status === 'Success' && data[0].PostOffice?.length) {
                const po = data[0].PostOffice[0];
                setVal('city',    po.District || '');
                setVal('state',   po.State    || '');
                setVal('country', 'INDIA');
                showFieldSuccess('pincode');
            } else {
                showFieldError('pincode');
            }
        })
        .catch(function(err) {
            console.error('Pincode API error:', err);
            pincodeInput.disabled = false;
            showFieldError('pincode');
        });
    }, 500);

    // Trigger on blur & after 6 digits
    pincodeInput.addEventListener('blur', function() {
        if (this.value.trim().length === 6) fetchPincodeData();
    });
    pincodeInput.addEventListener('input', function() {
        if (this.value.trim().length === 6) fetchPincodeData();
    });
});

// Initialize calculations on load
document.addEventListener('DOMContentLoaded', function() {
    calculateVolumetric();
    calculateTotals();
    
    document.querySelectorAll('.product-qty, .product-price, .product-discount, .calc-trigger, [name="weight"], [name="length"], [name="width"], [name="height"], [name="shipping_charge"], [name="order_discount"]').forEach(el => {
        el.addEventListener('input', () => {
            if(['length','width','height','weight'].includes(el.name)) calculateVolumetric();
            else calculateTotals();
        });
    });
});
</script>
@endpush
@endsection