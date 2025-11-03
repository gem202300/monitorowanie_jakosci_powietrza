<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Measurement extends Model
{   
    use HasFactory;
    protected $fillable = ['device_id', 'date_time'];
    
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    
    public function values()
    {
        return $this->hasMany(MeasurementValue::class);
    }
}