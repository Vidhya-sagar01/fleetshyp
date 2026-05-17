@extends('seller.layouts.app')

@section('content')
<div class="space-y-6">

    {{-- 🔔 Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fa fa-check-circle text-green-500 mr-3"></i>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fa fa-exclamation-circle text-red-500 mr-3"></i>
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">NDR Management</h1>
            <p class="text-sm text-gray-500 mt-1">Take action on undelivered orders to prevent RTO</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button class="px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:border-gold transition-all flex items-center" onclick="openBulkUploadModal()">
                <i class="fa fa-upload mr-2"></i> Upload Bulk NDR File
            </button>
            <button class="px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:border-gold transition-all flex items-center">
                <i class="fa fa-file-export mr-2"></i> Export
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-white flex items-center justify-between">
            <div class="flex items-center gap-2 overflow-x-auto pb-1">
                @php $activeTab = request('tab', 'action-required'); @endphp
                <button class="status-tab px-4 py-2 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ $activeTab == 'action-required' ? 'bg-gold text-white' : 'text-gray-600 hover:bg-gray-100' }}" data-target="action-required">
                    Action Required <span class="ml-1 px-2 py-0.5 {{ $activeTab == 'action-required' ? 'bg-white/20' : 'bg-gray-200' }} rounded-full text-xs">{{ $tabCounts['action-required'] ?? 0 }}</span>
                </button>
                <button class="status-tab px-4 py-2 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ $activeTab == 'action-taken' ? 'bg-gold text-white' : 'text-gray-600 hover:bg-gray-100' }}" data-target="action-taken">
                    Action Taken <span class="ml-1 px-2 py-0.5 {{ $activeTab == 'action-taken' ? 'bg-white/20' : 'bg-gray-200' }} rounded-full text-xs">{{ $tabCounts['action-taken'] ?? 0 }}</span>
                </button>
                <button class="status-tab px-4 py-2 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ $activeTab == 'delivered' ? 'bg-gold text-white' : 'text-gray-600 hover:bg-gray-100' }}" data-target="delivered">
                    Delivered <span class="ml-1 px-2 py-0.5 {{ $activeTab == 'delivered' ? 'bg-white/20' : 'bg-gray-200' }} rounded-full text-xs">{{ $tabCounts['delivered'] ?? 0 }}</span>
                </button>
                <button class="status-tab px-4 py-2 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ $activeTab == 'rto' ? 'bg-gold text-white' : 'text-gray-600 hover:bg-gray-100' }}" data-target="rto">
                    RTO <span class="ml-1 px-2 py-0.5 {{ $activeTab == 'rto' ? 'bg-white/20' : 'bg-gray-200' }} rounded-full text-xs">{{ $tabCounts['rto'] ?? 0 }}</span>
                </button>
                <button class="status-tab px-4 py-2 text-sm font-medium rounded-lg transition-all whitespace-nowrap {{ $activeTab == 'all' ? 'bg-gold text-white' : 'text-gray-600 hover:bg-gray-100' }}" data-target="all">
                    All <span class="ml-1 px-2 py-0.5 {{ $activeTab == 'all' ? 'bg-white/20' : 'bg-gray-200' }} rounded-full text-xs">{{ $orders->total() }}</span>
                </button>
            </div>
            
            <div id="bulkActionContainer" class="hidden items-center gap-2">
                <select id="bulkActionType" class="text-sm border border-gray-200 rounded-lg px-2 py-1.5 focus:ring-gold focus:border-gold transition-all bg-white">
                    <option value="">Bulk Action</option>
                    <option value="re-attempt">Re-Attempt</option>
                </select>
                <button class="px-3 py-1.5 text-sm text-white bg-gradient-gold rounded-lg hover:shadow-lg transition-all" onclick="handleBulkAction()">Apply</button>
            </div>
        </div>

        <div id="table-container" class="tab-content active">
            <div class="overflow-x-auto">
                <table class="w-full text-nowrap">
                    <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left"><input type="checkbox" id="selectAllNdr" class="form-checkbox rounded border-gray-300 text-gold focus:ring-gold"></th>
                            <th class="px-4 py-3 text-left">Tracking Detail</th>
                            <th class="px-4 py-3 text-left">Customer Detail</th>
                            <th class="px-4 py-3 text-left">Tag</th>
                            <th class="px-4 py-3 text-left">Item Detail</th>
                            <th class="px-4 py-3 text-left">Fulfilled By</th>
                            <th class="px-4 py-3 text-left">IVR Status</th>
                            <th class="px-4 py-3 text-left">Last Action</th>
                            <th class="px-4 py-3 text-left">First NDR</th>
                            <th class="px-4 py-3 text-left">Last NDR</th>
                            <th class="px-4 py-3 text-left">OFD/Aging</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-xs">
                        @forelse($orders as $order)
                            @php
                                // ✅ Calculate aging days with null safety
                                $agingDays = $order->updated_at ? \Carbon\Carbon::parse($order->updated_at)->diffInDays(now()) : 0;
                                
                                // ✅ Status badge color
                                $statusBadge = match(strtolower($order->status ?? '')) {
                                    'undelivered' => 'bg-yellow-100 text-yellow-700',
                                    'rto' => 'bg-red-100 text-red-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                                
                                // ✅ Payment mode badge
                                $paymentBadge = $order->payment_mode == 1 
                                    ? '<span class="px-1.5 py-0.5 bg-red-100 text-red-600 rounded text-[9px] font-bold">COD</span>' 
                                    : '<span class="px-1.5 py-0.5 bg-green-100 text-green-600 rounded text-[9px] font-bold">Prepaid</span>';
                                
                                // ✅ Check if order has successful NDR action - with null safety
                                $hasSuccessfulAction = false;
                                if ($order->relationLoaded('ndrLogs') && $order->ndrLogs) {
                                    $hasSuccessfulAction = $order->ndrLogs->contains(function($log) {
                                        return ($log->status ?? '') === 'action_taken' && 
                                               (($log->api_response_data['status'] ?? false) === true);
                                    });
                                }
                                
                                // ✅ Get NDR reason and date with null safety
                                $ndrReason = $order->tags ?? 'Pending scan';
                                $ndrDate = $order->created_at;
                                
                                // If ndrLogs exists, try to get latest reason from there
                                if ($order->relationLoaded('ndrLogs') && $order->ndrLogs && $order->ndrLogs->isNotEmpty()) {
                                    $latestNdr = $order->ndrLogs->sortByDesc('created_at')->first();
                                    if ($latestNdr) {
                                        $ndrReason = $latestNdr->remarks ?? $latestNdr->last_action_taken ?? $ndrReason;
                                        $ndrDate = $latestNdr->created_at ?? $ndrDate;
                                    }
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors" data-waybill="{{ $order->waybill ?? $order->fship_api_order_id }}">
                                <td class="px-4 py-4">
                                    <input type="checkbox" class="ndr-checkbox form-checkbox rounded border-gray-300 text-gold" 
                                           value="{{ $order->fship_api_order_id ?? $order->id }}"
                                           data-amount="{{ $order->product_subtotal ?? 0 }}">
                                </td>
                                
                                {{-- Tracking Detail --}}
                                <td class="px-4 py-4">
                                    <div class="font-bold text-blue-600 underline">Order: {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') : '-' }}</div>
                                    <div class="text-gray-500">AWB: {{ $order->waybill ?? 'N/A' }}</div>
                                    <div class="text-gray-400">Order: {{ $order->merchant_order_id ?? $order->fship_api_order_id ?? '-' }}</div>
                                    <div class="text-[10px] text-gray-400 font-medium">
                                        Current Status: 
                                        <span class="{{ $statusBadge }} px-1 rounded" id="status-{{ $order->id }}">{{ ucfirst($order->status ?? 'Unknown') }}</span>
                                    </div>
                                </td>
                                
                                {{-- Customer Detail --}}
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-gray-800">{{ $order->buyer_name ?? 'N/A' }},</div>
                                    <div class="text-gray-500">{{ $order->phone_number ?? '-' }},</div>
                                    <div class="text-[10px] text-gray-400 max-w-[150px] whitespace-normal">
                                        {{ Str::limit($order->complete_address ?? 'No address', 80) }}
                                    </div>
                                </td>
                                
                                {{-- Tag --}}
                                <td class="px-4 py-4">
                                    <span class="text-gray-400 italic">
                                        {{ Str::limit($order->tags ?? ($hasSuccessfulAction ? 'Action Taken' : 'No tag'), 20) }}
                                    </span>
                                </td>
                                
                                {{-- Item Detail --}}
                                <td class="px-4 py-4">
                                    <div class="font-bold">₹{{ number_format($order->product_subtotal ?? 0, 2) }}</div>
                                    {!! $paymentBadge !!}
                                    <div class="text-gray-500 mt-1">Products:</div>
                                    <div class="text-[10px] text-gray-400">Name: {{ Str::limit($order->product_name ?? 'Product Item', 25) }}</div>
                                    <div class="text-[10px] text-gray-400">SKU: {{ $order->product_sku ?? '-' }}</div>
                                    <div class="text-[10px] text-gray-400">Qty: {{ $order->product_qty ?? 1 }}</div>
                                </td>
                                
                                {{-- Fulfilled By --}}
                                <td class="px-4 py-4 text-gray-600">
                                    <div>{{ $order->courier_name ?? 'N/A' }}</div>
                                    <div class="text-gray-400">{{ $order->service_mode ?? 'Standard' }}</div>
                                </td>
                                
                                {{-- IVR Status --}}
                                <td class="px-4 py-4 text-gray-400">NA</td>
                                
                                {{-- ✅ Last Action --}}
                                <td class="px-4 py-4" id="lastaction-{{ $order->id }}">
                                    <div>Action: {{ $hasSuccessfulAction ? 'Action Taken' : 'NDR Raised' }}</div>
                                    <div class="text-gray-400">{{ $order->updated_at ? \Carbon\Carbon::parse($order->updated_at)->format('d-m-Y') : '-' }}</div>
                                </td>
                                
                                {{-- ✅ First NDR --}}
                                <td class="px-4 py-4" id="firstndr-{{ $order->id }}">
                                    <div>Reason: {{ Str::limit($ndrReason, 25) }}</div>
                                    <div class="text-gray-400 text-[10px]">NDR On: {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') : '-' }}</div>
                                </td>
                                
                                {{-- ✅ Last NDR - Show NDR Reason + Date/Time --}}
                                <td class="px-4 py-4 text-gray-400" id="lastndr-{{ $order->id }}">
                                    <div class="text-[10px]">
                                        <div class="font-medium text-gray-700">
                                            Reason: {{ Str::limit($ndrReason, 25) }}
                                        </div>
                                        <div class="text-gray-500">
                                            NDR On: {{ $ndrDate ? \Carbon\Carbon::parse($ndrDate)->format('d/m/Y h:i A') : '-' }}
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- ✅ OFD/Aging --}}
                                <td class="px-4 py-4" id="aging-{{ $order->id }}">
                                    <div>Attempts: <span id="attempts-{{ $order->id }}">{{ $agingDays > 0 ? $agingDays : 1 }}</span></div>
                                    <div class="{{ $agingDays >= 3 ? 'text-red-600' : 'text-orange-600' }} font-bold">
                                        Aging: <span id="aging-days-{{ $order->id }}">{{ $agingDays }}</span>
                                    </div>
                                </td>
                                
                                {{-- Action Buttons --}}
                                <td class="px-4 py-4">
                                    <div class="flex flex-col gap-1">
                                        @if(!$hasSuccessfulAction && $order->status === 'undelivered')
                                            <button class="px-3 py-1 bg-gold text-white rounded text-[10px] font-bold hover:bg-gold-dark transition-all" 
                                                onclick="openTakeActionModal('{{ $order->fship_api_order_id ?? $order->id }}', '{{ addslashes($order->buyer_name ?? '') }}', '{{ $order->phone_number ?? '' }}', '{{ addslashes($order->complete_address ?? '') }}', '{{ addslashes($order->landmark ?? '') }}')">
                                                Take Action
                                            </button>
                                        @elseif($hasSuccessfulAction)
                                            <button class="px-3 py-1 bg-white border border-gray-200 rounded text-[10px] font-bold text-gray-700 hover:border-gold hover:text-gold transition-all" onclick="viewPaymentDetail({{ $order->id }})">
                                                <i class="fa fa-eye"></i> View
                                            </button>
                                        @else
                                            <span class="text-[10px] text-gray-400">No action needed</span>
                                        @endif
                                        <button class="px-3 py-1 bg-white border border-gray-200 rounded text-[10px] font-bold text-gray-700 hover:border-gold hover:text-gold transition-all" onclick="openHistoryModal('{{ $order->waybill ?? $order->id }}')">Show History</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fa fa-inbox text-4xl text-gray-300 mb-3"></i>
                                    <p class="font-medium">No NDR orders found</p>
                                    <p class="text-sm mt-1">
                                        @if($activeTab === 'action-required') All undelivered orders have been actioned! 🎉
                                        @elseif($activeTab === 'action-taken') No actions taken yet. Go to "Action Required" tab.
                                        @elseif($activeTab === 'delivered') No delivered orders in this date range.
                                        @elseif($activeTab === 'rto') No RTO orders in this date range.
                                        @else Try adjusting your filters or check back later.
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="px-4 py-3 border-t border-gray-100">{{ $orders->withQueryString()->links() }}</div>
        </div>
    </div>
</div>

{{-- Take Action Modal --}}
<div id="takeActionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" tabindex="-1" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeModal('takeActionModal')"></div>
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
            <form action="{{ route('seller.ndr.action') }}" method="POST" id="ndrActionForm">
                @csrf
                <input type="hidden" name="apiorderid" id="modal_apiorderid">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900">Take Action</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors" onclick="closeModal('takeActionModal')">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Action*</label>
                            <select name="action" id="actionType" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" required onchange="handleNdrActionFields(this.value)">
                                <option value="">Select Action</option>
                                <option value="re-attempt">Re-Attempt</option>
                                <option value="change-address">Change Address</option>
                                <option value="change-phone">Change Contact Number</option>
                                <option value="rto">RTO</option>
                            </select>
                            <p class="text-[10px] text-gray-400 mt-1">*Action allowed only when Courier Company raises Exception</p>
                        </div>
                        <div id="rescheduleDiv" class="hidden col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Re-schedule On*</label>
                            <input type="date" name="reattempt_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Contact Name*</label><input type="text" name="contact_name" id="modal_contact_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50" readonly></div>
                        <div><label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Contact Number*</label><input type="text" name="mobilenumber" id="modal_contact_number" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50" readonly></div>
                    </div>
                    <div id="addressDiv"><label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Complete Address*</label><textarea name="complete_address" id="modal_address" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50" rows="2" readonly></textarea></div>
                    <div><label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Landmark</label><input type="text" name="landmark" id="modal_landmark" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" placeholder="Enter landmark..."></div>
                    <div><label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Remarks</label><textarea name="remarks" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gold focus:border-gold transition-all" rows="2" placeholder="Enter remarks..."></textarea></div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-800 transition-all sm:ml-3 sm:w-auto"><i class="fa fa-paper-plane mr-2"></i> Send to Fleetshyp </button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all sm:mt-0 sm:w-auto" onclick="closeModal('takeActionModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- View Payment Detail Modal --}}
<div id="paymentDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" tabindex="-1" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeModal('paymentDetailModal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Order Details</h3>
                <button type="button" onclick="closeModal('paymentDetailModal')" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fa fa-times text-xl"></i></button>
            </div>
            <div class="px-6 py-4 overflow-y-auto max-h-[calc(90vh-120px)]" id="paymentDetailContent">
                <div class="text-center py-8"><i class="fa fa-spinner fa-spin text-3xl text-gold"></i><p class="mt-2 text-gray-600">Loading order details...</p></div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button type="button" onclick="closeModal('paymentDetailModal')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Tracking History Modal - Events Format with Pagination (5 per page) --}}
<div id="trackingHistoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" tabindex="-1" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeModal('trackingHistoryModal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                <h3 class="text-xl font-semibold text-gray-800">Events</h3>
                <button type="button" onclick="closeModal('trackingHistoryModal')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Content --}}
            <div class="px-6 py-4 overflow-y-auto max-h-[calc(90vh-180px)]" id="trackingHistoryContent">
                <div class="text-center py-8">
                    <i class="fa fa-spinner fa-spin text-3xl text-gold"></i>
                    <p class="mt-2 text-gray-600">Loading tracking history...</p>
                </div>
            </div>
            
            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-between items-center">
                <div id="trackingPagination" class="text-sm text-gray-600"></div>
                <button type="button" onclick="closeModal('trackingHistoryModal')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .status-tab span { transition: all 0.2s; }
    .tab-content { display: none; }
    .tab-content.active { display: block; animation: fadeIn 0.3s; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .ndr-checkbox:checked + label { border-color: #D4AF37; }
    #takeActionModal, #paymentDetailModal, #trackingHistoryModal { display: none; }
    #takeActionModal.active, #paymentDetailModal.active, #trackingHistoryModal.active { display: block; }
    #takeActionModal .transform, #paymentDetailModal .transform, #trackingHistoryModal .transform { transition: all 0.3s ease-out; }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    document.querySelectorAll('.status-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.dataset.target;
            const url = new URL(window.location);
            url.searchParams.set('tab', target);
            window.location.href = url.toString();
        });
    });

    // Bulk Checkbox Handling
    const mainCheckbox = document.getElementById('selectAllNdr');
    const itemCheckboxes = document.querySelectorAll('.ndr-checkbox');
    const bulkContainer = document.getElementById('bulkActionContainer');
    if(mainCheckbox) {
        mainCheckbox.addEventListener('change', function() {
            itemCheckboxes.forEach(cb => cb.checked = this.checked);
            toggleBulkContainer();
        });
    }
    itemCheckboxes.forEach(cb => cb.addEventListener('change', toggleBulkContainer));
    function toggleBulkContainer() {
        const checkedCount = document.querySelectorAll('.ndr-checkbox:checked').length;
        if(checkedCount > 0) { bulkContainer.classList.remove('hidden'); bulkContainer.classList.add('flex'); } 
        else { bulkContainer.classList.add('hidden'); bulkContainer.classList.remove('flex'); }
    }

    // Form submit with loading state
    const ndrForm = document.getElementById('ndrActionForm');
    if(ndrForm) {
        ndrForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Sending...';
        });
    }
});

function openTakeActionModal(apiOrderId, contactName, contactNumber = '', address = '', landmark = '') {
    document.getElementById('modal_apiorderid').value = apiOrderId;
    document.getElementById('modal_contact_name').value = contactName || '';
    document.getElementById('modal_contact_number').value = contactNumber || '';
    document.getElementById('modal_address').value = address || '';
    document.getElementById('modal_landmark').value = landmark || '';
    const modal = document.getElementById('takeActionModal');
    modal.classList.remove('hidden'); modal.classList.add('active');
    document.getElementById('actionType').value = '';
    document.querySelector('textarea[name="remarks"]').value = '';
    document.querySelector('input[name="reattempt_date"]').value = '';
    handleNdrActionFields('');
}

function viewPaymentDetail(orderId) {
    const modal = document.getElementById('paymentDetailModal');
    const content = document.getElementById('paymentDetailContent');
    modal.classList.remove('hidden'); modal.classList.add('active');
    content.innerHTML = `<div class="text-center py-8"><i class="fa fa-spinner fa-spin text-3xl text-gold"></i><p class="mt-2 text-gray-600">Loading...</p></div>`;
    fetch(`/seller/ndr/order/${orderId}/details`, {
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.order) {
            const order = data.order;
            content.innerHTML = `<div class="space-y-4"><div class="grid grid-cols-2 gap-4 text-sm"><div><span class="text-gray-500">Waybill:</span><br><strong>${order.waybill || '-'}</strong></div><div><span class="text-gray-500">Order ID:</span><br><strong>${order.merchant_order_id || '-'}</strong></div><div><span class="text-gray-500">Customer:</span><br><strong>${order.buyer_name || 'N/A'}</strong><br><span class="text-gray-600">${order.phone_number || ''}</span></div><div><span class="text-gray-500">Address:</span><br><span class="text-gray-700">${order.complete_address || ''}, ${order.city || ''}, ${order.state || ''} - ${order.pincode || ''}</span></div><div><span class="text-gray-500">Amount:</span><br><strong>₹${parseFloat(order.product_subtotal || 0).toFixed(2)}</strong></div><div><span class="text-gray-500">Payment:</span><br><strong>${order.payment_mode == 1 ? 'COD' : 'Prepaid'}</strong></div><div><span class="text-gray-500">Courier:</span><br><strong>${order.courier_name || 'N/A'}</strong></div><div><span class="text-gray-500">Status:</span><br><strong class="${order.status === 'undelivered' ? 'text-yellow-600' : 'text-green-600'}">${order.status || 'Unknown'}</strong></div></div>${order.tracking_history && order.tracking_history.length > 0 ? `<div class="border-t pt-4"><h4 class="font-semibold text-gray-700 mb-2">Tracking History</h4><div class="space-y-2 max-h-40 overflow-y-auto">${order.tracking_history.map(log => `<div class="text-xs bg-gray-50 p-2 rounded"><div class="font-medium">${log.status || '-'}</div><div class="text-gray-500">${log.date || '-'} | ${log.location || ''}</div><div class="text-gray-600">${log.remark || ''}</div></div>`).join('')}</div></div>` : ''}</div>`;
        } else { content.innerHTML = `<p class="text-red-600 text-center">${data.message || 'Error loading details'}</p>`; }
    })
    .catch(error => { content.innerHTML = `<p class="text-red-600 text-center">Error loading details</p>`; console.error('Error:', error); });
}

