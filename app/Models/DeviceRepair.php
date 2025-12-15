<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceRepair extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'device_report_id',
        'user_id',
        'type',
        'description',
        'reported_at',
        'resolved_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deviceReport()
    {
        return $this->belongsTo(DeviceReport::class);
    }
}
