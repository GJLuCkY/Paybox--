<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $table = 'days';
    
    protected $fillable = [
        'user_id',
        'day',
        'count',
        'alive',
        'dead',
        'min',
        'max'
    ];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
