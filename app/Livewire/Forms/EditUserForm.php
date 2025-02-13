<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EditUserForm extends Form
{
    public User $edit_user;

    #[Validate]
    public string $edit_first_name = '';

    #[Validate]
    public string $edit_middle_name = '';

    #[Validate]
    public string $edit_last_name = '';

    #[Validate]
    public string $edit_birth_date = '';

    #[Validate]
    public string $edit_sex = '';

    #[Validate]
    public string $edit_contact_no = '';

    #[Validate]
    public string $edit_email = '';

    #[Validate]
    public string $edit_username = '';

    #[Validate]
    public string $edit_password = '';

    #[Validate]
    public string $edit_confirm_password = '';

    #[Validate]
    public string $edit_house_number = '';

    #[Validate]
    public string $edit_barangay = '';

    #[Validate]
    public string $edit_street = '';

    #[Validate]
    public string $edit_city = '';

    #[Validate]
    public string $edit_province = '';

    #[Validate]
    public string $edit_region = '';

    #[Validate]
    public string $edit_country = 'Philippines';

    #[Validate]
    public string $edit_role = '';

    #[Validate]
    public string $edit_position = '';

    #[Validate]
    public string $edit_term_start = '';

    #[Validate]
    public string $edit_term_end = '';

    #[Validate]
    public string $edit_certification_no = '';

    #[Validate]
    public string $edit_bhw_barangay = '';

    #[Validate]
    public string $edit_license_number = '';

    #[Validate]
    public string $edit_specialization = '';

    #[Validate]
    public string $edit_profile_photo_path = '';

    protected function rules(): array
    {
        return [
            'edit_first_name' => [
                'required',
                'alpha',
                'max:255',
            ],
            'edit_middle_name' => [
                'alpha',
                'max:255',
            ],
            'edit_last_name' => [
                'required',
                'alpha',
                'max:255',
            ],
            'edit_birth_date' => [
                'required',
                'date',
                'before:today',
                Rule::date()->after(now()->subYears(120))
            ],
            'edit_sex' => [
                'required',
                Rule::in([0, 1])
            ],
            'edit_contact_no' => [
                'required',
                'regex:^(09|\+639)\d{9}$^',
                'max:13',
            ],
            'edit_email' => [
                'required',
                'email',
                'max:320',
                Rule::unique('users', 'email')->ignore($this->edit_user->id)
            ],
            'edit_username' => [
                'required',
                'alpha_num',
                'max:40',
                Rule::unique('users', 'username')->ignore($this->edit_user->id)
            ],
            'edit_password' => [
                'required',
                'min:8',
                'max:128',
            ],
            'edit_confirm_password' => [
                'required',
                'same:password',
            ],
            'edit_house_number' => [
                'required',
                'string',
                'max:255',
            ],
            'edit_barangay' => [
                'required',
                'string',
            ],
            'edit_street' => [
                'required',
                'string',
                'max:255',
            ],
            'edit_city' => [
                'required',
                'string',
                'max:255',
            ],
            'edit_province' => [
                'required',
                'alpha',
                'max:255',
            ],
            'edit_region' => [
                'required',
                'string',
                'max:255',
            ],
            'edit_country' => [
                'required',
                'alpha',
                'max:255',
            ],
            'edit_role' => [
                'required',
                Rule::in(['barangay-official', 'bhw', 'doctor'])
            ],
            'edit_position' => [
                'required_if:role,barangay-official',
                'string',
                'max:255',
            ],
            'edit_term_start' => [
                'required_if:role,barangay-official',
                'date',
                'before:today',
            ],
            'edit_term_end' => [
                'required_if:role,barangay-official',
                'date',
                'after:term_start',
            ],
            'edit_certification_no' => [
                'required_if:role,bhw',
                'digits:9',
                'max:20',
            ],
            'edit_bhw_barangay' => [
                'required_if:role,bhw',
                'string',
            ],
            'edit_license_number' => [
                'required_if:role,doctor',
                'digits:7',
            ],
            'edit_specialization' => [
                'required_if:role,doctor',
                'string',
                'max:255',
            ],
            'edit_profile_photo_path' => [
                'nullable',
                'string',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'edit_first_name' => [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain letters only',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_middle_name' => [
                'alpha' => 'The :attribute field must contain letters only.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_last_name' => [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain letters only.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_birth_date' => [
                'required' => 'The :attribute field is required.',
                'date' => 'The :attribute field must be a valid date.',
                'before' => 'The :attribute field must be a date before today.',
                'after' => 'The :attribute field must be a date after :date.'
            ],
            'edit_sex' => [
                'required' => 'The :attribute field is required.',
                'in' => 'The :attribute field must be selected from the given options.'
            ],
            'edit_contact_no' => [
                'required' => 'The :attribute field is required.',
                'regex' => 'The :attribute field must be a valid contact number.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_email' => [
                'required' => 'The :attribute field is required.',
                'email' => 'The :attribute field must be a valid email address.',
                'max' => 'The :attribute field must not be greater than :max characters.',
                'unique' => 'The :attribute field has already been taken.'
            ],
            'edit_username' => [
                'required' => 'The :attribute field is required.',
                'alpha_num' => 'The :attribute field must contain only letters and numbers.',
                'max' => 'The :attribute field must not be greater than :max characters.',
                'unique' => 'The :attribute field has already been taken.'
            ],
            'edit_password' => [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute field must be at least :min characters.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_confirm_password' => [
                'required' => 'The :attribute field is required.',
                'same' => 'The :attribute field must match the password field.'
            ],
            'edit_house_number' => [
                'required' => 'The :attribute field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_barangay' => [
                'required' => 'The :attribute field is required.',
            ],
            'edit_street' => [
                'required' => 'The :attribute field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_city' => [
                'required' => 'The contact number field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_province' => [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain only letters.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_region' => [
                'required' => 'The :attribute field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_country' => [
                'required' => 'The :attribute field is required.',
                'alpha' => 'The :attribute field must contain only letters.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_role' => [
                'required' => 'The :attribute field is required.',
                'in' => 'The :attribute field must be selected from the given options.'
            ],
            'edit_position' => [
                'required_if' => 'The :attribute field is required.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_term_start' => [
                'required_if' => 'The :attribute field is required.',
                'date' => 'The :attribute field must be a valid date.',
                'before' => 'The :attribute field must be a date before today.'
            ],
            'edit_term_end' => [
                'required_if' => 'The :attribute field is required.',
                'date' => 'The :attribute field must be a valid date.',
                'after' => 'The :attribute field must be a date after the term start.'
            ],
            'edit_certification_no' => [
                'required_if' => 'The :attribute field is required.',
                'digits' => 'The :attribute field must contain only digits.',
                'max' => 'The :attribute field must not be greater than :max characters.'
            ],
            'edit_bhw_barangay' => [
                'required_if' => 'The barangay field is required.',
                'alpha_num' => 'The barangay field must contain only letters and numbers.'
            ],
            'edit_license_number' => [
                'required_if' => 'The license number field is required.',
                'digits' => 'The license number field must contain only digits.',
            ],
            'edit_specialization' => [
                'required_if' => 'The specialization field is required.',
                'alpha' => 'The specialization field must contain only letters.',
                'max' => 'The specialization field must not be greater than :max characters.',
                'exists' => 'The specialization field must be selected from the given options.'
            ],
        ];
    }
}
