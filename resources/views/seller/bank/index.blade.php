@extends('seller.layouts.app') 

@section('content')
<div class="max-w-5xl mx-auto">
    
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                <span class="text-green-700 font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i class="fas fa-times"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                <span class="text-red-700 font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i class="fas fa-times"></i></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-gold flex items-center justify-center text-white shadow-lg shadow-yellow-200">
                <i class="fas fa-university"></i>
            </div>
            {{ $isEditMode ? 'Update Bank Account' : 'Bank Account Management' }}
        </h1>
        <p class="text-gray-500 text-sm mt-1 ml-1">
            @if(!$bankDetail && !$isEditMode)
                Add your bank details to receive payouts.
            @elseif($isEditMode)
                Edit your details below. Changes will require admin re-verification.
            @else
                View and manage your verified bank account.
            @endif
        </p>
    </div>

    {{-- SCENARIO 1: SHOW FORM (If No Data OR If Edit Mode is Active) --}}
    @if(!$bankDetail || $isEditMode)
        
        @php
            // Helper to get value: Priority -> Old Input -> Session Edit Data -> Default
            $getValue = fn($field, $default = '') => old($field, $isEditMode && $editData ? $editData->$field : $default);
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="font-semibold text-gray-700 flex items-center gap-2">
                    <i class="fas {{ !$bankDetail ? 'fa-plus-circle' : 'fa-edit' }} text-gold"></i> 
                    {{ !$bankDetail ? 'Add New Bank Account' : 'Edit Existing Details' }}
                </h3>
                @if($isEditMode)
                    <a href="{{ route('bank-details.create') }}" class="text-xs text-gray-500 hover:text-gray-800 font-medium flex items-center gap-1">
                        <i class="fas fa-times"></i> Cancel Edit
                    </a>
                @endif
            </div>
            
            <form action="{{ route('bank-details.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Beneficiary Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Beneficiary Name <span class="text-red-500">*</span></label>
                        <input type="text" name="beneficiary_name" value="{{ $getValue('beneficiary_name') }}" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 transition-all @error('beneficiary_name') @enderror"
                            placeholder="Name exactly as per bank passbook">
                        @error('beneficiary_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Account Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Type <span class="text-red-500">*</span></label>
                        <select name="account_type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 transition-all @error('account_type') @enderror">
                            <option value="" disabled selected>Select Type</option>
                            <option value="saving" {{ $getValue('account_type') == 'saving' ? 'selected' : '' }}>Savings Account</option>
                            <option value="current" {{ $getValue('account_type') == 'current' ? 'selected' : '' }}>Current Account</option>
                        </select>
                        @error('account_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Account Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Number <span class="text-red-500">*</span></label>
                        <input type="text" name="account_number" value="{{ $getValue('account_number') }}" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 transition-all font-mono @error('account_number') @enderror"
                            placeholder="Enter account number">
                        @error('account_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Account Number -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Account Number <span class="text-red-500">*</span></label>
                        <input type="text" name="account_number_confirmation" value="{{ $getValue('account_number') }}" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 transition-all font-mono @error('account_number_confirmation') @enderror"
                            placeholder="Re-enter account number">
                        @error('account_number_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- IFSC Code -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">IFSC Code <span class="text-red-500">*</span></label>
                        <input type="text" name="ifsc_code" value="{{ $getValue('ifsc_code') }}" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-yellow-200 transition-all font-mono uppercase @error('ifsc_code') @enderror"
                            placeholder="e.g. SBIN0001234">
                        @error('ifsc_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Cheque Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Upload Cheque / Passbook 
                            @if(!$bankDetail) <span class="text-red-500">*</span> 
                            @else <span class="text-gray-400 text-xs font-normal">(Optional: Leave empty to keep current)</span>
                            @endif
                        </label>
                        
                        @if($isEditMode && $editData && $editData->cheque_image)
                            <div class="mb-3 flex items-center gap-2 text-xs bg-blue-50 text-blue-700 p-2 rounded border border-blue-100">
                                <i class="fas fa-file-image"></i>
                                <span>Current file uploaded.</span>
                                <a href="{{ route('bank-details.document', $editData->id) }}" target="_blank" class="underline font-bold hover:text-blue-900">View Current</a>
                            </div>
                        @endif

                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gold hover:bg-yellow-50 transition-all cursor-pointer relative">
                            <input type="file" name="cheque_image" id="cheque_upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*,.pdf">
                            <div class="space-y-1 text-center pointer-events-none">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="font-medium text-gold">Upload a file</span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, PDF up to 2MB</p>
                            </div>
                        </div>
                        @error('cheque_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <a href="{{ route('seller.dashboard') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-gold rounded-lg shadow-md hover:shadow-lg hover:bg-gold-dark transition-all transform hover:-translate-y-0.5">
                        {{ $isEditMode ? 'Update Details' : 'Submit for Verification' }}
                    </button>
                </div>
            </form>
        </div>

    {{-- SCENARIO 2: SHOW DETAILS (Only if Data Exists AND Not in Edit Mode) --}}
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Account Information Card -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-700 flex items-center gap-2">
                        <i class="far fa-id-card text-gold"></i> Account Information
                    </h3>
                    <span class="text-xs font-mono text-gray-400 bg-gray-100 px-2 py-1 rounded">ID: #{{ $bankDetail->id }}</span>
                </div>
                
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8">
                        <!-- Beneficiary Name -->
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 uppercase tracking-wider">Beneficiary Name</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 flex items-center gap-2">
                                {{ $bankDetail->beneficiary_name }}
                                <i class="fas fa-user-check text-green-500 text-xs" title="Name Matched"></i>
                            </dd>
                        </div>

                        <!-- Account Number -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 uppercase tracking-wider">Account Number</dt>
                            <dd class="mt-1 font-mono text-gray-800 bg-gray-50 inline-block px-3 py-1.5 rounded border border-gray-200">
                                {{ $bankDetail->account_number }}
                            </dd>
                        </div>

                        <!-- IFSC Code -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 uppercase tracking-wider">IFSC Code</dt>
                            <dd class="mt-1 font-mono text-gray-800 bg-gray-50 inline-block px-3 py-1.5 rounded border border-gray-200 uppercase">
                                {{ $bankDetail->ifsc_code }}
                            </dd>
                        </div>

                        <!-- Account Type -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 uppercase tracking-wider">Account Type</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ ucfirst($bankDetail->account_type) }}
                                </span>
                            </dd>
                        </div>

                        <!-- Cheque Image -->
                        @if($bankDetail->cheque_image)
                        <div class="sm:col-span-2 pt-4 border-t border-gray-100 mt-2">
                            <dt class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Uploaded Document</dt>
                            <dd>
                                <a href="{{ route('bank-details.document', $bankDetail->id) }}" target="_blank" class="group flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-gold hover:bg-yellow-50 transition-all duration-200">
                                    <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center text-gray-500 group-hover:text-gold group-hover:bg-white shadow-sm">
                                        <i class="fas fa-file-image text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">View Cheque / Passbook</p>
                                        <p class="text-xs text-gray-500">Click to open securely</p>
                                    </div>
                                    <i class="fas fa-external-link-alt text-gray-400 group-hover:text-gold"></i>
                                </a>
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Right Column: Status & Actions -->
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Status Card --}}
                @php
                    $statusConfig = [
                        'approved' => ['color' => 'text-green-600', 'bg' => 'bg-green-50', 'border' => 'border-green-100', 'icon' => 'fa-check-circle', 'label' => 'Verified'],
                        'rejected' => ['color' => 'text-red-600', 'bg' => 'bg-red-50', 'border' => 'border-red-100', 'icon' => 'fa-times-circle', 'label' => 'Rejected'],
                        'pending'  => ['color' => 'text-amber-600', 'bg' => 'bg-amber-50', 'border' => 'border-amber-100', 'icon' => 'fa-clock', 'label' => 'Pending Review'],
                    ];
                    $current = $statusConfig[$bankDetail->status] ?? $statusConfig['pending'];
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-700">Verification Status</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="w-12 h-12 rounded-full {{ $current['bg'] }} {{ $current['color'] }} flex items-center justify-center flex-shrink-0">
                                <i class="fas {{ $current['icon'] }} text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold {{ $current['color'] }}">{{ $current['label'] }}</h4>
                                <p class="text-sm text-gray-500 mt-1">
                                  @if($bankDetail->verified_at)
    Updated: {{ \Carbon\Carbon::parse($bankDetail->verified_at)->format('d M Y, h:i A') }}
@else
    Waiting for admin approval
@endif
                                </p>
                                
                            </div>



                        </div>

                        {{-- Rejection Reason --}}
                        @if($bankDetail->status == 'rejected' && $bankDetail->rejection_reason)
                            <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-6">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                                    <div>
                                        <h5 class="text-sm font-bold text-red-700">Reason for Rejection</h5>
                                        <p class="text-sm text-red-600 mt-1 leading-relaxed">{{ $bankDetail->rejection_reason }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Verified Badge Details --}}
                        @if($bankDetail->status == 'approved')
                            <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                                <div class="flex items-center gap-2 text-green-700 text-sm font-medium mb-2">
                                    <i class="fas fa-shield-alt"></i> Securely Verified
                                </div>
                                <p class="text-xs text-green-600">
                                    Verified by Admin ID: <span class="font-mono font-bold">#{{ $bankDetail->verified_by ?? 'N/A' }}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Button: Only show if Pending or Rejected --}}
                @if(in_array($bankDetail->status, ['pending', 'rejected']))
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                        <p class="text-sm text-gray-500 mb-4">
                            @if($bankDetail->status == 'rejected')
                                Please correct the errors above and resubmit.
                            @else
                                Your details are under review. You can update them if needed.
                            @endif
                        </p>
                        <a href="{{ route('bank-details.edit', $bankDetail->id) }}" class="w-full inline-flex justify-center items-center px-4 py-3 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition-colors shadow-md">
                            <i class="fas fa-edit mr-2"></i> Update Details
                        </a>
                    </div>
                @else
                    {{-- Approved State: No Edit Allowed --}}
                    <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6 text-center opacity-75">
                        <i class="fas fa-lock text-gray-400 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-500 font-medium">Account Verified</p>
                        <p class="text-xs text-gray-400 mt-1">Contact support to change bank details.</p>
                    </div>
                @endif

            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(10px)';
            setTimeout(() => {
                card.style.transition = 'all 0.4s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endpush
@endsection