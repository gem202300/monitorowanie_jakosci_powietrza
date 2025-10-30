<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceParameters extends Model
{
    protected $table = 'device_parameters';
    protected $fillable = ['device_id', 'parameter_id'];
}