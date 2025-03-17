<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateTBArimaModel;
use Illuminate\Support\Facades\Log;

class TestTBForecastUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tb:test-forecast-update
                            {--sync : Run job synchronously instead of queuing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the TB forecast model update job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting TB forecast model update test...');

        if ($this->option('verbose')) {
            Log::info('Verbose mode enabled for TB forecast test');
            Log::getLogger()->pushHandler(new \Monolog\Handler\StreamHandler(STDERR, \Monolog\Level::Debug));
        }

        $startTime = microtime(true);

        try {
            if ($this->option('sync')) {
                $this->info('Running job synchronously...');
                $job = new UpdateTBArimaModel();
                $job->handle();
            } else {
                $this->info('Dispatching job to queue...');
                UpdateTBArimaModel::dispatch();
            }

            $elapsedTime = number_format(microtime(true) - $startTime, 2);

            if ($this->option('sync')) {
                $this->info("Job completed in {$elapsedTime} seconds");

                // Display latest forecasts
                $this->displayLatestForecasts();
            } else {
                $this->info("Job dispatched in {$elapsedTime} seconds");
                $this->info("Check logs or queue worker output for results");
            }
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Display the latest forecasts.
     */
    private function displayLatestForecasts()
    {
        $this->info("Latest TB Forecasts:");

        $forecasts = \App\Models\TBForecast::orderBy('forecast_date', 'desc')
            ->orderBy('target_date')
            ->limit(10)
            ->get();

        if ($forecasts->isEmpty()) {
            $this->warn("No forecasts found in database");
            return;
        }

        $this->table(
            ['Target Date', 'Predicted Count', 'Lower Bound', 'Upper Bound'],
            $forecasts->map(function ($forecast) {
                return [
                    $forecast->target_date->format('Y-m-d'),
                    $forecast->predicted_count,
                    $forecast->lower_bound,
                    $forecast->upper_bound
                ];
            })
        );
    }
}
