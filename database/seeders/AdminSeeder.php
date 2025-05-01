<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@sajilocargo.com'], // prevent duplication
            [
                'name' => 'Super Admin',
                'email' => 'admin@sajilocargo.com',
                'password' => Hash::make('Admin@123'), // set your own strong password
                'role' => 'admin', // make sure your User model and DB has this field
            ]
        );
    }
}
