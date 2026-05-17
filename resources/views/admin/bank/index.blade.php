@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-university"></i>
                </div>
                Seller Bank Verification
            </h1>
            <p class="text-slate-500 text-sm mt-1 ml-1">Review and manage bank account submissions from sellers.</p>
        </div>
        
        {{-- Quick Stats --}}
        <div class="flex gap-3">
            <div class="bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm text-center">
                <span class="block text-xs text-slate-500 uppercase font-semibold">Pending</span>
                <!-- Note: Calculating stats on paginator collection requires getting all items, usually better to do in controller. 
                     But for simple display, we can count the current page or pass stats from controller. 
                     Here assuming you might want total counts, but for now keeping it simple. -->
                <span class="block text-xl font-bold text-amber-600">{{ $bankDetails->where('status', 'pending')->count() }}</span>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm text-center">
                <span class="block text-xs text-slate-500 uppercase font-semibold">Approved</span>
                <span class="block text-xl font-bold text-green-600">{{ $bankDetails->where('status', 'approved')->count() }}</span>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Seller & Company</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Bank Account Details</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">IFSC Code</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Documents</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">KYC Status</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Verification Status</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    
                    {{-- ✅ IMPORTANT: The 'as $detail' part defines the variable for the row --}}
                    @forelse($bankDetails as $detail)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            
                            {{-- 1. Seller & Company Info --}}
                            <td class="px-6 py-4 align-top">
                                <div class="flex items-start gap-3">
                                    @if($detail->logo)
                                        <img src="{{ asset('storage/' . $detail->logo) }}" alt="Logo" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                            {{ strtoupper(substr($detail->company_name ?? $detail->user_name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800">{{ $detail->company_name ?? 'N/A' }}</span>
                                        @if($detail->brand_name)
                                            <span class="text-xs text-slate-500"><i class="fas fa-tag mr-1"></i>{{ $detail->brand_name }}</span>
                                        @endif
                                        <span class="text-[10px] font-mono text-slate-400 mt-0.5">Code: {{ $detail->company_code ?? '-' }}</span>
                                        <span class="text-xs text-slate-600 mt-1">{{ $detail->user_name }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $detail->user_email }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- 2. Bank Account Details --}}
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col gap-1">
                                    <div>
                                        <span class="text-xs text-slate-400 block">Account Number</span>
                                        <span class="font-mono font-medium text-slate-700">{{ $detail->account_number }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-400 block">Beneficiary Name</span>
                                        <span class="text-slate-700 truncate max-w-[150px]" title="{{ $detail->beneficiary_name }}">{{ $detail->beneficiary_name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-400 block">Type</span>
                                        <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] uppercase font-bold">{{ $detail->account_type }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- 3. IFSC Code --}}
                            <td class="px-6 py-4 align-top">
                                <span class="font-mono text-slate-700 bg-slate-100 px-2 py-1 rounded text-xs font-bold">
                                    {{ strtoupper($detail->ifsc_code) }}
                                </span>
                            </td>

                            {{-- 4. Documents (Cheque) --}}
                            <td class="px-6 py-4 align-top">
                                @if($detail->cheque_image)
                                   <a href="{{ route('admin.bank.cheque.view', $detail->id) }}" target="_blank">
    View Cheque
</a>
                                @else
                                    <span class="text-slate-400 text-xs italic">No Document</span>
                                @endif
                                
                            </td>

                            {{-- 5. KYC Status --}}
                            <td class="px-6 py-4 align-top">
                                @php
                                    $kycColor = match($detail->kyc_status) {
                                        'VERIFIED' => 'bg-green-100 text-green-700 border-green-200',
                                        'REJECTED' => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-slate-100 text-slate-600 border-slate-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase border {{ $kycColor }}">
                                    {{ $detail->kyc_status ?? 'Not Submitted' }}
                                </span>
                            </td>

                            {{-- 6. Verification Status --}}
                            <td class="px-6 py-4 align-top">
                                @if($detail->status === 'approved')
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200 w-fit">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                        <span class="text-[10px] text-slate-400">By Admin #{{ $detail->verified_by }}</span>
                                    </div>
                                @elseif($detail->status === 'rejected')
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200 w-fit">
                                            <i class="fas fa-times-circle"></i> Rejected
                                        </span>
                                        <span class="text-[10px] text-red-500 max-w-[120px] truncate" title="{{ $detail->rejection_reason }}">
                                            {{ $detail->rejection_reason }}
                                        </span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700 border border-amber-200 w-fit">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>

                            {{-- 7. Actions --}}
                            <td class="px-6 py-4 align-top text-center">
                                <div class="flex items-center justify-center gap-2">
                                    
                                    {{-- ✅ NEW: View Details Button --}}
                                    <a href="{{ route('admin.bank.show', $detail->id) }}" 
                                       class="w-8 h-8 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors flex items-center justify-center shadow-sm" 
                                       title="View Full Details">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>

                                    @if($detail->status !== 'approved')
                                        {{-- Approve Button --}}
                                        <form action="{{ route('admin.bank.approve', $detail->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors flex items-center justify-center shadow-sm" title="Approve">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </form>
                                        
                                        {{-- Reject Button Trigger --}}
                                        <button onclick="toggleRejectModal({{ $detail->id }})" class="w-8 h-8 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors flex items-center justify-center shadow-sm" title="Reject">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Locked</span>
                                    @endif
                                </div>

                                {{-- Reject Modal --}}
                                @if($detail->status !== 'approved')
                                <div id="reject-modal-{{ $detail->id }}" class="hidden fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
                                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-100">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-lg font-bold text-slate-800">Reject Request</h3>
                                            <button onclick="toggleRejectModal({{ $detail->id }})" class="text-slate-400 hover:text-slate-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <p class="text-sm text-slate-500 mb-4">Provide a reason for rejecting <strong>{{ $detail->company_name ?? $detail->user_name }}</strong>'s bank details.</p>
                                        
                                        <form action="{{ route('admin.bank.reject', $detail->id) }}" method="POST">
                                            @csrf
                                            <textarea name="reason" rows="4" class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none resize-none" placeholder="e.g., IFSC code does not match bank name..." required></textarea>
                                            
                                            <div class="flex justify-end gap-3 mt-6">
                                                <button type="button" onclick="toggleRejectModal({{ $detail->id }})" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">Cancel</button>
                                                <button type="submit" class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 shadow-md transition-colors">Confirm Rejection</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-inbox text-2xl text-slate-400"></i>
                                </div>
                                <p class="text-slate-600 font-medium">No bank details submitted yet.</p>
                                <p class="text-slate-400 text-sm mt-1">Sellers will appear here once they add their bank information.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bankDetails->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $bankDetails->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function toggleRejectModal(id) {
        const modal = document.getElementById(`reject-modal-${id}`);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            // Optional: Add logic to prevent background scroll
        } else {
            modal.classList.add('hidden');
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('fixed')) {
            event.target.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection