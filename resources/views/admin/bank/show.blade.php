@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header with Back Button --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.bank.index') }}" class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Bank Verification Details</h1>
                <p class="text-slate-500 text-sm">Request ID: #{{ $detail->id }}</p>
            </div>
        </div>
        
        {{-- Status Badge --}}
        <div>
            @if($detail->status === 'approved')
                <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold text-sm border border-green-200">
                    <i class="fas fa-check-circle mr-2"></i> Verified
                </span>
            @elseif($detail->status === 'rejected')
                <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 font-bold text-sm border border-red-200">
                    <i class="fas fa-times-circle mr-2"></i> Rejected
                </span>
            @else
                <span class="px-4 py-2 rounded-full bg-amber-100 text-amber-700 font-bold text-sm border border-amber-200 animate-pulse">
                    <i class="fas fa-clock mr-2"></i> Pending Review
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- LEFT COLUMN: Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- 1. Bank Account Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-indigo-600 text-white flex items-center justify-center">
                        <i class="fas fa-university text-sm"></i>
                    </div>
                    <h3 class="font-bold text-indigo-900">Bank Account Information</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-semibold text-slate-400 uppercase">Beneficiary Name</label>
                        <p class="text-lg font-medium text-slate-800 mt-1">{{ $detail->beneficiary_name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-400 uppercase">Account Number</label>
                        <p class="text-lg font-mono font-medium text-slate-800 mt-1">{{ $detail->account_number }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-400 uppercase">IFSC Code</label>
                        <p class="text-lg font-mono font-medium text-slate-800 mt-1 bg-slate-100 inline-block px-2 rounded">{{ strtoupper($detail->ifsc_code) }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-400 uppercase">Account Type</label>
                        <p class="text-lg font-medium text-slate-800 mt-1 capitalize">{{ $detail->account_type }}</p>
                    </div>
                    
                    {{-- ✅ FIXED: Cheque Image Section --}}
                    @if($detail->cheque_image)
                    <div class="md:col-span-2 mt-4 pt-4 border-t border-slate-100">
                        <label class="text-xs font-semibold text-slate-400 uppercase mb-2 block">Uploaded Cheque / Passbook</label>
                        
                        {{-- Corrected Anchor Tag wrapping the Div --}}
                        <a href="{{ route('admin.bank.cheque.view', $detail->id) }}" target="_blank" class="group block">
                            <div class="aspect-video bg-slate-50 border-2 border-dashed border-slate-200 rounded-lg flex items-center justify-center group-hover:border-indigo-400 group-hover:bg-indigo-50 transition-all cursor-pointer">
                                <div class="text-center">
                                    <i class="fas fa-file-image text-4xl text-slate-300 group-hover:text-indigo-500 mb-2 transition-colors"></i>
                                    <p class="text-sm font-medium text-indigo-600">Click to View Full Image</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- 2. Seller & Company Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-slate-600 text-white flex items-center justify-center">
                        <i class="fas fa-building text-sm"></i>
                    </div>
                    <h3 class="font-bold text-slate-800">Seller & Company Profile</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-4 mb-6">
                        @if($detail->logo)
                            {{-- Check if logo is in public disk --}}
                            <img src="{{ asset('storage/' . $detail->logo) }}" class="w-16 h-16 rounded-lg object-cover border border-slate-200">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xl">
                                {{ strtoupper(substr($detail->company_name ?? $detail->user_name, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="text-xl font-bold text-slate-800">{{ $detail->company_name ?? 'N/A' }}</h4>
                            <p class="text-slate-500 text-sm">{{ $detail->brand_name ?? 'No Brand Name' }}</p>
                            <span class="text-xs font-mono text-slate-400 bg-slate-100 px-2 py-0.5 rounded mt-1 inline-block">Code: {{ $detail->company_code ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="block text-slate-400 text-xs uppercase">Contact Person</span>
                            <span class="font-medium text-slate-700">{{ $detail->user_name }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400 text-xs uppercase">Email Address</span>
                            <span class="font-medium text-slate-700">{{ $detail->user_email }}</span>
                        </div>
                        @if($detail->customer_care_mobile)
                        <div>
                            <span class="block text-slate-400 text-xs uppercase">Customer Care Mobile</span>
                            <span class="font-medium text-slate-700">{{ $detail->customer_care_mobile }}</span>
                        </div>
                        @endif
                        @if($detail->website)
                        <div>
                            <span class="block text-slate-400 text-xs uppercase">Website</span>
                            <a href="{{ $detail->website }}" target="_blank" class="font-medium text-indigo-600 hover:underline">{{ $detail->website }}</a>
                        </div>
                        @endif
                        <div>
                            <span class="block text-slate-400 text-xs uppercase">GST Enabled</span>
                            <span class="font-medium {{ $detail->has_gst ? 'text-green-600' : 'text-slate-400' }}">
                                {{ $detail->has_gst ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. KYC Status Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-slate-600 text-white flex items-center justify-center">
                        <i class="fas fa-id-card text-sm"></i>
                    </div>
                    <h3 class="font-bold text-slate-800">KYC Details</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <span class="block text-slate-400 text-xs uppercase">KYC Status</span>
                        <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold 
                            {{ $detail->kyc_status == 'VERIFIED' ? 'bg-green-100 text-green-700' : ($detail->kyc_status == 'REJECTED' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-600') }}">
                            {{ $detail->kyc_status ?? 'Not Submitted' }}
                        </span>
                    </div>
                    @if($detail->pan_number)
                    <div>
                        <span class="block text-slate-400 text-xs uppercase">PAN Number</span>
                        <span class="font-mono font-medium text-slate-700">{{ $detail->pan_number }}</span>
                    </div>
                    @endif
                    @if($detail->business_type)
                    <div>
                        <span class="block text-slate-400 text-xs uppercase">Business Type</span>
                        <span class="font-medium text-slate-700">{{ $detail->business_type }}</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: Actions --}}
        <div class="space-y-6">
            
            {{-- Action Card --}}
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6 sticky top-6">
                <h3 class="font-bold text-slate-800 text-lg mb-4">Verification Actions</h3>
                
                @if($detail->status === 'pending')
                    <div class="space-y-3">
                        <form action="{{ route('admin.bank.approve', $detail->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i> Approve Bank Details
                            </button>
                        </form>
                        
                        <button onclick="document.getElementById('reject-form').classList.toggle('hidden')" class="w-full py-3 bg-white border-2 border-red-200 text-red-600 hover:bg-red-50 font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-times-circle"></i> Reject Request
                        </button>

                        {{-- Inline Reject Form --}}
                        <div id="reject-form" class="hidden mt-4 pt-4 border-t border-slate-100">
                            <form action="{{ route('admin.bank.reject', $detail->id) }}" method="POST">
                                @csrf
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Rejection Reason</label>
                                <textarea name="reason" rows="4" class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-500 outline-none" placeholder="Explain why this is being rejected..." required></textarea>
                                <button type="submit" class="w-full mt-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg shadow">Confirm Rejection</button>
                            </form>
                        </div>
                    </div>

                @elseif($detail->status === 'approved')
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-shield-alt text-2xl"></i>
                        </div>
                        <p class="text-green-700 font-bold">Verified & Active</p>
                        <p class="text-xs text-slate-400 mt-1">Approved by Admin #{{ $detail->verified_by }}</p>
                        <p class="text-xs text-slate-400">{{ $detail->verified_at ? \Carbon\Carbon::parse($detail->verified_at)->format('d M Y, h:i A') : '' }}</p>
                    </div>

                @else
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-ban text-2xl"></i>
                        </div>
                        <p class="text-red-700 font-bold">Rejected</p>
                        <div class="bg-red-50 border border-red-100 rounded p-3 mt-3 text-left">
                            <p class="text-xs font-bold text-red-800 uppercase">Reason:</p>
                            <p class="text-sm text-red-600 mt-1">{{ $detail->rejection_reason ?? 'No reason provided.' }}</p>
                        </div>
                        <p class="text-xs text-slate-400 mt-4">Seller can update and resubmit.</p>
                    </div>
                @endif
            </div>

            {{-- Meta Info --}}
            <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 text-xs text-slate-500">
                <div class="flex justify-between mb-2">
                    <span>Request Date:</span>
                    <span class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($detail->bank_created_at)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>User Since:</span>
                    <span class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($detail->user_registered_at)->format('d M Y') }}</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection