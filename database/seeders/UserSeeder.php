<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'admin',
            'email'             => 'admin@gmail.com',
            'phone_number'      => '085222000000',
            'username'          => 'admin',
            'password'          => Hash::make('Admin@123'), // Hash password
            'role'              => 'admin',
            'site_id'           => 1,
        ]);

        User::create([
            'name'              => 'user',
            'email'             => 'user@gmail.com',
            'phone_number'      => '085222111111',
            'username'          => 'user',
            'password'          => Hash::make('User@123'), // Hash password
            'role'              => 'user',
            'site_id'           => 2,
        ]);
    }
}
