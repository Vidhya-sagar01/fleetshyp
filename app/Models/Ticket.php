<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'user_id', 'ticket_number', 'category', 'sub_category', 
        'reference_id', 'remark', 'attachments', 'status'
    ];

    protected $casts = [
        'attachments' => 'array', // JSON ko automatically array banata hai
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public static function generateNumber(): string {
        return 'TKT-' . strtoupper(uniqid());
    }
}