<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAssignmentHistory extends Model
{
    protected $table = 'device_assignments_history';

    protected $fillable = [
        'device_id',
        'user_id',
        'assigned_by',
        'assigned_at',
        'unassigned_at',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
