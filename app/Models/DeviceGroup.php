<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceGroup extends Model
{

    use HasFactory;
    protected $table = 'device_groups'; // Pastikan sesuai dengan nama tabel di database
    protected $fillable = [
        'device_group_name',
        'device_type',
    ];
}
