@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F1E8] p-4 sm:p-6">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- ✅ Success & Error Messages (Gold Theme) -->
        @if(session('success'))
        <div class="p-4 bg-white border-l-4 border-[#D4AF37] text-gray-700 rounded shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-check text-lg mr-2 text-[#D4AF37]"></i>
                <span>{!! session('success') !!}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-gray-500 hover:text-[#B8941F] transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        @if($errors->any())
        <div class="p-4 bg-white border-l-4 border-red-500 text-red-700 rounded shadow-sm">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- 1. Category Cards (Gold Theme + Hover Effects) -->
        <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
            <!-- First Mile -->
            <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex-shrink-0 w-56 text-center flex flex-col justify-between min-h-[240px] hover:border-[#D4AF37]">
                <div>
                    <div class="w-14 h-14 mx-auto bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4 border border-[#D4AF37]/30">
                        <i class="fa-solid fa-warehouse text-2xl text-[#D4AF37]"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2">First Mile</h3>
                    <p class="text-[11px] text-gray-500 mb-4 leading-tight">Concerns related to pick-up and handling to fulfillment.</p>
                </div>
                <a href="{{ route('seller.ticket.createticket') }}" class="bg-gradient-gold text-white text-xs px-5 py-2 rounded hover:bg-gold-dark transition mt-auto inline-block shadow-sm">Raise Ticket</a>
            </div>
            <!-- Last Mile -->
            <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex-shrink-0 w-56 text-center flex flex-col justify-between min-h-[240px] hover:border-[#D4AF37]">
                <div>
                    <div class="w-14 h-14 mx-auto bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4 border border-[#D4AF37]/30">
                        <i class="fa-solid fa-motorcycle text-2xl text-[#D4AF37]"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2">Last Mile</h3>
                    <p class="text-[11px] text-gray-500 mb-4 leading-tight">Concerns related to delivery and handling to customer.</p>
                </div>
                <a href="{{ route('seller.ticket.createticket') }}" class="bg-gradient-gold text-white text-xs px-5 py-2 rounded hover:bg-gold-dark transition mt-auto inline-block shadow-sm">Raise Ticket</a>
            </div>
            <!-- Post Delivery Dispute -->
            <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex-shrink-0 w-56 text-center flex flex-col justify-between min-h-[240px] hover:border-[#D4AF37]">
                <div>
                    <div class="w-14 h-14 mx-auto bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4 border border-[#D4AF37]/30">
                        <i class="fa-solid fa-truck-fast text-2xl text-[#D4AF37]"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2">Post Delivery Dispute</h3>
                    <p class="text-[11px] text-gray-500 mb-4 leading-tight">Concerns related to disputes after delivery completion.</p>
                </div>
                <a href="{{ route('seller.ticket.createticket') }}" class="bg-gradient-gold text-white text-xs px-5 py-2 rounded hover:bg-gold-dark transition mt-auto inline-block shadow-sm">Raise Ticket</a>
            </div>
            <!-- Weight -->
            <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex-shrink-0 w-56 text-center flex flex-col justify-between min-h-[240px] hover:border-[#D4AF37]">
                <div>
                    <div class="w-14 h-14 mx-auto bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4 border border-[#D4AF37]/30">
                        <i class="fa-solid fa-weight-scale text-2xl text-[#D4AF37]"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2">Weight</h3>
                    <p class="text-[11px] text-gray-500 mb-4 leading-tight">Concerns related to discrepancies in package weight.</p>
                </div>
                <a href="{{ route('seller.ticket.createticket') }}" class="bg-gradient-gold text-white text-xs px-5 py-2 rounded hover:bg-gold-dark transition mt-auto inline-block shadow-sm">Raise Ticket</a>
            </div>
            <!-- Finance -->
            <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex-shrink-0 w-56 text-center flex flex-col justify-between min-h-[240px] hover:border-[#D4AF37]">
                <div>
                    <div class="w-14 h-14 mx-auto bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4 border border-[#D4AF37]/30">
                        <i class="fa-solid fa-coins text-2xl text-[#D4AF37]"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2">Finance</h3>
                    <p class="text-[11px] text-gray-500 mb-4 leading-tight">Concerns related to billing and payment discrepancies.</p>
                </div>
                <a href="{{ route('seller.ticket.createticket') }}" class="bg-gradient-gold text-white text-xs px-5 py-2 rounded hover:bg-gold-dark transition mt-auto inline-block shadow-sm">Raise Ticket</a>
            </div>
            <!-- Technical -->
            <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex-shrink-0 w-56 text-center flex flex-col justify-between min-h-[240px] hover:border-[#D4AF37]">
                <div>
                    <div class="w-14 h-14 mx-auto bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4 border border-[#D4AF37]/30">
                        <i class="fa-solid fa-microchip text-2xl text-[#D4AF37]"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2">Technical</h3>
                    <p class="text-[11px] text-gray-500 mb-4 leading-tight">Concerns related to system issues and errors.</p>
                </div>
                <a href="{{ route('seller.ticket.createticket') }}" class="bg-gradient-gold text-white text-xs px-5 py-2 rounded hover:bg-gold-dark transition mt-auto inline-block shadow-sm">Raise Ticket</a>
            </div>
            <!-- Account Query -->
            <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex-shrink-0 w-56 text-center flex flex-col justify-between min-h-[240px] hover:border-[#D4AF37]">
                <div>
                    <div class="w-14 h-14 mx-auto bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4 border border-[#D4AF37]/30">
                        <i class="fa-solid fa-user-gear text-2xl text-[#D4AF37]"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2">Account Query</h3>
                    <p class="text-[11px] text-gray-500 mb-4 leading-tight">Concerns related to your account such as KYC, price enquiry and closure</p>
                </div>
                <a href="{{ route('seller.ticket.createticket') }}" class="bg-gradient-gold text-white text-xs px-5 py-2 rounded hover:bg-gold-dark transition mt-auto inline-block shadow-sm">Raise Ticket</a>
            </div>
            <!-- B2B Related Issues -->
            <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex-shrink-0 w-56 text-center flex flex-col justify-between min-h-[240px] hover:border-[#D4AF37]">
                <div>
                    <div class="w-14 h-14 mx-auto bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4 border border-[#D4AF37]/30">
                        <i class="fa-solid fa-handshake text-2xl text-[#D4AF37]"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2">B2B Related Issues</h3>
                    <p class="text-[11px] text-gray-500 mb-4 leading-tight">Concerns related to your B2B orders such as Pickup not attempted, Delivery Delayed, etc.</p>
                </div>
                <a href="{{ route('seller.ticket.createticket') }}" class="bg-gradient-gold text-white text-xs px-5 py-2 rounded hover:bg-gold-dark transition mt-auto inline-block shadow-sm">Raise Ticket</a>
            </div>
        </div>

        <!-- 2. Tabs Section (Gold Theme) -->
        <div class="flex items-center gap-2">
            <button class="bg-gradient-gold text-white px-4 py-1.5 rounded-lg text-sm font-medium shadow-sm hover:bg-gold-dark transition-all-300">
                Open Tickets ({{ $tickets->total() }})
            </button>
            <button class="bg-white text-gray-600 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-[#F5F1E8] hover:text-[#D4AF37] border border-gray-200 transition-all-300">
                Closed Tickets (0)
            </button>
        </div>

        <!-- ✅ 3. Filter Bar & Search - COMPLETE with Dependent Dropdown + Fixed Positioning -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 dashboard-card hover:border-[#D4AF37]/50 relative z-10">
            <form method="GET" action="{{ route('seller.ticket.index') }}" class="space-y-4" id="filterForm">
                <!-- Row 1: Filters -->
                <div class="flex flex-wrap items-center gap-3 relative">
                    <!-- Date Range -->
                    <div class="flex items-center border border-gray-300 rounded-md bg-[#F5F1E8] px-3 py-1.5 text-sm text-gray-600 cursor-pointer hover:border-[#D4AF37] transition">
                        <span>06/01/2026 - 08/04/2026</span>
                        <i class="fa-solid fa-refresh ml-2 text-[#D4AF37] hover:text-[#B8941F] transition"></i>
                    </div>
                    
                    <!-- Status Dropdown -->
                    <div class="relative">
                        <select name="status" class="appearance-none border border-gray-300 rounded-md px-3 py-1.5 pr-8 text-sm text-gray-500 bg-white focus:outline-none focus:ring-2 focus:ring-[#D4AF37] hover:border-[#D4AF37] transition cursor-pointer" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        <span class="absolute right-2 top-1/2 -translate-y-1/2 text-[#D4AF37] pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>

                    <!-- Category Dropdown -->
                    <div class="relative">
                        <select id="filterCategory" name="category" class="appearance-none border border-gray-300 rounded-md px-3 py-1.5 pr-8 text-sm text-gray-500 bg-white focus:outline-none focus:ring-2 focus:ring-[#D4AF37] hover:border-[#D4AF37] transition cursor-pointer" onchange="handleFilterCategoryChange()">
                            <option value="">All Categories</option>
                            <option value="First Mile" {{ request('category') == 'First Mile' ? 'selected' : '' }}>First Mile</option>
                            <option value="Last Mile" {{ request('category') == 'Last Mile' ? 'selected' : '' }}>Last Mile</option>
                            <option value="Post Delivery Dispute" {{ request('category') == 'Post Delivery Dispute' ? 'selected' : '' }}>Post Delivery Dispute</option>
                            <option value="Weight" {{ request('category') == 'Weight' ? 'selected' : '' }}>Weight</option>
                            <option value="Finance" {{ request('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Technical" {{ request('category') == 'Technical' ? 'selected' : '' }}>Technical</option>
                            <option value="Account Query" {{ request('category') == 'Account Query' ? 'selected' : '' }}>Account Query</option>
                            <option value="B2B Related Issues" {{ request('category') == 'B2B Related Issues' ? 'selected' : '' }}>B2B Related Issues</option>
                        </select>
                        <span class="absolute right-2 top-1/2 -translate-y-1/2 text-[#D4AF37] pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>

                    <!-- Sub-Category Dropdown (Dependent) -->
                    <div class="relative">
                        <select id="filterSubCategory" name="sub_category" class="appearance-none border border-gray-300 rounded-md px-3 py-1.5 pr-8 text-sm text-gray-400 bg-[#F5F1E8] focus:outline-none focus:ring-2 focus:ring-[#D4AF37] transition cursor-not-allowed disabled:opacity-60" disabled onchange="this.form.submit()">
                            <option value="">All Sub-Categories</option>
                        </select>
                        <span class="absolute right-2 top-1/2 -translate-y-1/2 text-[#D4AF37] pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>

                    <!-- Clear Filters -->
                    @if(request()->hasAny(['search', 'status', 'category', 'sub_category']))
                    <a href="{{ route('seller.ticket.index') }}" class="text-xs text-[#D4AF37] hover:text-[#B8941F] flex items-center gap-1 transition font-medium">
                        <i class="fa-solid fa-xmark"></i> Clear
                    </a>
                    @endif
                </div>

                <!-- Row 2: Search & Create New -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-gray-100">
                    <!-- Search Input -->
                    <div class="relative flex-1 max-w-md">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#D4AF37] text-sm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search Reference ID / Ticket ID..." 
                               class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] transition bg-[#F5F1E8]/50"
                               onkeyup="if(event.key === 'Enter') this.form.submit()">
                    </div>
                    <!-- Create New Button -->
                    <a href="{{ route('seller.ticket.createticket') }}"
                       class="bg-gradient-gold text-white px-5 py-2 rounded-md text-sm font-medium hover:bg-gold-dark transition flex items-center gap-2 shadow-sm whitespace-nowrap">
                        <i class="fa-solid fa-plus"></i> Create New
                    </a>
                </div>
            </form>

            <!-- ✅ Table Section -->
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#F5F1E8] text-xs uppercase text-gray-600 font-semibold border-b border-[#D4AF37]/30">
                        <tr>
                            <th class="px-4 py-3 w-[10%]">Ticket ID</th>
                            <th class="px-4 py-3 w-[15%]">Category</th>
                            <th class="px-4 py-3 w-[15%]">Reference ID</th>
                            <th class="px-4 py-3 w-[10%]">Due Date</th>
                            <th class="px-4 py-3 w-[10%]">Status</th>
                            <th class="px-4 py-3 w-[10%]">Action</th>
                            <th class="px-4 py-3 w-[15%]">Created At</th>
                            <th class="px-4 py-3 w-[15%]">Updated At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-[#F5F1E8] transition-all-300">
                            <td class="px-4 py-3"><span class="font-mono text-xs font-bold text-[#2d1b6f]">{{ $ticket->ticket_number }}</span></td>
                            <td class="px-4 py-3"><span class="px-2 py-1 bg-[#F5F1E8] text-[#B8941F] text-xs rounded-full font-medium inline-block border border-[#D4AF37]/30">{{ $ticket->category }}</span></td>
                            <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ Str::limit($ticket->reference_id, 18) }}</td>
                            <td class="px-4 py-3 text-xs text-gray-500">{{ $ticket->created_at->addDays(7)->format('d M') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusStyles = ['open' => 'bg-green-50 text-green-700 border-green-200', 'in_progress' => 'bg-blue-50 text-blue-700 border-blue-200', 'resolved' => 'bg-[#F5F1E8] text-[#B8941F] border-[#D4AF37]/40', 'closed' => 'bg-gray-50 text-gray-600 border-gray-200'];
                                @endphp
                                <span class="px-2 py-1 text-xs font-bold rounded-full border {{ $statusStyles[$ticket->status] ?? 'bg-gray-50 text-gray-600 border-gray-200' }} inline-block text-center min-w-[70px]">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right"><a href="#" class="text-[#D4AF37] hover:text-[#B8941F] text-xs transition" title="View Details"><i class="fa-solid fa-eye"></i></a></td>
                            <td class="px-4 py-3 text-xs text-gray-500">{{ $ticket->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-xs text-gray-500">{{ $ticket->updated_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="px-4 py-12 text-center"><div class="flex flex-col items-center justify-center"><div class="w-32 h-32 rounded-full bg-[#F5F1E8] flex items-center justify-center mb-4 border-2 border-dashed border-[#D4AF37]/40"><i class="fa-solid fa-ticket-simple text-4xl text-[#D4AF37]/60"></i></div><p class="text-gray-600 font-medium">@if(request()->hasAny(['search', 'status', 'category', 'sub_category'])) No tickets found matching your search @else No tickets found @endif</p><p class="text-gray-400 text-sm mt-1">@if(request()->hasAny(['search', 'status', 'category', 'sub_category'])) Try adjusting your filters or <a href="{{ route('seller.ticket.index') }}" class="text-[#D4AF37] hover:text-[#B8941F] transition">clear filters</a> @else Create your first ticket to get started! @endif</p>@if(!request()->hasAny(['search', 'status', 'category', 'sub_category']))<a href="{{ route('seller.ticket.createticket') }}" class="mt-4 px-4 py-2 bg-gradient-gold text-white text-sm rounded-lg hover:bg-gold-dark transition shadow-sm">Create Ticket</a>@endif</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ✅ Pagination -->
            <div class="px-4 py-3 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3 mt-2">
                <div class="text-sm text-gray-600">Showing <strong>{{ $tickets->firstItem() ?? 0 }}</strong> to <strong>{{ $tickets->lastItem() ?? 0 }}</strong> of <strong>{{ $tickets->total() }}</strong> entries @if(request()->hasAny(['search', 'status', 'category', 'sub_category']))<span class="text-xs text-gray-400 ml-2">(filtered)</span>@endif</div>
                <div>{{ $tickets->appends(request()->query())->links('pagination::tailwind') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ CSS + JavaScript - COMPLETE -->
@push('scripts')
<style>
/* Custom Dropdown Styling - Prevents "opening at top" issue */
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-image: none !important;
}
.relative { position: relative; z-index: 10; }
select:not(:disabled):focus { box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2); }
select:disabled { background-color: #F5F1E8 !important; color: #9ca3af !important; cursor: not-allowed; }
.bg-gradient-gold { background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%); }
.bg-gradient-gold:hover { background: linear-gradient(135deg, #B8941F 0%, #9A7A1A 100%); }
.transition-all-300 { transition: all 0.3s ease; }
</style>

<script>
// ✅ Dependent Sub-Category Filter Logic
function handleFilterCategoryChange() {
    const categorySelect = document.getElementById('filterCategory');
    const subCategorySelect = document.getElementById('filterSubCategory');
    const selectedCategory = categorySelect.value;
    
    const subCategoriesMap = {
        'First Mile': ['Pickup Not Done', 'Picked up but not connected'],
        'Last Mile': ['Branch Address Info', 'RTO Request', 'Expedite Delivery', 'NDR Reattempt', 'Update Buyer details', 'Status Mismatch', 'RTO Without Attempt'],
        'Post Delivery Dispute': ['Delivered not received RTO', 'Short/Empty Shipment Received RTO', 'Delivery not received by Buyer', 'Damage Shipment Received by Buyer', 'Wrong Delivery Received by Buyer', 'Wrong Delivery Received RTO', 'Short/Empty Shipment Received by Buyer', 'Damage Shipment Received RTO', 'Return from buyer']
    };
    
    // Clear & reset
    subCategorySelect.innerHTML = '<option value="">All Sub-Categories</option>';
    subCategorySelect.value = '';
    
    if (selectedCategory && subCategoriesMap[selectedCategory]) {
        subCategoriesMap[selectedCategory].forEach(sub => {
            const option = document.createElement('option');
            option.value = sub;
            option.textContent = sub;
            @if(request('sub_category'))
                if (sub === '{{ request('sub_category') }}') option.selected = true;
            @endif
            subCategorySelect.appendChild(option);
        });
        // Enable with gold theme
        subCategorySelect.disabled = false;
        subCategorySelect.classList.remove('bg-[#F5F1E8]', 'text-gray-400', 'cursor-not-allowed');
        subCategorySelect.classList.add('bg-white', 'text-gray-700', 'cursor-pointer');
    } else {
        // Disable
        subCategorySelect.disabled = true;
        subCategorySelect.classList.add('bg-[#F5F1E8]', 'text-gray-400', 'cursor-not-allowed');
        subCategorySelect.classList.remove('bg-white', 'text-gray-700', 'cursor-pointer');
    }
    // Auto-submit after small delay
    setTimeout(() => document.getElementById('filterForm').submit(), 150);
}

// ✅ Initialize on page load + Pagination Styling
document.addEventListener('DOMContentLoaded', function() {
    const cat = document.getElementById('filterCategory');
    if (cat && cat.value) handleFilterCategoryChange();
    
    const paginationLinks = document.querySelectorAll('.pagination a, .pagination span');
    paginationLinks.forEach(link => {
        if(link.tagName === 'SPAN' && !link.classList.contains('relative')) {
            link.classList.add('bg-[#D4AF37]', 'text-white', 'border-[#B8941F]');
        } else if(link.tagName === 'A') {
            link.classList.add('hover:bg-[#D4AF37]', 'hover:text-white', 'border-gray-300', 'text-gray-700');
        }
        link.classList.add('px-3', 'py-1', 'rounded', 'border', 'text-sm', 'transition');
    });
});
</script>
@endpush
@endsection