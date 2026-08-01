<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@sekolah.sch.id',
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
