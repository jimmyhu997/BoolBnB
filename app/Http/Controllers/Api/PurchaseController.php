<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function getSponsoredList() {
        $today = date("Y-m-d h:i:s");
        $resultList = Purchase
            ::where('end_date', '>=', $today)
            ->leftjoin('stays','stays.id','=','purchases.stay_id')
            ->where('visible',1)
            ->get();

        return response()->json($resultList->unique('stay_id'));
    }
}
