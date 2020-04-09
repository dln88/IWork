<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MstOperator extends Authenticatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mst_operator';

    use Notifiable;

    const ROLE_PERSON = 0;
    const ROLE_ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'operator_cd',
        'operator_last_name',
        'operator_first_name',
        'emp_no'
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
        return $this->admin_div === self::ROLE_ADMIN;
    }
}
