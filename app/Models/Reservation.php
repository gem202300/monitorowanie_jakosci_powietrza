<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'id_uzytkownika',
        'id_wydarzenia',
        'data_rezerwacji',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'id_uzytkownika');
    }

  
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_wydarzenia');
    }
}
