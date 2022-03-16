<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Stay;
use Illuminate\Http\Request;

class StayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stays = Stay::with('perks')->get();
        // dd($stays);
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
        $stays = Stay::with('perks')->where("slug", $slug)->first();
        return response()->json($stays);    
    }

    
}   
