<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Product extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_code', 'item', 'quantity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = "products";
}
