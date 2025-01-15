<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mother_id' => 'nullable|exists:parent_infos,id',
            'father_id' => 'nullable|exists:parent_infos,id',
            'first_name' => 'required|string|alpha|max:255',
            'middle_name' => 'nullable|string|alpha|max:255',
            'last_name' => 'required|string|alpha|max:255',
            'gender' => 'required|in:0,1',
            'birth_date' => 'required|date',
            'is_4ps' => 'required|boolean',
            'is_NHTS' => 'required|boolean',
            'deleted_by' => 'nullable|exists:users,id'

            // Address rules
        ];
    }
}
