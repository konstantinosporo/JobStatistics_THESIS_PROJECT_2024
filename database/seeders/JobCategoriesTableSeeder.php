<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader; // Make sure you have installed league/csv package via Composer

class JobCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        // If you're using league/csv package
        $csv = Reader::createFromPath(storage_path('job_categories_both.csv'), 'r');
        $csv->setHeaderOffset(0); // Set if the CSV has a header row

        foreach ($csv as $record) {
            DB::table('job_categories')->insert([
                'english_name' => $record['english_name'],
                'greek_name' => $record['greek_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
