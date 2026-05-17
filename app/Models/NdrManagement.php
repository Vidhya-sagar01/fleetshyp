<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
// Sahi namespace import karein taaki return type error na aaye
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NdrManagement extends Model
{
    protected $table = 'ndr_management';

    protected $fillable = [
        'api_order_id',
        'waybill_number',
        'last_action_taken',
        'reattempt_date',
        'contact_name',
        'mobilenumber',
        'complete_address',
        'remarks',
        'api_request_payload',
        'api_response_data',
        'status'
    ];

    /**
     * Fship API responses default roop se JSON format mein hoti hain[cite: 56].
     * Casts ka upyog array handling ko aasan banane ke liye kiya gaya hai.
     */
    protected $casts = [
        'api_request_payload' => 'array',
        'api_response_data'   => 'array',
        'reattempt_date'      => 'datetime'
    ];

    /**
     * Relationship: Is NDR entry se jude hue products fetch karne ke liye.
     */
    public function products(): HasMany
    {
        return $this->hasMany(NdrProductDetail::class, 'ndr_id');
    }

    /**
     * Relationship: NDR ko main order table se link karne ke liye.
     * Fship terminology mein waybill (AWB) number unique tracking identifier hota hai[cite: 30, 322].
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(FshipOrder::class, 'waybill_number', 'waybill');
    }
}