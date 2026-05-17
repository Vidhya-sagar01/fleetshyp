<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Updated to match Fship Warehouse & Order parameters.
     */
    protected $fillable = [
        'pickup_address_id', // Local database table ID
        'pick_address_ID',   // REQUIRED: Unique Warehouse ID from Fship Dashboard [cite: 79, 147]
        'vendor_name',       // Maps to contactName in API 
        'vendor_gstin',      // Additional info (Not required by Fship API but good for records)
        'warehouse_name',
       
    ];

    /**
     * Relationship with the PickupAddress details.
     */
    public function pickup(): BelongsTo
    {
        return $this->belongsTo(PickupAddress::class, 'pickup_address_id');
    }
}