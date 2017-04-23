<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'lm',
        'name',
        'category',
        'free_shipping',
        'description',
        'price'
    ];
}
