<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes 
Route::get('/stays', "Api\StayController@index");
Route::get("/stays/{slug}", "Api\StayController@show");
Route::post('/send-message',"Api\MessageController@store" );
Route::get('/perks', "Api\PerkController@index");


Route::prefix('search')->namespace('Api')->group(function () {
    Route::get('/basic', 'SearchController@basic')->name('basic');
    Route::get('/advanced/{params}', 'SearchController@advanced')->name('advanced');
});