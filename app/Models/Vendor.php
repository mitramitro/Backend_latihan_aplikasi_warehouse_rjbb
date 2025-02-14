<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendors_code',
        'vendor_name',
        'phone_number',
        'address',
        'email'
    ];
}
