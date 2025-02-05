<?php /** @noinspection PhpNamedArgumentsWithChangedOrderInspection */

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('regex:/^[A-Za-z\s.]+$/', message: 'The :attribute field must contain only letters, spaces, and dots.')]
    #[Validate('max:255', message: 'The :attribute field must not be greater than :max characters.')]
    public string $first_name = '';

    #[Validate('regex:/^[A-Za-z\s.]+$/', message: 'The middle name field must contain only letters and dots.')]
    #[Validate('max:255', message: 'The middle name field must not be greater than :max characters.')]
    public string $middle_name = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('alpha', message: 'The :attribute field must contain only letters.')]
    #[Validate('max:255', message: 'The :attribute field must not be greater than :max characters.')]
    public string $last_name = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('date', message: 'The :attribute field must be a valid date.')]
    #[Validate('before:today', message: 'The :attribute field must be a date before today.')]
    public string $birth_date = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('in:0,1', message: 'The :attribute field must be selected from the given options.')]
    public string $sex = '';

    #[Validate([
        'contact_no' => ['required', 'regex:/^\+63[0-9]{10}$/', 'max:13'],
    ], message: [
        'required' => 'The contact number field is required.',
        'regex' => 'The contact number field must be a valid Philippine mobile number.',
        'max' => 'The contact number field must not be greater than :max characters.',
    ])]
    public string $contact_no = '';

    #[Validate([
        'email' => ['required', 'email', 'unique:users,email'],
    ], message: [
        'required' => 'The email field is required.',
        'email' => 'The email field must be a valid email address.',
        'unique' => 'This email is already in use.',
    ])]
    public string $email = '';

    #[Validate([
        'username' => ['required', 'alpha_num', 'max:20', 'unique:users,username'],
    ], message: [
        'required' => 'The username field is required.',
        'alpha_num' => 'The username field must contain only letters and numbers.',
        'max' => 'The username field must not be greater than :max characters.',
        'unique' => 'This username is already in use.',
    ])]
    public string $username = '';

    #[Validate([
        'password' => ['required', 'min:8', 'max:128'],
    ], message: [
        'required' => 'The password field is required.',
        'min' => 'The password field must be at least :min characters.',
        'max' => 'The password field must not be greater than :max characters.',
    ])]
    public string $password = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('same:password', message: 'The :attribute field must match the password field.')]
    public string $confirm_password = '';

    #[Validate([
        'house_number' => ['required', 'regex:/^[A-Za-z0-9\-]+$/', 'max:255'],
    ], message: [
        'required' => 'The house number field is required.',
        'regex' => 'The house number field must contain only letters, numbers, and hyphens.',
        'max' => 'The house number field must not be greater than :max characters.',
    ])]
    public string $house_number = '';

    #[Validate([
        'barangay' => ['required', 'alpha', 'max:255'],
    ], message: [
        'required' => 'The barangay field is required.',
        'alpha' => 'The barangay field must contain only letters.',
        'max' => 'The barangay field must not be greater than :max characters.',
    ])]
    public string $barangay = '';

    #[Validate([
        'street' => ['required', 'regex:/^[A-Za-z\. ]+$/', 'max:255'],
    ], message: [
        'required' => 'The street field is required.',
        'alpha' => 'The street field must contain only letters, dot, and spaces.',
        'max' => 'The street field must not be greater than :max characters.',
    ])]
    public string $street = '';

    #[Validate([
        'city' => ['required', 'alpha', 'max:255'],
    ], message: [
        'required' => 'The city field is required.',
        'alpha' => 'The city field must contain only letters.',
        'max' => 'The city field must not be greater than :max characters.',
    ])]
    public string $city = '';

    #[Validate([
        'province' => ['required', 'alpha', 'max:255'],
    ], message: [
        'required' => 'The province field is required.',
        'alpha' => 'The province field must contain only letters.',
        'max' => 'The province field must not be greater than :max characters.',
    ])]
    public string $province = '';

    #[Validate([
        'region' => ['required', 'alpha', 'max:255'],
    ], message: [
        'required' => 'The region field is required.',
        'alpha' => 'The region field must contain only letters.',
        'max' => 'The region field must not be greater than :max characters.',
    ])]
    public string $region = '';

    #[Validate([
        'country' => ['required', 'alpha', 'max:255'],
    ], message: [
        'required' => 'The country field is required.',
        'alpha' => 'The country field must contain only letters.',
        'max' => 'The country field must not be greater than :max characters.',
    ])]
    public string $country = 'Philippines';

    #[Validate([
        'role' => ['required', 'in:barangay-official,bhw,doctor'],
    ], message: [
        'required' => 'The role field is required.',
        'in' => 'The role field must be selected from the given options.',
    ])]
    public string $role = '';

    #[Validate([
        'position' => ['required_if:role,barangay-official', 'alpha', 'max:255'],
    ], message: [
        'required_if' => 'The position field is required.',
        'alpha' => 'The position field must contain only letters.',
        'max' => 'The position field must not be greater than :max characters.',
    ])]
    public string $position = '';

    #[Validate([
        'term_start' => ['required_if:role,barangay-official', 'date', 'before:term_end'],
    ], message: [
        'required_if' => 'The term start field is required.',
        'date' => 'The term start field must be a valid date.',
        'before' => 'The term start field must be a date before the term end field.',
    ])]
    public string $term_start = '';

    #[Validate([
        'term_end' => ['required_if:role,barangay-official', 'date', 'after:term_start'],
    ], message: [
        'required_if' => 'The term end field is required.',
        'date' => 'The term end field must be a valid date.',
        'after' => 'The term end field must be a date after the term start field.',
    ])]
    public string $term_end = '';

    #[Validate([
        'certification_no' => ['required_if:role,bhw', 'alpha_num', 'max:20'],
    ], message: [
        'required_if' => 'The certification number field is required.',
        'alpha_num' => 'The certification number field must contain only letters and numbers.',
        'max' => 'The certification number field must not be greater than :max characters.',
    ])]
    public string $certification_no = '';

    #[Validate([
        'bhw_barangay' => ['required_if:role,bhw', 'alpha', 'max:255'],
    ], message: [
        'required_if' => 'The BHW barangay field is required.',
        'alpha' => 'The BHW barangay field must contain only letters.',
        'max' => 'The BHW barangay field must not be greater than :max characters.',
    ])]
    public string $bhw_barangay = '';

    #[Validate([
        'license_number' => ['required_if:role,doctor', 'digits', 'max:20'],
    ], message: [
        'required_if' => 'The license number field is required.',
        'digits' => 'The license number field must contain only digits.',
        'max' => 'The license number field must not be greater than :max characters.',
    ])]
    public string $license_number = '';

    #[Validate([
        'specialization' => ['required_if:role,doctor', 'alpha', 'max:255'],
    ], message: [
        'required_if' => 'The specialization field is required.',
        'alpha' => 'The specialization field must contain only letters.',
        'max' => 'The specialization field must not be greater than :max characters.',
    ])]
    public string $specialization = '';
}
