{{-- resources/views/admin/costomer/kycAppreved.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'KYC Verification Review')

@push('styles')
<style>
    /* Custom Styles for KYC Review */
    .doc-preview-container {
        position: relative;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .doc-preview-container:hover {
        border-color: #D4AF37;
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.15);
    }
    .doc-preview {
        width: 100%;
        height: 200px;
        object-fit: contain;
        background: #f8fafc;
    }
    .doc-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .doc-preview-container:hover .doc-overlay {
        opacity: 1;
    }
    .status-badge {
        padding: 0.375rem 1rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .status-pending { background: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
    .status-verified { background: #dcfce7; color: #166534; border: 1px solid #22c55e; }
    .status-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
    
    .info-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s;
    }
    .info-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }
    .info-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .info-value {
        font-size: 0.95rem;
        color: #1e293b;
        font-weight: 500;
    }
    .section-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
    }
    .btn-approve {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        transition: all 0.3s;
    }
    .btn-approve:hover {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
    }
    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        transition: all 0.3s;
    }
    .btn-reject:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }
    .btn-back {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        transition: all 0.3s;
    }
    .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.4s ease-out;
    }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6">
    
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-fade-in">
        <div class="flex items-center gap-4">
            <a href="{{ route('kyc.pending') }}" class="btn-back px-4 py-2 rounded-lg font-medium">
                <i class="fa-solid fa-arrow-left mr-2"></i>Back
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    <i class="fa-solid fa-id-card-clip mr-2 text-gold"></i>
                    KYC Verification Review
                </h1>
                <p class="text-slate-500 text-sm mt-1">Review seller documents and verify identity</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="status-badge status-{{ strtolower($kyc->status) }}">
                {{ $kyc->status }}
            </span>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-r animate-fade-in" role="alert">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r animate-fade-in" role="alert">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Left Column - User & Business Info --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- User Information --}}
            <div class="info-card animate-fade-in">
                <div class="flex items-center mb-4">
                    <div class="section-icon bg-blue-100">
                        <i class="fa-regular fa-user text-blue-600 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">User Information</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="info-label">Full Name</p>
                        <p class="info-value">{{ $kyc->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="info-label">Email Address</p>
                        <p class="info-value">{{ $kyc->user->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="info-label">Phone Number</p>
                        <p class="info-value">{{ $kyc->user->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="info-label">User ID</p>
                        <p class="info-value">#{{ $kyc->user->id ?? 'N/A' }}</p>
                    </div>
                    @if($kyc->user_photo)
                    <div class="col-span-2">
                        <p class="info-label">Profile Photo</p>
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $kyc->user_photo) }}" 
                                 alt="User Photo" 
                                 class="w-24 h-24 rounded-full object-cover border-4 border-slate-200">
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Business Information --}}
            <div class="info-card animate-fade-in">
                <div class="flex items-center mb-4">
                    <div class="section-icon bg-purple-100">
                        <i class="fa-solid fa-briefcase text-purple-600 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Business Information</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="info-label">Business Type</p>
                        <p class="info-value">
                            <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded text-sm">
                                {{ $kyc->business_type ?? 'Individual' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="info-label">Verification Method</p>
                        <p class="info-value">{{ $kyc->verification_method ?? 'Express KYC' }}</p>
                    </div>
                    <div>
                        <p class="info-label">PAN Number</p>
                        <p class="info-value font-mono">{{ $kyc->pan_number ?? 'Not Provided' }}</p>
                    </div>
                    <div>
                        <p class="info-label">Aadhaar Number</p>
                        <p class="info-value font-mono">{{ $kyc->aadhaar_number ?? 'Not Provided' }}</p>
                    </div>
                </div>
            </div>

            {{-- Document Previews --}}
            <div class="info-card animate-fade-in">
                <div class="flex items-center mb-4">
                    <div class="section-icon bg-amber-100">
                        <i class="fa-regular fa-file-image text-amber-600 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Uploaded Documents</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    {{-- PAN Card --}}
                    <div>
                        <p class="info-label mb-2">PAN Card</p>
                        @if($kyc->pan_card_image)
                            <div class="doc-preview-container">
                                <img src="{{ asset('storage/' . $kyc->pan_card_image) }}" 
                                     alt="PAN Card" 
                                     class="doc-preview">
                                <a href="{{ asset('storage/' . $kyc->pan_card_image) }}" 
                                   target="_blank"
                                   class="doc-overlay">
                                    <button class="bg-white text-slate-800 px-4 py-2 rounded-lg font-medium hover:bg-slate-100 transition">
                                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>View Full Size
                                    </button>
                                </a>
                            </div>
                        @else
                            <div class="h-48 bg-slate-100 rounded-lg flex items-center justify-center border-2 border-dashed border-slate-300">
                                <div class="text-center">
                                    <i class="fa-regular fa-file text-3xl text-slate-400 mb-2"></i>
                                    <p class="text-sm text-slate-500">PAN Card not uploaded</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Aadhaar Card --}}
                    <div>
                        <p class="info-label mb-2">Aadhaar Card</p>
                        @if($kyc->aadhaar_card_image)
                            <div class="doc-preview-container">
                                <img src="{{ asset('storage/' . $kyc->aadhaar_card_image) }}" 
                                     alt="Aadhaar Card" 
                                     class="doc-preview">
                                <a href="{{ asset('storage/' . $kyc->aadhaar_card_image) }}" 
                                   target="_blank"
                                   class="doc-overlay">
                                    <button class="bg-white text-slate-800 px-4 py-2 rounded-lg font-medium hover:bg-slate-100 transition">
                                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>View Full Size
                                    </button>
                                </a>
                            </div>
                        @else
                            <div class="h-48 bg-slate-100 rounded-lg flex items-center justify-center border-2 border-dashed border-slate-300">
                                <div class="text-center">
                                    <i class="fa-regular fa-file text-3xl text-slate-400 mb-2"></i>
                                    <p class="text-sm text-slate-500">Aadhaar Card not uploaded</p>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- Right Column - Actions --}}
        <div class="space-y-6">
            <div class="info-card animate-fade-in sticky top-6">
                <div class="flex items-center mb-4">
                    <div class="section-icon bg-gold/20">
                        <i class="fa-solid fa-gavel text-gold text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Verification Action</h3>
                </div>

                @if($kyc->status == 'PENDING')
                    <div class="space-y-4">
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                            <p class="text-sm text-amber-800">
                                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                                This application is pending review
                            </p>
                        </div>

                        <form method="POST" action="{{ route('kyc.approve', $kyc->id) }}" 
                              onsubmit="return confirm('✅ Are you sure you want to APPROVE this KYC?')">
                            @csrf
                            <button type="submit" class="w-full btn-approve py-3 px-4 rounded-lg font-semibold">
                                <i class="fa-solid fa-circle-check mr-2"></i>Approve KYC
                            </button>
                        </form>

                        <button type="button" 
                                onclick="openRejectModal()"
                                class="w-full btn-reject py-3 px-4 rounded-lg font-semibold">
                            <i class="fa-solid fa-circle-xmark mr-2"></i>Reject KYC
                        </button>
                    </div>
                @elseif($kyc->status == 'VERIFIED')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-circle-check text-3xl text-green-600"></i>
                        </div>
                        <p class="font-semibold text-green-800 mb-1">KYC Verified</p>
                        <p class="text-sm text-green-600">
                            @if($kyc->verified_at)
                                Approved on {{ $kyc->verified_at->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                @elseif($kyc->status == 'REJECTED')
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-circle-xmark text-3xl text-red-600"></i>
                        </div>
                        <p class="font-semibold text-red-800 mb-1">KYC Rejected</p>
                        @if($kyc->admin_remarks)
                            <div class="mt-3 p-3 bg-white rounded border border-red-100">
                                <p class="text-sm text-red-600">{{ $kyc->admin_remarks }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-red-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Reject KYC Application</h3>
                <p class="text-sm text-slate-500">Provide a reason for rejection</p>
            </div>
        </div>
        
        <form id="rejectForm" method="POST" action="{{ route('kyc.reject', $kyc->id) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Rejection Reason <span class="text-red-500">*</span>
                </label>
                <textarea name="rejection_reason" 
                          id="rejectionReason" 
                          rows="4" 
                          class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-200 focus:border-red-500 outline-none resize-none"
                          placeholder="Reason for rejection..." 
                          required></textarea>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2.5 btn-back rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2.5 btn-reject rounded-lg font-medium">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('rejectModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeRejectModal();
    });
</script>
@endpush