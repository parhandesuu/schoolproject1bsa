<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
            SampleDataSeeder::class,
            ServiceSeeder::class,
            SurveyResponseSeeder::class,
        ]);
    }
}
