<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TestUsersSeeder::class,
            AcademicDomainSeeder::class,
            TrayectoriaSeeder::class,
            DeclaracionesJuradasSeeder::class,
            TestUserSeeder::class,
        ]);
    }
}
