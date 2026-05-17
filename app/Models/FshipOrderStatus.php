<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FshipOrderStatus extends Model
{
    protected $table = 'fship_order_statuses';

    protected $fillable = [
        'fship_order_id',
        'status',
        'status_code',
        'status_name',
        'status_date',
        'location',
        'remarks',
        'tag', // Isme multiple tags store honge
        'note',
        'source'
    ];

    /**
     * Fship Agreement Compliance:
     * Multiple tags ko array ki tarah handle karne ke liye casting.
     */
    protected $casts = [
        'status_date' => 'datetime',
        'tag' => 'array', // <--- Ye change zaroori hai
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(FshipOrder::class, 'fship_order_id');
    }
}