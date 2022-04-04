<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;


    protected $appends = array('manager', 'state');
    protected $dates = [ 'date', 'previous_date' ];
    protected $dateFormat = 'Y-m-d';
    protected $fillable = [ 'id', 'date', 'previous_date', 'user_id', 'order', 'organization_name', 'organization_address', 'is_region', 'contact_person', 'phone', 'comment', 'is_paid', 'is_available', 'account', 'selling', 'value', 'delivery_state_id' ];
    protected $hidden = [ 'user_id', 'delivery_state_id'];
    public $timestamps = false;

    public function actions()
    {
        return $this->belongsToMany(Action::class);
    }

    public function getManagerAttribute()
    {
        return !is_null($this->user_id)
            ? User::find($this->user_id)
            : null;
    }

    public function getStateAttribute()
    {
        return DeliveryState::find($this->delivery_state_id);
    }

    //На этот костыль я потратил слишком много времени, а должно ведь работать просто так
    function toArray()
    {
        return array_merge(parent::toArray(), ['actions' => $this->actions]);
    }
}
