<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Barangay',
            'middle_name' => '',
            'last_name' => 'Admin',
            'sex' => '0',
            'email' => 'barangay.admin@gmail.com',
            'username' => 'admin',
            'password' => 'admin123',
            'user_type' => '1',
        ]);
    }
}
