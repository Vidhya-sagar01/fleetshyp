{{-- resources/views/admin/costomer/kycRejectLIst.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Rejected KYC List')

@push('styles')
<style>
    /* Custom Styles */
    .status-badge {
        padding: 0.375rem 1rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .status-verified { 
        background: #dcfce7; 
        color: #166534; 
        border: 1px solid #22c55e; 
    }
    .status-pending { 
        background: #fef3c7; 
        color: #92400e; 
        border: 1px solid #f59e0b; 
    }
    .status-rejected { 
        background: #fee2e2; 
        color: #991b1b; 
        border: 1px solid #ef4444; 
    }
    
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
    
    .user-avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }
    
    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .btn-view {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .btn-view:hover { 
        background: #e2e8f0; 
        color: #1e293b; 
    }
    .btn-reapprove {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
    }
    .btn-reapprove:hover { 
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }
    .btn-download {
        background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
        color: white;
    }
    .btn-download:hover { 
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }
    
    .reason-box {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 0.5rem;
        padding: 0.75rem;
        font-size: 0.8rem;
        color: #991b1b;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.4s ease-out;
    }
    
    .table-row:hover {
        background: linear-gradient(90deg, rgba(239, 68, 68, 0.05) 0%, transparent 100%);
    }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6">
    
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-fade-in">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                <i class="fa-solid fa-circle-xmark mr-2 text-red-600"></i>
                Rejected KYC List
            </h1>
            <p class="text-slate-500 text-sm mt-1">Rejected applications with reasons and re-approval options</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('kyc.pending') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                <i class="fa-solid fa-hourglass-half mr-2"></i>Pending KYC
            </a>
            <a href="{{ route('kyc.approved') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                <i class="fa-solid fa-circle-check mr-2"></i>Approved KYC
            </a>
            <a href="{{ route('kyc.export', 'rejected') }}" class="btn-download px-4 py-2 rounded-lg font-medium">
                <i class="fa-solid fa-download mr-2"></i>Export CSV
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-r animate-fade-in" role="alert">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 animate-fade-in">
        <div class="info-card">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                    <i class="fa-solid fa-circle-xmark text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['total_rejected'] }}</p>
                    <p class="text-xs text-slate-500">Total Rejected</p>
                </div>
            </div>
        </div>
        <div class="info-card">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                    <i class="fa-solid fa-hourglass-half text-amber-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['total_pending'] }}</p>
                    <p class="text-xs text-slate-500">Pending Review</p>
                </div>
            </div>
        </div>
        <div class="info-card">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['total_verified'] }}</p>
                    <p class="text-xs text-slate-500">Total Verified</p>
                </div>
            </div>
        </div>
        <div class="info-card">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fa-solid fa-rotate-right text-blue-600 text-xl"></i>
                </div>
                
            </div>
        </div>
    </div>

    {{-- Filters & Search --}}
    <div class="info-card animate-fade-in">
        <form method="GET" action="{{ route('kyc.rejected') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by name, email, PAN, rejection reason..." 
                           class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
            </div>
            <div class="sm:w-48">
                <select name="business_type" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none bg-white">
                    <option value="">All Business Types</option>
                    <option value="Individual" {{ request('business_type')=='Individual'?'selected':'' }}>Individual</option>
                    <option value="Proprietorship" {{ request('business_type')=='Proprietorship'?'selected':'' }}>Proprietorship</option>
                    <option value="Partnership" {{ request('business_type')=='Partnership'?'selected':'' }}>Partnership</option>
                    <option value="Private Limited" {{ request('business_type')=='Private Limited'?'selected':'' }}>Private Limited</option>
                    <option value="LLP" {{ request('business_type')=='LLP'?'selected':'' }}>LLP</option>
                </select>
            </div>
            <div class="sm:w-48">
                <select name="date_range" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none bg-white">
                    <option value="">All Time</option>
                    <option value="today" {{ request('date_range')=='today'?'selected':'' }}>Today</option>
                    <option value="week" {{ request('date_range')=='week'?'selected':'' }}>This Week</option>
                    <option value="month" {{ request('date_range')=='month'?'selected':'' }}>This Month</option>
                    <option value="year" {{ request('date_range')=='year'?'selected':'' }}>This Year</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition whitespace-nowrap">
                <i class="fa-solid fa-filter mr-2"></i>Filter
            </button>
            @if(request()->anyFilled(['search','business_type','date_range']))
                <a href="{{ route('admin.kyc.rejected') }}" class="px-4 py-2.5 text-slate-600 hover:text-slate-800 transition whitespace-nowrap">
                    <i class="fa-solid fa-times mr-1"></i>Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Rejected KYC Table --}}
    <div class="info-card animate-fade-in overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800">
                <i class="fa-solid fa-list-xmark mr-2 text-red-600"></i>
                Rejected Applications ({{ $rejectedKyc->total() }})
            </h3>
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500">Show:</span>
                <select id="perPageSelect" class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none bg-white">
                    <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
                    <option value="25" {{ request('per_page')==25?'selected':'' }}>25</option>
                    <option value="50" {{ request('per_page')==50?'selected':'' }}>50</option>
                    <option value="100" {{ request('per_page')==100?'selected':'' }}>100</option>
                </select>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Seller</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Business</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Rejection Reason</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Rejected Date</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rejectedKyc as $kyc)
                        <tr class="table-row transition">
                            {{-- Seller Info --}}
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="user-avatar bg-slate-200 flex items-center justify-center overflow-hidden">
                                        @if($kyc->user_photo && Storage::disk('public')->exists($kyc->user_photo))
                                            <img src="{{ Storage::url($kyc->user_photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-regular fa-user text-slate-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $kyc->user->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-slate-500">{{ $kyc->user->email ?? 'N/A' }}</p>
                                        @if($kyc->user->phone)
                                            <p class="text-xs text-slate-400">📞 {{ $kyc->user->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Business Type --}}
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $kyc->business_type }}
                                </span>
                                @if($kyc->pan_number)
                                    <p class="text-xs text-slate-500 mt-1 font-mono">PAN: {{ $kyc->pan_number }}</p>
                                @endif
                            </td>
                            
                            {{-- Rejection Reason --}}
                            <td class="py-4 px-4">
                                @if($kyc->admin_remarks)
                                    <div class="reason-box max-w-xs">
                                        <i class="fa-solid fa-circle-info mr-1"></i>
                                        {{ Str::limit($kyc->admin_remarks, 50) }}
                                    </div>
                                    @if(strlen($kyc->admin_remarks) > 50)
                                        <button type="button" onclick="showFullReason({{ $kyc->id }}, '{{ addslashes($kyc->admin_remarks) }}')" 
                                                class="text-xs text-red-600 hover:text-red-800 font-medium mt-1">
                                            View Full →
                                        </button>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400 italic">No reason provided</span>
                                @endif
                            </td>
                            
                            {{-- Rejected Date --}}
                            <td class="py-4 px-4">
                                <p class="text-sm text-slate-700">{{ $kyc->rejected_at?->format('M d, Y') ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-400">{{ $kyc->rejected_at?->diffForHumans() ?? '-' }}</p>
                            </td>
                            
                            {{-- Status --}}
                            <td class="py-4 px-4">
                                <span class="status-badge status-rejected">
                                    <i class="fa-solid fa-xmark mr-1"></i>{{ $kyc->status }}
                                </span>
                            </td>
                            
                            {{-- Actions --}}
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('kyc.show', $kyc) }}" 
                                       class="action-btn btn-view" title="View Details">
                                        <i class="fa-regular fa-eye mr-1"></i>View
                                    </a>
                                    <form method="POST" action="{{ route('kyc.reapprove', $kyc) }}" 
                                          class="inline" 
                                          onsubmit="return confirm('⚠️ Re-approve this KYC application?\n\nThis will change status to VERIFIED and grant full access.')">
                                        @csrf
                                        <button type="submit" class="action-btn btn-reapprove" title="Re-Approve">
                                            <i class="fa-solid fa-rotate-left mr-1"></i>Re-Approve
                                        </button>
                                    </form>
                                    <a href="{{ route('kyc.download', $kyc) }}" 
                                       class="action-btn btn-download" title="Download Documents">
                                        <i class="fa-solid fa-download mr-1"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="inline-flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                        <i class="fa-solid fa-clipboard-check text-2xl text-slate-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-slate-700 font-medium">No rejected KYC applications</p>
                                        <p class="text-sm text-slate-400">Rejected records will appear here</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="px-4 py-3 border-t border-slate-200 bg-slate-50 flex items-center justify-between">
            <p class="text-sm text-slate-600">
                Showing <span class="font-medium">{{ $rejectedKyc->firstItem() }}</span> to 
                <span class="font-medium">{{ $rejectedKyc->lastItem() }}</span> of 
                <span class="font-medium">{{ $rejectedKyc->total() }}</span> results
            </p>
            <div>
                {{ $rejectedKyc->withQueryString()->links() }}
        </div>
    </div>

</div>

{{-- Full Reason Modal --}}
<div id="reasonModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fa-solid fa-circle-info text-red-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Rejection Reason</h3>
                <p class="text-sm text-slate-500">Full details</p>
            </div>
        </div>
        
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <p id="fullReasonText" class="text-sm text-red-800 whitespace-pre-wrap"></p>
        </div>
        
        <div class="flex justify-end">
            <button type="button" onclick="closeReasonModal()" 
                    class="px-4 py-2.5 bg-slate-800 text-white rounded-lg hover:bg-slate-700 font-medium transition">
                Close
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Per Page Change
    document.getElementById('perPageSelect')?.addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('per_page', this.value);
        window.location.href = url.toString();
    });

    // Show Full Reason
    function showFullReason(id, reason) {
        const modal = document.getElementById('reasonModal');
        document.getElementById('fullReasonText').textContent = reason;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeReasonModal() {
        const modal = document.getElementById('reasonModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('fullReasonText').textContent = '';
    }
    
    // Close modal on outside click
    document.getElementById('reasonModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeReasonModal();
    });
    
    // Keyboard shortcut: ESC to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeReasonModal();
    });

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('[role="alert"]').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
</script>
@endpush