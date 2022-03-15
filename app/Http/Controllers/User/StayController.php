<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Perk;
use App\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StayController extends Controller
{
    protected $validationRule = [
        "title" => "required|string|max:100",
        "description" => "required|string",
        "square_meters" => "required|numeric|max:999",
        "guests" => "required|numeric|max:99",
        "rooms" => "required|numeric|max:99",
        "beds" => "required|numeric|max:99",
        "bathrooms" => "required|numeric|max:99",
        "street_address" => "required|string",
        "zip_code" => "required|string|max:12",
        "city" => "required|string|max:50",
        "province_state" => "required|string|max:50",
        "country" => "required|string|max:50",
        "image_path" => "required|mimes:jpeg,jpg,bmp,png|max:5120",
        "price" => "required",
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index()
    {   
        $stays = Stay::all()->where('user_id', Auth::user()->id);
        $perks = Perk::all();
        return response()->json([$stays, $perks]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate($this->validationRule);

        $data = $request->all();

        $newStay = new Stay();

        $newStay->title = $data['title'];

        // Slug da gestire correttamente 
        $newStay->slug = $data['title'];

        $slug = Str::of($newStay->title)->slug("-");
        
        $count = 1;

        while( Stay::where("slug", $slug)->first()) {
            $slug = Str::of($newStay->title)->slug("-")."-{$count}";
            $count++;
        }
        $newStay->slug = $slug;
        
        $newStay->description = $data['description'];
        $newStay->square_meters = $data['square_meters'];
        $newStay->guests = $data['guests'];
        

        // da sistemare con TomTom
        $newStay->longitude = 10.10;
        $newStay->latitude = 10.10;
        
        $newStay->rooms = $data['rooms'];
        $newStay->beds = $data['beds'];
        $newStay->bathrooms = $data['bathrooms'];
        $newStay->street_address = $data['street_address'];
        $newStay->zip_code = $data['zip_code'];
        $newStay->city = $data['city'];
        $newStay->province_state = $data['province_state'];
        $newStay->country = $data['country'];
        $path = Storage::put("uploads", $data["image_path"]);
        $newStay->image_path = $path;
        $newStay->price = $data['price'];

       
        $newStay->user_id = Auth::user()->id;
        $newStay->save();

        if (isset($data["perks"]) ) {
            $perks = explode(',', $data['perks']);
            $newStay->perks()->sync($perks);
        }
        return response()->json([
           "stayId" => $newStay->id
        ]);
    }

  
    public function edit($stayId) {
        $stay = Stay::where('id','=',$stayId)->with(['perks'])->get()->first();

        if($stay->user_id == Auth::user()->id) {
            return response()->json($stay);
        }
        else {
            return response()->json([
                'success' => false
            ],404);
        }
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
        $request->validate($this->validationRule);

        $data = $request->all();

        $stay->title = $data['title'];

        if ( $stay->title != $data['title']) {
            $stay->title = $data['title']; 

            $slug = Str::of($stay->title)->slug("-");
            
            if($slug != $stay->slug) {
                $count = 1;

                while( Stay::where("slug", $slug)->first()) {
                    $slug = Str::of($stay->title)->slug("-")."-{$count}";
                    $count++;
                }
                $stay->slug = $slug;
            }
        }
       
        $stay->description = $data['description'];
        $stay->square_meters = $data['square_meters'];
        $stay->guests = $data['guests'];


        // da sistemare con TomTom
        $stay->longitude = 10.10;
        $stay->latitude = 10.10;

        $stay->rooms = $data['rooms'];
        $stay->beds = $data['beds'];
        $stay->bathrooms = $data['bathrooms'];
        $stay->street_address = $data['street_address'];
        $stay->zip_code = $data['zip_code'];
        $stay->city = $data['city'];
        $stay->province_state = $data['province_state'];
        $stay->country = $data['country'];
        $stay->image_path = '//';
        $stay->price = $data['price'];
        $stay->save();

        if (isset($data["perks"]) ) {
            $stay->perks()->sync($data["perks"]);
        }

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
