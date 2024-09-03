<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CivilitySeeder::class,
            UserPermissionsSeeder::class,
            UserSeeder::class,
            FormulaSeeder::class,
            FormulaDescriptionsSeeder::class,
            FormulaCustomOptionSeeder::class,
            FormulaDefaultElementSeeder::class,
            FormulaDefaultSeeder::class,            
            FormulaOptionsSeeder::class,
            TestimonialSeeder::class,
            CompanySeeder::class,
            StatusSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
