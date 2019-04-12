<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Corral;
use App\Sheep;
use App\User;
use App\Day;

class CorralService 
{
    const MaxCorrals = 4;
    const Sheeps = 10;

    public static function isCorralsEmpty($id)
    {
        $user = User::find($id);
        // dd($user);
        $count = $user->corrals->count();
        if ($count == 4) {
            return false;
            // В конце на false;
        } else {
            for ($i = 1; $i <= self::MaxCorrals - $count; $i++) {
                $user->corrals()->create();
                $user->day = 1;
                $user->save();
            }
            return true;
        } 
    }

    public static function isSheepsEmpty($id)
    {
        $user = User::find($id);
        
        $emptyCorral = 0;

        foreach($user->corrals as $key=>$corral) {
            $countSheepsInCorral = $corral->sheeps->count();
            if($countSheepsInCorral == 0) {
                $emptyCorral++;
            }
        }

        if($emptyCorral == 0) {
            return false;
        } else if($emptyCorral == 4) {

            for ($i = 1; $i <= self::Sheeps; $i++) {
                $numberCorral = mt_rand(0, 3);
                $user->corrals[$numberCorral]->sheeps()->create();
            }
        }
            
        self::isCorralEmpty($user);
        
    }


    public static function isCorralEmpty($user)
    {
        $corrals = Corral::where('user_id', $user->id)->get();

        $minCorrals = $corrals->where('count_sheeps', 0);
             
        foreach($minCorrals as $minCorral) {
            // Определяем самый заселенный загон
            $maxCorral = $corrals->sortByDesc('count_sheeps')->first();
            $minCorral->sheeps()->create();
            $maxCorral->sheeps()->first()->delete();
        }   
    }

    public static function addSheepToCorral()
    {
        $user = Auth::user();

        $numberCorral = mt_rand(0, 3);
        $user->corrals[$numberCorral]->sheeps()->create();
    }



    public static function addSheep()
    {
        $users = User::all();

        foreach($users as $user) {

            $dead = false;
            $alive = $user->sheeps_count;

            $user->update([
                'day' => ++$user->day
            ]);
            $numberCorral = mt_rand(0, 3);
            $user->corrals[$numberCorral]->sheeps()->create();

            if($user->day % 10 == 0) {
                $dead = true;
                $alive = $alive - 1;
                self::removeSheep($user->id);
            }

            $corrals = Corral::where('user_id', $user->id)->get();

            $minCorral = $corrals->sortBy('count_sheeps')->first();
             
            $maxCorral = $corrals->sortByDesc('count_sheeps')->first();

            self::nextDay($user->id, $user->day, $user->sheeps_count, $dead, $alive, $maxCorral->id, $minCorral->id);

        }
    }


    public static function nextDay($id, $day, $count, $dead, $alive, $maxCorral, $minCorral) {
        $day = Day::create([
            'user_id' => $id,
            'day' => $day,
            'count' => $count,
            'alive' => $alive,
            'dead' => $dead ? 1 : 0,
            'max' => $maxCorral,
            'min' => $minCorral
        ]);
    }

    public static function removeSheep($id)
    {
        $user = User::find($id);
        $numberCorral = mt_rand(0, 3);

        $user->corrals[$numberCorral]->sheeps()->first()->delete();



    }

    public static function reset($id)
    {
        $user = User::find($id);
        $user->day = 1;
        $user->save();
        $user->corrals()->delete();
        $user->days()->delete();
        self::isCorralsEmpty($id);
        self::isSheepsEmpty($id);

    }

}