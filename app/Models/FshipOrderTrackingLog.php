<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FshipOrderTrackingLog extends Model
{
    /**
     * The attributes that are mass assignable.
     * Updated based on Fship Tracking History API response[cite: 304].
     */
    protected $fillable = [
        'fship_order_id', 
        'status_text',    // API field: "Status" [cite: 307]
        'location',       // API field: "Location" [cite: 309]
        'remarks',        // API field: "Remark" [cite: 308]
        'scanned_at',     // API field: "DateandTime" 
        'shipment_journey' // API field: "shipmentJourney" [cite: 310]
    ];

    /**
     * Casts for specific fields.
     */
    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    /**
     * Relationship with the main FshipOrder.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(FshipOrder::class, 'fship_order_id');
    }
}