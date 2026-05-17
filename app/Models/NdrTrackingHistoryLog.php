<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NdrTrackingHistoryLog extends Model
{
    protected $table = 'ndr_tracking_history_logs';

   
    protected $fillable = [
        'waybill_number',
        'scan_date_time',
        'scan_status',
        'scan_location',
        'scan_remark',
        'shipment_journey'
    ];

    protected $casts = [
        'scan_date_time' => 'datetime'
    ];
}