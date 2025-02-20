<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EditUserForm extends Form
{
    public ?int $user_id;

    #[Validate]
    public string $first_name = '';

    #[Validate]
    public string $middle_name = '';

    #[Validate]
    public string $last_name = '';

    #[Validate]
    public string $birth_date = '';

    #[Validate]
    public string $sex = '';

    #[Validate]
    public string $contact_no = '';

    #[Validate]
    public string $email = '';

    #[Validate]
    public string $username = '';

    #[Validate]
    public string $password = '';

    #[Validate]
    public string $confirm_password = '';

    #[Validate]
    public string $house_number = '';

    #[Validate]
    public string $barangay = '';

    #[Validate]
    public string $street = '';

    #[Validate]
    public string $city = '';

    #[Validate]
    public string $province = '';

    #[Validate]
    public string $region = '';

    #[Validate]
    public string $country = 'Philippines';

    #[Validate]
    public string $role = '';

    #[Validate]
    public string $position = '';

    #[Validate]
    public string $term_start = '';

    #[Validate]
    public string $term_end = '';

    #[Validate]
    public string $certification_no = '';

    #[Validate]
    public string $assigned_barangay = '';

    #[Validate]
    public string $license_number = '';

    #[Validate]
    public string $specialization = '';

    #[Validate]
    public string $profile_photo_path = '';

    protected function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'alpha',
                'max:255',
            ],
            'middle_name' => [
                'alpha',
                'max:255',
            ],
            'last_name' => [
                'required',
                'alpha',
                'max:255',
            ],
            'birth_date' => [
                'required',
                'date',
                'before:today',
                Rule::date()->after(now()->subYears(120))
            ],
            'sex' => [
                'required',
                Rule::in([0, 1])
            ],
            'contact_no' => [
                'required',
                'regex:^(09|\+639)\d{9}$^',
                'max:13',
            ],
            'email' => [
                'required',
                'email',
                'max:320',
                Rule::unique('users', 'email')->ignore($this->user_id)
            ],
            'username' => [
                'required',
                'alpha_num',
                'max:40',
                Rule::unique('users', 'username')->ignore($this->user_id)
            ],
            'password' => [
                'required',
                'min:8',
                'max:128',
            ],
            'confirm_password' => [
                'required',
                'same:password',
            ],
            'house_number' => [
                'required',
                'string',
                'max:255',
            ],
            'barangay' => [
                'required',
                'string',
            ],
            'street' => [
                'required',
                'string',
                'max:255',
            ],
            'city' => [
                'required',
                'string',
                'max:255',
            ],
            'province' => [
                'required',
                'string',
                'max:255',
            ],
            'region' => [
                'required',
                'string',
                'max:255',
            ],
            'country' => [
                'required',
                'string',
                'max:255',
            ],
            'role' => [
                'required',
                Rule::in(['barangay-official', 'bhw', 'doctor'])
            ],
            'position' => [
                'required_if:role,barangay-official',
                'string',
                'max:255',
            ],
            'term_start' => [
                'required_if:role,barangay-official',
                'date',
                'before:today',
            ],
            'term_end' => [
                'required_if:role,barangay-official',
                'date',
                'after:term_start',
            ],
            'certification_no' => [
                'required_if:role,bhw',
                'digits:9',
                'max:20',
            ],
            'assigned_barangay' => [
                'required_if:role,bhw',
                'string',
            ],
            'license_number' => [
                'required_if:role,doctor',
                'digits:7',
            ],
            'specialization' => [
                'required_if:role,doctor',
                'exists:specializations,name',
            ],
            'profile_photo_path' => [
                'nullable',
                'string',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'first_name' => [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain letters only',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'middle_name' => [
                'alpha' => 'The :attribute field must contain letters only.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'last_name' => [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain letters only.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'birth_date' => [
                'required' => 'The :attribute field is required.',
                'date' => 'The :attribute field must be a valid date.',
                'before' => 'The :attribute field must be a date before today.',
                'after' => 'The :attribute field must be a date after :date.'
            ],
            'sex' => [
                'required' => 'The :attribute field is required.',
                'in' => 'The :attribute field must be selected from the given options.'
            ],
            'contact_no' => [
                'required' => 'The :attribute field is required.',
                'regex' => 'The :attribute field must be a valid contact number.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'email' => [
                'required' => 'The :attribute field is required.',
                'email' => 'The :attribute field must be a valid email address.',
                'max' => 'The :attribute field must not be greater than :max characters.',
                'unique' => 'The :attribute field has already been taken.'
            ],
            'username' => [
                'required' => 'The :attribute field is required.',
                'alpha_num' => 'The :attribute field must contain only letters and numbers.',
                'max' => 'The :attribute field must not be greater than :max characters.',
                'unique' => 'The :attribute field has already been taken.'
            ],
            'password' => [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute field must be at least :min characters.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'confirm_password' => [
                'required' => 'The :attribute field is required.',
                'same' => 'The :attribute field must match the password field.'
            ],
            'house_number' => [
                'required' => 'The :attribute field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'barangay' => [
                'required' => 'The :attribute field is required.',
            ],
            'street' => [
                'required' => 'The :attribute field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'city' => [
                'required' => 'The contact number field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'province' => [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain only letters.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'region' => [
                'required' => 'The :attribute field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'country' => [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain only letters.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'role' => [
                'required' => 'The :attribute field is required.',
                'in' => 'The :attribute field must be selected from the given options.'
            ],
            'position' => [
                'required_if' => 'The :attribute field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'term_start' => [
                'required_if' => 'The :attribute field is required.',
                'date' => 'The :attribute field must be a valid date.',
                'before' => 'The :attribute field must be a date before today.'
            ],
            'term_end' => [
                'required_if' => 'The :attribute field is required.',
                'date' => 'The :attribute field must be a valid date.',
                'after' => 'The :attribute field must be a date after the term start.'
            ],
            'certification_no' => [
                'required_if' => 'The :attribute field is required.',
                'digits' => 'The :attribute field must contain only digits.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'assigned_barangay' => [
                'required_if' => 'The barangay field is required.',
                'alpha_num' => 'The barangay field must contain only letters and numbers.'
            ],
            'license_number' => [
                'required_if' => 'The license number field is required.',
                'digits' => 'The license number field must contain only digits.',
            ],
            'specialization' => [
                'required_if' => 'The specialization field is required.',
                'max' => 'The specialization field must not be greater than :max characters.',
                'exists' => 'The specialization field must be selected from the given options.'
            ],
        ];
    }
}
