<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sheep extends Model
{
    protected $table = 'sheeps';
    
    protected $fillable = [
        'corral_id',
    ];

    public function corral()
    {
        return $this->belongsTo('App\Corral', 'corral_id');
    }

}
