<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KycDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * * @var string
     */
    protected $table = 'kyc_details';

   
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'verification_method',
        'status',
        'business_type',
        'pan_number',
        'aadhaar_number',
        'user_photo',
        'pan_card_image',
        'aadhaar_card_image',
        'verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'verified_at' => 'datetime',
        'status' => 'string', 
    ];

   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

   
    public function isVerified(): bool
    {
        return $this->status === 'VERIFIED';
    }

 
    public function isPending(): bool
    {
        return $this->status === 'PENDING';
    }

   
    public function isRejected(): bool
    {
        return $this->status === 'REJECTED';
    }
}