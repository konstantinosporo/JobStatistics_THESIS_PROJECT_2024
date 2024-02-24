<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class JobDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // If you're using league/csv package
        $csv = Reader::createFromPath(storage_path('job_descriptions.csv'), 'r');
        $csv->setHeaderOffset(0); // Set if the CSV has a header row

        foreach ($csv as $record) {
            DB::table('job_descriptions')->insert([
                'job_id' => $record['id'], // Assuming the column name is 'job_id'
                'jobdescriptionenglish' => $record['jobdescriptionenglish'],
                'jobdescriptiongreek' => $record['jobdescriptiongreek'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
