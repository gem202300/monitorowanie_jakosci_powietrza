<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'device_status_histories';

    protected $fillable = [
        'device_id',
        'from_status',
        'to_status',
        'reason',
        'changed_at',
    ];

    protected $dates = [
        'changed_at',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
