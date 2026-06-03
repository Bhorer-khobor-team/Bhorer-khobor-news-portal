<?php


namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Authenticatable
{
    use HasRoles, Notifiable;


    // Tell Spatie to use the 'admin' guard for this model
    protected $guard_name = 'admin';


    protected $fillable = [
        'name', 'email', 'password', 'phone', 'is_locked', 'is_active',
    ];


    protected $hidden = ['password', 'remember_token'];


    protected $casts = [
        'is_locked' => 'boolean',
        'is_active' => 'boolean',
    ];
}

