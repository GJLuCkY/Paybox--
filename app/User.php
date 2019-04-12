<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends  = ['sheeps_count'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function corrals()
    {
        return $this->hasMany('App\Corral', 'user_id');
    }

    public function days()
    {
        return $this->hasMany('App\Day', 'user_id');
    }

    public function getSheepsCountAttribute()
    {
        $sheeps = 0;
        foreach($this->corrals as $corral) {
            $sheeps = $sheeps + $corral->count_sheeps;
        }
        return $sheeps;
    }
}
