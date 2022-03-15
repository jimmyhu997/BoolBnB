<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
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

   
}
