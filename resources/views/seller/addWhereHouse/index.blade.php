@extends('seller.layouts.app')
@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden min-h-[80vh] flex flex-col">
    
    {{-- Top Bar --}}
    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/50">
        <div class="text-sm font-semibold text-gray-600 bg-white px-3 py-1.5 rounded border border-gray-200 shadow-sm">
            Total: {{ $warehouses->total() }}
        </div>
        <div class="flex items-center gap-3">
            <button onclick="toggleFilter()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fas fa-filter text-gray-500"></i> Filter
            </button>
            <button onclick="toggleModal('addModal')" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                <i class="fas fa-plus text-gold"></i> Add Address
            </button>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div id="filterPanel" class="hidden bg-white border-b border-gray-200 p-5 transition-all duration-300">
        <form action="{{ route('add.whereHouse') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Address Name</label>
                    <input type="text" name="search" placeholder="Search by address name" value="{{ request('search') }}" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 transition-all pl-3">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Contact Name</label>
                    <input type="text" name="contact" placeholder="Search by contact name" value="{{ request('contact') }}" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 transition-all pl-3">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Keywords</label>
                    <input type="text" name="keyword" placeholder="Search by keywords" value="{{ request('keyword') }}" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 transition-all pl-3">
                </div>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('add.whereHouse') }}" class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">Clear</a>
                <button type="submit" class="px-4 py-2 bg-indigo-900 text-white text-sm font-medium rounded-lg hover:bg-indigo-800 transition-colors">Apply</button>
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="overflow-x-auto flex-1">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4 border-b">Address Nick Name</th>
                    <th class="px-6 py-4 border-b">Contact Name</th>
                    <th class="px-6 py-4 border-b">Email / Phone</th>
                    <th class="px-6 py-4 border-b">Address</th>
                    <th class="px-6 py-4 border-b text-center">Primary</th>
                    <th class="px-6 py-4 border-b text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse($warehouses as $wh)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium">{{ $wh->warehouse_name }}</td>
                    <td class="px-6 py-4">{{ $wh->contact_name }}</td>
                    <td class="px-6 py-4">{{ $wh->email }}<br><span class="text-xs text-gray-500">{{ $wh->phone_number }}</span></td>
                    <td class="px-6 py-4 text-gray-600">{{ $wh->address_line1 }}<br><span class="text-xs text-gray-500">Pincode: {{ $wh->pincode }}</span></td>
                    <td class="px-6 py-4 text-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer primaryToggle" data-id="{{ $wh->id }}" {{ $wh->is_default == 1 ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                        </label>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button type="button" onclick="editWarehouse({{ $wh->id }})" class="px-3 py-1.5 bg-white border border-gray-300 rounded text-xs hover:text-blue-600 shadow-sm transition-all">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No addresses found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-between items-center">
        <select class="border-gray-300 rounded text-sm text-gray-600 focus:border-gold focus:ring focus:ring-yellow-200 pl-3" onchange="window.location.href=this.value">
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
        </select>
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span>Showing {{ $warehouses->firstItem() }} to {{ $warehouses->lastItem() }} of {{ $warehouses->total() }}</span>
        </div>
    </div>
</div>

{{-- ================= ADD MODAL ================= --}}
<div id="addModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-40 backdrop-blur-sm transition-opacity" onclick="toggleModal('addModal')"></div>
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-4xl transform transition-all flex flex-col max-h-[90vh]">
            
            {{-- Header --}}
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Add Pickup Address</h3>
                <button onclick="toggleModal('addModal')" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors"><i class="fas fa-times"></i></button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-6 overflow-y-auto custom-scrollbar">
                <form id="storeForm" action="{{ route('add.whereHouse.store') }}" method="POST">
                    @csrf
                    
                   
@if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    {{-- Contact Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Warehouse Name <span class="text-red-500">*</span></label>
                            <input type="text" name="warehouseName" placeholder="Enter address nick name" required value="{{ old('warehouseName') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3">
                            @error('warehouseName')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Name <span class="text-red-500">*</span></label>
                            <input type="text" name="contactName" placeholder="Enter Contact Name" required value="{{ old('contactName') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3">
                            @error('contactName')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" name="phoneNumber" placeholder="Enter phone number" required value="{{ old('phoneNumber') }}" maxlength="10" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3">
                            @error('phoneNumber')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alternate Phone Number</label>
                            <input type="text" name="altPhoneNumber" placeholder="Enter alternate phone number" value="{{ old('altPhoneNumber') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" placeholder="Enter email address" required value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3">
                            @error('email')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <h4 class="text-md font-bold text-gray-800 mb-4 border-b pb-2">Address Details</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Address Line 1 <span class="text-red-500">*</span></label>
                            <textarea name="addressLine1" rows="3" placeholder="Enter address line 1" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3 pt-2">{{ old('addressLine1') }}</textarea>
                            @error('addressLine1')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Address Line 2</label>
                            <textarea name="addressLine2" rows="3" placeholder="Enter address line 2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3 pt-2">{{ old('addressLine2') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pincode <span class="text-red-500">*</span></label>
                            <input type="text" name="pincode" placeholder="Enter Pincode" required value="{{ old('pincode') }}" maxlength="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3">
                            @error('pincode')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                            <input type="text" name="city" placeholder="Enter City" required value="{{ old('city') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3">
                            @error('city')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                        
                        {{-- State Dropdown --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">State <span class="text-red-500">*</span></label>
                            <select name="stateId" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3">
                                <option value="">Select state</option>
                                @php
                                $states = [1=>'Andhra Pradesh',2=>'Arunachal Pradesh',3=>'Assam',4=>'Bihar',5=>'Chhattisgarh',6=>'Goa',7=>'Gujarat',8=>'Haryana',9=>'Himachal Pradesh',10=>'Jharkhand',11=>'Karnataka',12=>'Kerala',13=>'Madhya Pradesh',14=>'Maharashtra',15=>'Manipur',16=>'Meghalaya',17=>'Mizoram',18=>'Nagaland',19=>'Odisha',20=>'Punjab',21=>'Rajasthan',22=>'Sikkim',23=>'Tamil Nadu',24=>'Telangana',25=>'Tripura',26=>'Uttar Pradesh',27=>'Uttarakhand',28=>'West Bengal',29=>'Andaman and Nicobar Islands',30=>'Chandigarh',31=>'Dadra and Nagar Haveli and Daman and Diu',32=>'Delhi',33=>'Jammu and Kashmir',34=>'Ladakh',35=>'Lakshadweep',36=>'Puducherry'];
                                @endphp
                                @foreach($states as $id => $name)
                                    <option value="{{ $id }}" {{ (string)old('stateId') === (string)$id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('stateId')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Country</label>
                            <select name="countryId" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 text-sm pl-3">
                                <option value="1" {{ old('countryId') == 1 ? 'selected' : '' }}>India</option>
                            </select>
                        </div>
                    </div>

                    {{-- Vendor Section --}}
                    <div class="mb-4">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 cursor-pointer">
                            <input type="checkbox" id="vendorCheckbox" name="is_vendor" value="on" {{ old('is_vendor') ? 'checked' : '' }} class="rounded border-gray-300 text-gold focus:ring-gold h-4 w-4">
                            Add this address as supplier/vendor address
                        </label>
                        <span class="text-xs text-gray-500 ml-6"><i class="fas fa-info-circle"></i> Required only if you use vendor GST</span>
                        <div id="vendorFields" class="{{ old('is_vendor') ? '' : 'hidden' }} mt-4 pl-6 border-l-2 border-gray-200 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Vendor Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="vendor_name" placeholder="Enter vendor name" value="{{ old('vendor_name') }}" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 pl-3">
                                    @error('vendor_name')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Vendor GSTIN <span class="text-red-500">*</span></label>
                                    <input type="text" name="vendor_gstin" placeholder="Enter vendor GSTIN" value="{{ old('vendor_gstin') }}" maxlength="20" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 pl-3">
                                    @error('vendor_gstin')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RTO Section --}}
                    <div class="mb-4">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 cursor-pointer">
                            <input type="checkbox" id="rtoCheckbox" name="is_rto" value="on" {{ old('is_rto') ? 'checked' : '' }} class="rounded border-gray-300 text-gold focus:ring-gold h-4 w-4">
                            Use a different address as RTO address
                        </label>
                        <span class="text-xs text-gray-500 ml-6"><i class="fas fa-info-circle"></i> Required only for COD/returns</span>
                        <div id="rtoFields" class="{{ old('is_rto') ? '' : 'hidden' }} mt-4 pl-6 border-l-2 border-gray-200 space-y-4">
                            <h5 class="text-sm font-bold text-gray-800 mb-2">RTO Contact Info</h5>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Address Nick Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="rto_nick_name" placeholder="Enter nick name" value="{{ old('rto_nick_name') }}" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 pl-3">
                                    @error('rto_nick_name')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Contact Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="rto_contact_name" placeholder="Enter contact name" value="{{ old('rto_contact_name') }}" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 pl-3">
                                    @error('rto_contact_name')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                    <input type="text" name="rto_phone" placeholder="Enter phone number" value="{{ old('rto_phone') }}" maxlength="10" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 pl-3">
                                    @error('rto_phone')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="rto_email" placeholder="Enter email" value="{{ old('rto_email') }}" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 pl-3">
                                    @error('rto_email')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Address Line 1 <span class="text-red-500">*</span></label>
                                    <input type="text" name="rto_address" placeholder="Enter RTO address line 1" value="{{ old('rto_address') }}" class="w-full rounded-lg border-gray-300 text-sm focus:border-gold focus:ring focus:ring-yellow-200 pl-3">
                                    @error('rto_address')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3 rounded-b-xl">
                <button onclick="toggleModal('addModal')" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" form="storeForm" class="px-6 py-2.5 bg-indigo-900 text-white text-sm font-medium rounded-lg hover:bg-indigo-800 shadow-md transition-colors">Add Address</button>
            </div>
        </div>
    </div>
</div>

{{-- ================= EDIT MODAL ================= --}}
<div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-40 backdrop-blur-sm transition-opacity" onclick="toggleModal('editModal')"></div>
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-4xl transform transition-all flex flex-col max-h-[90vh]">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Edit Warehouse Details</h3>
                <button onclick="toggleModal('editModal')" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="px-6 py-6 overflow-y-auto custom-scrollbar">
                <form id="updateForm" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    
                    <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4">Pickup Address Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Warehouse Name</label><input type="text" name="warehouseName" id="edit_warehouseName" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold text-sm pl-3"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Contact Name</label><input type="text" name="contactName" id="edit_contactName" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold text-sm pl-3"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Email</label><input type="email" name="email" id="edit_email" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold text-sm pl-3"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label><input type="text" name="phoneNumber" id="edit_phoneNumber" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold text-sm pl-3"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">City</label><input type="text" name="city" id="edit_city" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold text-sm pl-3"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Pincode</label><input type="text" name="pincode" id="edit_pincode" readonly class="w-full rounded-lg border-gray-100 bg-gray-50 text-sm pl-3 cursor-not-allowed"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Address Line 1</label><textarea name="addressLine1" id="edit_addressLine1" rows="2" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold text-sm pl-3 pt-2"></textarea></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Address Line 2</label><textarea name="addressLine2" id="edit_addressLine2" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold text-sm pl-3 pt-2"></textarea></div>
                    </div>
                    
                    {{-- Edit Modal: State Dropdown --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">State</label>
                        <select name="stateId" id="edit_stateId" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold text-sm pl-3">
                            <option value="">Select state</option>
                            @foreach([1=>'Andhra Pradesh',2=>'Arunachal Pradesh',3=>'Assam',4=>'Bihar',5=>'Chhattisgarh',6=>'Goa',7=>'Gujarat',8=>'Haryana',9=>'Himachal Pradesh',10=>'Jharkhand',11=>'Karnataka',12=>'Kerala',13=>'Madhya Pradesh',14=>'Maharashtra',15=>'Manipur',16=>'Meghalaya',17=>'Mizoram',18=>'Nagaland',19=>'Odisha',20=>'Punjab',21=>'Rajasthan',22=>'Sikkim',23=>'Tamil Nadu',24=>'Telangana',25=>'Tripura',26=>'Uttar Pradesh',27=>'Uttarakhand',28=>'West Bengal',29=>'Andaman and Nicobar Islands',30=>'Chandigarh',31=>'Dadra and Nagar Haveli and Daman and Diu',32=>'Delhi',33=>'Jammu and Kashmir',34=>'Ladakh',35=>'Lakshadweep',36=>'Puducherry'] as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- Vendor Details --}}
                    <div class="mt-8 border-t pt-6">
                        <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-4">Vendor Details (Optional)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="block text-xs font-semibold text-gray-600 mb-1">Vendor Name</label><input type="text" name="vendor_name" id="edit_vendor_name" class="w-full rounded-lg border-gray-300 text-sm pl-3"></div>
                            <div><label class="block text-xs font-semibold text-gray-600 mb-1">Vendor GSTIN</label><input type="text" name="vendor_gstin" id="edit_vendor_gstin" class="w-full rounded-lg border-gray-300 text-sm pl-3"></div>
                        </div>
                    </div>
                    
                    {{-- RTO Details --}}
                    <div class="mt-8 border-t pt-6">
                        <h4 class="text-sm font-bold text-red-600 uppercase tracking-wider mb-4">RTO Details (Optional)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div><label class="block text-xs font-semibold text-gray-600 mb-1">RTO Nick Name</label><input type="text" name="rto_nick_name" id="edit_rto_nick_name" class="w-full rounded-lg border-gray-300 text-sm pl-3"></div>
                            <div><label class="block text-xs font-semibold text-gray-600 mb-1">RTO Contact Name</label><input type="text" name="rto_contact_name" id="edit_rto_contact_name" class="w-full rounded-lg border-gray-300 text-sm pl-3"></div>
                            <div><label class="block text-xs font-semibold text-gray-600 mb-1">RTO Phone</label><input type="text" name="rto_phone" id="edit_rto_phone" class="w-full rounded-lg border-gray-300 text-sm pl-3"></div>
                            <div><label class="block text-xs font-semibold text-gray-600 mb-1">RTO Email</label><input type="email" name="rto_email" id="edit_rto_email" class="w-full rounded-lg border-gray-300 text-sm pl-3"></div>
                            <div class="md:col-span-2"><label class="block text-xs font-semibold text-gray-600 mb-1">RTO Address</label><input type="text" name="rto_address" id="edit_rto_address" class="w-full rounded-lg border-gray-300 text-sm pl-3"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3 rounded-b-xl">
                <button onclick="toggleModal('editModal')" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Cancel</button>
                <button type="submit" form="updateForm" class="px-6 py-2.5 bg-indigo-900 text-white text-sm font-medium rounded-lg hover:bg-indigo-800 shadow-md">Update Warehouse</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleFilter() { document.getElementById('filterPanel').classList.toggle('hidden'); }

function toggleModal(id) {
    const modal = document.getElementById(id);
    modal.classList.toggle('hidden');
    document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
    if(id === 'addModal' && modal.classList.contains('hidden')) {
        document.getElementById('storeForm').reset();
        document.getElementById('vendorFields').classList.add('hidden');
        document.getElementById('rtoFields').classList.add('hidden');
        document.getElementById('vendorCheckbox').checked = false;
        document.getElementById('rtoCheckbox').checked = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Vendor Toggle
    const vendorCheckbox = document.getElementById('vendorCheckbox');
    const vendorFields = document.getElementById('vendorFields');
    if(vendorCheckbox) {
        vendorCheckbox.addEventListener('change', function() {
            ['vendor_name','vendor_gstin'].forEach(f => {
                const el = document.querySelector(`[name="${f}"]`);
                if(el) el.required = this.checked;
            });
            vendorFields.classList.toggle('hidden', !this.checked);
        });
    }

    // RTO Toggle
    const rtoCheckbox = document.getElementById('rtoCheckbox');
    const rtoFields = document.getElementById('rtoFields');
    if(rtoCheckbox) {
        rtoCheckbox.addEventListener('change', function() {
            ['rto_nick_name','rto_contact_name','rto_phone','rto_email','rto_address'].forEach(f => {
                const el = document.querySelector(`[name="${f}"]`);
                if(el) el.required = this.checked;
            });
            rtoFields.classList.toggle('hidden', !this.checked);
        });
    }

    // ESC to close modals
    document.addEventListener('keydown', e => {
        if(e.key === "Escape") {
            document.querySelectorAll('[id$="Modal"]').forEach(m => {
                if(!m.classList.contains('hidden')) toggleModal(m.id);
            });
        }
    });

    // Primary Toggle AJAX
    document.addEventListener('change', function(e) {
        if(e.target.classList.contains('primaryToggle')) {
            const clicked = e.target;
            fetch("{{ route('set.primary.address') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ id: clicked.dataset.id })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) { 
                    document.querySelectorAll('.primaryToggle').forEach(t => t.checked = false); 
                    clicked.checked = true; 
                } else { 
                    clicked.checked = !clicked.checked; 
                    alert(data.message || "Failed"); 
                }
            })
            .catch(() => { clicked.checked = !clicked.checked; alert("Error"); });
        }
    });
});

function editWarehouse(id) {
    fetch(`/seller/addWhereHouse/${id}/edit`)
    .then(res => res.ok ? res.json() : Promise.reject('Network error'))
    .then(data => {
        document.getElementById('updateForm').action = `/seller/addWhereHouse/${id}`;
        document.getElementById('edit_id').value = data.id || '';
        document.getElementById('edit_warehouseName').value = data.warehouse_name || '';
        document.getElementById('edit_contactName').value = data.contact_name || '';
        document.getElementById('edit_phoneNumber').value = data.phone_number || '';
        document.getElementById('edit_addressLine1').value = data.address_line1 || '';
        document.getElementById('edit_addressLine2').value = data.address_line2 || '';
        document.getElementById('edit_pincode').value = data.pincode || '';
        document.getElementById('edit_city').value = data.city || '';
        document.getElementById('edit_email').value = data.email || '';
        
        const stateSelect = document.getElementById('edit_stateId');
        if(stateSelect && data.state_id) stateSelect.value = data.state_id;
        
        if(data.vendor_address) {
            document.getElementById('edit_vendor_name').value = data.vendor_address.vendor_name || '';
            document.getElementById('edit_vendor_gstin').value = data.vendor_address.vendor_gstin || '';
        }
        if(data.rto) {
            document.getElementById('edit_rto_nick_name').value = data.rto.rto_nick_name || '';
            document.getElementById('edit_rto_contact_name').value = data.rto.contact_name || '';
            document.getElementById('edit_rto_phone').value = data.rto.phone || '';
            document.getElementById('edit_rto_email').value = data.rto.email || '';
            document.getElementById('edit_rto_address').value = data.rto.address_line1 || '';
        }
        toggleModal('editModal');
    })
    .catch(err => alert("Error: " + err.message));
}
</script>
<style>
.custom-scrollbar::-webkit-scrollbar{width:6px}
.custom-scrollbar::-webkit-scrollbar-track{background:#f1f1f1;border-radius:4px}
.custom-scrollbar::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}
.custom-scrollbar::-webkit-scrollbar-thumb:hover{background:#94a3b8}
@keyframes fadeInDown{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}
.animate-fade-in-down{animation:fadeInDown .3s ease-out forwards}
input::placeholder,textarea::placeholder{padding-left:.25rem}
</style>
@endpush
@endsection