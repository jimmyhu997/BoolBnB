<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Stay;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function basic(Request $request) {
        // dd('forza roma');
        // 0.18018
        $max_lat = $request->latitude + 0.18018;
        $min_lat = $request->latitude - 0.18018;
        dd($max_lat);
        // $max_lon = $request->longitude + 0.18018;
        // $min_lon = $request->longitude + 0.18018;

        // $result = Stay::where('latitude','<=',$max_lat)->where('latitude','>=',$min_lat)->where('longitude','<=',$max_lon)->where('longitude','>=',$min_lon)->get();
        // return response()->json($result);
    }
}
