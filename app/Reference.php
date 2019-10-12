<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Reference extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference_number', 'customer_id','flag','discount_percent'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = "reference";
}
