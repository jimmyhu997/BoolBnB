<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
 

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $newMessage = new Message();

        $newMessage->name = $data['name'];
        $newMessage->content = $data['content'];
        $newMessage->email = $data['email'];
        $newMessage->stay_id = $data['stay_id'];

        $newMessage->save();


    }
}
   
