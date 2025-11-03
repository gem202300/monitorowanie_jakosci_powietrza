<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Auth\RoleType;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone', 
        'address', 
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone' => 'string',
        'address' => 'string',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function devices()
    {
        return $this->belongsToMany(Device::class, 'user_devices')
                    ->withPivot('assign_at', 'unassign_at')
                    ->withTimestamps();
    }
public function isServiceman(): bool
{
    return $this->hasRole(RoleType::SERWISANT->value);
}

    
    public function isAdmin(): bool
    {
        return $this->hasRole(RoleType::ADMIN->value);
    }


   
}