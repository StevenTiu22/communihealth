<?php

namespace App\Actions\Fortify;

<<<<<<< HEAD
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
=======
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
<<<<<<< HEAD
    public function create(array $input): DB
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'alpha', 'max:255'],
            'middle_name' => ['nullable', 'string', 'alpha', 'max:255'],
            'last_name' => ['required', 'string', 'alpha', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:0,1'],
            'contact_number' => ['required', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
            'role' => ['required', 'in:0,1,2'],
            'housing_number' => ['required', 'string'],
            'street' => ['required', 'string', 'alpha'],
            'city' => ['required', 'string', 'alpha'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'first_name' => $input['first_name'],
                'middle_name' => $input['middle_name'],
                'last_name' => $input['first_name'],
                'birth_date' => $input['birth_date'],
                'gender' => $input['gender'],
                'contact_number' => $input['contact_number'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'role' => $input['role']
            ]);
    
            $address = Address::create([
                'housing_number' => $input['housing_number'],
                'street' => $input['street'],
                'city' => $input['city']
            ]);
    
            $user->addresses->attach($address->id);

            return $user;
        });
=======
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
    }
}
