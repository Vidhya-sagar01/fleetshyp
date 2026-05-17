<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class BankDetail extends Model
{
    protected $fillable = [
        'user_id',
        'beneficiary_name',
        'account_type',
        'account_number',
        'ifsc_code',
        'cheque_image',
        'status',
        'verified_by',
        'verified_at',
        'rejection_reason'
    ];

   
    public function setAccountNumberAttribute($value)
    {
        $this->attributes['account_number'] =
            Crypt::encryptString($value);
    }

   
    public function getAccountNumberAttribute($value)
    {
        return Crypt::decryptString($value);
    }

 
    public function getMaskedAccountNumberAttribute()
    {
        $acc = $this->account_number;

        return str_repeat('•', strlen($acc) - 4)
               . substr($acc, -4);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
