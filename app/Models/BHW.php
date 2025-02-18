<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BHW extends Model
{
    use HasFactory;

    protected $table = 'bhw';

    protected $fillable = [
        'user_id',
        'certification_no',
        'assigned_barangay',
    ];

    // Relationships
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
}
