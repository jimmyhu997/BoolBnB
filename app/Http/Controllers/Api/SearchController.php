<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Stay;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function basic(Request $request) {
        // tabella di conversione delle cordite in decimali
        // http://wiki.gis.com/wiki/index.php/Decimal_degrees
        $offset = (($request->radius / 111) * 0.001);
        $max_lat = $request->latitude + $offset;
        $min_lat = $request->latitude - $offset;
        $max_lon = $request->longitude + $offset;
        $min_lon = $request->longitude - $offset;


        // dd($max_lat);

        $result = Stay::where('latitude','<=',$max_lat)->where('latitude','>=',$min_lat)->where('longitude','<=',$max_lon)->where('longitude','>=',$min_lon)->get();
        return response()->json($result);

        // $result = Stay::whereBetween('latitude', [$min_lat, $max_lat])->whereBetween('latitude', [$min_lon, $max_lon])->get();
        return response()->json($result);
    }
}
