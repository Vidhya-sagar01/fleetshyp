@extends('admin.layouts.app')
@section('title', 'Customer Details')

@push('styles')
<style>
    /* Custom scrollbar */
    .content-container::-webkit-scrollbar {
        width: 6px;
    }

    .content-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .content-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .content-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Status badge animation */
    .status-badge {
        transition: all 0.2s ease;
    }

    .status-badge:hover {
        transform: scale(1.05);
    }

    /* Card hover effect */
    .info-card {
        transition: all 0.2s ease;
    }

    .info-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Tab styling */
    .tab-active {
        border-bottom: 2px solid #2563eb;
        color: #2563eb;
        font-weight: 600;
    }

    .tab-inactive {
        border-bottom: 2px solid transparent;
        color: #6b7280;
    }

    .tab-inactive:hover {
        color: #374151;
        cursor: pointer;
    }

    /* Tab content transition */
    .tab-content {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-4 px-2 sm:px-4 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header with Back Button -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.customers.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                            <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-linear-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-semibold text-lg">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            {{ $user->name }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            ID: #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }} •
                            <span class="inline-flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full {{ $user->suspended_at ? 'bg-red-500' : 'bg-green-500' }}"></span>
                                {{ $user->suspended_at ? 'Suspended' : 'Active' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Wallet Balance Card -->
            <div class="info-card bg-white rounded-xl shadow p-4 sm:p-5 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Wallet Balance</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 mt-1">
                            ₹{{ number_format($user->wallet?->balance ?? 0, 2) }}
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <a href="#" class="mt-3 text-xs sm:text-sm text-green-600 hover:text-green-800 font-medium inline-flex items-center">
                    View Transactions
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- KYC Status Card -->
            <div class="info-card bg-white rounded-xl shadow p-4 sm:p-5 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">KYC Status</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 mt-1">
                            {{ $kyc?->status ?? 'PENDING' }}
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-xs sm:text-sm text-gray-500">
                    {{ $kyc?->verification_method ?? 'Not Submitted' }}
                </p>
            </div>

            <!-- Company Card -->
            <div class="info-card bg-white rounded-xl shadow p-4 sm:p-5 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Company</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 mt-1 truncate">
                            {{ $companyProfile?->company_name ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-xs sm:text-sm text-gray-500">
                    {{ $companyProfile?->brand_name ?? 'No Brand' }}
                </p>
            </div>

            <!-- Member Since Card -->
            <div class="info-card bg-white rounded-xl shadow p-4 sm:p-5 border-l-4 border-amber-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Member Since</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 mt-1">
                            {{ $user->created_at?->format('d M, Y') }}
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-xs sm:text-sm text-gray-500">
                    {{ $user->created_at?->diffForHumans() }}
                </p>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-xl shadow mb-6 overflow-x-auto">
            <div class="flex border-b border-gray-200 min-w-max">
                <button onclick="switchTab('overview')" id="tab-overview" class="tab-active px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium transition">
                    📋 Overview
                </button>
                <button onclick="switchTab('kyc')" id="tab-kyc" class="tab-inactive px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium transition">
                    🪪 KYC Details
                </button>
                <button onclick="switchTab('company')" id="tab-company" class="tab-inactive px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium transition">
                    🏢 Company Profile
                </button>
                <button onclick="switchTab('wallet')" id="tab-wallet" class="tab-inactive px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium transition">
                    💰 Wallet
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="content-container">

            <!-- ============ OVERVIEW TAB ============ -->
            <div id="content-overview" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Personal Information -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Personal Information
                            </h3>
                        </div>
                        <div class="p-4 sm:p-6 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Full Name</span>
                                <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Email Address</span>
                                <span class="text-sm font-medium text-gray-900">{{ $user->email }}</span>
                            </div>
                            @if($kyc?->phone ?? $user->phone)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Phone Number</span>
                                <span class="text-sm font-medium text-gray-900">📱 {{ $kyc?->phone ?? $user->phone }}</span>
                            </div>
                            @endif
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Role</span>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Account Status</span>
                                @php
                                $isSuspended = $user->suspended_at !== null;
                                $statusConfig = [
                                'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Active'],
                                'suspended' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Suspended'],
                                ];
                                $config = $statusConfig[$isSuspended ? 'suspended' : 'active'];
                                @endphp
                                <span class="status-badge px-2.5 py-1 text-xs font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                                    {{ $config['label'] }}
                                </span>
                            </div>
                            @if($user->suspended_at)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Suspended At</span>
                                <span class="text-sm font-medium text-red-600">
                                    {{ optional($user->suspended_at)->format('d M, Y h:i A') }}
                                </span>
                            </div>
                            @endif
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Email Verified</span>
                                @if($user->email_verified_at)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">✓ Verified</span>
                                @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">⚠️ Not Verified</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Account Information
                            </h3>
                        </div>
                        <div class="p-4 sm:p-6 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">User ID</span>
                               <span class="text-sm font-medium text-gray-900"> {{ $user->remember_token }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Created At</span>
                                <span class="text-sm font-medium text-gray-900">{{ $user->created_at?->format('d M, Y h:i A') }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Last Updated</span>
                                <span class="text-sm font-medium text-gray-900">{{ $user->updated_at?->format('d M, Y h:i A') }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">password</span>
                                <span class="text-sm font-medium text-gray-900">{{ $user->remember_password ?: 'Never' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">IP Address</span>
                                <span class="text-sm font-medium text-gray-900">{{ $user->last_login_ip ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions  -->
               <div class="mt-6 bg-white rounded-xl shadow p-4 sm:p-6">
    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

       
       

        <!-- Toggle Status -->
        <button
            type="button"
            onclick="toggleStatus({{ $user->id }}, '{{ $isSuspended ? 'suspended' : 'active' }}', '{{ $user->name }}')"
            class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">

            <svg class="w-8 h-8 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>

            <span class="text-sm text-gray-700 font-medium text-center">
                {{ $isSuspended ? 'Suspended' : 'Suspend' }}
            </span>
        </button>

        <!-- Email -->
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $user->email }}"
           target="_blank"
           class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">

            <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>

            <span class="text-sm text-gray-700 font-medium text-center">Email</span>
        </a>

    </div>
</div>
            </div>

            <!-- ============ KYC TAB ============ -->
            <div id="content-kyc" class="tab-content hidden">
                @if($kyc)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- KYC Status -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">KYC Status</h3>
                        </div>
                        <div class="p-4 sm:p-6 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Verification Method</span>
                                <span class="text-sm font-medium text-gray-900">{{ $kyc->verification_method ?? 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Status</span>
                                @php
                                $kycStatusConfig = [
                                'PENDING' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => '⏳ Pending'],
                                'VERIFIED' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => '✓ Verified'],
                                'REJECTED' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => '✗ Rejected'],
                                ];
                                $kycConfig = $kycStatusConfig[$kyc->status] ?? $kycStatusConfig['PENDING'];
                                @endphp
                                <span class="status-badge px-2.5 py-1 text-xs font-semibold rounded-full {{ $kycConfig['bg'] }} {{ $kycConfig['text'] }}">
                                    {{ $kycConfig['label'] }}
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Business Type</span>
                                <span class="text-sm font-medium text-gray-900">{{ $kyc->business_type ?? 'Individual' }}</span>
                            </div>
                            @if($kyc->verified_at)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Verified At</span>
                                <span class="text-sm font-medium text-green-600">{{ $kyc->verified_at->format('d M, Y h:i A') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- KYC Documents -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">KYC Documents</h3>
                        </div>
                        <div class="p-4 sm:p-6 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">PAN Number</span>
                                <span class="text-sm font-medium text-gray-900">{{ $kyc->pan_number ?? 'Not Provided' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Aadhaar Number</span>
                                <span class="text-sm font-medium text-gray-900">{{ $kyc->aadhaar_number ?? 'Not Provided' }}</span>
                            </div>
                            @if($kyc->pan_card_image)
                            <div class="py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 block mb-2">PAN Card Image</span>
                                <a href="{{ asset('storage/'.$kyc->pan_card_image) }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    View PAN Card
                                </a>
                            </div>
                            @endif
                            @if($kyc->aadhaar_card_image)
                            <div class="py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 block mb-2">Aadhaar Card Image</span>
                                <a href="{{ asset('storage/'.$kyc->aadhaar_card_image) }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    View Aadhaar Card
                                </a>
                            </div>
                            @endif
                            @if($kyc->user_photo)
                            <div class="py-3">
                                <span class="text-sm text-gray-500 block mb-2">User Photo</span>
                                <a href="{{ asset('storage/'.$kyc->user_photo) }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    View Photo
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-white rounded-xl shadow p-6 sm:p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No KYC Details</h3>
                    <p class="mt-1 text-sm text-gray-500">This user has not submitted KYC documents yet.</p>
                </div>
                @endif
            </div>

            <!-- ============ COMPANY TAB ============ -->
            <div id="content-company" class="tab-content hidden">
                @if($companyProfile)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Company Info -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Company Information</h3>
                        </div>
                        <div class="p-4 sm:p-6 space-y-4">
                            @if($companyProfile->logo)
                            <div class="flex justify-center py-4 border-b border-gray-100">
                                <img src="{{ asset('storage/'.$companyProfile->logo) }}" alt="Company Logo" class="h-20 w-20 object-contain">
                            </div>
                            @endif
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Company Code</span>
                                <span class="text-sm font-medium text-gray-900">{{ $companyProfile->company_code }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Company Name</span>
                                <span class="text-sm font-medium text-gray-900">{{ $companyProfile->company_name }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Brand Name</span>
                                <span class="text-sm font-medium text-gray-900">{{ $companyProfile->brand_name }}</span>
                            </div>
                            @if($companyProfile->website)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Website</span>
                                <a href="{{ $companyProfile->website }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">{{ $companyProfile->website }}</a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contact & GST -->
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Contact & GST</h3>
                        </div>
                        <div class="p-4 sm:p-6 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Email</span>
                                <span class="text-sm font-medium text-gray-900">{{ $companyProfile->email }}</span>
                            </div>
                            @if($companyProfile->customer_care_email)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Customer Care Email</span>
                                <span class="text-sm font-medium text-gray-900">{{ $companyProfile->customer_care_email }}</span>
                            </div>
                            @endif
                            @if($companyProfile->customer_care_mobile)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Customer Care Mobile</span>
                                <span class="text-sm font-medium text-gray-900">📱 {{ $companyProfile->customer_care_mobile }}</span>
                            </div>
                            @endif
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Has GST</span>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $companyProfile->has_gst ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $companyProfile->has_gst ? '✓ Yes' : '✗ No' }}
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3">
                                <span class="text-sm text-gray-500 mb-1 sm:mb-0">Enable State GST</span>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $companyProfile->enable_state_gst ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $companyProfile->enable_state_gst ? '✓ Yes' : '✗ No' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-white rounded-xl shadow p-6 sm:p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Company Profile</h3>
                    <p class="mt-1 text-sm text-gray-500">This user has not created a company profile yet.</p>
                </div>
                @endif
            </div>

            <!-- ============ WALLET TAB ============ -->
            <div id="content-wallet" class="tab-content hidden">
                @if($user->wallet)
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">Wallet Information</h3>
                    </div>
                    <div class="p-4 sm:p-6 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500 mb-1 sm:mb-0">Current Balance</span>
                            <span class="text-lg font-bold text-green-600">₹{{ number_format($user->wallet->balance, 2) }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500 mb-1 sm:mb-0">Wallet ID</span>
                            <span class="text-sm font-medium text-gray-900">#{{ $user->wallet->id }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500 mb-1 sm:mb-0">Created At</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->wallet->created_at?->format('d M, Y h:i A') }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3">
                            <span class="text-sm text-gray-500 mb-1 sm:mb-0">Last Updated</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->wallet->updated_at?->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <!-- Transactions Button -->
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        View All Transactions
                    </a>
                </div>
                @else
                <div class="bg-white rounded-xl shadow p-6 sm:p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Wallet Found</h3>
                    <p class="mt-1 text-sm text-gray-500">This user does not have a wallet yet.</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- ============ MODALS ============ -->

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDeleteModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex items-center gap-4">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Delete Customer?</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Are you sure you want to delete <strong id="deleteUserName"></strong>? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Toggle Status Modal -->
<div id="toggleStatusModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeToggleStatusModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <form id="toggleStatusForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" id="statusValue">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex items-center gap-4">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" id="toggleStatusTitle">Suspend Customer?</h3>
                            <p class="mt-1 text-sm text-gray-500" id="toggleStatusMessage">
                                Are you sure you want to suspend <strong id="toggleStatusUserName">{{ $user->name }}</strong>? They will not be able to access their account.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                    <button type="button" onclick="closeToggleStatusModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script>
    // ============ TAB SWITCHING (Fixed) ============
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
        });

        // Show selected tab content
        const target = document.getElementById(`content-${tabName}`);
        if (target) {
            target.classList.remove('hidden');
        }

        // Update tab button styles
        document.querySelectorAll('[id^="tab-"]').forEach(el => {
            el.classList.remove('tab-active', 'text-blue-600');
            el.classList.add('tab-inactive', 'text-gray-600');
        });

        const activeTab = document.getElementById(`tab-${tabName}`);
        if (activeTab) {
            activeTab.classList.remove('tab-inactive', 'text-gray-600');
            activeTab.classList.add('tab-active', 'text-blue-600');
        }

        // Save tab to URL hash for persistence
        history.replaceState(null, null, `#${tabName}`);
    }





    // ============ TOGGLE STATUS ============
    function toggleStatus(userId, currentStatus, userName) {

        const title = document.getElementById('toggleStatusTitle');
        const message = document.getElementById('toggleStatusMessage');
        const nameField = document.getElementById('toggleStatusUserName');
        const form = document.getElementById('toggleStatusForm');
        const statusInput = document.getElementById('statusValue');

        let url = "{{ route('admin.customers.status', ':id') }}";
        url = url.replace(':id', userId);

        form.action = url;

        nameField.textContent = userName;

        if (currentStatus === 'active') {

            title.textContent = 'Suspend Customer?';

            message.innerHTML =
                `Are you sure you want to suspend <strong>${userName}</strong>? They will not be able to access their account.`;

            statusInput.value = 'suspended';

        } else {

            title.textContent = 'Activate Customer?';

            message.innerHTML =
                `Are you sure you want to activate <strong>${userName}</strong>? They will regain access to their account.`;

            statusInput.value = 'active';
        }

        document.getElementById('toggleStatusModal').classList.remove('hidden');
    }

    function closeToggleStatusModal() {
        document.getElementById('toggleStatusModal').classList.add('hidden');
    }




    // ============ MODAL CLOSE ON OUTSIDE CLICK ============
    window.onclick = function(event) {
        if (event.target.classList.contains('bg-gray-500')) {
            closeDeleteModal();
            closeResetPasswordModal();
            closeToggleStatusModal();
            closeSendSmsModal();
        }
    }

    // ============ INIT TAB ON PAGE LOAD (With Hash Support) ============
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash.replace('#', '');
        const validTabs = ['overview', 'kyc', 'company', 'wallet'];

        if (validTabs.includes(hash)) {
            switchTab(hash);
        } else {
            switchTab('overview');
        }
    });

</script>
@endpush
