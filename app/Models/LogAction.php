<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_action';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'action_log_no';

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
        'operator_cd',
        'operator_name',
        'screen_id',
        'screen_name',
        'operation',
        'contents',
    ];

}
