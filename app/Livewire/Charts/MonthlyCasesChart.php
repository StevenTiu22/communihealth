<?php

namespace App\Livewire\Charts;

use App\Models\Disease;
use App\Models\TreatmentRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MonthlyCasesChart extends Component
{
    public $chartData;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $startDate = Carbon::now()->subYear();
        $endDate = Carbon::now();
        $months = [];

// Create array of month labels for the chart
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
        }
        $months = array_reverse($months);

// Query treatment records with disease names (not types)
        $records = TreatmentRecord::join('diseases', 'treatment_records.disease_id', '=', 'diseases.id')
            ->whereBetween('treatment_records.created_at', [$startDate, $endDate])
            ->select(
                'diseases.name', // Changed from type to name
                DB::raw('MONTH(treatment_records.created_at) as month'),
                DB::raw('YEAR(treatment_records.created_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('diseases.name', 'month', 'year')
            ->get();

// Get unique disease names
        $diseaseNames = $records->pluck('name')->unique()->values()->toArray();

// Initialize datasets array
        $datasets = [];

// Create a dataset for each disease
        foreach ($diseaseNames as $index => $diseaseName) {
            // Generate a color for this disease
            $color = $this->getChartColor($index);

            // Initialize counts array with zeros
            $counts = array_fill(0, 12, 0);

            // Fill in actual counts where available
            foreach ($records->where('name', $diseaseName) as $record) {
                $monthYear = Carbon::createFromDate($record->year, $record->month, 1)->format('M Y');
                $monthIndex = array_search($monthYear, $months);
                if ($monthIndex !== false) {
                    $counts[$monthIndex] = $record->count;
                }
            }

            // Add to datasets array
            $datasets[] = [
                'label' => $diseaseName,
                'data' => $counts,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'borderWidth' => 1,
            ];
        }

        $this->chartData = [
            'labels' => $months,
            'datasets' => $datasets
        ];
    }

    // Helper function to generate chart colors
    private function getChartColor($index)
    {
        $colors = [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(255, 99, 255, 0.8)',
            'rgba(54, 162, 64, 0.8)',
        ];

        return $colors[$index % count($colors)];
    }

    public function render()
    {
        return view('livewire.charts.monthly-cases-chart');
    }
}
