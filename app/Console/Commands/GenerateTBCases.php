<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Disease;
use App\Models\Patient;
use App\Models\TreatmentRecord;
use App\Models\Appointment;
use App\Models\AppointmentQueue;
use App\Models\AppointmentType;
use App\Models\User;
use App\Models\VitalSign;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class GenerateTBCases extends Command
{
    protected $signature = 'tb:generate-cases {count=30 : Number of cases to generate} {--months=12 : Number of months to distribute cases}';
    protected $description = 'Generate TB cases for testing';

    public function handle(): int
    {
        $count = $this->argument('count');
        $months = $this->option('months');
        $faker = Faker::create();

        $this->info("Generating $count TB cases distributed over $months months...");

        // Ensure TB disease exists
        $tb = Disease::firstOrCreate(
            ['name' => 'Tuberculosis'],
            [
                'code' => 'TB',
                'description' => 'A bacterial infection caused by Mycobacterium tuberculosis',
                'type' => 'Infectious',
                'risk_factors' => 'Close contact with infected individuals',
                'prevention' => 'BCG vaccination, early detection',
                'treatment' => 'Multi-drug therapy',
                'severity' => 'severe'
            ]
        );

        // Ensure TB appointment type exists
        $tbConsultation = AppointmentType::firstOrCreate(
            ['name' => 'TB Consultation'],
            [
                'description' => 'Consultation for tuberculosis',
                'duration_minutes' => 30
            ]
        );

        // Get doctors and BHWs
        $doctors = User::role('doctor')->get();
        if ($doctors->isEmpty()) {
            $this->error('No doctors found in database! Please create doctor users first.');
            return 1;
        }

        $bhws = User::role('bhw')->get();
        if ($bhws->isEmpty()) {
            $bhws = [$doctors->first()]; // Use doctor as fallback
        }

        // Start transaction
        DB::beginTransaction();

        try {
            $bar = $this->output->createProgressBar($count);
            $bar->start();

            // Generate cases with a basic distribution pattern
            $endDate = Carbon::now();
            $startDate = $endDate->copy()->subMonths($months);

            for ($i = 0; $i < $count; $i++) {
                // Generate a date between start and end with a slight bias toward recent months
                $bias = rand(0, 100);
                if ($bias > 70) {
                    // 30% of cases in most recent 2 months
                    $date = Carbon::now()->subDays(rand(1, 60));
                } else {
                    // 70% of cases distributed throughout the period
                    $date = Carbon::createFromTimestamp(
                        rand($startDate->timestamp, $endDate->timestamp)
                    );
                }

                // Create a patient
                $patient = Patient::create([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'sex' => $faker->randomElement(['0', '1']),
                    'birth_date' => $faker->dateTimeBetween('-80 years', '-5 years'),
                    'contact_number' => $faker->numerify('09#########'),
                    'is_4ps' => $faker->randomElement([0, 1]),
                    'is_NHTS' => $faker->randomElement([0, 1]),
                ]);

                // Create vital signs
                $vitalSign = VitalSign::create([
                    'temperature' => $faker->randomFloat(1, 36.5, 39.5),
                    'height' => $faker->randomFloat(2, 150, 200),
                    'weight' => $faker->randomFloat(1, 45, 85),
                    'systolic' => $faker->randomElement(['120', '130', '140']),
                    'diastolic' => $faker->randomElement(['80', '90', '95']),
                    'heart_rate' => $faker->numberBetween(65, 95),
                ]);

                // Create treatment record
                $treatmentRecord = TreatmentRecord::create([
                    'disease_id' => $tb->id,
                    'assessment' => 'Patient presents with TB symptoms',
                    'diagnosis' => 'Pulmonary tuberculosis',
                    'treatment' => 'HRZE regimen for 6 months',
                    'medication' => 'Fixed-dose combination tablets daily'
                ]);

                // Create appointment
                $appointment = Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctors->random()->id,
                    'bhw_id' => ($bhws instanceof \Illuminate\Database\Eloquent\Collection)
                        ? $bhws->random()->id
                        : $bhws[0]->id,
                    'appointment_type_id' => $tbConsultation->id,
                    'treatment_record_id' => $treatmentRecord->id,
                    'vital_signs_id' => $vitalSign->id,
                    'appointment_date' => $date,
                    'time_in' => $date->copy()->setTime(rand(8, 16), 0),
                    'time_out' => $date->copy()->setTime(rand(9, 17), 0),
                    'chief_complaint' => 'Persistent cough, fever',
                    'is_cancelled' => 0,
                ]);

                $dateKey = $date->format('Y-m-d');
                if (!isset($queueCounters[$dateKey])) {
                    $queueCounters[$dateKey] = 1;
                }

                // Create appointment queue
                AppointmentQueue::create([
                    'appointment_id' => $appointment->id,
                    'queue_number' => $queueCounters[$dateKey]++,
                    'queue_date' => $date,
                    'queue_status' => 'completed',
                    'queue_type' => 'regular',
                    'called_at' => Carbon::createFromTimestamp($appointment->time_in),
                    'completed_at' => Carbon::createFromTimestamp($appointment->time_out),
                ]);

                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);

            DB::commit();
            $this->info("Successfully generated $count TB cases!");

            // Prompt to run the ARIMA model update
            if ($this->confirm('Would you like to update the TB ARIMA model now?')) {
                $this->call('tb:test-forecast-update', [
                    '--sync' => true,
                    '--verbose' => true  // Using Laravel's built-in verbose option
                ]);
            }

            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error generating TB cases: " . $e->getMessage());
            return 1;
        }
    }
}
