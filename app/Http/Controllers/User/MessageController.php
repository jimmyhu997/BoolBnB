<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $stays = DB::table('stays')
        //             ->join('messages', 'stays.id', '=', 'messages.stays_id')
        //             ->select('stays.title')
        //             ->where('user_id', Auth::user()->id)
        //             ->get();
        $stays = Stay
            ::with('messages')
            ->where('user_id', Auth::user()->id)
            ->get();
        return response()->json($stays);
    }

   
}
