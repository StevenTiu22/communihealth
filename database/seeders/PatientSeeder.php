<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Address;
use App\Models\ParentInfo;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        // Create 50 patients with addresses and parents
        Patient::factory()
            ->count(50)
            ->create()
            ->each(function ($patient) {
                // Create and attach 1 address
                $address = Address::factory()->create();
                $patient->addresses()->attach($address->id);

                // Create and attach 1-2 parents
                $numberOfParents = rand(1, 2);
                $parents = ParentInfo::factory()
                    ->count($numberOfParents)
                    ->create()
                    ->each(function ($parent) use ($patient) {
                        $patient->parents()->attach($parent->id);
                    });
            });
    }
} 