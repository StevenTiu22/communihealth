<?php

namespace App\Livewire\Charts;

use App\Models\Patient;
use Livewire\Component;

class SocioEconomicStatusChart extends Component
{
    public $chartData;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $is4ps = Patient::where('is_4ps', 1)->count();
        $isNHTS = Patient::where('is_NHTS', 1)->count();
        $neither = Patient::where('is_4ps', 0)->where('is_NHTS', 0)->count();

        $this->chartData = [
            'labels' => ['4Ps Beneficiary', 'NHTS Beneficiary', 'Neither'],
            'datasets' => [
                [
                    'label' => 'Number of Patients',
                    'data' => [$is4ps, $isNHTS, $neither],
                    'backgroundColor' => [
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(54, 162, 235, 0.6)'
                    ],
                    'borderColor' => [
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.charts.socio-economic-status-chart');
    }
}
