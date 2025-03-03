<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDevice extends Model
{
    use HasFactory;
    protected $table = 'reportdevices';
    protected $fillable = [
        'report_id',
        'device_name',
        'device_type',
        'status_used_new',
        'status_damage',
        'status_rent',
        'status_asset',
        'description',
    ];
}
