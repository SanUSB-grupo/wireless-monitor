<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'monitor_key',
        'data',
        'user_id',
    ];
}
