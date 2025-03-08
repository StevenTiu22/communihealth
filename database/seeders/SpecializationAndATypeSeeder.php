<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationAndATypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $general_doctor = Specialization::create([
            'name' => 'General Doctor',
            'description' => 'Provides broad primary care, diagnosing and treating common illnesses and managing overall health.'
        ]);

        $dentist = Specialization::create([
            'name' => 'Dentist',
            'description' => 'Focuses on oral health, treating dental issues like cavities and gum disease while promoting preventive care.'
        ]);

        $midwife = Specialization::create([
            'name' => 'Midwife',
            'description' => 'Supports pregnancy and childbirth, offering prenatal care, delivery assistance, and postnatal support.'
        ]);

        AppointmentType::create([
            'name' => 'General Checkup',
            'specialization_id' => $general_doctor->id,
            'description' => 'A comprehensive check-up for general health concerns, illness management, and preventive care.',
            'duration_minutes' => 30
        ]);


    }
}
