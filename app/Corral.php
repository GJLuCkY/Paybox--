<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corral extends Model
{
    protected $table = 'corrals';
    
    protected $fillable = [
        'user_id',
    ];

    protected $appends = ['count_sheeps'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function sheeps()
    {
        return $this->hasMany('App\Sheep', 'corral_id');
    }

    public function getCountSheepsAttribute()
    {
        return $this->sheeps->count();
    }
}
