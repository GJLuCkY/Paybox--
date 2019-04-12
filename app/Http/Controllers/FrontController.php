<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sheep;
use App\Corral;
use Illuminate\Support\Facades\Auth;
use App\Services\CorralService;

class FrontController extends Controller
{
    protected $sheep;
    protected $corral;

    public function __construct(Sheep $sheep, Corral $corral)
    {
        $this->sheep = $sheep;
        $this->corral = $corral;
        
    }

    public function home()
    {
        $user = Auth::user();

        // Проверка на наличие загонов
        CorralService::isCorralsEmpty($user->id);

        // Проверка на наличие овец в загонах
        CorralService::isSheepsEmpty($user->id);


        return view('pages.home');
    }

}
