<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrigadeType extends Model
{
    protected $fillable = [ 'id', 'name' ];

    public $timestamps = false;
}
