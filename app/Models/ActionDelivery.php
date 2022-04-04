<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionDelivery extends Model
{
    protected $fillable = [ 'id', 'delivery_id', 'action_id' ];

    public $timestamps = false;

    protected $table = 'action_delivery';
}
