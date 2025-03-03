<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'status_contract',
        'contract_type',
        'contract_number',
        'invoice'
    ];

    public function devices()
    {
        return $this->hasMany(Device::class, 'contract_id');
    }
}
