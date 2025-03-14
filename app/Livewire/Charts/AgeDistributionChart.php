<?php

namespace App\Livewire\Charts;

use App\Models\Patient;
use Carbon\Carbon;
use Livewire\Component;

class AgeDistributionChart extends Component
{
    public $chartData;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $ageGroups = [
            '0-5' => 0,
            '6-17' => 0,
            '18-30' => 0,
            '31-45' => 0,
            '46-60' => 0,
            '61+' => 0
        ];

        $patients = Patient::select('birth_date')->get();

        foreach ($patients as $patient) {
            $age = Carbon::parse($patient->birth_date)->age;

            if ($age <= 5) $ageGroups['0-5']++;
            elseif ($age <= 17) $ageGroups['6-17']++;
            elseif ($age <= 30) $ageGroups['18-30']++;
            elseif ($age <= 45) $ageGroups['31-45']++;
            elseif ($age <= 60) $ageGroups['46-60']++;
            else $ageGroups['61+']++;
        }

        $this->chartData = [
            'labels' => array_keys($ageGroups),
            'datasets' => [
                [
                    'label' => 'Number of Patients',
                    'data' => array_values($ageGroups),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.charts.age-distribution-chart');
    }
}
