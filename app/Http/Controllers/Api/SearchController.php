<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Stay;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function basic($params) {
        
        Stay::query()
        ->where('city','LIKE',"%{$params}%")
        
        ->orWhere('country','LIKE',"%{$params}%")
        ->get();

        // return response()->json()
    }
}
