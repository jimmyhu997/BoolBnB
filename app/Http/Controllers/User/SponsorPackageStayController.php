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
        $sponsorHistory = SponsorPackageStay::all()->join('stays','stays.user_id','=',Auth::user()->id);
        return response()->json([$stays, $sponsorPackages, $sponsorHistory]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

}
