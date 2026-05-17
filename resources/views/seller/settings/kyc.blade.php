@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-linear-to-br from-[#F8F9FD] to-[#E8ECF5] py-6 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-5xl mx-auto">
        
        {{-- 🎯 Progress Stepper (New Users ke liye) --}}
        @if(!isset($kyc) || !in_array($kyc->status, ['VERIFIED', 'PENDING', 'REJECTED']))
        <div class="mb-6">
            <div class="flex items-center justify-between max-w-2xl mx-auto px-4">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-[#1A0A45] text-white flex items-center justify-center font-bold border-4 border-white shadow-md">1</div>
                    <span class="text-xs mt-2 text-[#1A0A45] font-semibold">Personal Info</span>
                </div>
                <div class="flex-1 h-1 bg-[#1A0A45] mx-2 rounded"></div>
                
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-[#1A0A45] text-white flex items-center justify-center font-bold border-4 border-white shadow-md">2</div>
                    <span class="text-xs mt-2 text-[#1A0A45] font-semibold">Documents</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300 mx-2 rounded"></div>
                
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 border-2 border-gray-300 text-gray-400 flex items-center justify-center font-bold">3</div>
                    <span class="text-xs mt-2 text-gray-400">Review</span>
                </div>
            </div>
        </div>
        @endif

        {{-- ✅ Case 1: KYC VERIFIED --}}
        @if(isset($kyc) && $kyc->status === 'VERIFIED')
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                {{-- Celebration Header --}}
                <div class="bg-linear-to-r from-[#00C06A] to-[#00A859] p-6 sm:p-8 text-white relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <circle cx="20" cy="20" r="15" fill="white"/>
                            <circle cx="80" cy="80" r="25" fill="white"/>
                        </svg>
                    </div>
                    
                    <div class="relative flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center animate-bounce">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class=" text-black/90 text-2xl font-bold">🎉 Verified Successfully!</h2>
                            <p class="text-black/90 mt-1 text-sm sm:text-base">Now you can use all FleetShyp features! 🚚</p>
                            <div class="mt-4 flex flex-wrap gap-3">
                                <a href="{{ route('seller.dashboard') }}" class="px-5 py-2.5 bg-white text-[#00A859] rounded-xl font-bold text-sm hover:bg-gray-100 transition shadow-md">
                                    <i class="fa-solid fa-home mr-1"></i> Dashboard
                                </a>
                                <a href="{{ route('seller.settings.kyc.submit') }}" class="px-5 py-2.5 bg-white/20 text-white rounded-xl font-medium text-sm hover:bg-white/30 transition border border-white/30">
                                    <i class="fa-solid fa-plus mr-1"></i> Create Shipment
                                </a>
                            </div>
                        </div>
                        @if($kyc->user_photo)
                            <div class="shrink-0">
                                <img src="{{ asset('storage/' . $kyc->user_photo) }}" 
                                     class="w-20 h-20 rounded-2xl border-4 border-white/50 shadow-xl object-cover ring-4 ring-white/30">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Verified Details Grid --}}
                <div class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 border-b border-gray-100 pb-6">
                        @php
                            $details = [
                                ['label' => 'Verification Method', 'value' => $kyc->verification_method ?? 'Express KYC'],
                                ['label' => 'Business Type', 'value' => $kyc->business_type ?? 'Individual'],
                                ['label' => 'KYC Status', 'value' => '<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200 flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> VERIFIED</span>'],
                                ['label' => 'Verified On', 'value' => $kyc->verified_at ? $kyc->verified_at->format('d M, Y h:i A') : 'N/A'],
                                ['label' => 'PAN Number', 'value' => $kyc->pan_number ? '<span class="font-mono">'.strtoupper($kyc->pan_number).'</span>' : 'N/A'],
                                ['label' => 'Aadhaar Number', 'value' => $kyc->aadhaar_number ? '<span class="font-mono">XXXX-XXXX-'.substr($kyc->aadhaar_number, -4).'</span>' : 'N/A'],
                            ];
                        @endphp
                        @foreach($details as $item)
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-500 text-sm">{{ $item['label'] }}</span>
                                <span class="font-semibold text-gray-800 text-sm">{!! $item['value'] !!}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 flex flex-wrap justify-start gap-3">
                        <a href="{{ url()->previous() }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition flex items-center">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Back
                        </a>
                        <a href="{{ route('seller.settings.profile') }}" class="px-6 py-2.5 bg-[#1A0A45] text-white rounded-xl text-sm font-medium hover:bg-[#0f0529] transition shadow-md">
                            Update Profile <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

        {{-- ⏳ Case 2: PENDING or REJECTED --}}
        @elseif(isset($kyc) && in_array($kyc->status, ['PENDING', 'REJECTED']))
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-10 text-center">
                <div class="mb-6">
                    @if($kyc->status === 'PENDING')
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 rounded-2xl mb-4 animate-pulse">
                            <i class="fa-solid fa-clock-rotate-left text-blue-500 text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#1A0A45]">Verification in Progress</h2>
                        <p class="text-gray-500 mt-3 max-w-md mx-auto">We are Verifying your documents. This may take <strong>24-48 hours</strong>.</p>
                        @if($kyc->business_type)
                            <p class="text-sm text-gray-400 mt-2">Business Type: <strong class="text-gray-600">{{ $kyc->business_type }}</strong></p>
                        @endif
                        
                       
                    @else
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-50 rounded-2xl mb-4">
                            <i class="fa-solid fa-circle-xmark text-red-500 text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-red-600">KYC Verification Failed</h2>
                        <p class="text-gray-500 mt-3 max-w-md mx-auto">We are sorry, but your KYC verification has been rejected.</p>
                        @if($kyc->business_type)
                            <p class="text-sm text-gray-400 mt-2">Business Type: <strong class="text-gray-600">{{ $kyc->business_type }}</strong></p>
                        @endif
                        
                        @if($kyc->rejection_reason)
                            <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100 text-left max-w-md mx-auto">
                                <p class="text-sm font-medium text-red-700 mb-1">Reason:</p>
                                <p class="text-sm text-red-600">{{ $kyc->rejection_reason }}</p>
                            </div>
                        @endif
                        
                        <a href="{{ route('seller.settings.kyc', ['reapply' => true]) }}" 
                           class="mt-6 inline-flex items-center px-6 py-3 bg-[#1A0A45] text-white rounded-xl font-bold text-sm hover:bg-[#0f0529] transition shadow-lg hover:shadow-xl active:scale-95">
                            <i class="fa-solid fa-rotate-right mr-2"></i> Re-Apply Now
                        </a>
                    @endif
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <p class="text-sm text-gray-400">
                        Current Status: 
                        <span class="font-bold uppercase px-3 py-1 rounded-full text-xs 
                            {{ $kyc->status === 'PENDING' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                            {{ $kyc->status }}
                        </span>
                    </p>
                    
                </div>
            </div>

        {{-- 📝 Case 3: New User / Re-apply Form --}}
        @else
            <div class="bg-white rounded-2xl shadow-xl border overflow-hidden">
                {{-- Form Header --}}
                <div class="bg-linear-to-r from-[#1A0A45] to-[#2D1B69] p-6 sm:p-8">
                    <h2 class="text-xl sm:text-2xl font-bold uppercase tracking-wide">Complete Your KYC</h2>
                    <p class="text-sm mt-2">Valid government ID details provide karein for instant verification. 🔒 Secure & Encrypted</p>
                </div>

                <form action="{{ route('seller.settings.kyc.submit') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8" id="kycForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    
                    {{-- Verification Method & Business Type --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-200 hover:border-[#1A0A45]/30 transition">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Verification Method <span class="text-red-500">*</span>
                            </label>
                            <select name="verification_method" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1A0A45]/20 focus:border-[#1A0A45] transition bg-white" required>
                                <option value="Express KYC" {{ old('verification_method') == 'Express KYC' ? 'selected' : '' }}>⚡ Express KYC (Instant)</option>
                                <option value="Standard KYC" {{ old('verification_method') == 'Standard KYC' ? 'selected' : '' }}>📋 Standard KYC (24-48 hrs)</option>
                            </select>
                        </div>

                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-200 hover:border-[#1A0A45]/30 transition">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Business Type <span class="text-red-500">*</span>
                            </label>
                            <select name="business_type" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1A0A45]/20 focus:border-[#1A0A45] transition bg-white" required>
                                <option value="">-- Select Business Type --</option>
                                <option value="Individual" {{ old('business_type') == 'Individual' ? 'selected' : '' }}>👤 Individual</option>
                                <option value="Proprietorship" {{ old('business_type') == 'Proprietorship' ? 'selected' : '' }}>🏪 Proprietorship</option>
                                <option value="Partnership" {{ old('business_type') == 'Partnership' ? 'selected' : '' }}>🤝 Partnership</option>
                                <option value="Private Limited" {{ old('business_type') == 'Private Limited' ? 'selected' : '' }}>🏢 Private Limited</option>
                                <option value="LLP" {{ old('business_type') == 'LLP' ? 'selected' : '' }}>📜 LLP</option>
                            </select>
                        </div>
                    </div>

                    {{-- Profile Photo Upload --}}
                    <div class="p-6 bg-linear-to-br from-gray-50 to-white rounded-2xl border-2 border-dashed border-gray-300 hover:border-[#1A0A45] hover:bg-[#F8F9FD] transition-all cursor-pointer group" 
                         onclick="document.getElementById('user_photo').click()">
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <div class="relative w-24 h-24 rounded-2xl bg-linear-to-br from-[#1A0A45] to-[#6B4C9A] flex items-center justify-center overflow-hidden shadow-lg group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-camera text-white text-3xl" id="cameraIcon"></i>
                                <img id="profilePreview" class="hidden w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fa-solid fa-pen text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <label class="block text-sm font-bold text-gray-700 cursor-pointer">
                                    Profile Photo <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Clear face photo • JPG/PNG • Max 2MB</p>
                                <p class="text-xs text-[#1A0A45] font-medium mt-2 group-hover:underline">
                                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Click to upload or drag & drop
                                </p>
                                <input type="file" name="user_photo" id="user_photo" class="hidden" accept="image/*" required onchange="previewImage(this, 'profilePreview', 'cameraIcon', 2)">
                            </div>
                        </div>
                        @error('user_photo') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- PAN & Aadhaar Cards Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- PAN Card --}}
                        <div class="bg-linear-to-br from-white to-gray-50 p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                                <div class="w-10 h-10 rounded-xl bg-[#1A0A45]/10 flex items-center justify-center shrink-0">
                                    <i class="fa-regular fa-id-card text-[#1A0A45] text-lg"></i>
                                </div>
                                <h3 class="font-bold text-[#1A0A45]">PAN Card</h3>
                                
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">PAN Number</label>
                                    <div class="relative">
                                        <i class="fa-solid fa-fingerprint absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" name="pan_number" value="{{ old('pan_number') }}" 
                                               class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1A0A45]/20 focus:border-[#1A0A45] transition-all uppercase placeholder:text-gray-300 font-mono" 
                                               placeholder="ABCDE1234F" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" >
                                    </div>
                                    @error('pan_number') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Upload PAN Card</label>
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-[#1A0A45]/50 transition">
                                        <i class="fa-solid fa-cloud-arrow-up text-gray-400 text-lg"></i>
                                        <input type="file" name="pan_card_image" id="pan_card_image" 
                                               class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#1A0A45] file:text-white file:text-xs file:font-medium hover:file:bg-[#0f0529] transition cursor-pointer" 
                                               accept="image/*,.pdf" >
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, PDF • Max 5MB</p>
                                    @error('pan_card_image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Aadhaar Card --}}
                        <div class="bg-linear-to-br from-white to-gray-50 p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                                <div class="w-10 h-10 rounded-xl bg-[#1A0A45]/10 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-id-badge text-[#1A0A45] text-lg"></i>
                                </div>
                                <h3 class="font-bold text-[#1A0A45]">Aadhaar Card</h3>
                                <span class="ml-auto text-xs bg-green-100 text-green-700 px-2.5 py-1 rounded-full font-medium">Required</span>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Aadhaar Number</label>
                                    <div class="relative">
                                        <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" name="aadhaar_number" value="{{ old('aadhaar_number') }}" 
                                               class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1A0A45]/20 focus:border-[#1A0A45] transition-all placeholder:text-gray-300 font-mono" 
                                               placeholder="1234 5678 9012" maxlength="14" pattern="[0-9]{4} [0-9]{4} [0-9]{4}" required>
                                    </div>
                                    @error('aadhaar_number') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Upload Aadhaar Card</label>
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-[#1A0A45]/50 transition">
                                        <i class="fa-solid fa-cloud-arrow-up text-gray-400 text-lg"></i>
                                        <input type="file" name="aadhaar_card_image" id="aadhaar_card_image" 
                                               class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#1A0A45] file:text-white file:text-xs file:font-medium hover:file:bg-[#0f0529] transition cursor-pointer" 
                                               accept="image/*,.pdf" required>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, PDF • Max 5MB</p>
                                    @error('aadhaar_card_image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Security Note --}}
                    <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <i class="fa-solid fa-lock text-blue-500 mt-0.5"></i>
                        <p class="text-sm text-blue-800">
                            <strong>Your data is secure:</strong> All documents are encrypted and stored securely. We never share your personal information with third parties.
                        </p>
                    </div>

                    {{-- Submit Actions --}}
                    <div class="hidden lg:flex justify-end items-center gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ url()->previous() }}" class="px-6 py-3 text-gray-600 font-medium hover:text-gray-800 transition flex items-center">
                            <i class="fa-solid fa-xmark mr-2"></i> Cancel
                        </a>
                        <button type="submit" id="submitBtn" class="px-8 py-3 bg-linear-to-r  rounded-xl font-bold hover:from-[#0f0529] hover:to-[#1A0A45] transition shadow-lg hover:shadow-xl active:scale-95 flex items-center">
                            <span id="btnText">Submit KYC Details</span>
                            <i id="btnIcon" class="fa-solid fa-paper-plane ml-2"></i>
                            <i id="btnSpinner" class="fa-solid fa-spinner animate-spin ml-2 hidden"></i>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Mobile Sticky Action Bar --}}
            <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-2xl z-50 safe-area-pb">
                <div class="flex gap-3">
                    <a href="{{ url()->previous() }}" class="flex-1 px-4 py-3 text-center border border-gray-300 rounded-xl font-medium text-gray-700 hover:bg-gray-50 transition flex items-center justify-center">
                        <i class="fa-solid fa-xmark mr-1"></i> Cancel
                    </a>
                    <button type="submit" form="kycForm" id="mobileSubmitBtn" class="flex-1 px-4 py-3  rounded-xl font-bold shadow-lg active:scale-95 transition flex items-center justify-center">
                        <span id="mobileBtnText">Submit</span>
                        <i id="mobileBtnSpinner" class="fa-solid fa-spinner animate-spin ml-2 hidden"></i>
                    </button>
                </div>
            </div>
            <div class="lg:hidden h-20"></div> {{-- Spacer for mobile bar --}}
        @endif

    </div>
</div>

{{-- ✨ Enhanced JavaScript --}}
<script>
    // Image Preview with Validation
    function previewImage(input, previewId, iconId, maxSizeMB) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSize = maxSizeMB * 1024 * 1024;
            
            if (file.size > maxSize) {
                alert(`⚠️ File size should be less than ${maxSizeMB}MB`);
                input.value = '';
                return;
            }
            
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!validTypes.includes(file.type)) {
                alert('⚠️ Please upload only JPG, PNG or PDF files');
                input.value = '';
                return;
            }
            
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    const icon = document.getElementById(iconId);
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if(icon) icon.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                // PDF preview fallback
                document.getElementById(previewId).classList.add('hidden');
                if(document.getElementById(iconId)) {
                    document.getElementById(iconId).classList.remove('hidden');
                }
            }
        }
    }

    // PAN Auto-uppercase
    document.querySelector('input[name="pan_number"]')?.addEventListener('input', function(e) {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10);
    });

    // Aadhaar Auto-format with spaces
    document.querySelector('input[name="aadhaar_number"]')?.addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, '').substring(0, 12);
        let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
        this.value = formatted;
    });

    // Form Submit with Loading State
    document.getElementById('kycForm')?.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        const mobileBtn = document.getElementById('mobileSubmitBtn');
        const btnText = document.getElementById('btnText');
        const btnIcon = document.getElementById('btnIcon');
        const btnSpinner = document.getElementById('btnSpinner');
        const mobileBtnText = document.getElementById('mobileBtnText');
        const mobileBtnSpinner = document.getElementById('mobileBtnSpinner');
        
        if (submitBtn) {
            submitBtn.disabled = true;
            if(btnText) btnText.textContent = 'Submitting...';
            if(btnIcon) btnIcon.classList.add('hidden');
            if(btnSpinner) btnSpinner.classList.remove('hidden');
        }
        if (mobileBtn) {
            mobileBtn.disabled = true;
            if(mobileBtnText) mobileBtnText.textContent = 'Wait...';
            if(mobileBtnSpinner) mobileBtnSpinner.classList.remove('hidden');
        }
        
        // Form will submit normally; if using AJAX, preventDefault and handle accordingly
    });

    // Input Focus Animation Enhancement
    document.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('focus', function() {
            this.classList.add('ring-2', 'ring-[#1A0A45]/20', 'border-[#1A0A45]');
        });
        input.addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-[#1A0A45]/20', 'border-[#1A0A45]');
        });
    });

    // Drag & Drop Support for File Uploads
    document.querySelectorAll('[onclick*="user_photo"]').forEach(zone => {
        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            zone.classList.add('border-[#1A0A45]', 'bg-[#F8F9FD]');
        });
        zone.addEventListener('dragleave', () => {
            zone.classList.remove('border-[#1A0A45]', 'bg-[#F8F9FD]');
        });
        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('border-[#1A0A45]', 'bg-[#F9FD]');
            const input = zone.querySelector('input[type="file"]');
            if (input && e.dataTransfer.files[0]) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
