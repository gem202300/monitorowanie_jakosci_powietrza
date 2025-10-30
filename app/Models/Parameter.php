<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parameter extends Model
{
    protected $fillable = ['id', 'name', 'label', 'unit', 'valueType'];
    protected $primaryKey = 'id';
    
    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(Device::class, 'device_parameters', 'parameter_id', 'device_id')
            ->withTimestamps();
    }
}