<?php

namespace App\Actions;

use App\Models\Address;
use App\Models\ParentInfo;
use App\Models\Patient;

class UpdatePatientInformation
{
    public function update(Patient $patient, array $input): Patient
    {
        $patient->forceFill([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'sex' => $input['sex'],
            'birth_date' => $input['birth_date'],
            'contact_number' => $input['contact_number'],
            'is_4ps' => $input['is_4ps'],
            'is_NHTS' => $input['is_NHTS'],
        ])->save();

        if (! Patient::where('id', $patient->id)) {
            throw new \Exception('Failed to update patient information.');
        }

        if ($input['father_first_name'] &&
            $input['father_last_name']) {
            $father = $patient->parents->where('pivot.relationship', 'father')->first();

            $father->forceFill([
                'first_name' => $input['father_first_name'],
                'middle_name' => $input['father_middle_name'],
                'last_name' => $input['father_last_name'],
                'philhealth_no' => $input['father_philhealth'],
            ])->save();
        }

        if ($input['mother_first_name'] &&
            $input['mother_last_name']) {
            $mother = $patient->parents->where('pivot.relationship', 'mother')->first();

            $mother->forceFill([
                'first_name' => $input['mother_first_name'],
                'middle_name' => $input['mother_middle_name'],
                'last_name' => $input['mother_last_name'],
                'philhealth_no' => $input['mother_philhealth'],
            ])->save();
        }

        $patient->address->forceFill([
            'house_number' => $input['house_number'],
            'street' => $input['street'],
            'barangay' => $input['barangay'],
            'city' => $input['city'],
            'province' => $input['province'],
            'region' => $input['region'],
            'country' => $input['country'],
        ])->save();

        if (! Address::where('id', $patient->address->id)) {
            throw new \Exception('Failed to update address information.');
        }

        return $patient;
    }
}
