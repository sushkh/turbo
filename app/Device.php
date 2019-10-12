<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Device extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'customer_code','device_pin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = "devices";
}
