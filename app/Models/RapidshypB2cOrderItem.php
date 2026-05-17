<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RapidshypB2cOrderItem extends Model
{
    protected $table = 'rapidshyp_b2c_order_items';
    
    protected $fillable = [
        'rapidshyp_b2c_order_id', 'item_name', 'sku', 'description',
        'units', 'unit_price', 'tax', 'hsn', 'product_length',
        'product_breadth', 'product_height', 'product_weight',
        'brand', 'image_url', 'is_fragile', 'is_personalisable',
        'pickup_address_name'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'tax' => 'decimal:2',
        'is_fragile' => 'boolean',
        'is_personalisable' => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(RapidshypB2cOrder::class, 'rapidshyp_b2c_order_id');
    }
}
