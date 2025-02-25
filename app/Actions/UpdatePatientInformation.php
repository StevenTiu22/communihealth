<?php

namespace App\Actions;

use App\Models\Address;
use App\Models\Patient;

class UpdatePatientInformation
{
    public function update(Patient $patient, array $input): Patient
    {
        $patient->forceFill([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'gender' => $input['gender'],
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
            $father = $patient->parents->where('relationship', 'father');

            $father->forceFill([
                'first_name' => $input['father_first_name'],
                'middle_name' => $input['father_middle_name'],
                'last_name' => $input['father_last_name'],
                'philhealth_no' => $input['father_philhealth'],
            ])->save();

            if (! ParentInfo::where('id', $father->id)) {
                throw new \Exception('Failed to update father information.');
            }
        }

        if ($input['mother_first_name'] &&
            $input['mother_last_name']) {
            $mother = $patient->parents->where('relationship', 'mother');

            $mother->forceFill([
                'first_name' => $input['mother_first_name'],
                'middle_name' => $input['mother_middle_name'],
                'last_name' => $input['mother_last_name'],
                'philhealth_no' => $input['mother_philhealth'],
            ])->save();

            if (! ParentInfo::where('id', $mother->id)) {
                throw new \Exception('Failed to update mother information.');
            }
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
