<?php

namespace App\Livewire;

use App\Models\ARIMAModelVersion;
use Livewire\Component;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TBForecastTable extends Component
{
    public $forecastMonths = 12;
    public $forecastData = null;
    public $isLoading = false;
    public $error = null;
    public $lastUpdated;
    public $currentModel = null;

    public function mount()
    {
        $this->currentModel = ARIMAModelVersion::latest()->first();
        $this->lastUpdated = now()->format('Y-m-d H:i:s');
        $this->generateForecast();
    }

    public function generateForecast()
    {
        $this->isLoading = true;
        $this->error = null;

        try {
            // Call Python script
            $process = Process::timeout(60)->run('python ' . '../python_scripts/forecast.py' . ' ' . json_encode($this->forecastMonths) . ' ' . $this->currentModel->file_path);

            if ($process->failed()) {
                throw new \Exception("Python process failed: " . $process->errorOutput());
            }

            $output = $process->output();
            $data = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON response from Python script");
            }

            if ($data['status'] !== 'success') {
                throw new \Exception($data['error'] ?? 'Unknown error in forecast generation');
            }

            // Process forecast data for display
            $this->forecastData = $this->processForecasts($data);
            $this->lastUpdated = now()->format('Y-m-d H:i:s');

        } catch (\Exception $e) {
            Log::error('TB Forecast Error: ' . $e->getMessage());
            $this->error = $e->getMessage();
        }

        $this->isLoading = false;
    }

    private function processForecasts($data)
    {
        $result = [];
        $forecast_dates = $data['forecast_dates'];

        for ($i = 0; $i < count($data['forecast']); $i++) {
            $date = Carbon::parse($forecast_dates[$i]);

            $result[] = [
                'month' => $date->format('M Y'),
                'date' => $date->format('Y-m-d'),
                'forecast' => round($data['forecast'][$i]),
                'lower_bound' => round($data['lower_bound'][$i]),
                'upper_bound' => round($data['upper_bound'][$i])
            ];
        }

        return $result;
    }

    public function render()
    {
        return view('livewire.tb-forecast-table');
    }
}
