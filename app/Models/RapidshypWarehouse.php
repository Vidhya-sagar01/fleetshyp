<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RapidshypWarehouse extends Model
{
    use HasFactory;

    /**
     * Table name agar default se alag hai toh specify karein
     */
    protected $table = 'rapidshyp_warehouses';

    /**
     * Mass assignable fields (RapidShyp API ke fields ke hisaab se)
     */
 
protected $fillable = [
    'seller_id',              
    'warehouse_name',
    'contact_person',
    'contact_number',
    'email_id',
    'address_line_1',
    'address_line_2',
    'pincode',
    'city',
    'state',
    'country',
    'gstin',
    'latitude',                
    'longitude',               
    'warehousing_system',      
    'is_primary',
    'dropship_location',
    'use_alt_rto_address',
    'rto_address_id',
    'rapidshyp_warehouse_id',
    'rto_location_name'
];

    /**
     * Casting for boolean fields
     */
    protected $casts = [
        'is_primary' => 'boolean',
        'dropship_location' => 'boolean',
        'use_alt_rto_address' => 'boolean',
    ];

    /**
     * RTO Address ke saath relationship
     */
    public function rtoAddress(): BelongsTo
    {
        return $this->belongsTo(RapidshypRtoAddress::class, 'rto_address_id');
    }
}

