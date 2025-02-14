<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks untuk menghindari error saat insert
        Schema::disableForeignKeyConstraints();
        DB::table('vendors')->truncate(); // Hapus semua data lama
        Schema::enableForeignKeyConstraints();

        DB::table('vendors')->insert([
            [
                'vendors_code' => 'VND001',
                'vendor_name' => 'PT. Teknologi Nusantara',
                'phone_number' => '081234567890',
                'address' => 'Jl. Sudirman No. 10, Jakarta',
                'email' => 'contact@teknologi.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vendors_code' => 'VND002',
                'vendor_name' => 'CV. Solusi Mandiri',
                'phone_number' => '081298765432',
                'address' => 'Jl. Ahmad Yani No. 5, Bandung',
                'email' => 'info@solusimandiri.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vendors_code' => 'VND003',
                'vendor_name' => 'PT. Global Elektronik',
                'phone_number' => '081377788899',
                'address' => 'Jl. Gajah Mada No. 12, Surabaya',
                'email' => 'support@globalelektronik.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vendors_code' => 'VND004',
                'vendor_name' => 'UD. Sumber Berkah',
                'phone_number' => '082112233445',
                'address' => 'Jl. Diponegoro No. 8, Semarang',
                'email' => 'sales@sumberberkah.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vendors_code' => 'VND005',
                'vendor_name' => 'PT. Mitra Sejahtera',
                'phone_number' => '081355667788',
                'address' => 'Jl. Merdeka No. 20, Medan',
                'email' => 'admin@mitrasejahtera.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
