<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayOfficial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'term_start',
        'term_end'
    ];

    protected $casts = [
        'term_start' => 'date',
        'term_end' => 'date'
    ];

    // Relationship
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessors and mutators
    protected function position(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function termStart(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('F j, Y'),
            set: fn ($value) => Carbon::parse($value)->format('Y-m-d')
        );
    }

    protected function termEnd(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('F j, Y'),
            set: fn ($value) => Carbon::parse($value)->format('Y-m-d')
        );
    }

    /**
     * Check if the barangay official is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return Carbon::now()->between($this->term_start, $this->term_end);
    }

    /**
     * Get the remaining term duration in months
     */
    public function remainingTermDuration(): int
    {
        return Carbon::now()->diffInMonths($this->term_end, false);
    }

    /**
     * Scope a query to only include active barangay officials.
     */
    public function scopeActive($query)
    {
        return $query->where('term_start', '>=', Carbon::now())
            ->andWhere('term_end', '<=', Carbon::now());
    }

    /**
     * Scope a query to only include barangay officials with expired term.
     */
    public function scopeExpired($query)
    {
        return $query->where('term_end', '>', Carbon::now());
    }

    /**
     * Scope a query to only include officials by position
     */
    public function scopeByPosition($query, string $position)
    {
        return $query->where('position', $position);
    }
}
