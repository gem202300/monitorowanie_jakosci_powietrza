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
    
    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }
}
