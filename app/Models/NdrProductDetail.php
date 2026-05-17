<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NdrProductDetail extends Model
{
    protected $table = 'ndr_product_details';

    protected $fillable = [
        'ndr_id',
        'product_id',
        'product_name',
        'sku',
        'quantity',
        'unit_price'
    ];

    /**
     * Yeh product kis NDR action ka hissa hai.
     */
    public function ndrManagement(): BelongsTo
    {
        return $this->belongsTo(NdrManagement::class, 'ndr_id');
    }
}