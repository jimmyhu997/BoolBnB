<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\SponsorPackage;
use App\Purchase;
use App\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stays = Stay::all()->where('user_id', Auth::user()->id);
        $sponsorPackages = SponsorPackage::all();
        $today = date('Y-m-d h:i:s');
        $purchaseHistory = Purchase
            ::select('purchases.*','stays.title as stay_title','stays.slug as stay_slug','stays.image_path as stay_image_path', 'sponsor_packages.price as tier_price', 'sponsor_packages.name as tier_name')
            ->leftjoin('sponsor_packages','sponsor_packages.id','=','purchases.sponsor_package_id')
            ->leftjoin('stays','stays.id','=','purchases.stay_id')
            ->where('user_id', Auth::user()->id)
            ->get();
        $sponsorActive = Purchase
            ::select('purchases.*','stays.title as stay_title','stays.slug as stay_slug','stays.image_path as stay_image_path')
            ->where('end_date', '>=', $today)
            ->leftjoin('stays','stays.id','=','purchases.stay_id')
            ->where('user_id', Auth::user()->id)
            ->get();
        return response()->json([$stays, $sponsorPackages,$purchaseHistory,$sponsorActive]);
    }

    public function getSponsoredList($stay_id) {
        $resultList = Purchase::where('stay_id',$stay_id)->get();
        return response()->json($resultList);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $data = $request->all();
        $newPurchase = new Purchase();
        $newPurchase->stay_id = $data['stay_id'];
        $newPurchase->sponsor_package_id = $data['sponsorPackage_id'];
        $newPurchase->start_date = $data['start_date'];
        $newPurchase->end_date = $data['end_date'];
        
        $newPurchase->save();
        return response()->json('forza roma');
    }

}