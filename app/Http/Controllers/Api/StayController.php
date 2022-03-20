<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stays = Stay::with('perks')->where('visible', 1 )->get();
        return response()->json($stays);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {   
        
        $stay = Stay::with('perks')->where("slug", $slug)->with('user')->first();

        // $newVisit = new Visit();

        // $newVisit->session = explode(';', $_SERVER['HTTP_COOKIE'])[0];

        // $newVisit->save();
        

        return response()->json($stay) ; 
    }

}   
