<?php

namespace App\Livewire\Charts;

use App\Models\TreatmentRecord;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DiseaseTypeChart extends Component
{
    public $chartData;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $diseaseTypes = TreatmentRecord::join('diseases', 'treatment_records.disease_id', '=', 'diseases.id')
            ->select('diseases.type', DB::raw('count(*) as count'))
            ->groupBy('diseases.type')
            ->pluck('count', 'diseases.type')
            ->toArray();

        $this->chartData = [
            'labels' => array_keys($diseaseTypes),
            'datasets' => [
                [
                    'data' => array_values($diseaseTypes),
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#C9CBCF', '#7BC8A4'
                    ],
                    'hoverOffset' => 4
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.charts.disease-type-chart');
    }
}
