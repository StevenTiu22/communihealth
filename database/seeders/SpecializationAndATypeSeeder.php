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

        $general_doctor->appointmentTypes()->createMany([
            [
                'name' => 'General Consultation',
                'description' => 'A comprehensive check-up for general health concerns, illness management, and preventive care.',
                'duration_minutes' => 30
            ],
            [
                'name' => 'Follow-Up Consultation',
                'description' => 'A follow-up visit to review treatment progress or manage ongoing conditions.',
                'duration_minutes' => 20
            ],
            [
                'name' => 'Preventive Health Screening',
                'description' => 'A screening appointment focused on early detection of health issues and assessment of risk factors.',
                'duration_minutes' => 40
            ],
            [
                'name' => 'Chronic Disease Management',
                'description' => 'A consultation to manage symptoms and adjust treatment plans for chronic conditions.',
                'duration_minutes' => 45
            ],
            [
                'name' => 'Immunization Appointment',
                'description' => 'An appointment for administering vaccines and providing immunization advice.',
                'duration_minutes' => 15
            ],
            // TB-specific appointment types
            [
                'name' => 'TB Initial Screening',
                'description' => 'Initial assessment for tuberculosis symptoms, risk factors, and diagnostic testing.',
                'duration_minutes' => 45
            ],
            [
                'name' => 'TB Diagnosis Consultation',
                'description' => 'Consultation to discuss tuberculosis test results and diagnosis.',
                'duration_minutes' => 30
            ],
            [
                'name' => 'TB Treatment Initiation',
                'description' => 'First appointment to start tuberculosis treatment and review the treatment plan.',
                'duration_minutes' => 60
            ],
            [
                'name' => 'TB Treatment Follow-up',
                'description' => 'Regular follow-up to monitor treatment progress, manage side effects, and ensure adherence.',
                'duration_minutes' => 20
            ],
            [
                'name' => 'TB Contact Tracing',
                'description' => 'Appointment for screening and assessment of close contacts of TB patients.',
                'duration_minutes' => 30
            ],
            [
                'name' => 'TB Treatment Completion Review',
                'description' => 'Final consultation to confirm TB treatment completion and provide follow-up instructions.',
                'duration_minutes' => 45
            ],
        ]);

        // Dentist appointment types
        $dentist->appointmentTypes()->createMany([
            [
                'name' => 'Dental Check-Up',
                'description' => 'A routine oral examination to assess dental health and provide preventive care.',
                'duration_minutes' => 45
            ],
            [
                'name' => 'Teeth Cleaning',
                'description' => 'A professional cleaning session to remove plaque and tartar and improve oral hygiene.',
                'duration_minutes' => 60
            ],
            [
                'name' => 'Cavity Treatment Consultation',
                'description' => 'A consultation for diagnosing dental decay and planning appropriate treatment.',
                'duration_minutes' => 30
            ],
            [
                'name' => 'Oral Surgery Consultation',
                'description' => 'An evaluation for surgical dental procedures, including wisdom tooth extraction or other interventions.',
                'duration_minutes' => 60
            ],
            [
                'name' => 'Cosmetic Dentistry Consultation',
                'description' => 'A session to discuss cosmetic procedures such as teeth whitening, veneers, or orthodontics.',
                'duration_minutes' => 45
            ],
        ]);

        // Midwife appointment types
        $midwife->appointmentTypes()->createMany([
            [
                'name' => 'Midwife Consultation',
                'description' => 'A consultation covering prenatal care, labor support, and postnatal guidance.',
                'duration_minutes' => 60
            ],
            [
                'name' => 'Prenatal Appointment',
                'description' => 'An appointment focusing on the health and progress of the pregnancy with routine checks.',
                'duration_minutes' => 45
            ],
            [
                'name' => 'Postnatal Appointment',
                'description' => 'A follow-up session after childbirth to support recovery and provide newborn care advice.',
                'duration_minutes' => 45
            ],
            [
                'name' => 'Birth Plan Consultation',
                'description' => 'A session to discuss birth preferences and prepare for various delivery options.',
                'duration_minutes' => 30
            ],
            [
                'name' => 'Lactation Support Session',
                'description' => 'An appointment to provide guidance and support for breastfeeding and lactation challenges.',
                'duration_minutes' => 30
            ],
        ]);
    }
}
