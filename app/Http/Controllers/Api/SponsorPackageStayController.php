<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SponsorPackageStay;
use Illuminate\Http\Request;

class SponsorPackageStayController extends Controller
{
    public function getSponsoredList($stay_id) {
        $resultList = SponsorPackageStay::where('stay_id',$stay_id)->get();
        return response()->json($resultList);
    }
}
