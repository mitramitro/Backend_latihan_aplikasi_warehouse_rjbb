<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageDevice extends Model
{
    use HasFactory;
    protected $table = 'manage_devices'; // Pastikan sesuai dengan nama tabel di database
    protected $fillable = [
        'user_id',
        'device_id',
        'condition',
        'date',
    ];
}
