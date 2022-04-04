<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'name' ];

    public $timestamps = false;

    public function actions()
    {
        return $this->belongsToMany(Delivery::class);
    }
}
