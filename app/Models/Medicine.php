<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'generic_name',
        'manufacturer',
        'description',
        'tracking_number',
        'delivery_date',
        'manufactured_date',
        'expiry_date',
        'number_of_boxes',
        'quantity_per_boxes',
        'source',
        'current_stock'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'delivery_date' => 'date',
        'manufactured_date' => 'date',
        'expiry_date' => 'date',
        'deleted_at' => 'datetime'
    ];

    protected $dates = [
        'delivery_date',
        'manufactured_date',
        'expiry_date'
    ];

    // Relationships
    public function category() : BelongsTo
    {
        return $this->belongsTo(MedicineCategory::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MedicineTransaction::class);
    }

    // Accessors and mutators
    protected function name() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function genericName() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function manufacturer() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function deliveryDate() : Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return Carbon::parse($value)->format('F d, Y');
            }
        );
    }

    protected function manufacturedDate() : Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return Carbon::parse($value)->format('F d, Y');
            }
        );
    }

    protected function expiryDate() : Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return Carbon::parse($value)->format('F d, Y');
            }
        );
    }

    protected function source() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    // Methods
    public function updateStock(int $quantity, string $type = 'out'): void
    {
        $this->current_stock += $type === 'out' ? -$quantity : $quantity;
        $this->save();
    }

    public function hasEnoughStock(int $quantity): bool
    {
        return $this->current_stock >= $quantity;
    }

    public function isExpired(): bool
    {
        return Carbon::parse($this->expiry_date)->isPast();
    }
}
