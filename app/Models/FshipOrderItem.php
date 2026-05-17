<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FshipOrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     * Updated based on Fship API 'products' array requirements.
     */
    protected $fillable = [
        'fship_order_id',
         'product_name',
         'quantity',
         'unit_price',
         'sku',
         'hsn_code',
         'shipping_charge',    
         'gift_wrap_charge',   
         'transaction_fee',    
         'order_discount'      
    ];

    /**
     * Relation with the main FshipOrder.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(FshipOrder::class, 'fship_order_id');
    }
}