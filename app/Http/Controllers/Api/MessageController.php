<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $validationRule = [
        "name" => "string|max:100",
        "content" => "required|string",
        "email" => "required|string|email|max:255",
    ];

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

        $newMessage = new Message();
        $newMessage->name = $data['name'];
        $newMessage->content = $data['content'];
        $newMessage->email = $data['email'];

        $newMessage->stay_id = $data['stay_id'];

        $newMessage->save();
        return response()->json([
           "success" => true 
        ]);

    }
}
   
