<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    #[Validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'sex' => 'required|in:0,1',
        'contact_no' => ['required', 'string', 'regex:/^\+63\d{10}$/'],
        'email' => 'required|email|unique:users,email',
        'username' => 'required|string|max:20|unique:users,username',
        'password' => 'required|string|min:8',
        'profile_photo_path' => 'nullable|string',
    ], message: [
        'first_name.required' => "The first name field is required.",
        'last_name.required' => "The last name field is required.",
        'birth_date.required' => "The birth date field is required.",
        'birth_date.date' => "The birth date must be a valid date.",
        'sex.required' => "The sex field is required.",
        'sex.in' => "The selected sex is invalid.",
        'contact_no.required' => "The contact number field is required.",
        'contact_no.regex' => "The contact number format must be +63XXXXXXXXXX.",
        'email.required' => "The email field is required.",
        'email.email' => "The email must be a valid email address.",
        'email.unique' => "The email has already been taken.",
        'username.required' => "The username field is required.",
        'username.max' => "The username must not exceed 20 characters.",
        'username.unique' => "The username has already been taken.",
        'password.required' => "The password field is required.",
        'password.min' => "The password must be at least 8 characters.",
    ], attribute: [
        'first_name' => 'First Name',
        'middle_name' => 'Middle Name',
        'last_name' => 'Last Name',
        'birth_date' => 'Birth Date',
        'sex' => 'Sex',
        'contact_no' => 'Contact Number',
        'email' => 'Email Address',
        'username' => 'Username',
        'password' => 'Password',
        'profile_photo_path' => 'Profile Photo',
    ])]
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $birth_date = '';
    public string $sex = '';
    public string $contact_no = '';
    public string $email = '';
    public string $username = '';
    public string $password = '';
    public string $profile_photo_path = '';
}
