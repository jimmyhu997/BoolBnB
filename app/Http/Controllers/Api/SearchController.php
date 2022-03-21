<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Stay;
use App\Perk;
use App\Purchase;
use App\SponsorPackageStay;
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
        $result = Stay
            ::where('latitude','<=',$max_lat)
            ->where('latitude','>=',$min_lat)
            ->where('longitude','<=',$max_lon)
            ->where('longitude','>=',$min_lon)
            ->with('perks')
            ->where('visible', 1 )
            ->get();

        if (count($result) < 1) {
            $result = Stay
            ::where('street_address','LIKE',"%".$request->queryKey."%")
            ->orWhere('city','LIKE','%'.$request->queryKey."%")
            ->orWhere('province_state','LIKE','%'.$request->queryKey."%")
            ->orWhere('country','LIKE','%'.$request->queryKey."%")
            ->with('perks')
            ->get();
        }

        $today = date("Y-m-d h:i:s");

        $sponsoredResult = Purchase
            ::select('purchases.stay_id')
            ->leftjoin('stays','stays.id','=','purchases.stay_id')
            ->where('end_date', '>=', $today)
            ->where('visible',1)
            ->where('latitude','<=',$max_lat)
            ->where('latitude','>=',$min_lat)
            ->where('longitude','<=',$max_lon)
            ->where('longitude','>=',$min_lon)
            ->get();
            // dd($sponsoredResult->unique('stay_id'));

        return response()->json([$result, $sponsoredResult->unique('stay_id')]);
    }

}
