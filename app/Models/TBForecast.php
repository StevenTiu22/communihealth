<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class TBForecast extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_forecasts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'forecast_date',
        'target_date',
        'predicted_count',
        'lower_bound',
        'upper_bound',
        'standard_error',
        'model_version',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'forecast_date' => 'datetime',
        'target_date' => 'date',
        'predicted_count' => 'decimal:2',
        'lower_bound' => 'decimal:2',
        'upper_bound' => 'decimal:2',
        'standard_error' => 'decimal:4',
    ];

    /**
     * Get the forecasts for a specific month and year
     *
     * @param Builder $query
     * @param int $year
     * @param int $month
     * @return Builder
     */
    public function scopeForMonth(Builder $query, int $year, int $month): Builder
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        return $query->whereBetween('target_date', [$startDate, $endDate]);
    }

    /**
     * Get the latest forecasts
     *
     * @param Builder $query
     * @param int|null $limit
     * @return Builder
     */
    public function scopeLatest(Builder $query, int $limit = null): Builder
    {
        $query = $query->orderBy('forecast_date', 'desc')
            ->orderBy('target_date', 'asc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Get the most recent forecast batch
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeMostRecentBatch(Builder $query): Builder
    {
        $latestDate = $this->select('forecast_date')
            ->orderBy('forecast_date', 'desc')
            ->first()
            ?->forecast_date;

        if ($latestDate) {
            return $query->where('forecast_date', $latestDate);
        }

        return $query;
    }

    /**
     * Get the model version that produced this forecast
     */
    public function modelVersion()
    {
        return $this->belongsTo(ArimaModelVersion::class, 'model_version', 'version_date');
    }

    /**
     * Calculate prediction interval width
     *
     * @return float
     */
    public function getIntervalWidthAttribute(): float
    {
        return $this->upper_bound - $this->lower_bound;
    }

    /**
     * Check if a given count is within the prediction interval
     *
     * @param float $actualCount
     * @return bool
     */
    public function isWithinInterval(float $actualCount): bool
    {
        return $actualCount >= $this->lower_bound && $actualCount <= $this->upper_bound;
    }

    /**
     * Format the target month in a human-readable format
     *
     * @return string
     */
    public function getTargetMonthAttribute(): string
    {
        return Carbon::parse($this->target_date)->format('F Y');
    }
}
