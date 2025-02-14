<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks untuk menghindari error saat insert
        Schema::disableForeignKeyConstraints();
        DB::table('contracts')->truncate(); // Hapus semua data lama
        Schema::enableForeignKeyConstraints();

        DB::table('contracts')->insert([
            [
                'vendor_id' => 1,
                'status_contract' => 'Active',
                'contract_type' => 'Annual Maintenance',
                'contract_number' => 'CT-2024001',
                'invoice' => 'INV-1001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vendor_id' => 2,
                'status_contract' => 'Expired',
                'contract_type' => 'Project-Based',
                'contract_number' => 'CT-2024002',
                'invoice' => 'INV-1002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vendor_id' => 3,
                'status_contract' => 'Pending',
                'contract_type' => 'Service Agreement',
                'contract_number' => 'CT-2024003',
                'invoice' => 'INV-1003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vendor_id' => 4,
                'status_contract' => 'Active',
                'contract_type' => 'Procurement',
                'contract_number' => 'CT-2024004',
                'invoice' => 'INV-1004',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vendor_id' => 5,
                'status_contract' => 'Terminated',
                'contract_type' => 'Leasing',
                'contract_number' => 'CT-2024005',
                'invoice' => 'INV-1005',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
