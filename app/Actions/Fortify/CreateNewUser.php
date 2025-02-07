<?php

namespace App\Actions\Fortify;

use App\Models\Address;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     * @throws Exception
     */
    public function create(array $input): void
    {
        // User creation
        $user = User::create([
           'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'birth_date' => $input['birth_date'],
            'sex' => $input['sex'],
            'contact_no' => $input['contact_no'],
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
            'profile_photo_path' => $input['profile_photo_path']
        ]);

        if (! User::where('id', $user->id)->exists()) {
            throw new Exception('Failed to create user.');
        }

        // Address creation
        $user->address()->create([
            'house_number' => $input['house_number'],
            'street' => $input['street'],
            'barangay' => $input['barangay'],
            'city' => $input['city'],
            'province' => $input['province'],
            'region' => $input['region'],
            'country' => $input['country'],
        ]);

        if (! Address::where('id', $user->address()->id)->exists()) {
            throw new Exception('Failed to insert address information.');
        }

        // Role assignment and related information creation
        $user->assignRole($input['role']);

        if (! $user->hasRole($input['role'])) {
            throw new Exception('Failed to assign role.');
        }

        switch($input['role'])
        {
            case 'barangay_official':
                $user->barangayOfficial()->create([
                    'position' => $input['position'],
                    'term_start' => $input['term_start'],
                    'term_end' => $input['term_end']
                ]);

                if (! $user->barangayOfficial()->exists()) {
                    throw new Exception('Failed to insert barangay official information.');
                }

                break;
            case 'bhw':
                $user->bhw()->create([
                    'certificate_no' => $input['certificate_no'],
                    'barangay' => $input['bhw_barangay']
                ]);

                if (! $user->bhw()->exists()) {
                    throw new Exception('Failed to insert BHW information.');
                }

                break;
            case 'doctor':
                $user->doctor()->create([
                    'license_number' => $input['license_number'],
                    'specialization' => $input['specialization']
                ]);

                if (! $user->doctor()->exists()) {
                    throw new Exception('Failed to insert doctor information.');
                }

                break;
        }
    }
}
