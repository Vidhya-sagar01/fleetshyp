<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletRecharge extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wallet_recharges';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'payment_method',
        'status',
        'failure_reason',
        'metadata',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Status constants for consistency.
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUNDED = 'refunded';

    /**
     * Payment method constants.
     */
    public const METHOD_CARD = 'card';
    public const METHOD_UPI = 'upi';
    public const METHOD_NETBANKING = 'netbanking';
    public const METHOD_WALLET = 'wallet';

    // ============================================================
    // RELATIONSHIPS
    // ============================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function walletTransaction()
    {
        return $this->hasOne(WalletTransaction::class, 'fship_order_id')
                    ->where('charge_type', 'recharge')
                    ->where('source', 'razorpay');
    }

    // ============================================================
    // SCOPES
    // ============================================================

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', self::STATUS_SUCCESS);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ============================================================
    // HELPERS / ACCESSORS
    // ============================================================

    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function getFormattedAmountAttribute(): string
    {
        return '₹' . number_format($this->amount, 2);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_SUCCESS => 'bg-green-100 text-green-700',
            self::STATUS_FAILED => 'bg-red-100 text-red-700',
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-700',
            self::STATUS_REFUNDED => 'bg-gray-100 text-gray-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    /**
     * ✅ FIXED: Get status label with icon for UI
     */
    public function getStatusWithIconAttribute(): string
    {
        $icons = [
            self::STATUS_SUCCESS => '<i class="fa fa-check-circle text-green-500 mr-1"></i>Success',
            self::STATUS_FAILED => '<i class="fa fa-times-circle text-red-500 mr-1"></i>Failed',
            self::STATUS_PENDING => '<i class="fa fa-clock text-yellow-500 mr-1"></i>Pending',
            self::STATUS_REFUNDED => '<i class="fa fa-undo text-gray-500 mr-1"></i>Refunded',
        ];
        
        // ✅ Return icon + label, or fallback to ucfirst status
        return $icons[$this->status] ?? ucfirst($this->status ?? 'Unknown');
    }
}