</script>

{{-- 🎨 Optional: Confetti Animation for Verified Status --}}
@if(isset($kyc) && $kyc->status === 'VERIFIED')
<script>
    // Simple confetti effect (vanilla JS)
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('kycConfettiShown') !== 'true') {
            const colors = ['#00C06A', '#1A0A45', '#FFD700', '#FF6B6B'];
            
            for(let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.style.cssText = `
                    position: fixed;
                    width: 10px;
                    height: 10px;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    top: -10px;
                    left: ${Math.random() * 100}vw;
                    border-radius: ${Math.random() > 0.5 ? '50%' : '0'};
                    animation: fall ${2 + Math.random() * 3}s linear forwards;
                    z-index: 9999;
                    opacity: 0.8;
                `;
                document.body.appendChild(confetti);
                
                setTimeout(() => confetti.remove(), 5000);
            }
            
            // Add keyframes
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fall {
                    to {
                        transform: translateY(100vh) rotate(720deg);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
            
            localStorage.setItem('kycConfettiShown', 'true');
        }
    });
</script>
@endif

@endsection

{{-- 💡 Tailwind Config Tip: Ensure these are in your tailwind.config.js --}}
{{-- 
module.exports = {
    theme: {
        extend: {
            animation: {
                'bounce-slow': 'bounce 2s infinite',
            }
        }
    }
}
--}}