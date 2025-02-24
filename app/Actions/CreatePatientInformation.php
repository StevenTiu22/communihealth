<?php

namespace App\Actions;

use App\Models\ParentInfo;
use App\Models\Patient;

class CreatePatientInformation
{
    public function create(array $input): \Exception|Patient
    {
        $patient = Patient::create([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'gender' => $input['gender'],
            'birth_date' => $input['birth_date'],
            'contact_number' => $input['contact_number'],
            'is_4ps' => $input['is_4ps'],
            'is_NHTS' => $input['is_NHTS'],
        ]);

        if (! Patient::where('id', $patient->id)) {
            throw new \Exception('Failed to create patient information.');
        }

        if ($input['father_first_name'] &&
            $input['father_last_name']) {
            $father = ParentInfo::create([
                'first_name' => $input['father_first_name'],
                'middle_name' => $input['father_middle_name'],
                'last_name' => $input['father_last_name'],
                'philhealth_no' => $input['father_philhealth'],
            ]);

            if (! ParentInfo::where('id', $father->id)) {
                throw new \Exception('Failed to create father information.');
            }

            $patient->parents()->attach($father->id);

            if (! $patient->parents()->where('id', $father->id)) {
                throw new \Exception('Failed to attach father information.');
            }
        }

        if ($input['mother_first_name'] &&
            $input['mother_last_name']) {
            $mother = ParentInfo::create([
                'first_name' => $input['mother_first_name'],
                'middle_name' => $input['mother_middle_name'],
                'last_name' => $input['mother_last_name'],
                'philhealth_no' => $input['mother_philhealth'],
            ]);

            if (! ParentInfo::where('id', $mother->id)) {
                throw new \Exception('Failed to create mother information.');
            }

            $patient->parents()->attach($mother->id);

            if (! $patient->parents()->where('id', $mother->id)) {
                throw new \Exception('Failed to attach mother information.');
            }
        }

        $patient->address()->create([
            'house_number' => $input['house_number'],
            'street' => $input['street'],
            'barangay' => $input['barangay'],
            'city' => $input['city'],
            'province' => $input['province'],
            'region' => $input['region'],
            'country' => $input['country'],
        ]);

        if (! $patient->address()) {
            throw new \Exception('Failed to insert address information.');
        }

        return $patient;
    }
}
