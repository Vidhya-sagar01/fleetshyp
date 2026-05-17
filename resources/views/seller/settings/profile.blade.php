@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-[#F8F9FD] py-8 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-sm border border-gray-100 p-8">
        
       <form action="{{ route('seller.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
            @csrf
           
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-600 mb-1">Company Name<span class="text-red-500">*</span></label>
                        <input type="text" name="company_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-indigo-500 text-[14px]" 
                               value="{{ old('company_name', $profile->company_name ?? '') }}" placeholder="Enter Company Name" required>
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-600 mb-1">Website</label>
                        <input type="url" name="website" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-indigo-500 text-[14px]" 
                               value="{{ old('website', $profile->website ?? '') }}" placeholder="https://example.com">
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-600 mb-1">Customer Care Email</label>
                        <input type="email" name="customer_care_email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-indigo-500 text-[14px]" 
                               value="{{ old('customer_care_email', $profile->customer_care_email ?? '') }}" placeholder="support@example.com">
                    </div>

                    <div class="flex items-center space-x-3 pt-2">
                        <span class="text-[13px] font-semibold text-gray-600">Do you have GST?</span>
                        <input type="checkbox" name="has_gst" class="w-4 h-4 text-indigo-600 border-gray-300 rounded" 
                               {{ old('has_gst', $profile->has_gst ?? false) ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-600 mb-1">Brand Name <span class="text-red-500">*</span></label>
                        <input type="text" name="brand_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-indigo-500 text-[14px]" 
                               value="{{ old('brand_name', $profile->brand_name ?? '') }}" placeholder="Enter Brand Name" required>
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-600 mb-1">Email<span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-indigo-500 text-[14px]" 
                               value="{{ old('email', $profile->email ?? '') }}" placeholder="info@example.com" required>
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-600 mb-1">Customer Care Mobile No.</label>
                        <input type="tel" name="customer_care_mobile" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-indigo-500 text-[14px]" 
                               value="{{ old('customer_care_mobile', $profile->customer_care_mobile ?? '') }}" placeholder="99xxxxxx88">
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-600 mb-1">Website/Company Logo</label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-md p-6 flex flex-col items-center justify-center hover:bg-gray-50 cursor-pointer group" id="uploadContainer">
                            <input type="file" name="logo" id="logo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                            <div class="text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-gray-400 text-2xl mb-2 group-hover:text-indigo-500 transition-colors"></i>
                                <p class="text-[13px] text-gray-500">Upload Logo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <div class="w-48 h-48 border border-gray-100 rounded-full overflow-hidden bg-white flex items-center justify-center p-2 shadow-sm">
                    @php
                        $logoPath = (isset($profile->logo) && $profile->logo) ? asset('storage/' . $profile->logo) : 'https://via.placeholder.com/150?text=No+Logo';
                    @endphp
                    <img src="{{ $logoPath }}" alt="Preview" id="logoPreview" class="max-w-full h-auto object-contain {{ !isset($profile->logo) ? 'opacity-40' : '' }}">
                </div>
            </div>

            <div class="pt-12">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="text-[13px] font-semibold text-gray-600">Enable State GST?</span>
                    <input type="checkbox" name="enable_state_gst" class="w-4 h-4 text-indigo-600 border-gray-300 rounded" 
                           {{ old('enable_state_gst', $profile->enable_state_gst ?? false) ? 'checked' : '' }}>
                </div>
                <p class="text-[12px] text-gray-500 max-w-2xl leading-relaxed">
                    If you have multiple pickup addresses and want one consolidated state level invoice for each state then select state GST and uncheck the box below
                </p>
            </div>

            <div class="flex justify-between items-center pt-8 border-t border-gray-100">
                <a href="{{ url()->previous() }}" class="flex items-center px-6 py-1.5 bg-[#1A0A45] text-white rounded text-[14px] font-medium hover:bg-black transition-all uppercase">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </a>
                <button type="submit" class="px-8 py-1.5 bg-[#1A0A45] text-white rounded text-[14px] font-medium hover:bg-black transition-all uppercase shadow-sm">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('logo').addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('logoPreview');
                preview.src = e.target.result;
                preview.classList.remove('opacity-40');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endsection