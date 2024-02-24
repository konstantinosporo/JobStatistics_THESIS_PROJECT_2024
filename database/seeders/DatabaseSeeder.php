<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Call other seeders to seed the database
        $this->call([
            JobCategoriesTableSeeder::class,
            JobsTableSeeder::class,
            JobDescriptionSeeder::class,

            // Add other seeders here as needed
        ]);
    }
}
