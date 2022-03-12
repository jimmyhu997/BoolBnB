<?php

namespace App\Http\Controllers\User;

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

        $stays = Stay::all()->where('user_id', Auth::user()->id);
        return response()->json($stays);
        
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

        $newStay = new Stay();

        $newStay->title = $data['title'];

        // Slug da gestire correttamente 
        $newStay->slug = $data['title'];

        $newStay->description = $data['description'];
        $newStay->square_meters = $data['square_meters'];
        $newStay->guests = $data['guests'];


        // da sistemare con TomTom
        $newStay->longitude = 10.10;
        $newStay->latitude = 10.10;
        
        // $newStay->rooms = $data['rooms'];
        // $newStay->beds = $data['beds'];
        // $newStay->bathrooms = $data['bathrooms'];
        // $newStay->street_address = $data['street_address'];
        // $newStay->zip_code = $data['zip_code'];
        // $newStay->city = $data['city'];
        // $newStay->province_state = $data['province_state'];
        // $newStay->country = $data['country'];
        // $newStay->image_path = '//';
        // $newStay->price = $data['price'];

        // dati di prova perchè sono pigro 
        $newStay->rooms = 1;
        $newStay->beds = 3;
        $newStay->bathrooms = 2;
        $newStay->street_address = 'ciaoneee';
        $newStay->zip_code = '00071';
        $newStay->city = 'Pomezia';
        $newStay->province_state = 'Roma';
        $newStay->country = 'Italia';
        $newStay->image_path = '//';
        $newStay->price = 50;

        $newStay->user_id = Auth::user()->id;
        $newStay->save();
        return response()->json([
           "stayId" => $newStay->id
        ]);
    }

  
    public function edit(Stay $stay) {
        
        return response()->json($stay);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stay $stay)
    {
        $data = $request->all();

        $stay->title = $data['title'];

        // Slug da gestire correttamente 
        $stay->slug = $data['title'];

        $stay->description = $data['description'];
        $stay->square_meters = $data['square_meters'];
        $stay->guests = $data['guests'];


        // da sistemare con TomTom
        $stay->longitude = 10.10;
        $stay->latitude = 10.10;

        // $stay->rooms = $data['rooms'];
        // $stay->beds = $data['beds'];
        // $stay->bathrooms = $data['bathrooms'];
        // $stay->street_address = $data['street_address'];
        // $stay->zip_code = $data['zip_code'];
        // $stay->city = $data['city'];
        // $stay->province_state = $data['province_state'];
        // $stay->country = $data['country'];
        // $stay->image_path = '//';
        // $stay->price = $data['price'];
        $stay->save();

        return response()->json([
            "stayId" => $stay->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stay $stay)
    {

        $stay->delete();

        return response()->json([
            "stayId" => $stay->id
        ]);
    }
}
