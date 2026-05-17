<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RapidshypB2cOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rapidshyp_b2c_orders';

    protected $fillable = [
        'seller_id',
        'order_id',
        'order_date',
        'store_name',
        'pickup_address_name',
        'pickup_location',
        'shipping_address',
        'billing_is_shipping',
        'billing_address',
        'order_items',
        'package_details',
        'payment_method',
        'shipping_charges',
        'gift_wrap_charges',
        'transaction_charges',
        'total_discount',
        'total_order_value',
        'cod_charges',
        'prepaid_amount',
        'collectable_value',
        'api_response',
        'api_status',
        'awb',
        'shipment_id',
        'order_status',
    ];

    protected $casts = [
        'pickup_location'    => 'array',
        'shipping_address'   => 'array',
        'billing_address'    => 'array',
        'order_items'        => 'array',
        'package_details'    => 'array',
        'api_response'       => 'array',
        'billing_is_shipping'=> 'boolean',
        'order_date'         => 'date',
        'shipping_charges'   => 'float',
        'gift_wrap_charges'  => 'float',
        'transaction_charges'=> 'float',
        'total_discount'     => 'float',
        'total_order_value'  => 'float',
        'cod_charges'        => 'float',
        'prepaid_amount'     => 'float',
        'collectable_value'  => 'float',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeForSeller($query, $sellerId = null)
    {
        return $query->where('seller_id', $sellerId ?? auth()->id());
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getShippingNameAttribute(): string
    {
        $addr = $this->shipping_address ?? [];
        return trim(($addr['firstName'] ?? '') . ' ' . ($addr['lastName'] ?? ''));
    }

    public function getItemCountAttribute(): int
    {
        return collect($this->order_items ?? [])->sum('units');
    }

    public function getIsCodAttribute(): bool
    {
        return $this->payment_method === 'COD';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->order_status) {
            'PENDING'        => 'bg-gray-100 text-gray-700',
            'PROCESSING'     => 'bg-blue-100 text-blue-700',
            'READY_TO_SHIP'  => 'bg-yellow-100 text-yellow-700',
            'SHIPPED'        => 'bg-indigo-100 text-indigo-700',
            'DELIVERED'      => 'bg-green-100 text-green-700',
            'CANCELLED'      => 'bg-red-100 text-red-700',
            'RTO'            => 'bg-orange-100 text-orange-700',
            default          => 'bg-gray-100 text-gray-700',
        };
    }
}