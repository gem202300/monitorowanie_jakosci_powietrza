<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeasurementValue extends Model
{
    protected $fillable = ['measurement_id', 'parameter_id', 'value'];
    
    public function measurement()
    {
        return $this->belongsTo(Measurement::class);
    }
    
    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}