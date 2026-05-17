@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-file-signature"></i>
                </div>
                Agreement Signatures
            </h1>
            <p class="text-slate-500 text-sm mt-1 ml-1">
                Track sellers who have accepted the latest agreement.
            </p>
        </div>
        
        @if($latestAgreement)
            <a href="{{ route('admin.agreements.download', $latestAgreement->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                <i class="fas fa-download mr-2 text-indigo-600"></i> Download PDF
            </a>
        @endif
    </div>

    @if(!$latestAgreement)
        {{-- No Agreement State --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-10 text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-inbox text-3xl text-slate-400"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">No Active Agreement</h3>
            <p class="text-slate-500 mt-2">Publish an agreement first to track signatures.</p>
        </div>
    @else
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Total Sellers -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Sellers</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $totalSellers }}</p>
                    </div>
                </div>
            </div>

            <!-- Signed Count -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Signed</p>
                        <p class="text-2xl font-bold text-green-600">{{ $signedCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Not Signed -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Pending</p>
                        <p class="text-2xl font-bold text-red-600">{{ $notSignedCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Percentage -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Compliance</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $percentage }}%</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Table Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                <h3 class="font-semibold text-slate-700 flex items-center gap-2">
                    <i class="fas fa-list text-indigo-600"></i> Sellers Who Have Signed
                </h3>
                <span class="text-xs font-medium bg-indigo-100 text-indigo-700 px-2.5 py-1 rounded-full">
                    Version: {{ $latestAgreement->version ?? '1.0' }}
                </span>
            </div>

            <div class="overflow-x-auto">
                @if($signedUsersList->count() > 0)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold border-b border-slate-200">#</th>
                                <th class="px-6 py-4 font-semibold border-b border-slate-200">Company / Brand</th>
                                <th class="px-6 py-4 font-semibold border-b border-slate-200">Contact Person</th>
                                <th class="px-6 py-4 font-semibold border-b border-slate-200">Email</th>
                                <th class="px-6 py-4 font-semibold border-b border-slate-200 text-center">GST</th>
                                <th class="px-6 py-4 font-semibold border-b border-slate-200">Signed Date</th>
                                <th class="px-6 py-4 font-semibold border-b border-slate-200 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($signedUsersList as $index => $user)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-slate-500 font-mono">{{ $index + 1 }}</td>
                                    
                                    {{-- Company & Brand Info --}}
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800">
                                                {{ $user->company_name ?? 'N/A' }}
                                            </span>
                                            @if($user->brand_name)
                                                <span class="text-xs text-slate-500">
                                                    <i class="fas fa-tag mr-1"></i>{{ $user->brand_name }}
                                                </span>
                                            @endif
                                            @if($user->company_code)
                                                <span class="text-[10px] font-mono text-slate-400 mt-0.5">
                                                    ID: {{ $user->company_code }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Contact Person --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <span class="font-medium text-slate-800">{{ $user->name }}</span>
                                        </div>
                                    </td>

                                    {{-- Email --}}
                                    <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>

                                    {{-- GST Status --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($user->has_gst)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Yes
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Signed Date --}}
                                    <td class="px-6 py-4 text-slate-600">
                                        <div class="flex flex-col">
                                            <span>{{ \Carbon\Carbon::parse($user->signed_at)->format('d M Y') }}</span>
                                            <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($user->signed_at)->format('h:i A') }}</span>
                                        </div>
                                    </td>

                                    {{-- Status Badge --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                            <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                            Verified
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    {{-- Empty State --}}
                    <div class="p-10 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user-slash text-2xl text-slate-400"></i>
                        </div>
                        <p class="text-slate-600 font-medium">No sellers have signed this agreement yet.</p>
                        <p class="text-slate-400 text-sm mt-1">The list will appear here once sellers accept the terms.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection