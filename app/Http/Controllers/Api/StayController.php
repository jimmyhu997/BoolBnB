<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Stay;
use App\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $ipArray = array( "199.120.74.239", "238.8.190.209", "227.95.234.193", "191.31.64.191", "85.39.166.145", "43.73.221.62", "208.43.67.70", "120.12.36.104", 
    "191.219.21.3", "222.181.96.221" , "170.58.183.160" , "22.253.147.58", "177.235.99.20", "177.109.69.225", "93.165.119.8", "74.187.208.193", "201.99.27.26", "160.63.20.121"
    , "126.165.13.23", "80.110.105.80", "23.180.227.90", "40.252.197.134", "27.122.63.249", "14.70.114.72" , "24.244.232.40", "237.68.179.6", "181.63.199.153", 
    "153.31.109.130", "89.213.115.127", "175.19.38.133");
    
    public function index()
    {
        $stays = Stay::with('perks')->where('visible', 1 )->get();
        return response()->json($stays);
    }

    public function show($slug)
    {   
        $stay = Stay::with('perks')->where("slug", $slug)->with('user')->first();
  
        $newVisit = new Visit();
        $newVisit->stay_id = $stay->id;
        $newVisit->visitor_ip = $this->ipArray[array_rand($this->ipArray,1)];
        $newVisit->save();

        return response()->json($stay) ; 
    }

}   
