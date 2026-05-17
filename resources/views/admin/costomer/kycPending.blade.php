{{-- resources/views/admin/kyc/pending.blade.php --}}
@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">
        🔹 Pending KYC Applications ({{ $pendingKyc->count() }})
    </h2>

    @if($pendingKyc->count() > 0)
        <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-600">User</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-600">Business</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-600">PAN</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($pendingKyc as $kyc)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4">
                            <p class="font-medium text-slate-800">{{ $kyc->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500">{{ $kyc->user->email ?? 'N/A' }}</p>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded text-xs">
                                {{ $kyc->business_type }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $kyc->pan_number ?? '-' }}
                        </td>
                       
                        <td class="py-3 px-4 text-right">
                            <a href="{{ route('kyc.show', $kyc->id) }}" 
                               class="text-gold hover:text-gold-dark font-medium text-sm">
                                Review →
                            </a>
                        </td>
                    </tr
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl border border-slate-200">
            <i class="fa-solid fa-clipboard-check text-4xl text-slate-300 mb-3"></i>
            <p class="text-slate-600 font-medium">No pending KYC applications</p>
            <p class="text-sm text-slate-400">All records have been reviewed</p>
        </div>
    @endif
</div>
@endsection