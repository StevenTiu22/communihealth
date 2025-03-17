<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\ARIMAModelVersion;

class UpdateTBArimaModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Log::info('Starting TB ARIMA model update job');

        try {
            // 1. Get TB case data from joined tables
            $TBCaseData = $this->getTBCaseData();

            if (empty($TBCaseData)) {
                Log::warning('No TB case data found. Skipping model update.');
                return;
            }

            Log::info('Retrieved ' . count($TBCaseData) . ' TB case records');

            // 2. Save data to JSON for Python script
            $inputPath = $this->saveDataToJson($TBCaseData);
            $outputPath = storage_path('app/tb_arima_output.json');

            // 3. Execute Python script to update the model
            $result = $this->executeModelUpdate($inputPath, $outputPath);

            // 4. Process results
            if ($result['success']) {
                Log::info('TB ARIMA model updated successfully');

                // Record model version in database
                $modelVersion =$this->recordModelVersion($result['model_info']);

                // Save forecasts to TBForecast model
                $this->saveForecasts($result['forecast'], $modelVersion);
            } else {
                Log::error('TB ARIMA model update failed: ' . $result['message']);
            }

            Log::info('TB ARIMA model update job completed');

        } catch (\Exception $e) {
            Log::error('Error in TB ARIMA model update job: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get TB case data by joining Appointment, TreatmentRecord, and Disease tables.
     *
     * @return array
     */
    private function getTBCaseData(): array
    {
        // Get all TB cases grouped by month
        $cases = DB::table('appointments')
            ->join('treatment_records', 'appointments.treatment_record_id', '=', 'treatment_records.id')
            ->join('diseases', 'treatment_records.disease_id', '=', 'diseases.id')
            ->where('diseases.name', 'like', '%tuberculosis%')
            ->select(
                DB::raw('DATE_FORMAT(appointments.appointment_date, "%Y-%m-01") as date'),
                DB::raw('COUNT(*) as cases')
            )
            ->groupBy(DB::raw('DATE_FORMAT(appointments.appointment_date, "%Y-%m-01")'))
            ->orderBy('date')
            ->get()
            ->toArray();

        // Convert to array of objects with date and count properties
        return array_map(function ($item) {
            return [
                'date' => $item->date,
                'cases' => (int) $item->cases
            ];
        }, $cases);
    }

    /**
     * Save TB case data to a temporary JSON file.
     *
     * @param array $data
     * @return string Path to the temporary JSON file
     */
    private function saveDataToJson(array $data): string
    {
        $path = storage_path('app/tb_arima_input.json');
        file_put_contents($path, json_encode($data));
        return $path;
    }

    /**
     * Execute the Python script to update the ARIMA model.
     *
     * @param string $inputPath Path to the input JSON file
     * @param string $outputPath Path to the output JSON file
     * @return array Result of the model update
     */
    private function executeModelUpdate(string $inputPath, string $outputPath): array
    {
        $pythonPath = config('app.python_path', 'python');
        $scriptPath = base_path('python_scripts/update_arima_model.py');

        $process = new Process([
            $pythonPath,
            $scriptPath,
            $inputPath,
            $outputPath
        ]);

        $process->setTimeout(300); // 5 minute timeout

        try {
            $process->run();

            // Check if process was successful
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // Parse output file
            if (file_exists($outputPath)) {
                $jsonOutput = json_decode(file_get_contents($outputPath), true);
                return $jsonOutput ?? [
                    'success' => false,
                    'message' => 'Failed to parse output JSON'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Output file not created'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Python script execution failed: ' . $e->getMessage());
            Log::error('Script output: ' . $process->getOutput());
            Log::error('Script errors: ' . $process->getErrorOutput());

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'output' => $process->getOutput(),
                'error_output' => $process->getErrorOutput()
            ];
        }
    }

    /**
     * Record the ARIMA model version in the database.
     *
     * @param array $modelInfo
     * @return ARIMAModelVersion
     */
    private function recordModelVersion(array $modelInfo): ARIMAModelVersion
    {
        return ArimaModelVersion::create([
            'version_date' => $modelInfo['version_date'] ?? date('Y-m-d'),
            'training_date' => now()->format('Y-m-d'),
            'file_path' => $modelInfo['version_path'],
            'order_p' => $modelInfo['order'][0] ?? 1,
            'order_d' => $modelInfo['order'][1] ?? 1,
            'order_q' => $modelInfo['order'][2] ?? 1,
            'aic' => $modelInfo['aic'] ?? null,
            'bic' => $modelInfo['bic'] ?? null,
            'last_data_date' => $modelInfo['last_updated_date'] ?? null,
            'notes' => 'Auto-updated on the 1st of the month'
        ]);
    }

    /**
     * Save forecasts to TBForecast model
     *
     * @param array $forecasts Forecasted values from the ARIMA model
     * @param ArimaModelVersion $modelVersion The model version record
     * @return void
     */
    private function saveForecasts(array $forecasts, $modelVersion): void
    {
        // Current timestamp for the forecast_date field
        $forecastDate = now();

        // Get model version identifier
        $versionIdentifier = $modelVersion->version_date ?? $modelVersion;

        // Process each forecast entry
        foreach ($forecasts as $forecast) {
            // Calculate standard error if available, otherwise null
            $standardError = isset($forecast['upper_bound']) && isset($forecast['lower_bound'])
                ? ($forecast['upper_bound'] - $forecast['lower_bound']) / 3.92 // 95% CI is approximately 1.96*SE on each side
                : null;

            // Create new forecast in database
            \App\Models\TBForecast::create([
                'forecast_date' => $forecastDate,  // When this forecast batch was generated
                'target_date' => $forecast['date'],  // The future date being forecasted
                'predicted_count' => $forecast['forecast'],
                'lower_bound' => $forecast['lower_bound'] ?? null,
                'upper_bound' => $forecast['upper_bound'] ?? null,
                'standard_error' => $standardError,
                'model_version' => $versionIdentifier,
            ]);
        }
    }
}
