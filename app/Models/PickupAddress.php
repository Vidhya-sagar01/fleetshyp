<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupAddress extends Model
{
    protected $fillable = [
        'user_id',
        'warehouse_name',
        'contact_name',
        'address_line1',
        'address_line2',
        'pincode',
        'city',
        'state_id',
        'country_id',
        'phone_number',
        'email',
        'pick_address_ID',
        'is_default', 
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


public function rto()
{
    return $this->hasOne(RtoAddress::class, 'pickup_address_id');
}

public function vendorAddress() {
    return $this->hasOne(VendorAddress::class, 'pickup_address_id');
}
}