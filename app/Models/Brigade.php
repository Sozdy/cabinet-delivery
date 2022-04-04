<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brigade extends Model
{
    public $timestamps = false;

    protected $appends = array('brigade_type');
    protected $fillable = [ 'id', 'phone', 'contact_person', 'car', 'driver', 'brigade_type_id' ];
    protected $hidden = [ 'brigade_type_id' ];

    public function brigade_type()
    {
        return $this->hasOne('brigade_types');
    }

    public function getBrigadeTypeAttribute()
    {
        return BrigadeType::find($this->brigade_type_id);
    }
}
