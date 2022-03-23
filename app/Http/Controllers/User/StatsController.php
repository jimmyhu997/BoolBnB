<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Visit;
use App\Stay;

use Illuminate\Support\Facades\Auth;


class StatsController extends Controller
{
    public function getInfoGeneral() {

        $resultVisits = Stay
            ::with('visits')
            ->with('messages')
            ->where('user_id', Auth::user()->id)
            ->get();
            
        return response()->json($resultVisits);
    }

    public function getInfo($stay_id) {

        $result = Stay
            ::with('visits')
            ->with('messages')
            ->where('id',$stay_id)
            ->where('user_id', Auth::user()->id)
            ->get();

        return response()->json($result);
    }

}
