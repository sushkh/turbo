<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Offer extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_code', 'refill_type', 'discount_percent','discount_volume','discount_object'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $table = "offers";
}
