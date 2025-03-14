<?php

namespace App\Livewire\Charts;

use App\Models\Disease;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DiseaseSeverityChart extends Component
{
    public $chartData;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $severities = Disease::select('severity', DB::raw('count(*) as count'))
            ->groupBy('severity')
            ->get()
            ->pluck('count', 'severity')
            ->toArray();

        $this->chartData = [
            'labels' => array_keys($severities),
            'datasets' => [
                [
                    'label' => 'Number of Cases',
                    'data' => array_values($severities),
                    'backgroundColor' => [
                        'rgba(75, 192, 192, 0.6)', // mild
                        'rgba(255, 206, 86, 0.6)', // moderate
                        'rgba(255, 99, 132, 0.6)', // severe
                        'rgba(153, 102, 255, 0.6)' // critical
                    ],
                    'borderColor' => [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.charts.disease-severity-chart');
    }
}
