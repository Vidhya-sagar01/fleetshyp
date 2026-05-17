<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FshipReverseOrder extends Model
{
   


protected $fillable = [
    
    'seller_id',           
    'forward_order_id',
    'warehouse_id',
    
  
    'original_waybill',
    'reverse_waybill',
    'fship_api_order_id',
    'courier_name',
    'courier_id',
    'route_code',
    'tracking_number',
    
    
    'is_qc_required',
    'return_reason',
    'return_type',
    
   
    'consignee_name',
    'consignee_phone',
    'consignee_email',
    'pickup_address',
    'pickup_landmark',
    'pickup_address_type',
    'pickup_pincode',
    'pickup_city',
    'pickup_state',
    
   
    'invoice_number',
    'order_amount',
    'tax_amount',
    'extra_charges',
    'total_amount',
    'cod_amount',
    'payment_mode',
    
    // Dimensions
    'shipment_weight',
    'shipment_length',
    'shipment_width',
    'shipment_height',
    'volumetric_weight',
    
    // Status
    'status',
    'reverse_order_created_at',
    'reverse_order_updated_at',
    'picked_at',
    'delivered_at',
    'cancelled_at',
    'cancellation_reason',
    
    // API
    'api_request',
    'api_response',
    'is_valid',
    
    // Additional
    'notes',
    'latitude',
    'longitude',
];

protected $casts = [
    'is_qc_required' => 'boolean',
    'is_valid' => 'boolean',
    'qc_parameters' => 'array',
    'api_request' => 'array',
    'api_response' => 'array',
    'reverse_order_created_at' => 'datetime',
    'reverse_order_updated_at' => 'datetime',
    'picked_at' => 'datetime',
    'delivered_at' => 'datetime',
    'cancelled_at' => 'datetime',
];

/**
 * Relationship: Belongs to Seller
 */
public function seller()
{
    return $this->belongsTo(\App\Models\User::class, 'seller_id');
}


public function fshipOrder()
{
    return $this->belongsTo(\App\Models\FshipOrder::class, 'forward_order_id');
}
public function warehouse()
{
    return $this->belongsTo(\App\Models\PickupAddress::class, 'warehouse_id');
}

public function items()
{
    return $this->hasMany(\App\Models\FshipReverseOrderItem::class, 'reverse_order_id');
}

}