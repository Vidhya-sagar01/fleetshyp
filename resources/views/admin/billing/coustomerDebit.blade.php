@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <i class="fa fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <i class="fa fa-exclamation-triangle text-red-500 mr-3"></i>
            <p class="text-red-700">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex">
            <i class="fa fa-list-ul text-yellow-600 mr-3 mt-1"></i>
            <div>
                <p class="font-medium text-yellow-800">Please fix the following:</p>
                <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">💰 Manual Wallet Recharge</h1>
            <p class="text-gray-500 text-sm mt-1">Select a seller admin and add balance to their wallet</p>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all text-sm font-medium">
            <i class="fa fa-arrow-left mr-2"></i>Back to Users
        </a>
    </div>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Left: Seller Admins List --}}
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                <h3 class="font-semibold text-gray-700">
                    <i class="fa fa-users mr-2 text-blue-500"></i>Seller Admins
                </h3>
            </div>
            
            {{-- Search --}}
            <div class="p-3 border-b border-gray-100">
                <input type="text" id="userSearch" 
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Search by name or email...">
            </div>

            {{-- Users List --}}
            <div class="max-h-[calc(100vh-280px)] overflow-y-auto">
                @forelse($sellerAdmins as $user)
                    @php
                        $wallet = $user->wallet;
                        $isSelected = isset($selectedUser) && $selectedUser->id == $user->id;
                    @endphp
                    <div class="user-row px-4 py-3 border-b border-gray-50 {{ $isSelected ? 'bg-blue-50 border-l-4 border-blue-500' : 'hover:bg-gray-50' }} cursor-pointer"
                         onclick="selectUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $wallet?->balance ?? 0 }}')"
                         data-user-id="{{ $user->id }}"
                         data-user-name="{{ $user->name }}"
                         data-user-email="{{ $user->email }}"
                         data-balance="{{ $wallet?->balance ?? 0 }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 text-sm truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600 text-sm">₹{{ number_format($wallet?->balance ?? 0, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        <p class="text-sm">No seller admins found</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Right: Recharge Form --}}
        <div class="lg:col-span-2">
            @if(isset($selectedUser))
                
                {{-- Selected User Header --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $selectedUser->name }}</h2>
                            <p class="text-gray-500 text-sm">{{ $selectedUser->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Current Balance Card --}}
                <div class="bg-gradient-to-br from-green-600 to-emerald-700 rounded-xl shadow-lg p-6 text-white mb-4">
                    <p class="text-green-100 text-sm font-medium">Current Wallet Balance</p>
                    <p class="text-4xl font-bold mt-1">₹{{ number_format($selectedWallet?->balance ?? 0, 2) }}</p>
                </div>

                {{-- Simple Recharge Form --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-700 mb-4">
                        <i class="fa fa-plus-circle mr-2 text-green-500"></i>Add Balance
                    </h3>
                    
                    <form action="{{ route('admin.wallet.adjust', $selectedUser->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="credit">
                        <input type="hidden" name="charge_type" value="recharge">
                        <input type="hidden" name="source" value="admin_manual">
                        
                        <div class="space-y-4">
                            {{-- Amount --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Amount to Add (₹)</label>
                                <input type="number" name="amount" step="0.01" min="1" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Enter amount" required>
                            </div>

                            {{-- Remark --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Remark (Optional)</label>
                                <input type="text" name="remark" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="e.g., Monthly bonus, Support credit, etc.">
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="mt-6">
                            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-lg hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                <i class="fa fa-wallet"></i> Recharge Wallet
                            </button>
                        </div>
                    </form>
                </div>

            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-10 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fa fa-hand-pointer text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Select a Seller Admin</h3>
                    <p class="text-gray-500 text-sm">
                        Click on any seller admin from the left panel to recharge their wallet.
                    </p>
                </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
    // User Selection - Simple redirect with user ID
    function selectUser(userId, userName, balance) {
        // Update URL for better UX
        const url = new URL(window.location);
        url.searchParams.set('user', userId);
        window.history.pushState({}, '', url);
        
        // Highlight selected row
        document.querySelectorAll('.user-row').forEach(row => {
            row.classList.remove('bg-blue-50', 'border-l-4', 'border-blue-500');
        });
        const selectedRow = document.querySelector(`.user-row[data-user-id="${userId}"]`);
        if(selectedRow) {
            selectedRow.classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
        }
        
      
        window.location.href = ``;
    }

    // Search Filter
    document.getElementById('userSearch')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.user-row').forEach(row => {
            const name = row.dataset.userName?.toLowerCase() || '';
            const email = row.dataset.userEmail?.toLowerCase() || '';
            const match = name.includes(searchTerm) || email.includes(searchTerm);
            row.style.display = match ? '' : 'none';
        });
    });

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const selectedUserId = urlParams.get('user');
        if(selectedUserId) {
            const row = document.querySelector(`.user-row[data-user-id="${selectedUserId}"]`);
            row?.classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
        }
    });
</script>
@endpush
@endsection