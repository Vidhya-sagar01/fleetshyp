<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RapidshypServiceabilityLog extends Model
{
    protected $table = 'rapidshyp_serviceability_logs';

    protected $fillable = [
        'seller_id',
        'pickup_pincode',
        'delivery_pincode',
        'is_cod',
        'total_order_value',
        'weight',
        'is_serviceable',
        'courier_list',
        'raw_response',
        'api_status',
        'error_message',
        'order_id',
        'selected_courier_code',
        'selected_courier_name',
    ];

    protected $casts = [
        'is_cod'         => 'boolean',
        'is_serviceable' => 'boolean',
        'courier_list'   => 'array',
        'raw_response'   => 'array',
        'total_order_value' => 'float',
        'weight'         => 'float',
    ];

    /**
     * Relationship to User/Seller
     */
    public function seller()
    {
        return $this->belongsTo(\App\Models\User::class, 'seller_id');
    }

    /**
     * Relationship to Order (nullable)
     */
    public function order()
    {
        return $this->belongsTo(RapidshypB2cOrder::class, 'order_id');
    }
}
