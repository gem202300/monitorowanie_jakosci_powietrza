<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'address',
        'longitude',
        'latitude',
    ];

    protected $primaryKey = 'id';

    public function parameters(): BelongsToMany
    {
        return $this->belongsToMany(Parameter::class, 'device_parameters', 'device_id', 'parameter_id')
            ->withTimestamps();
    }
     public function users()
    {
        return $this->belongsToMany(User::class, 'user_devices')
                    ->withPivot('assign_at', 'unassign_at')
                    ->withTimestamps();
    }
    public function repairs()
    {
        return $this->hasMany(DeviceRepair::class);
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(DeviceStatusHistory::class, 'device_id')->orderByDesc('changed_at');
    }
        public function reports()
    {
        return $this->hasMany(DeviceReport::class);
    }

}
