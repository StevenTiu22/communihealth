<?php

namespace App\Livewire\Charts;

use App\Models\Patient;
use Livewire\Component;

class SexDistributionChart extends Component
{
    public $chartData;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $maleCount = Patient::where('sex', 0)->count();
        $femaleCount = Patient::where('sex', 1)->count();

        $this->chartData = [
            'labels' => ['Male', 'Female'],
            'datasets' => [
                [
                    'data' => [$maleCount, $femaleCount],
                    'backgroundColor' => ['#36a2eb', '#ff6384'],
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.charts.sex-distribution-chart');
    }
}
