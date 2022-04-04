<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $appends = array('brigades');
    protected $fillable = [ 'id', 'date', 'value', 'free_brigades' ];
    protected $hidden = ['free_brigades'];
    public $timestamps = false;

    public function getBrigadesAttribute()
    {
        $brigades = unserialize($this->free_brigades);

        if ($brigades == false)
        {
            $brigades = [];
        }

        $checkedBrigades = [];

        foreach ($brigades as $brigade_id)
        {
            if (!is_null(Brigade::find($brigade_id)))
            {
                array_push($checkedBrigades, $brigade_id);
            }
        }

        if (count($checkedBrigades) != count($brigades))
        {
            $this->free_brigades = serialize($checkedBrigades);
        }

        return $checkedBrigades;
    }

    public function setBrigadesAttribute($value)
    {
        $this->free_brigades = serialize($value);
    }
}
