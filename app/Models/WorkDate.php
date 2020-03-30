<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkDate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'work_date', 'start_time', 'end_time', 'break_time', 'working_time', 'over_time', 'over_night'
    ];
}
