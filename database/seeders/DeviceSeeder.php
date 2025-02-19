<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('devices')->insert([
            [
                'device_name' => 'Router A',
                'brand_and_type' => 'Cisco 2901',
                'serial_number' => 'SN123456789',
                'device_type' => 'Router',
                'ip_address' => '192.168.1.1',
                'tag_name' => 'RTR-001',
                'location' => 'Data Center 1',
                'contract_id' => 1,
                'installation_year' => '2019',
                'description' => 'Main branch router',
                'user_responsible' => 1, // John Doe -> ID: 1
                'user_device' => 2, // Network Team -> ID: 2
                'condition' => 'Good',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_name' => 'Switch B',
                'brand_and_type' => 'HP ProCurve 2920',
                'serial_number' => 'SN987654321',
                'device_type' => 'Switch',
                'ip_address' => '192.168.1.2',
                'tag_name' => 'SWT-002',
                'location' => 'Data Center 2',
                'contract_id' => 2,
                'installation_year' => '2020',
                'description' => 'Core switch for VLAN segmentation',
                'user_responsible' => 3, // Jane Smith -> ID: 3
                'user_device' => 4, // IT Support -> ID: 4
                'condition' => 'Good',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_name' => 'Firewall C',
                'brand_and_type' => 'Fortinet FG-100E',
                'serial_number' => 'SN1122334455',
                'device_type' => 'Firewall',
                'ip_address' => '192.168.1.3',
                'tag_name' => 'FW-003',
                'location' => 'Data Center 1',
                'contract_id' => 3,
                'installation_year' => '2021',
                'description' => 'Security firewall',
                'user_responsible' => 5, // Michael Brown -> ID: 5
                'user_device' => 6, // Security Team -> ID: 6
                'condition' => 'Excellent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_name' => 'Access Point D',
                'brand_and_type' => 'Ubiquiti UAP-AC-PRO',
                'serial_number' => 'SN4455667788',
                'device_type' => 'Access Point',
                'ip_address' => '192.168.1.4',
                'tag_name' => 'AP-004',
                'location' => 'Office Floor 1',
                'contract_id' => 4,
                'installation_year' => '2018',
                'description' => 'WiFi access point',
                'user_responsible' => 7, // Sarah Johnson -> ID: 7
                'user_device' => 8, // Networking -> ID: 8
                'condition' => 'Fair',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
