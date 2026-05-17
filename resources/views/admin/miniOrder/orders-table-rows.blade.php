@forelse($recentOrders as $order)
@php
    $statusColors = [
        'Booked' => 'badge-primary', 'Picked' => 'badge-info',
        'In Transit' => 'badge-warning', 'Delivered' => 'badge-success',
        'Cancelled' => 'badge-danger', 'RTO' => 'badge-danger',
    ];
    $paymentBadge = $order->payment_mode == 1 ? 'badge-cod' : 'badge-prepaid';
    $paymentLabel = $order->payment_mode == 1 ? 'COD' : 'Prepaid';
@endphp
<tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location.href='/admin/orders/{{ $order->id }}/edit'">
    <td>
        <div class="font-mono text-sm font-medium text-slate-700">#{{ Str::limit($order->merchant_order_id, 12) }}</div>
        <div class="text-xs text-slate-400">ID: {{ $order->id }}</div>
    </td>
    <td>
        @if($order->waybill)
            <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded">{{ Str::limit($order->waybill, 10) }}</span>
        @else
            <span class="text-slate-400 text-xs">—</span>
        @endif
    </td>
    <td>
        <div class="font-medium text-slate-800">{{ Str::limit($order->buyer_name, 18) }}</div>
        <div class="text-xs text-slate-400">{{ Str::limit($order->phone_number, 12) }}</div>
    </td>
    <td class="hide-mobile">
        <div class="text-sm text-slate-600">{{ Str::limit($order->city, 12) }}, {{ Str::limit($order->state, 10) }}</div>
        <div class="text-xs text-slate-400 font-mono">{{ $order->pincode }}</div>
    </td>
    <td class="font-semibold text-slate-800">₹{{ number_format($order->total_amount, 2) }}</td>
    <td><span class="badge {{ $paymentBadge }}">{{ $paymentLabel }}</span></td>
    <td class="hide-mobile"><span class="text-sm text-slate-600">{{ Str::limit($order->courier_name ?? '—', 12) }}</span></td>
    <td><span class="badge {{ $statusColors[$order->status] ?? 'badge-secondary' }}">{{ $order->status }}</span></td>
    <td class="text-sm text-slate-500">
        {{ $order->created_at->format('M d') }}
        <div class="text-xs text-slate-400">{{ $order->created_at->format('H:i') }}</div>
    </td>
    <td>
        <div class="flex items-center gap-1">
            <a href="/admin/orders/{{ $order->id }}/edit" class="btn-icon w-7 h-7 rounded-lg hover:bg-slate-100" onclick="event.stopPropagation()" title="Edit">
                <i class="fas fa-pen text-slate-500 text-xs"></i>
            </a>
            <a href="/admin/orders/{{ $order->id }}" class="btn-icon w-7 h-7 rounded-lg hover:bg-slate-100" onclick="event.stopPropagation()" title="View">
                <i class="fas fa-eye text-slate-500 text-xs"></i>
            </a>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="10" class="text-center py-8 text-slate-400">
        <i class="fas fa-box-open text-3xl mb-2 block"></i>
        <div>No orders found</div>
    </td>
</tr>
@endforelse