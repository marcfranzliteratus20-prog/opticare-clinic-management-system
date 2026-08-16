<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gumawa o mag-update ng Admin Account
        User::updateOrCreate(
            ['email' => 'admin@opticare.com'], // Hanapin kung may ganitong email
            [
                'name'     => 'OptiCare Admin',
                'email'    => 'admin@opticare.com',
                'password' => Hash::make('admin123'), // Bagong password mo
                'role'     => 'Admin',
            ]
        );
    }
}