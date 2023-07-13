<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DateTime;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'company_name' => 'Company',
            'street_address' => 'Tokyo',
            'representive_name' => 'A',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
