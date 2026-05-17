<?php
// app/Models/CodRemittancePayment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodRemittancePayment extends Model
{
    use HasFactory;

    protected $table = 'cod_remittance_payments';

    protected $fillable = [
        'user_id',
        'order_id',
        'waybill',        // ✅ Added waybill
        'admin_id',
        'remitted_amount',
        'payment_reference',
        'convenience_fee',
        'payment_date',
        'payment_mode',
        'status',
        'remarks',
        'bank_name',        // ✅ Added
        'bank_account',     // ✅ Added
    ];

    protected $casts = [
        'remitted_amount' => 'decimal:2',
        'convenience_fee' => 'decimal:2',
        'payment_date' => 'date',
        'admin_id' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(FshipOrder::class, 'order_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function getFormattedAmountAttribute(): string
    {
        return '₹' . number_format($this->remitted_amount, 2);
    }
}