<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BHW extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'local_government_unit',
        'issuance_date'
    ];

    // Relationships
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessors and Mutators
    protected function localGovernmentUnit() : Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }
}
