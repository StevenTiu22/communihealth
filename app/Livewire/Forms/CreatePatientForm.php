<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreatePatientForm extends Form
{
    #[Validate]
    public string $first_name = '';

    #[Validate]
    public string $middle_name = '';

    #[Validate]
    public string $last_name = '';

    #[Validate]
    public string $sex = '';

    #[Validate]
    public string $birth_date = '';

    #[Validate]
    public string $contact_number = '';

    #[Validate]
    public bool $is_4ps = false;

    #[Validate]
    public bool $is_NHTS = false;

    #[Validate]
    public string $mother_first_name = '';

    #[Validate]
    public string $mother_middle_name = '';

    #[Validate]
    public string $mother_last_name = '';

    #[Validate]
    public string $mother_philhealth = '';

    #[Validate]
    public string $father_first_name = '';

    #[Validate]
    public string $father_middle_name = '';

    #[Validate]
    public string $father_last_name = '';

    #[Validate]
    public string $father_philhealth = '';

    #[Validate]
    public string $house_number = '';

    #[Validate]
    public string $street = '';

    #[Validate]
    public string $barangay = '';

    #[Validate]
    public string $city = '';

    #[Validate]
    public string $province = '';

    #[Validate]
    public string $region = '';

    #[Validate]
    public string $country = '';

    public string $profile_photo_path = '';

    protected function rules(): array
    {
        return [
            'first_name' => 'required|string|regex:/^[a-zA-Z\s.-]*$/',
            'middle_name' => 'nullable|string|regex:/^[a-zA-Z\s.-]*$/',
            'last_name' => 'required|string|regex:/^[a-zA-Z\s.-]*$/',
            'sex' => 'required|numeric|in:0,1',
            'birth_date' => 'required|date|before:today',
            'contact_number' => 'required|numeric|digits:11',
            'is_4ps' => 'boolean',
            'is_NHTS' => 'boolean',
            'mother_first_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'mother_middle_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'mother_last_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'mother_philhealth' => 'nullable|regex:/^[0-9]{2}-[0-9]{9}-[0-9]$/',
            'father_first_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'father_middle_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'father_last_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'father_philhealth' => 'regex:/^[0-9]{2}-[0-9]{9}-[0-9]$/',
            'house_number' => 'required|string|max:50',
            'street' => 'required|string|max:100',
            'barangay' => 'required|string|max:100',
            'city' => 'required|string|max:100',
        ];
    }

    protected function messages(): array
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'first_name.regex' => 'The first name may only contain letters, spaces, dots and dashes.',
            'middle_name.regex' => 'The middle name may only contain letters, spaces, dots and dashes.',
            'last_name.required' => 'The last name field is required.',
            'last_name.regex' => 'The last name may only contain letters, spaces, dots and dashes.',
            'sex.required' => 'Please select a sex.',
            'sex.in' => 'Please select a valid sex.',
            'birth_date.required' => 'The birth date field is required.',
            'birth_date.before' => 'The birth date must be before today.',
            'birth_date.date' => 'Please enter a valid date.',
            'contact_number.required' => 'The contact number field is required.',
            'contact_number.digits' => 'The contact number must be exactly 11 digits.',
            'contact_number.numeric' => 'The contact number must contain only numbers.',
            'mother_first_name.regex' => 'The mother\'s first name may only contain letters, spaces, dots and dashes.',
            'mother_middle_name.regex' => 'The mother\'s middle name may only contain letters, spaces, dots and dashes.',
            'mother_last_name.regex' => 'The mother\'s last name may only contain letters, spaces, dots and dashes.',
            'mother_philhealth.regex' => 'The mother\'s PhilHealth number must be in XX-XXXXXXXXX-X format.',
            'father_first_name.regex' => 'The father\'s first name may only contain letters, spaces, dots and dashes.',
            'father_middle_name.regex' => 'The father\'s middle name may only contain letters, spaces, dots and dashes.',
            'father_last_name.regex' => 'The father\'s last name may only contain letters, spaces, dots and dashes.',
            'father_philhealth.regex' => 'The father\'s PhilHealth number must be in XX-XXXXXXXXX-X format.',
            'house_number.required' => 'The house number field is required.',
            'house_number.max' => 'The house number must not exceed 50 characters.',
            'street.required' => 'The street field is required.',
            'street.max' => 'The street must not exceed 100 characters.',
            'barangay.required' => 'The barangay field is required.',
            'barangay.max' => 'The barangay must not exceed 100 characters.',
            'city.required' => 'The city field is required.',
            'city.max' => 'The city must not exceed 100 characters.',
        ];
    }
}
