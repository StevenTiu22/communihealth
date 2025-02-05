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

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('regex:/^\+63[0-9]{10}$/', message: 'The :attribute field must be a valid Philippine mobile number.')]
    #[Validate('max:13', message: 'The :attribute field must not be greater than :max characters.')]
    public string $contact_no = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('email', message: 'The :attribute field must be a valid email address.')]
    #[Validate('max:320', message: 'The :attribute field must not be greater than :max characters.')]
    #[Validate('unique:users,email', message: 'This email is already taken.')]
    public string $email = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('min:8', message: 'The :attribute field must be at least :min characters.')]
    #[Validate('max:40', message: 'The :attribute field must not be greater than :max characters.')]
    public string $username = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('min:8', message: 'The :attribute field must be at least :min characters.')]
    #[Validate('max:128', message: 'The :attribute field must not be greater than :max characters.')]
    public string $password = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('same:password', message: 'The :attribute field must match the password field.')]
    public string $confirm_password = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('regex:^[A-Za-z0-9\s-]+$', message: 'The :attribute field must contain only letters, numbers, spaces, and dashes.')]
    #[Validate('max:255', message: 'The :attribute field must not be greater than :max characters.')]
    public string $house_number = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('regex:^[A-Za-z0-9\s\.]+$', message: 'The :attribute field must contain only letters, numbers, spaces, and dots.')]
    public string $barangay = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('regex:^[A-Za-z0-9\s\.]+$', message: 'The :attribute field must contain only letters, numbers, spaces, and dots.')]
    #[Validate('max:255', message: 'The :attribute field must not be greater than :max characters.')]
    public string $street = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('alpha', message: 'The :attribute field must contain only letters.')]
    #[Validate('max:255', message: 'The :attribute field must not be greater than :max characters.')]
    public string $city = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('alpha', message: 'The :attribute field must contain only letters.')]
    #[Validate('max:255', message: 'The :attribute field must not be greater than :max characters.')]
    public string $province = '';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('alpha', message: 'The :attribute field must contain only letters.')]
    #[Validate('max:255', message: 'The :attribute field must not be greater than :max characters.')]
    public string $region = '';


    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('alpha', message: 'The :attribute field must contain only letters.')]
    #[Validate('max:255', message: 'The :attribute field must not be greater than :max characters.')]
    public string $country = 'Philippines';

    #[Validate('required', message: 'The :attribute field is required.')]
    #[Validate('in:barangay-official,bhw,doctor', message: 'The :attribute field must be selected from the given options.')]
    public string $role = '';

    #[Validate('required_if:role,barangay-official', message: 'The :attribute field is required.')]
    #[Validate('alpha', message: 'The :attribute field must contain only letters.')]
    #[Validate('max:255', message: 'The :attribute field must not be greater than :max characters.')]
    public string $position = '';

    #[Validate('required_if:role,barangay-official', message: 'The :attribute field is required.')]
    #[Validate('date', message: 'The :attribute field must be a valid date.')]
    #[Validate('before:today', message: 'The :attribute field must be a date before today.')]
    public string $term_start = '';

    #[Validate('required_if:role,barangay-official', message: 'The :attribute field is required.')]
    #[Validate('date', message: 'The :attribute field must be a valid date.')]
    #[Validate('after:term_start', message: 'The :attribute field must be a date after the term start.')]
    public string $term_end = '';

    #[Validate('required_if:role,bhw', message: 'The :attribute field is required.')]
    #[Validate('digits', message: 'The :attribute field must contain only digits.')]
    #[Validate('max:20', message: 'The :attribute field must not be greater than :max characters.')]
    public string $certification_no = '';

    #[Validate('required_if:role,bhw', message: 'The :attribute field is required.')]
    #[Validate('alpha_num', message: 'The :attribute field must contain only letters and numbers.')]
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