// ✅ GLOBAL VARIABLES FOR TRACKING MODAL
let allTrackingData = [];
let currentPage = 1;
const itemsPerPage = 5; // ✅ Changed to 5 items per page

// ✅ Helper: Format date and time
function formatDateWithTime(dateString) {
    if (!dateString) return '-';
    try {
        const date = new Date(dateString);
        return date.toLocaleString('en-IN', {
            day: '2-digit',
            month: '2-digit', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        }).replace(',', '');
    } catch (e) {
        return dateString;
    }
}

// ✅ FIXED: Open History Modal - Events Format with Pagination (5 per page)
function openHistoryModal(waybill) {
    const modal = document.getElementById('trackingHistoryModal');
    const content = document.getElementById('trackingHistoryContent');
    const pagination = document.getElementById('trackingPagination');
    
    modal.classList.remove('hidden'); 
    modal.classList.add('active');
    content.innerHTML = `<div class="text-center py-8"><i class="fa fa-spinner fa-spin text-3xl text-gold"></i><p class="mt-2 text-gray-600">Loading tracking history...</p></div>`;
    pagination.innerHTML = '';
    currentPage = 1;
    
    fetch(`/seller/ndr/tracking-history?waybill=${encodeURIComponent(waybill)}`, {
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}', 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest' 
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success && data.trackingdata && data.trackingdata.length > 0) {
            allTrackingData = data.trackingdata;
            renderTrackingTable(1, data.summary || {});
            renderPagination();
        } else {
            content.innerHTML = `<p class="text-red-600 text-center py-8">${data.message || 'No tracking data available'}</p>`;
        }
    })
    .catch(error => { 
        console.error('Error:', error);
        content.innerHTML = `
            <div class="text-center py-8">
                <i class="fa fa-exclamation-circle text-4xl text-red-500 mb-3"></i>
                <p class="text-red-600">Error loading tracking history</p>
                <p class="text-sm text-gray-500 mt-2">${error.message}</p>
                <button onclick="openHistoryModal('${waybill}')" class="mt-4 px-4 py-2 bg-gold text-white rounded-lg hover:bg-gold-dark">
                    <i class="fa fa-refresh mr-2"></i>Retry
                </button>
            </div>
        `; 
    });
}

