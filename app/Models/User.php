<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'phone',
    'profile_image',
    'suspended_at',

    // 👇 ADD THESE
    'remember_password',
    'remember_token',
    'user_code',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ===========================================
       📦 RELATIONSHIPS - All Defined Here
       =========================================== */
    
    /**
     * 👤 User has many Fship Orders
     * Table: fship_orders, Foreign Key: user_id
     */
    public function fshipOrders(): HasMany
    {
        return $this->hasMany(FshipOrder::class, 'user_id', 'id');
    }
    
    /**
     * 📍 User has many Pickup Addresses
     * Table: pickup_addresses, Foreign Key: user_id
     */
    public function pickupAddresses(): HasMany
    {
        return $this->hasMany(PickupAddress::class, 'user_id', 'id');
    }
    
    /**
     * 🏢 User has many Vendor Addresses (via Pickup Address)
     * Note: vendor_addresses table has pickup_address_id, NOT user_id
     * So we use a helper method instead of hasManyThrough for flexibility
     */
    public function getVendorAddressesAttribute()
    {
        // Returns collection of all vendor addresses via user's pickups
        return $this->pickupAddresses->flatMap(function($pickup) {
            return $pickup->vendorAddresses ?? collect();
        });
    }
    
    /**
     * 🔄 User has many RTO Addresses (via Pickup Address)
     * Note: rto_addresses table has pickup_address_id, NOT user_id
     */
    public function getRtoAddressesAttribute()
    {
        // Returns collection of all RTO addresses via user's pickups
        return $this->pickupAddresses->flatMap(function($pickup) {
            return $pickup->rtoAddresses ?? collect();
        });
    }
    
    /**
     * 💰 User has one Wallet
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }
    
    /**
     * 🪪 User has one KYC Detail
     */
    public function kycDetail(): HasOne
    {
        return $this->hasOne(KycDetail::class, 'user_id', 'id');
    }
    
    /**
     * 🏢 User has one Company Profile
     * Note: company_profiles table uses seller_id as foreign key
     */
    public function companyProfile(): HasOne
    {
        return $this->hasOne(CompanyProfile::class, 'seller_id', 'id');
    }
    
    /* ===========================================
       🔧 HELPER METHODS for Analytics
       =========================================== */
    
    /**
     * Get count of active (non-cancelled) orders
     */
    public function getActiveOrdersCountAttribute(): int
    {
        return $this->fshipOrders()->whereNotIn('status', ['cancelled', 'deleted'])->count();
    }
    
    /**
     * Get total revenue from all orders
     */
    public function getTotalRevenueAttribute(): float
    {
        return $this->fshipOrders()->sum('total_amount') ?? 0;
    }
    
    /**
     * Get total COD revenue
     */
    public function getCodRevenueAttribute(): float
    {
        return $this->fshipOrders()
            ->where('payment_mode', 1)
            ->sum('total_amount') ?? 0;
    }
    
    /**
     * Get vendor address count (via pickup)
     */
    public function getVendorAddressCountAttribute(): int
    {
        return $this->vendor_addresses->count();
    }
    
    /**
     * Get RTO address count (via pickup)
     */
    public function getRtoAddressCountAttribute(): int
    {
        return $this->rto_addresses->count();
    }
}