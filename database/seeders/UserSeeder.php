<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@sekolah.sch.id',
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);

        $editor = User::updateOrCreate(
            ['email' => 'editor@sekolah.sch.id'],
            [
                'name' => 'Content Editor',
                'email' => 'editor@sekolah.sch.id',
                'password' => Hash::make('Editor@12345'),
                'role' => 'editor',
                'email_verified_at' => now(),
            ]
        );
        $editor->syncRoles(['editor']);

        $staff = User::updateOrCreate(
            ['email' => 'staff@sekolah.sch.id'],
            [
                'name' => 'Staff Operasional',
                'email' => 'staff@sekolah.sch.id',
                'password' => Hash::make('Staff@12345'),
                'role' => 'staff',
                'email_verified_at' => now(),
            ]
        );
        $staff->syncRoles(['staff']);
    }
}
