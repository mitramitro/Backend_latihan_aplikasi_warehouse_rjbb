<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks untuk menghindari error saat insert
        Schema::disableForeignKeyConstraints();
        DB::table('employees')->truncate(); // Hapus semua data lama
        Schema::enableForeignKeyConstraints();

        DB::table('employees')->insert([
            [
                'site_id' => 1,
                'name' => 'John Doe',
                'employee_number' => 'EMP001',
                'position' => 'Manager',
                'fungsi' => 'Operations',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 2,
                'name' => 'Jane Smith',
                'employee_number' => 'EMP002',
                'position' => 'Supervisor',
                'fungsi' => 'Finance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 3,
                'name' => 'Michael Johnson',
                'employee_number' => 'EMP003',
                'position' => 'Technician',
                'fungsi' => 'Maintenance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 1,
                'name' => 'Emily Davis',
                'employee_number' => 'EMP004',
                'position' => 'Engineer',
                'fungsi' => 'IT Support',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 2,
                'name' => 'David Wilson',
                'employee_number' => 'EMP005',
                'position' => 'HR Specialist',
                'fungsi' => 'Human Resources',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 3,
                'name' => 'Olivia Brown',
                'employee_number' => 'EMP006',
                'position' => 'Clerk',
                'fungsi' => 'Administration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 1,
                'name' => 'William Jones',
                'employee_number' => 'EMP007',
                'position' => 'Security Officer',
                'fungsi' => 'Security',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 2,
                'name' => 'Sophia Miller',
                'employee_number' => 'EMP008',
                'position' => 'Accountant',
                'fungsi' => 'Accounting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 3,
                'name' => 'James Martinez',
                'employee_number' => 'EMP009',
                'position' => 'Project Manager',
                'fungsi' => 'Construction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 1,
                'name' => 'Isabella Hernandez',
                'employee_number' => 'EMP010',
                'position' => 'Electrician',
                'fungsi' => 'Technical Support',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 2,
                'name' => 'Daniel Garcia',
                'employee_number' => 'EMP011',
                'position' => 'Supervisor',
                'fungsi' => 'Quality Control',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 3,
                'name' => 'Ava Martinez',
                'employee_number' => 'EMP012',
                'position' => 'Warehouse Staff',
                'fungsi' => 'Logistics',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 1,
                'name' => 'Liam Thomas',
                'employee_number' => 'EMP013',
                'position' => 'Procurement Officer',
                'fungsi' => 'Purchasing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 2,
                'name' => 'Mia White',
                'employee_number' => 'EMP014',
                'position' => 'Legal Advisor',
                'fungsi' => 'Legal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_id' => 3,
                'name' => 'Ethan Moore',
                'employee_number' => 'EMP015',
                'position' => 'Driver',
                'fungsi' => 'Transport',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
