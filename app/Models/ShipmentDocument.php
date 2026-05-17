<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentDocument extends Model
{
    // Agar aap manually timestamps handle kar rahe hain toh false rakhein,
    // lekin last_regenerated_at ke liye ise true rakhna behtar hota hai.
    public $timestamps = false;

    protected $table = 'shipment_documents';

    protected $fillable = [
        'pickup_order_id', 
        'manifest_url', 
        'invoice_url', 
        'label_url', 
        'courier_name',       
        'pickup_status',      
        'shipment_count',      
        'provider_pickup_id',  
        'pickup_date',         
        'remark',              
        'last_regenerated_at'  
    ];

    /**
     * Dates ko Carbon instances mein convert karne ke liye
     */
    protected $casts = [
        'pickup_date' => 'datetime',
        'last_regenerated_at' => 'datetime',
        'shipment_count' => 'integer',
    ];
}