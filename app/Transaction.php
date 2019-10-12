<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Transaction extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vehicle_number', 'volume', 'device_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = "transaction";
}
