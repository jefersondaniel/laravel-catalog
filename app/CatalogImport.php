<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogImport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['attachment'];
}
