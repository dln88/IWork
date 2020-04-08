<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogLogin extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_login';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'login_log_no';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'operation_timestamp',
        'ip_address',
        'user_id',
        'operator_cd',
        'operator_name',
        'operation_type',
        'contents'
    ];

}
