<?php

namespace App\Actions;

use App\Models\Address;
use App\Models\BarangayOfficial;
use App\Models\BHW;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     * @throws Exception
     */
    public function create(array $input): User
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

        if (! User::where('id', $user->id)) {
            throw new Exception('Failed to create user.');
        }

        // Role assignment and related information creation
        $user->assignRole($input['role']);

        if (! $user->hasRole($input['role'])) {
            throw new Exception('Failed to assign role.');
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

        if (! $user->address()) {
            throw new Exception('Failed to insert address information.');
        }

        switch($input['role'])
        {
            case 'barangay-official':
                $user->barangayOfficial()->create([
                    'position' => $input['position'],
                    'term_start' => $input['term_start'],
                    'term_end' => $input['term_end']
                ]);

                if (! $user->barangayOfficial()) {
                    throw new Exception('Failed to insert barangay official information.');
                }

                break;

            case 'bhw':
                $user->bhw()->create([
                    'certification_no' => $input['certification_no'],
                    'assigned_barangay' => $input['assigned_barangay']
                ]);

                if (! $user->bhw()) {
                    throw new Exception('Failed to insert BHW information.');
                }

                break;

            case 'doctor':
                $user->doctor()->create([
                    'license_number' => $input['license_number'],
                ]);

                if (! $user->doctor()) {
                    throw new Exception('Failed to insert doctor information.');
                }

                $specialization = Specialization::firstOrCreate(['name' => $input['specialization']]);

                $user->doctor->specializations()->attach($specialization->id);

                if (! $user->doctor->specializations()) {
                    throw new Exception('Failed to insert doctor specialization information.');
                }

                break;
        }

        return $user;
    }
}
