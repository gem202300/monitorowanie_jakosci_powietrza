<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'location',
        'max_participants',
    ];
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_wydarzenia');
    }
}
