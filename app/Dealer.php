<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Dealer extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'customer_code', 'contact','pump_name','city','email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = "dealers";
}
