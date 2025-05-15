<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public $incrementing = false;
}
