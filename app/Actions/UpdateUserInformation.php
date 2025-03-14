<?php

namespace App\Actions;

use App\Models\Specialization;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;

class UpdateUserInformation
{
    public function update(User $user, array $input): User
    {
        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        }
        else
        {
            // Basic Information
            $user->forceFill([
               'first_name' => $input['first_name'],
                'middle_name' => $input['middle_name'],
                'last_name' => $input['last_name'],
                'birth_date' => $input['birth_date'],
                'sex' => $input['sex'],
                'contact_no' => $input['contact_no'],
                'email' => $input['email'],
                'username' => $input['username'],
            ])->save();
        }

        // Password handling
        if ($input['password'] != null) {
            $user->forceFill([
                'password' => Hash::make($input['password']),
            ])->save();
        }

        // Address
        $user->address->forceFill([
            'house_number' => $input['house_number'],
            'street' => $input['street'],
            'barangay' => $input['barangay'],
            'city' => $input['city'],
            'province' => $input['province'],
            'region' => $input['region'],
            'country' => $input['country'],
        ])->save();

        // Updating existing role-based information
        if ($user->getRoleNames()[0] === $input['role']) {
            switch ($user->getRoleNames()[0]) {
                case 'barangay-official':
                    if (! $user->barangayOfficial) {
                        $user->barangayOfficial()->create([
                            'position' => $input['position'],
                            'term_start' => $input['term_start'],
                            'term_end' => $input['term_end']
                        ]);
                    }
                    else
                    {
                        $user->barangayOfficial->forceFill([
                            'position' => $input['position'],
                            'term_start' => $input['term_start'],
                            'term_end' => $input['term_end']
                        ])->save();
                    }

                    break;
                case 'bhw':
                    if (! $user->bhw) {
                        $user->bhw()->create([
                            'certification_no' => $input['certification_no'],
                            'assigned_barangay' => $input['assigned_barangay']
                        ]);
                    }
                    else
                    {
                        $user->bhw->forceFill([
                            'certification_no' => $input['certification_no'],
                            'assigned_barangay' => $input['assigned_barangay']
                        ])->save();
                    }
                    break;
                case 'doctor':
                    if (! $user->doctor && ! $user->doctor->specializations) {
                        $user->doctor()->create([
                            'license_number' => $input['license_number'],
                        ]);

                        $user->doctor->specializations()->attach($input['specialization']);
                    }
                    else
                    {
                        $user->doctor->update([
                            'license_number' => $input['license_number'],
                        ]);

                        $user->doctor->specializations()->sync($input['specialization']);
                    }
                    break;
            }
        }

        // Updates to new role
        if ($user->getRoleNames()[0] != $input['role'])
        {
            if ($user->barangayOfficial())
            {
                $user->barangayOfficial()->delete();
            }
            else if ($user->bhw())
            {
                $user->bhw()->delete();
            }
            else
            {
                $user->doctor->specializations->first()->delete();
                $user->doctor()->delete();
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
                        'barangay' => $input['assigned_barangay']
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
        }

        $user->syncRoles([$input['role']]);

        return $user;
    }

    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'birth_date' => $input['birth_date'],
            'sex' => $input['sex'],
            'contact_no' => $input['contact_no'],
            'email' => $input['email'],
            'username' => $input['username'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
