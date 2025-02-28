<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_date',
        'site',
        'manager_name',
        'ict_name',
    ];

    public function devices()
    {
        return $this->hasMany(ReportDevice::class);
    }
}
