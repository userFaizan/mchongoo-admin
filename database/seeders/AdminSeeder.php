<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin',
            'phone_no' => '1234567890',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123'), // Replace 'password' with the desired admin password
            'terms_and_condition' => true,
            'otp' => null,
            'remember_token' => null,
        ]);
    }
}
