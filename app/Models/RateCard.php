<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class RateCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'shipping_rates_mini';

  protected $fillable = [
    'user_id', 'type', 'plan_name', 'courier_id', 'mode', 'mode_icon', 
    'weight_info', 'add_weight', 'is_active',
    'zone_a_forward', 'zone_a_rto', 'zone_a_add_forward', 'zone_a_add_rto', 'zone_a_cod_charge', 'zone_a_cod_percent',
    'zone_b_forward', 'zone_b_rto', 'zone_b_add_forward', 'zone_b_add_rto', 'zone_b_cod_charge', 'zone_b_cod_percent',
    'zone_c_forward', 'zone_c_rto', 'zone_c_add_forward', 'zone_c_add_rto', 'zone_c_cod_charge', 'zone_c_cod_percent',
    'zone_d_forward', 'zone_d_rto', 'zone_d_add_forward', 'zone_d_add_rto', 'zone_d_cod_charge', 'zone_d_cod_percent',
    'zone_e_forward', 'zone_e_rto', 'zone_e_add_forward', 'zone_e_add_rto', 'zone_e_cod_charge', 'zone_e_cod_percent',
];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

   
  public function getCourierLogoUrlAttribute()
{
    // 1. Agar RateCard table mein manual logo upload hai (Priority 1)
    if (!empty($this->mode_icon) && \Storage::disk('public')->exists($this->mode_icon)) {
        return \Storage::url($this->mode_icon);
    }

    // 2. Courier relationship se Couriers table ka data uthayein
    if ($this->courier) {
        $url = $this->courier->logo_url;
        
        // Agar URL valid 'http' link hai
        if ($url && (str_starts_with($url, 'http://') || str_starts_with($url, 'https://'))) {
            return $url;
        }
        
        // Agar courier table mein manual image file path hai
        if ($this->courier->logo && \Storage::disk('public')->exists($this->courier->logo)) {
            return \Storage::url($this->courier->logo);
        }
    }

    // 3. Fallback: Agar kuch nahi mila
    return asset('images/default-courier.png');
}

    public function getModeIconUrlAttribute()
    {
        return $this->mode_icon ? Storage::url($this->mode_icon) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

     public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }
 
  
}