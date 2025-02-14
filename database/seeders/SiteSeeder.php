<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks untuk menghindari error saat insert
        Schema::disableForeignKeyConstraints();
        DB::table('sites')->truncate(); // Hapus semua data lama
        Schema::enableForeignKeyConstraints();

        DB::table('sites')->insert([
            [
                'site_name' => 'Head Office',
                'address' => 'Jl. Sudirman No. 1',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_name' => 'Warehouse West',
                'address' => 'Jl. Raya Bogor No. 23',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_name' => 'Branch Surabaya',
                'address' => 'Jl. Diponegoro No. 12',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_name' => 'Factory Cikarang',
                'address' => 'Kawasan Industri MM2100',
                'city' => 'Bekasi',
                'province' => 'Jawa Barat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_name' => 'Sales Office Medan',
                'address' => 'Jl. Gatot Subroto No. 45',
                'city' => 'Medan',
                'province' => 'Sumatera Utara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
