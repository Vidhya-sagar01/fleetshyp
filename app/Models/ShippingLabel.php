<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingLabel extends Model
{
    use HasFactory;

    protected $table = 'label_settings'; // ✅ Separate table for settings

    protected $fillable = [
        'user_id',
        'label_display_name',
        'label_printer',
        'label_template',
        'show_signature_on_label',
        'template_settings',
    ];

    protected $casts = [
        'template_settings' => 'array',
        'show_signature_on_label' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}