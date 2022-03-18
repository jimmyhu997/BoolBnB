<?php

namespace App\Http\Controllers\Api;

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
        $perks = Perk::orderBy('name')->get();

        return response()->json($perks);
    }

}
