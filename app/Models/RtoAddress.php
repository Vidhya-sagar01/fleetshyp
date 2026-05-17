<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RtoAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Updated based on Fship Warehouse/RTO parameters.
     */
    protected $fillable = [
    'pickup_address_id',
    'pick_address_id', // ✅ change
    'rto_nick_name',
    'contact_name',
    'phone',
    'email',
    'address_line1',
    'address_line2',
    'pincode',
    'city',
    'state_id',
    'country_id'
];
    /**
     * Relationship with the main PickupAddress.
     */
    public function pickup(): BelongsTo
    {
        return $this->belongsTo(PickupAddress::class, 'pickup_address_id');
    }
}