<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class JobsTableSeeder extends Seeder
{
    public function run()
    {
        // If you're using league/csv package
        $csv = Reader::createFromPath(storage_path('jobs.csv'), 'r');
        $csv->setHeaderOffset(0); // Set if the CSV has a header row

        foreach ($csv as $record) {
            DB::table('jobs')->insert([
                'job_category_id' => $record['job_category_id'],
                'year' => $record['year'],
                'total' => $record['total'], // Make sure this is a string in your migrations if it contains commas
                'employees' => $record['employees'], // Same note as above
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
