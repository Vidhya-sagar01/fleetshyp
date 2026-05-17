<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'logo_url',
        'rating_pickup',
        'rating_delivery',
        'rating_ndr',
        'rating_weight',
        'rating_tat',
        'expected_pickup',
        'estimated_delivery',
        'is_active',
        'fship_courier_id'
    ];

    /**
     * Relation: Courier has many rate cards
     */
    public function rateCards()
    {
        return $this->hasMany(RateCard::class);
    }

    public function rates()
{
    return $this->hasMany(ShippingRateMini::class, 'courier_id');
}
}