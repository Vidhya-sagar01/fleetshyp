<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgreementAcceptance extends Model
{
    use HasFactory;

    protected $table = 'agreement_acceptances';

    protected $fillable = [
        'agreement_id',
        'user_id',
        'accepted_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

  

   
    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }

  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}