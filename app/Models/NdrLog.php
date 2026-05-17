<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NdrLog extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'ndr_logs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'action',
        'reason',
        'remarks',
        'user_id',
        'status',
        'attempted_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'attempted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the order that owns this NDR log.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(FshipOrder::class, 'order_id');
    }

    /**
     * Get the user who created this log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}