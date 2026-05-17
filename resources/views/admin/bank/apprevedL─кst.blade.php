@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-600 flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-shield-alt"></i>
                </div>
                Verified Bank Accounts
            </h1>
            <p class="text-slate-500 text-sm mt-1 ml-1">List of all sellers with approved bank details.</p>
        </div>
        
        <a href="{{ route('admin.bank.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back to All Requests
        </a>
    </div>

    {{-- Stats Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Verified</p>
                <p class="text-2xl font-bold text-slate-800">{{ $bankDetails->total() }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                <i class="fas fa-building text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Companies</p>
                <p class="text-2xl font-bold text-slate-800">{{ $bankDetails->unique('company_name')->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                <i class="fas fa-calendar-check text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Last Verified</p>
                <p class="text-sm font-bold text-slate-800">
                    {{ $bankDetails->first()?->verified_at ? \Carbon\Carbon::parse($bankDetails->first()->verified_at)->format('d M Y') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Seller / Company</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Bank Account</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">IFSC Code</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Verified By</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Verified Date</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($bankDetails as $detail)
                        <tr class="hover:bg-slate-50 transition-colors">
                            
                            {{-- Seller Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($detail->logo)
                                        <img src="{{ asset('storage/' . $detail->logo) }}" alt="Logo" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                            {{ strtoupper(substr($detail->company_name ?? $detail->user_name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $detail->company_name ?? 'N/A' }}</p>
                                        <p class="text-xs text-slate-500">{{ $detail->user_name }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $detail->user_email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Bank Account --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-mono font-medium text-slate-700">{{ $detail->account_number }}</span>
                                    <span class="text-xs text-slate-500">{{ $detail->beneficiary_name }}</span>
                                </div>
                            </td>

                            {{-- IFSC --}}
                            <td class="px-6 py-4">
                                <span class="font-mono text-slate-600 bg-slate-100 px-2 py-1 rounded text-xs font-bold">
                                    {{ strtoupper($detail->ifsc_code) }}
                                </span>
                            </td>

                            {{-- Verified By --}}
                            <td class="px-6 py-4">
                                <span class="text-slate-600 text-xs">
                                    Admin ID: <span class="font-mono font-bold">{{ $detail->verified_by }}</span>
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-slate-700 font-medium">
                                        {{ \Carbon\Carbon::parse($detail->verified_at)->format('d M Y') }}
                                    </span>
                                    <span class="text-xs text-slate-400">
                                        {{ \Carbon\Carbon::parse($detail->verified_at)->format('h:i A') }}
                                    </span>
                                </div>
                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.bank.show', $detail->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors border border-indigo-100">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-check-circle text-2xl text-green-300"></i>
                                </div>
                                <p class="text-slate-600 font-medium">No verified bank accounts yet.</p>
                                <p class="text-slate-400 text-sm mt-1">Approved sellers will appear here automatically.</p>
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
@endsection