<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasRoles, Notifiable;
    protected $fillable = [
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function spread()
    {
        return $this->hasMany(Spread::class, 'uid', 'id');
    }

}
