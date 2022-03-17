<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Perk;
use Illuminate\Http\Request;

class PerkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perks = Perk::all();
        return response()->json($perks);
    }

}
