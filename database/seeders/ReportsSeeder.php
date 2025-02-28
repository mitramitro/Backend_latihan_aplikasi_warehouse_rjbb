<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reports')->insert([
            [
                'report_date' => now(),
                'site' => 'Jakarta',
                'manager_name' => 'John Doe',
                'ict_name' => 'Jane Smith',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'report_date' => now()->subDays(1),
                'site' => 'Surabaya',
                'manager_name' => 'Michael Johnson',
                'ict_name' => 'Emily Davis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
