<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'John Doe',
            'username' => 'admin',
            'user_level'=>1,
            'password' => Hash::make('pass'),
        ]);

        // Add more users as needed
        User::create([
            'name' => 'user',
            'username' => 'test',
            'user_level'=>3,
            'password' => Hash::make('pass'),
        ]);
    }
}