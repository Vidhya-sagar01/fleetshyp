<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FshipOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     * Updated based on Fship API v1.2.3.2 structure.
     */
    protected $fillable = [
        'user_id',
        'merchant_order_id', 
        'fship_api_order_id', 
        'pickup_order_id',
        'waybill',           
        'buyer_name',       
        'phone_number',     
        'email_id',       
        'pincode',         
        'complete_address', 
        'city',               
        'state',
        'weight',           
        'volumetric_weight', 
        'length',          
        'width',            
        'height',            
        'pick_address_ID',   
        'payment_mode',     
        'total_amount',     
        'cod_amount',      
        'courier_name',
        'order_type',       
        'order_date',
        'product_subtotal',   
        'alt_phone_number',  
        'landmark', 
        'company_name',    
        'gstin_number', 
        'zone',
        'is_pickup_available',
        'is_delivery_available',
        'is_cod_available',
        'is_prepaid_available', 
        'source_pincode',
        'destination_pincode',
        'source_destination',
        'status',
        'forward_charge',          
        'cod_charge',              
        'wallet_deduction_amount', 
        'courier_name',
        'courier_id',
        'service_mode',            
        'booked_at',
        'expected_delivery_date',
        'has_reverse_order',          
        'is_refunded',
        'is_remitted',      
        'remitted_at',  
    ];


    /**
     * Relationship with Order Items (Products).
     * Fship supports multiple products per shipment. [cite: 169]
     */
    public function items(): HasMany
    {
        return $this->hasMany(FshipOrderItem::class, 'fship_order_id');
    }

    /**
     * Relationship with Tracking History.
     * Used for full travel lifecycle scans. [cite: 272]
     */
    public function trackingLogs(): HasMany
    {
        return $this->hasMany(FshipOrderTrackingLog::class, 'fship_order_id');
    }

    /**
     * Relationship with the User who placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

// public function pickupAddress()
// {
//     return $this->belongsTo(PickupAddress::class, 'pick_address_ID', 'pick_address_ID');
    
// }
public function pickupAddress()
{
    // Param 1: Model Name
    // Param 2: Order table ka column (Foreign Key) -> jo ki '47' save kar raha hai
    // Param 3: PickupAddress table ka column jisse match karna hai -> jo ki 'id' hai
    return $this->belongsTo(PickupAddress::class, 'pick_address_ID', 'id');
}

public function document()
{
    return $this->hasOne(ShipmentDocument::class, 'pickup_order_id', 'pickup_order_id');
}

public function reverseOrders() {
    return $this->hasMany(FshipReverseOrder::class, 'forward_order_id');
}

public function remittancePayments()
{
    return $this->hasMany(\App\Models\CodRemittancePayment::class, 'order_id');
}

public function latestPayment(): HasOne
    {
        return $this->hasOne(CodRemittancePayment::class, 'order_id', 'id')
            ->orderByDesc('id');
    }
public function ndrLogs(): HasMany
    {
        return $this->hasMany(NdrLog::class, 'order_id', 'id')
            ->orderByDesc('created_at');
    }

protected $casts = [
    'qc_json' => 'array', 
    'expected_delivery_date' => 'datetime',
    'tags' => 'array',
    'is_refunded' => 'boolean',
    'is_remitted' => 'boolean',     
    'remitted_at' => 'datetime',  // ✅ ADD THIS
];
}