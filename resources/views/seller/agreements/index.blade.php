@extends('seller.layouts.app') 

@section('content')
<div class="max-w-7xl mx-auto h-full flex flex-col pb-10">

    {{-- Header --}}
    <div class="mb-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Seller Agreement</h1>
            <p class="text-sm text-slate-600 mt-1">Review and sign the latest terms to continue selling.</p>
        </div>
        @if(isset($alreadyAccepted) && $alreadyAccepted)
            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold border border-green-200 flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-check-circle"></i> Verified & Signed
            </span>
        @endif
    </div>

    @if(!isset($masterAgreement))
        <div class="p-10 text-center bg-white rounded-xl shadow-lg border border-red-200">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-4xl mb-3"></i>
            <h3 class="text-lg font-bold text-slate-800">Unable to Load Agreement</h3>
            <a href="{{ url()->previous() }}" class="mt-4 inline-block text-indigo-600 hover:underline">Go Back</a>
        </div>

    @elseif(!isset($alreadyAccepted) || !$alreadyAccepted)
        
        {{-- STATE 1: PENDING (PDF + Checkbox) --}}
        <div class="flex flex-col bg-white rounded-xl shadow-lg border border-[#D4AF37]/30 overflow-hidden relative" 
             style="height: calc(100vh - 180px);">
            
            <div class="bg-yellow-50 border-b border-yellow-200 p-4 flex items-start gap-3 flex-shrink-0 z-10">
                <i class="fa-solid fa-circle-exclamation text-yellow-600 mt-1"></i>
                <div>
                    <h3 class="font-semibold text-yellow-800">Action Required</h3>
                    <p class="text-sm text-yellow-700">You must accept <strong>Version {{ $masterAgreement->version }}</strong> to proceed.</p>
                </div>
            </div>

            <div class="flex-1 relative bg-slate-100 overflow-hidden min-h-0">
                @if($masterAgreement->file_path)
                    <iframe src="{{ Storage::url($masterAgreement->file_path) }}#toolbar=0" class="w-full h-full border-0" frameborder="0"></iframe>
                @else
                    <div class="flex items-center justify-center h-full text-slate-400">PDF File Missing</div>
                @endif
            </div>

            <div class="bg-white border-t border-[#D4AF37]/30 p-5 shadow-[0_-5px_15px_rgba(0,0,0,0.1)] z-50 flex-shrink-0">
                <form id="acceptForm" action="{{ route('agreement.accept') }}" method="POST">
                    @csrf
                    <input type="hidden" name="version" value="{{ $masterAgreement->version }}">
                    <input type="hidden" name="section_name" value="{{ $masterAgreement->section_name }}">
                    
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                        <div class="flex-1 w-full">
                            <label for="agree_checkbox" class="flex items-start gap-3 cursor-pointer group select-none">
                                <div class="relative flex items-center justify-center mt-0.5">
                                    <input id="agree_checkbox" name="accept" type="checkbox" value="on" class="peer sr-only">
                                    <div class="w-5 h-5 border-2 border-slate-300 rounded bg-white peer-checked:bg-[#D4AF37] peer-checked:border-[#D4AF37] transition-all duration-200 flex items-center justify-center shadow-sm group-hover:border-[#D4AF37]">
                                        <i class="fa-solid fa-check text-white text-[10px] opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                <div class="text-sm leading-snug">
                                    <span class="block font-semibold text-slate-800 group-hover:text-[#B8941F] transition-colors">
                                        I agree to the Seller Agreement (v{{ $masterAgreement->version }})
                                    </span>
                                    <span class="text-slate-500 text-xs mt-0.5 block">By checking this, you confirm acceptance of all terms.</span>
                                </div>
                            </label>
                        </div>
                        <div class="w-full lg:w-auto flex-shrink-0">
                            <button type="submit" id="submitBtn" disabled class="w-full lg:w-auto px-8 py-3 bg-gradient-to-r from-[#D4AF37] to-[#B8941F] hover:from-[#B8941F] hover:to-[#D4AF37] text-black font-bold rounded-lg shadow-md hover:shadow-lg transform transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none flex items-center justify-center gap-2 text-sm uppercase tracking-wide">
                                <i class="fa-solid fa-pen-nib"></i> <span>Sign & Accept</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @else
        {{-- STATE 2: ALREADY ACCEPTED (HISTORY TABLE) --}}
        <div class="bg-white rounded-xl shadow-lg border border-[#D4AF37]/20 overflow-hidden">
            
            <div class="p-6 bg-gradient-cream border-b border-[#D4AF37]/20 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Agreement History</h2>
                    <p class="text-sm text-slate-600">Record of your accepted agreements.</p>
                </div>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold border border-green-200 flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> Active Seller
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider font-semibold border-b border-slate-200">
                            <th class="p-4">Section Name</th>
                            <th class="p-4">Version</th>
                            <th class="p-4">Change Description</th>
                            <th class="p-4">Accepted By</th>
                            <th class="p-4">Acceptance Date</th>
                            <th class="p-4">Published On</th>
                            <th class="p-4">IP Address</th>
                            <th class="p-4">Doc Link</th>
                            <th class="p-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                        @forelse($history ?? [] as $item)
                        <tr class="hover:bg-[#F5F1E8]/50 transition-colors">
                            
                            {{-- डेटा अब $item->agreement->column से आएगा --}}
                            <td class="p-4 font-medium text-slate-800">
                                {{ $item->agreement->section_name ?? 'N/A' }}
                            </td>
                            
                            <td class="p-4">
                                <span class="bg-[#D4AF37]/10 text-[#B8941F] px-2 py-1 rounded text-xs font-bold border border-[#D4AF37]/20">
                                    v{{ $item->agreement->version ?? '?' }}
                                </span>
                            </td>
                            
                            <td class="p-4 max-w-xs truncate" title="{{ $item->agreement->change_description ?? '' }}">
                                {{ $item->agreement->change_description ?? '-' }}
                            </td>
                            
                            <td class="p-4 font-medium text-slate-800">
                                {{ $item->user->name ?? 'User #' . $item->user_id }}
                                @if($item->ip_address)
                                    <div class="text-xs text-slate-400 font-mono mt-1">IP: {{ $item->ip_address }}</div>
                                @endif
                            </td>
                            
                            <td class="p-4 text-slate-600 whitespace-nowrap">
                                {{-- DB Column: accepted_at --}}
                                {{ $item->accepted_at ? \Carbon\Carbon::parse($item->accepted_at)->format('d-m-Y h:i A') : '-' }}
                            </td>
                            
                            <td class="p-4 text-slate-500 whitespace-nowrap">
                                {{ $item->agreement->created_at ? \Carbon\Carbon::parse($item->agreement->created_at)->format('d-m-Y h:i A') : '-' }}
                            </td>
                            
                            <td class="p-4 font-mono text-xs text-slate-500">{{ $item->ip_address ?? '-' }}</td>
                            
                            <td class="p-4">
                                @if($item->agreement->file_path)
                                    <a href="{{ Storage::url($item->agreement->file_path) }}" target="_blank" class="text-[#B8941F] hover:text-[#D4AF37] font-medium flex items-center gap-1">
                                        <i class="fa-solid fa-file-pdf"></i> View PDF
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs">No File</span>
                                @endif
                            </td>
                            
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold border bg-green-100 text-green-700 border-green-200">
                                    Accepted
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-500">No acceptance history found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-200 bg-slate-50 flex justify-between items-center">
                <span class="text-xs text-slate-500">
                    Showing : <strong>1</strong> to <strong>{{ count($history ?? []) }}</strong> of <strong>{{ count($history ?? []) }}</strong>
                </span>
                <div class="flex gap-2">
                    <button disabled class="px-3 py-1 border border-slate-300 rounded text-xs text-slate-400 bg-white cursor-not-allowed">First</button>
                    <button disabled class="px-3 py-1 border border-slate-300 rounded text-xs text-slate-400 bg-white cursor-not-allowed">&lt;</button>
                    <span class="px-3 py-1 bg-[#D4AF37] text-white rounded text-xs font-bold">1</span>
                    <button disabled class="px-3 py-1 border border-slate-300 rounded text-xs text-slate-400 bg-white cursor-not-allowed">&gt;</button>
                    <button disabled class="px-3 py-1 border border-slate-300 rounded text-xs text-slate-400 bg-white cursor-not-allowed">Last</button>
                </div>
            </div>

        </div>
    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('agree_checkbox');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('acceptForm');

    if (checkbox && submitBtn) {
        checkbox.addEventListener('change', function() {
            submitBtn.disabled = !this.checked;
            if(this.checked) {
                submitBtn.classList.remove('opacity-40', 'cursor-not-allowed');
            } else {
                submitBtn.classList.add('opacity-40', 'cursor-not-allowed');
            }
        });
    }

    if(form && submitBtn) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Processing...';
            submitBtn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Error occurred');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Network error. Please try again.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>
@endpush
@endsection