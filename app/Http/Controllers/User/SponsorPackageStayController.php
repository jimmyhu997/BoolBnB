<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\SponsorPackage;
use App\SponsorPackageStay;
use App\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorPackageStayController extends Controller
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
        // $sponsorHistory = SponsorPackageStay::all();
        $sponsorHistory = SponsorPackageStay::select('sponsor_package_stay.*','stays.id','stays.title as stays_title')
                                            ->leftjoin('stays','stays.id','=','sponsor_package_stay.stay_id')
                                            ->where('user_id', Auth::user()->id)
                                            ->get();
        return response()->json([$stays, $sponsorPackages,$sponsorHistory]); 
        // return response()->json($sponsorPackages);
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
        // dd($data);
        // dd($sponsorHistory);
        $newSponsor = new SponsorPackageStay();
        $newSponsor->stay_id = $data['stay_id'];
        $newSponsor->sponsor_package_id = $data['sponsorPackage_id'];
        $newSponsor->start_date = $data['start_date'];
        $newSponsor->end_date = $data['end_date'];

        $newSponsor->save();
        return response()->json('forza roma');
    }

}
