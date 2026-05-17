@extends('admin.layouts.app')
@section('title', 'Seller Admin Management')
@push('styles')
<style>
/* Custom scrollbar for table */
.table-container::-webkit-scrollbar { height: 6px; width: 6px; }
.table-container::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
.table-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.table-container::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
/* Status badge animation */
.status-badge { transition: all 0.2s ease; }
.status-badge:hover { transform: scale(1.05); }
/* Row hover effect */
tbody tr { transition: background-color 0.15s ease, box-shadow 0.15s ease; }
tbody tr:hover { background-color: #f8fafc !important; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
/* Mobile responsive utilities */
@media (max-width: 640px) {
    .action-btn-group { flex-direction: column; gap: 0.5rem; }
    .action-btn-group > * { width: 100%; justify-content: center; }
}
</style>
@endpush
@section('content')
<div class="min-h-screen bg-gray-50 py-4 px-2 sm:px-4 lg:px-8">
<!-- Page Header -->
<div class="max-w-7xl mx-auto">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Seller Admin Management
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Manage your seller admins, view wallets, and control access.
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 gap-3">
            <a href="#"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition w-full sm:w-auto justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Seller Admins</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['totalUsers'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Active</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['activeUsers'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-amber-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Suspended</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['suspendedUsers'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Card -->
    <div class="bg-white rounded-xl shadow mb-6">
        <div class="p-4 border-b border-gray-200">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by name, email, or phone..."
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition">
                </div>
                <!-- Status Filter -->
                <div class="w-full md:w-40">
                    <select name="status" onchange="this.form.submit()"
                            class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <!-- Date Filter -->
                <div class="w-full md:w-48">
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           placeholder="From Date"
                           class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <!-- Reset Button -->
                <a href="{{ route('admin.customers.index') }}"
                   class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition whitespace-nowrap text-center">
                    Reset
                </a>
            </form>
        </div>
        <!-- Bulk Actions Bar -->
        <div id="bulkActions" class="hidden px-4 py-3 bg-blue-50 border-t border-blue-100 flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <span class="text-sm font-medium text-blue-800 whitespace-nowrap">
                    <span id="selectedCount">0</span> selected
                </span>
                <select id="bulkAction" class="text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 flex-1 sm:flex-none">
                    <option value="">Bulk Actions</option>
                    <option value="activate">Activate</option>
                    <option value="suspend">Suspend</option>
                    <option value="delete">Delete</option>
                    <option value="export">Export Selected</option>
                </select>
                <button onclick="applyBulkAction()"
                        class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition whitespace-nowrap">
                    Apply
                </button>
            </div>
            <button onclick="clearSelection()" class="text-sm text-blue-600 hover:text-blue-800 font-medium w-full sm:w-auto text-center sm:text-left">
                Clear Selection
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto table-container">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <!-- Checkbox for bulk select -->
                    <th scope="col" class="px-4 py-3 text-left">
                        <input type="checkbox" id="selectAll"
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer"
                               onchange="toggleSelectAll(this)">
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" onclick="sortBy('name')">
                        <div class="flex items-center gap-1">
                            Seller Admin
                            <svg id="sort-name" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortBy('email')">
                        Email / Phone
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">
                        Wallet Balance
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">
                        Joined
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users ?? [] as $user)
                    <tr class="hover:bg-gray-50 transition" data-user-id="{{ $user->id }}">
                        <!-- Checkbox -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                   class="user-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer"
                                   onchange="updateBulkActions()">
                        </td>
                        <!-- Customer Info -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="shrink-0 h-10 w-10">
                                    @if($user->avatar)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/'.$user->avatar) }}" alt="">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-linear-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">ID: #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <!-- Email / Phone -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            @if($user->phone)
                                <div class="text-xs text-gray-500">📱 {{ $user->phone }}</div>
                            @endif
                        </td>
                        <!-- Wallet Balance -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-gray-900">
                                    ₹{{ number_format($user->wallet?->balance ?? 0, 2) }}
                                </span>
                            </div>
                            @if(($user->wallet?->balance ?? 0) < 100)
                                <span class="text-xs text-amber-600">⚠️ Low</span>
                            @endif
                        </td>
                        <!-- Status Badge -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            @php
                                $isSuspended = $user->suspended_at !== null;
                                $status = $isSuspended ? 'suspended' : 'active';
                                $statusConfig = [
                                    'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dot' => 'bg-green-500', 'label' => 'Active'],
                                    'suspended' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'dot' => 'bg-red-500', 'label' => 'Suspended'],
                                ];
                                $config = $statusConfig[$status];
                            @endphp
                            <span class="status-badge px-2.5 py-1 inline-flex items-center gap-1.5 text-xs font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }} border border-transparent">
                                <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <!-- Joined Date -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>{{ $user->created_at?->format('d M, Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $user->created_at?->diffForHumans() }}</div>
                        </td>
                        <!-- Actions -->
                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
    <div class="flex items-center justify-end gap-1 sm:gap-2 action-btn-group">

        <!-- View -->
        <a href="{{ route('admin.customers.show', $user->id) }}"
           class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition"
           title="View Details">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                         c4.478 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.064 7-9.542 7
                         -4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </a>

        <!-- Wallet -->
   <a href="javascript:void(0)"
   onclick="openWalletModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->wallet->balance ?? 0 }}')"
   class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded-lg transition"
   title="Manage Wallet">

    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M7 15h1m4 0h1m-7 4h12
                 a3 3 0 003-3V8a3 3 0 00-3-3H6
                 a3 3 0 00-3 3v8a3 3 0 003 3z"/>
    </svg>
</a>

       

    </div>
</td>
                    </tr>
                @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No seller admins found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding a new seller admin.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if(isset($users) && $users->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 flex items-center justify-between sm:px-6">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $users->firstItem() }}</span>
                            to <span class="font-medium">{{ $users->lastItem() }}</span>
                            of <span class="font-medium">{{ $users->total() }}</span> results
                        </p>
                    </div>
                    <div>
                        {{ $users->appends(request()->query())->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
                <!-- Mobile Pagination Simple -->
                <div class="flex sm:hidden justify-between w-full">
                     {{ $users->appends(request()->query())->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        @endif
    </div>
</div>

<div id="walletModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-lg w-96 p-6">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Wallet Details</h3>

            <button onclick="closeWalletModal()" class="text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>

        <div class="space-y-3">

            <p class="text-sm text-gray-500">User</p>
            <p id="walletUserName" class="font-semibold text-gray-800"></p>

            <p class="text-sm text-gray-500 mt-3">Balance</p>
            <p id="walletBalance" class="text-2xl font-bold text-green-600"></p>

      </div>

    </div>

</div>



<!-- Toast Notification -->
<div id="toast" class="fixed top-4 right-4 left-4 sm:left-auto z-50 hidden transform transition-all duration-300">
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg bg-white border-l-4 max-w-sm mx-auto sm:mx-0" id="toastContent">
        <svg id="toastIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
        <span id="toastMessage" class="text-sm font-medium text-gray-900"></span>
        <button onclick="hideToast()" class="ml-auto text-gray-400 hover:text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
@endsection
@push('scripts')
<script>
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
// Bulk Selection
function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(cb => cb.checked = source.checked);
    updateBulkActions();
}
function updateBulkActions() {
    const checked = document.querySelectorAll('.user-checkbox:checked');
    const bulkBar = document.getElementById('bulkActions');
    const count = document.getElementById('selectedCount');
    if (checked.length > 0) {
        bulkBar.classList.remove('hidden');
        bulkBar.classList.add('flex');
        count.textContent = checked.length;
    } else {
        bulkBar.classList.add('hidden');
        bulkBar.classList.remove('flex');
    }
}
function clearSelection() {
    document.getElementById('selectAll').checked = false;
    document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('bulkActions').classList.add('hidden');
    document.getElementById('bulkActions').classList.remove('flex');
}
function applyBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const selected = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (!action || selected.length === 0) {
        showToast('Please select an action and users', 'warning');
        return;
    }
    if (action === 'delete') {
        if (!confirm(`Are you sure you want to delete ${selected.length} users?`)) return;
    }
    fetch("{{ route('admin.customers.bulk') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ action, users: selected })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Action failed', 'error');
        }
    })
    .catch(() => showToast('Something went wrong', 'error'));
}
// Delete Confirmation
function confirmDelete(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteForm').action = `/admin/customers/${userId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}
// Status Toggle
function toggleStatus(userId, currentStatus) {

    const newStatus = currentStatus === 'active' ? 'suspended' : 'active';

    fetch(`/admin/customers/${userId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {

            showToast(
                `User ${newStatus === 'active' ? 'activated' : 'suspended'} successfully`,
                'success'
            );

            setTimeout(() => {
                location.reload();
            }, 800);

        } else {
            showToast(data.message || 'Failed to update status', 'error');
        }

    })
    .catch(error => {
        console.error(error);
        showToast('Server error occurred', 'error');
    });
}


// Toast Notification
function showToast(message, type = 'info') {
    const toast = document.getElementById('toast');
    const toastContent = document.getElementById('toastContent');
    const toastIcon = document.getElementById('toastIcon');
    const toastMessage = document.getElementById('toastMessage');
    const config = {
        success: { bg: 'border-green-500', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>', color: 'text-green-600' },
        error: { bg: 'border-red-500', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>', color: 'text-red-600' },
        warning: { bg: 'border-amber-500', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/>', color: 'text-amber-600' },
        info: { bg: 'border-blue-500', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01"/>', color: 'text-blue-600' }
    };
    const c = config[type];
    toastContent.className = `flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg bg-white border-l-4 ${c.bg}`;
    toastIcon.innerHTML = `<svg class="w-5 h-5 ${c.color}" fill="none" stroke="currentColor" viewBox="0 0 24 24">${c.icon}</svg>`;
    toastMessage.textContent = message;
    toast.classList.remove('hidden', 'translate-x-full');
    setTimeout(hideToast, 4000);
}
function hideToast() {
    const toast = document.getElementById('toast');
    toast.classList.add('translate-x-full');
    setTimeout(() => toast.classList.add('hidden'), 300);
}
// Sorting
function sortBy(field) {
    const url = new URL(window.location);
    url.searchParams.set('sort', field);
    url.searchParams.set('direction', url.searchParams.get('direction') === 'asc' ? 'desc' : 'asc');
    window.location = url;
}

@if(session('success'))
showToast("{{ session('success') }}", 'success');
@elseif(session('error'))
showToast("{{ session('error') }}", 'error');
@endif

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

// Wallet Modal Logic
let currentUserId = null;

function openWalletModal(userId, userName, balance)
{
    currentUserId = userId;

    document.getElementById('walletUserName').innerText = userName;
    document.getElementById('walletBalance').innerText = "₹ " + balance;

    document.getElementById('walletModal').classList.remove('hidden');
    document.getElementById('walletModal').classList.add('flex');
}

function closeWalletModal()
{
    document.getElementById('walletModal').classList.add('hidden');
}
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush