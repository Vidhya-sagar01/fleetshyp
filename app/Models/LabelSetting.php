<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelSetting extends Model
{
    protected $fillable = [
        'user_id', 'display_name', 'printer', 'template', 'show_signature', 'template_settings'
    ];

    // Auto convert JSON to Array
    protected $casts = [
        'template_settings' => 'array',
    ];
}
