<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\CorralCollection;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CorralService;

class CorralApiController extends Controller
{
    public function show($id)
    {
       
        $user = User::find($id);

        return response()->json([
            'data' => CorralCollection::collection($user->corrals),
            'day' => $user->day,
            'days' => $user->days
        ], 200);
    }

    public function reset(Request $request)
    {
       CorralService::reset($request->get('user', 1));
       
    }
}