@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Shipping Rate Card</h1>
            <p class="text-sm text-gray-600">Manage your B2C and B2B shipping costs.</p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-4">
            <form action="{{ route('ratecard.index') }}" method="GET" id="filterForm" class="flex items-center gap-2">
                <input type="hidden" name="type" value="{{ $type }}">
                
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Plan:</label>
                <select name="plan_name" onchange="document.getElementById('filterForm').submit()" 
                    class="bg-white border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-gold focus:border-gold block w-full p-2.5 shadow-sm outline-none">
                    <option value="">All Plans</option>
                    @foreach(['Starter', 'Growth', 'Professional', 'Enterprise'] as $plan)
                        <option value="{{ $plan }}" {{ $selectedPlan == $plan ? 'selected' : '' }}>{{ $plan }}</option>
                    @endforeach
                </select>
            </form>

            <div class="inline-flex p-1 bg-gray-200/50 rounded-lg border border-gray-200 shadow-sm">
                @foreach(['mini' => 'Mini B2C', 'b2b' => 'B2B Bulk', 'b2c' => 'B2C'] as $key => $label)
                <a href="{{ route('ratecard.index', ['type' => $key, 'plan_name' => $selectedPlan]) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-300 {{ $type == $key ? 'bg-gold text-white shadow-md' : 'text-gray-500 hover:bg-white/50' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="overflow-x-auto scrollbar-hide">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-gray-200 text-[11px] uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-4 py-4 font-semibold">Couriers</th>
                        <th class="px-4 py-4 font-semibold text-center">Mode</th>
                        @foreach(['A' => '(City)', 'B' => '(State)', 'C' => '(Metro)', 'D' => '(ROI)', 'E' => '(Special)'] as $key => $sub)
                        <th class="px-4 py-4 font-semibold text-center border-l border-gray-200">
                            Zone {{ $key }} <br> <span class="lowercase font-normal opacity-70">{{ $sub }}</span>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rateCards as $rate)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-10 flex items-center justify-center border rounded bg-white p-1">
                                    <img src="{{ $rate->courier_logo_url }}" alt="Logo" class="max-h-full max-w-full object-contain">
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 text-sm">{{ $rate->courier_name }}</div>
                                    <div class="flex gap-2 items-center">
                                        <span class="text-[10px] bg-gray-100 px-1 rounded text-gray-600">{{ $rate->plan_name }}</span>
                                        <span class="text-[10px] text-gray-400">Base: {{ $rate->weight_info ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-6 text-center">
                            <i class="fa-solid {{ strtolower($rate->mode) == 'air' ? 'fa-plane text-blue-400' : 'fa-truck text-gray-400' }} text-lg"></i>
                            <div class="text-[9px] uppercase mt-1 font-bold">{{ $rate->mode }}</div>
                        </td>

                        @foreach(['a', 'b', 'c', 'd', 'e'] as $z)
                        <td class="px-4 py-6 border-l border-gray-50">
                            <div class="flex justify-between text-[12px] gap-2">
                                <div class="text-right flex-1">
                                    <div class="text-gray-400 text-[9px] font-bold">FWD</div>
                                    <div class="text-gray-900 font-bold">₹{{ $rate->{'zone_'.$z.'_forward'} }}</div>
                                    <div class="text-gray-500">₹{{ $rate->{'zone_'.$z.'_add_forward'} }}</div>
                                    <div class="text-blue-600 text-[10px] font-medium">C: ₹{{ $rate->{'zone_'.$z.'_cod_charge'} }}</div>
                                </div>
                                <div class="text-right flex-1 border-l border-gray-100 pl-2">
                                    <div class="text-gray-400 text-[9px] font-bold">RTO</div>
                                    <div class="text-gray-900 font-bold">₹{{ $rate->{'zone_'.$z.'_rto'} }}</div>
                                    <div class="text-gray-500">₹{{ $rate->{'zone_'.$z.'_add_rto'} }}</div>
                                    <div class="text-red-500 text-[10px] font-medium">{{ $rate->{'zone_'.$z.'_cod_percent'} }}%</div>
                                </div>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-magnifying-glass text-3xl text-gray-200 mb-2"></i>
                                <div class="text-gray-400 italic">No rates found for {{ strtoupper($type) }} ({{ $selectedPlan ?: 'All Plans' }})</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection