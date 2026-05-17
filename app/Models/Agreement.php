<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_name',
        'version',
        'change_description',
        'file_path',
        'file_name',
        'accepted_by',
        'acceptance_date',
        'accepted_by_ip',
        'published_at',
        'ip_address',
        'status',
        'uploaded_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'acceptance_date' => 'datetime',
    ];

    /**
     * Relationship: Who uploaded this agreement?
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Accessor: Get full URL for the PDF
     */
    public function getDocUrlAttribute()
    {
        if ($this->file_path) {
            return Storage::url($this->file_path);
        }
        return null;
    }

    /**
     * Scope: Get only the latest active version
     */
    public function scopeLatestVersion($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}