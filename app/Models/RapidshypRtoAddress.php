<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RapidshypRtoAddress extends Model
{
    use HasFactory;

    protected $table = 'rapidshyp_rto_addresses';

    protected $fillable = [
        'rto_address_name',
        'rto_contact_name',
        'rto_contact_number',
        'rto_email',
        'rto_address_line',
        'rto_address_line2',
        'rto_pincode',
        'rto_city',
        'rto_state',
        'rto_country',
        'rto_gstin',

        // system
        'seller_id',

        // ✅ FIXED: match DB column name
        'rapidshyp_rto_name',
    ];

    protected $casts = [
        'seller_id' => 'integer',
        'rto_pincode' => 'string',
        'rto_contact_number' => 'string',
        'rto_gstin' => 'string',
    ];

    // ======================================================
    // RELATIONS
    // ======================================================

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * ✅ Correct relation: One RTO → Many Warehouses
     */
    public function warehouses(): HasMany
    {
        return $this->hasMany(RapidshypWarehouse::class, 'rto_address_id');
    }

    // ======================================================
    // SCOPES
    // ======================================================

    public function scopeForSeller($query, int $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    public function scopeSearch($query, string $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('rto_address_name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('rto_city', 'LIKE', "%{$searchTerm}%")
              ->orWhere('rto_pincode', 'LIKE', "%{$searchTerm}%");
        });
    }

    // ======================================================
    // ACCESSORS
    // ======================================================

    /**
     * ✅ Safe phone formatter
     */
    public function getFormattedContactNumberAttribute(): string
    {
        $clean = preg_replace('/\D/', '', $this->rto_contact_number ?? '');

        if (strlen($clean) !== 10) {
            return ''; // ya throw bhi kar sakte ho depending on use-case
        }

        return $clean;
    }

    /**
     * ✅ GSTIN validator (auto uppercase)
     */
    public function hasValidGstin(): bool
    {
        if (empty($this->rto_gstin)) {
            return false;
        }

        $gstin = strtoupper($this->rto_gstin);

        return preg_match(
            '/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            $gstin
        ) === 1;
    }

    /**
     * Full formatted address
     */
    public function getFullAddressAttribute(): string
    {
        return implode(', ', array_filter([
            $this->rto_address_line,
            $this->rto_address_line2,
            $this->rto_city,
            $this->rto_state,
            $this->rto_pincode,
            $this->rto_country,
        ]));
    }
}