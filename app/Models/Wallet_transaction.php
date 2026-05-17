<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet_transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wallet_transactions';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'fship_order_id',
        'amount',
        'type',           // credit/debit
        'charge_type',    // forward/cod/rto/recharge/etc.
        'source',         // admin_manual/razorpay/fship_booking/etc.
        'opening_balance',
        'closing_balance',
        'remark',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get the FShip order associated with the transaction.
     */
    public function fshipOrder(): BelongsTo
    {
        return $this->belongsTo(\App\Models\FshipOrder::class, 'fship_order_id');
    }

    /**
     * Scope: Credit transactions only.
     */
    public function scopeCredit($query)
    {
        return $query->where('type', 'credit');
    }

    /**
     * Scope: Debit transactions only.
     */
    public function scopeDebit($query)
    {
        return $query->where('type', 'debit');
    }

    /**
     * Scope: Filter by source.
     */
    public function scopeBySource($query, string $source)
    {
        return $query->where('source', $source);
    }
}