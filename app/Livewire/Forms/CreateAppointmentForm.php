<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateAppointmentForm extends Form
{
    #[Validate]
    public int $patient_id;

    #[Validate]
    public int $doctor_id;

    #[Validate]
    public int $bhw_id;

    #[Validate]
    public int $appointment_type_id;

    #[Validate]
    public string $appointment_date;

    #[Validate]
    public string $time_in;

    #[Validate]
    public string $time_out;

    #[Validate]
    public string $chief_complaint;

    #[Validate]
    public string $remarks;

    #[Validate]
    public int $is_cancelled = 0;

    #[Validate]
    public string $cancellation_reason = '';

    protected function rules(): array
    {
        return [
            'patient_id' => [
                'required',
                'exists:patients,id'
            ],
            'doctor_id' => [
                'exists:doctors,id'
            ],
            'bhw_id' => [
                'required',
                'exists:bhws,id'
            ],
            'appointment_type_id' => [
                'required',
                'exists:appointment_types,id'
            ],
            'appointment_date' => [
                'required',
                'date',
                'date_format:Y-m-d'
            ],
            'time_in' => [
                'required',
                'date_format:H:i:s'
            ],
            'time_out' => [
                'required',
                'date_format:H:i:s'
            ],
            'chief_complaint' => [
                'required',
                'string',
                'max:255'
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:255'
            ],
            'is_cancelled' => [
                'in:0,1'
            ],
            'cancellation_reason' => [
                'string',
                'max:255'
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'patient_id' => [
                'required' => 'The patient field is required.',
                'exists' => 'The selected patient is invalid.'
            ],
            'doctor_id' => [
                'exists' => 'The selected doctor is invalid.'
            ],
            'bhw_id' => [
                'required' => 'The BHW field is required.',
                'exists' => 'The selected BHW is invalid.'
            ],
            'appointment_type_id' => [
                'required' => 'The appointment type field is required.',
                'exists' => 'The selected appointment type is invalid.'
            ],
            'appointment_date' => [
                'required' => 'The appointment date field is required.',
                'date' => 'The appointment date must be a valid date.',
                'date_format' => 'The appointment date is in invalid format.'
            ],
            'time_in' => [
                'required' => 'The time in field is required.',
                'date_format' => 'The time in is in invalid format.'
            ],
            'time_out' => [
                'required' => 'The time out field is required.',
                'date_format' => 'The time out is in invalid format.'
            ],
            'chief_complaint' => [
                'required' => 'The chief complaint field is required.',
                'string' => 'The chief complaint must be a string.',
                'max' => 'The chief complaint may not be greater than :max characters.'
            ],
            'remarks' => [
                'string' => 'The remarks must be a string.',
                'max' => 'The remarks may not be greater than :max characters.'
            ],
            'is_cancelled' => [
                'in:0,1' => 'The selected cancellation status is invalid.'
            ],
            'cancellation_reason' => [
                'string' => 'The cancellation reason must be a string.',
                'max' => 'The cancellation reason may not be greater than :max characters.'
            ]
        ];
    }
}
