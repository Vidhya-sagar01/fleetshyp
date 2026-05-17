<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'seller_id',
        'company_code',
        'company_name',
        'brand_name',
        'website',
        'email',
        'customer_care_email',
        'customer_care_mobile',
        'has_gst',
        'enable_state_gst',
        'logo'
    ];

    public function seller()
    {
        return $this->belongsTo(\App\Models\User::class, 'seller_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {

            do {
                $code = mt_rand(1000, 9999);
            } while (self::where('company_code', $code)->exists());

            $company->company_code = $code;
        });
    }
}