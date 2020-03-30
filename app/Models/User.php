<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_STAFF = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check is Admin
     * @return bool
     */
    public function isAdmin()    {
        return $this->role_id === self::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isStaff()    {
        return $this->role_id === self::ROLE_STAFF;
    }
}
