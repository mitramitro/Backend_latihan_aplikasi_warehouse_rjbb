<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices'; // Pastikan sesuai dengan nama tabel di database

    /**
     * Kolom yang boleh diisi secara mass assignment
     */
    protected $fillable = [
        'device_name',
        'brand_and_type',
        'serial_number',
        'device_type',
        'ip_address',
        'tag_name',
        'location',
        'contract_id',
        'installation_year',
        'description',
        'user_responsible',
        'user_device',
        'condition'
    ];

    /**
     * Relasi dengan tabel Contracts
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
