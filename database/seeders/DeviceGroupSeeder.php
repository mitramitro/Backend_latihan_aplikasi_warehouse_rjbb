<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeviceGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deviceGroups = [
            ['device_group_name' => 'CCTV', 'device_type' => 'Indoor'],
            ['device_group_name' => 'CCTV', 'device_type' => 'Outdoor'],
            ['device_group_name' => 'CCTV', 'device_type' => 'PTZ'],
            ['device_group_name' => 'CCTV', 'device_type' => 'Explosion'],
            ['device_group_name' => 'HT', 'device_type' => 'Radio BS'],
            ['device_group_name' => 'HT', 'device_type' => 'Radio Mobil'],
            ['device_group_name' => 'HT', 'device_type' => 'Radio BS Marine'],
            ['device_group_name' => 'HT', 'device_type' => 'Radio LS Marine'],
            ['device_group_name' => 'Printer', 'device_type' => 'MFP Color'],
            ['device_group_name' => 'Printer', 'device_type' => 'MFP Black'],
            ['device_group_name' => 'Printer', 'device_type' => 'SFP Color'],
            ['device_group_name' => 'Printer', 'device_type' => 'SFP Black'],
            ['device_group_name' => 'Device Mobile', 'device_type' => 'HT Explosion'],
            ['device_group_name' => 'Device Mobile', 'device_type' => 'HT Satellite'],
            ['device_group_name' => 'Network & Telephony', 'device_type' => 'Switch'],
            ['device_group_name' => 'Network & Telephony', 'device_type' => 'Access Point'],
            ['device_group_name' => 'Network & Telephony', 'device_type' => 'Telephony Analog'],
            ['device_group_name' => 'Network & Telephony', 'device_type' => 'Telephony Digital'],
            ['device_group_name' => 'Komputer', 'device_type' => 'PC Desktop'],
            ['device_group_name' => 'Komputer', 'device_type' => 'Mini PC'],
            ['device_group_name' => 'Komputer', 'device_type' => 'Laptop Type 2'],
            ['device_group_name' => 'Komputer', 'device_type' => 'Laptop Type 3'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'TV'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'Projector'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'Camera'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'Laptop'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'Speaker Portable'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'Mic Wireless'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'Mic Meja'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'Mixer'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'Amplifier'],
            ['device_group_name' => 'Multimedia', 'device_type' => 'Printer']
        ];

        DB::table('device_groups')->insert($deviceGroups);
    }
}
