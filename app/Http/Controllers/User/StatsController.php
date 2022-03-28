<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Visit;
use App\Stay;
use App\User;

use Illuminate\Support\Facades\Auth;


class StatsController extends Controller
{
    public function getInfoVisit() {
        $user = Auth::user()->id;
        $resultVisits = Visit
            ::join('stays', 'stays.id', '=', 'visits.stay_id')
            ->join('users', 'stays.user_id', '=', 'users.id')
            ->where('user_id', Auth::user()->id)
            ->select('user_id', 'stay_id','visits.created_at','stays.title','stays.slug','stays.street_address')
            ->get();
        // dd( $resultVisits[200]);
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