function renderTrackingTable(page, summary = {}) {
    const content = document.getElementById('trackingHistoryContent');
    const pagination = document.getElementById('trackingPagination');
    
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageData = allTrackingData.slice(startIndex, endIndex);
    const totalPages = Math.ceil(allTrackingData.length / itemsPerPage);
    
    let html = `
        <div class="grid grid-cols-3 gap-6">
            {{-- Events Table --}}
            <div class="col-span-2">
                <div class="mb-3 flex items-center justify-between">
                    <p class="text-sm text-gray-600">Showing ${startIndex + 1} - ${Math.min(endIndex, allTrackingData.length)} of ${allTrackingData.length} events</p>
                </div>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Remark</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Location</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
    `;
    
    pageData.forEach((log, index) => {
        const formattedDate = formatDateWithTime(log.dateandTime || log.DateandTime || log.created_at);
        const status = log.status || log.Status || '-';
        const remark = log.remark || log.Remark || '-';
        const location = log.location || log.Location || '-';
        const rowClass = index === 0 ? 'bg-blue-50' : 'hover:bg-gray-50';
        
        html += `
            <tr class="${rowClass} transition-colors">
                <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">${formattedDate}</td>
                <td class="px-4 py-3 text-sm text-gray-700">${status}</td>
                <td class="px-4 py-3 text-sm text-gray-700">${remark}</td>
                <td class="px-4 py-3 text-sm text-gray-500">${location}</td>
            </tr>
        `;
    });
    
    html += `
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Controls --}}
                ${totalPages > 1 ? `
                <div class="mt-4 flex items-center justify-between">
                    <button onclick="changeTrackingPage(${page - 1})" 
                            class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg ${page === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'}" 
                            ${page === 1 ? 'disabled' : ''}>
                        <i class="fa fa-chevron-left mr-1"></i> Previous
                    </button>
                    <div class="flex items-center gap-2">
                        ${Array.from({length: totalPages}, (_, i) => i + 1).map(p => `
                            <button onclick="changeTrackingPage(${p})" 
                                    class="px-3 py-1.5 text-sm rounded-lg ${p === page ? 'bg-gold text-white' : 'border border-gray-300 hover:bg-gray-50'}">
                                ${p}
                            </button>
                        `).join('')}
                    </div>
                    <button onclick="changeTrackingPage(${page + 1})" 
                            class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg ${page === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'}" 
                            ${page === totalPages ? 'disabled' : ''}>
                        Next <i class="fa fa-chevron-right ml-1"></i>
                    </button>
                </div>
                ` : ''}
            </div>
            
            {{-- Attachments Section --}}
            <div class="col-span-1 border-l border-gray-200 pl-6">
                <div class="flex items-center gap-2 mb-4">
                    <h4 class="text-lg font-semibold text-gray-800">Attachments</h4>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732a2.5 2.5 0 013.536 0z" />
                    </svg>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Remarks:</p>
                        <p class="text-sm text-gray-700">${summary.remark || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Waybill:</p>
                        <p class="text-sm text-gray-700 font-mono">${summary.waybill || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase mb-1">Status:</p>
                        <p class="text-sm text-gray-700">${summary.status || 'N/A'}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    content.innerHTML = html;
}

function changeTrackingPage(page) {
    const totalPages = Math.ceil(allTrackingData.length / itemsPerPage);
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    const summary = allTrackingData[0] ? {
        waybill: allTrackingData[0].waybill || '',
        status: allTrackingData[0].status || '',
        remark: allTrackingData[0].remark || ''
    } : {};
    renderTrackingTable(page, summary);
}

function renderPagination() {
    const pagination = document.getElementById('trackingPagination');
    const totalPages = Math.ceil(allTrackingData.length / itemsPerPage);
    
    pagination.innerHTML = `
        <span class="text-sm text-gray-600">
            Page ${currentPage} of ${totalPages} (${allTrackingData.length} events)
        </span>
    `;
}

function closeModal(id) { const modal = document.getElementById(id); modal.classList.add('hidden'); modal.classList.remove('active'); }

function handleNdrActionFields(val) {
    const rescheduleDiv = document.getElementById('rescheduleDiv');
    const addressInput = document.getElementById('modal_address');
    const phoneInput = document.getElementById('modal_contact_number');
    const landmarkInput = document.getElementById('modal_landmark');
    if(val === 're-attempt') { rescheduleDiv.classList.remove('hidden'); [addressInput, phoneInput, landmarkInput].forEach(input => { input.setAttribute('readonly', true); input.classList.add('bg-gray-50'); }); }
    else if(val === 'change-address') { rescheduleDiv.classList.add('hidden'); addressInput.removeAttribute('readonly'); addressInput.classList.remove('bg-gray-50'); phoneInput.setAttribute('readonly', true); phoneInput.classList.add('bg-gray-50'); landmarkInput.removeAttribute('readonly'); landmarkInput.classList.remove('bg-gray-50'); }
    else if(val === 'change-phone') { rescheduleDiv.classList.add('hidden'); addressInput.setAttribute('readonly', true); addressInput.classList.add('bg-gray-50'); phoneInput.removeAttribute('readonly'); phoneInput.classList.remove('bg-gray-50'); landmarkInput.setAttribute('readonly', true); landmarkInput.classList.add('bg-gray-50'); }
    else if(val === 'rto') { rescheduleDiv.classList.add('hidden'); [addressInput, phoneInput, landmarkInput].forEach(input => { input.setAttribute('readonly', true); input.classList.add('bg-gray-50'); }); }
    else { rescheduleDiv.classList.add('hidden'); [addressInput, phoneInput, landmarkInput].forEach(input => { input.setAttribute('readonly', true); input.classList.add('bg-gray-50'); }); }
}

function openBulkUploadModal() { alert('Bulk upload coming soon!'); }
function handleBulkAction() { const actionType = document.getElementById('bulkActionType').value; if(!actionType) { alert('Please select a bulk action'); return; } alert('Bulk ' + actionType + ' - Feature under development'); }

['takeActionModal', 'paymentDetailModal', 'trackingHistoryModal'].forEach(id => {
    const modal = document.getElementById(id);
    if(modal) { modal.addEventListener('click', function(e) { if(e.target === this) closeModal(id); }); }
});
document.addEventListener('keydown', function(e) { if(e.key === 'Escape') { closeModal('takeActionModal'); closeModal('paymentDetailModal'); closeModal('trackingHistoryModal'); } });

// ✅ AUTO LIVE STATUS UPDATE - Every 60 seconds (No Button Click)
document.addEventListener('DOMContentLoaded', function() {
    const waybills = Array.from(document.querySelectorAll('[data-waybill]'))
        .map(el => el.dataset.waybill)
        .filter(w => w && w !== 'N/A' && w !== '');
    
    if (waybills.length === 0) { console.log('ℹ️ No waybills found for auto-tracking'); return; }
    console.log('🔄 Auto-track enabled for', waybills.length, 'waybills');
    
    function updateLiveStatus() {
        console.log('📡 Fetching live status for', waybills.length, 'waybills...');
        fetch('{{ route("ndr.autoTrack") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: JSON.stringify({ waybills: waybills })
        })
        .then(response => response.json())
        .then(response => {
            if (response.data) {
                let updatedCount = 0;
                Object.entries(response.data).forEach(([waybill, data]) => {
                    if (data.success) {
                        const row = document.querySelector(`[data-waybill="${CSS.escape(waybill)}"]`);
                        if (!row) return;
                        
                        // ✅ Update Status Badge
                        const statusBadge = row.querySelector('[id^="status-"]');
                        if (statusBadge && data.status) {
                            statusBadge.textContent = data.status;
                            statusBadge.className = `px-1 rounded ${data.badgeClass}`;
                        }
                        
                        // ✅ Update Last Action Column
                        const lastActionEl = row.querySelector('[id^="lastaction-"]');
                        if (lastActionEl && data.status) {
                            lastActionEl.innerHTML = `<div>Action: ${data.status}</div><div class="text-gray-400">${formatDate(data.lastScanDate)}</div>`;
                        }
                        
                        // ✅ Update First NDR Column
                        const firstNdrEl = row.querySelector('[id^="firstndr-"]');
                        if (firstNdrEl && data.remark) {
                            firstNdrEl.innerHTML = `<div>Reason: ${strLimit(data.remark, 25)}</div><div class="text-gray-400 text-[10px]">NDR On: ${formatDate(data.lastScanDate)}</div>`;
                        }
                        
                        // ✅ Update Last NDR Column - Show NDR Reason + Date/Time
                        const lastNdrEl = row.querySelector('[id^="lastndr-"]');
                        if (lastNdrEl) {
                            const reason = data.remark || 'Pending scan';
                            const ndrDate = data.lastScanDate ? formatDateWithTime(data.lastScanDate) : '-';
                            lastNdrEl.innerHTML = `
                                <div class="text-[10px]">
                                    <div class="font-medium text-gray-700">
                                        Reason: ${strLimit(reason, 25)}
                                    </div>
                                    <div class="text-gray-500">
                                        NDR On: ${ndrDate}
                                    </div>
                                </div>
                            `;
                        }
                        
                        // ✅ Update OFD/Aging Column
                        const agingEl = row.querySelector('[id^="aging-"]');
                        const attemptsEl = row.querySelector('[id^="attempts-"]');
                        const agingDaysEl = row.querySelector('[id^="aging-days-"]');
                        if (agingEl && data.lastScanDate) {
                            const days = calculateAgingDays(data.lastScanDate);
                            if (attemptsEl) attemptsEl.textContent = days > 0 ? days : 1;
                            if (agingDaysEl) agingDaysEl.textContent = days;
                            agingEl.querySelector('div:last-child').className = days >= 3 ? 'text-red-600 font-bold' : 'text-orange-600 font-bold';
                        }
                        
                        // ✅ Visual pulse effect
                        row.style.transition = 'background-color 0.3s';
                        row.style.backgroundColor = '#fef3c7';
                        setTimeout(() => { row.style.backgroundColor = ''; }, 1000);
                        
                        updatedCount++;
                        console.log(`✅ Updated: ${waybill} → ${data.status}`);
                    }
                });
                if (updatedCount > 0) console.log(`🎯 ${updatedCount} rows updated`);
            }
        })
        .catch(error => console.error('❌ Auto-track error:', error));
    }
    
    // ✅ Helper: Format API date
    function formatDate(apiDate) {
        if (!apiDate) return '-';
        try {
            const date = new Date(apiDate);
            return date.toLocaleString('en-IN', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }).replace(',', '');
        } catch (e) { return apiDate; }
    }
    
    // ✅ Helper: Calculate aging days
    function calculateAgingDays(apiDate) {
        if (!apiDate) return 0;
        try {
            const scanDate = new Date(apiDate);
            const now = new Date();
            const diffTime = Math.abs(now - scanDate);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        } catch (e) { return 0; }
    }
    
    // ✅ Helper: String limit (like Laravel Str::limit)
    function strLimit(str, limit) {
        if (!str) return '';
        return str.length > limit ? str.substring(0, limit) + '...' : str;
    }
    
    // ✅ Run immediately + every 60 seconds
    updateLiveStatus();
    const autoTrackInterval = setInterval(updateLiveStatus, 60000);
    console.log('⏱️ Auto-refresh scheduled every 60 seconds');
    
    // ✅ Cleanup
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) console.log('⏸️ Pausing auto-track (tab hidden)');
        else console.log('▶️ Resuming auto-track (tab visible)');
    });
    window.addEventListener('beforeunload', function() { clearInterval(autoTrackInterval); });
});
</script>
@endpush
@endsection