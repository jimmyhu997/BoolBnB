<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();


// Route::prefix('admin')->middleware('auth')->get('/{any?}', function () {
//     return view('registered_user.dashboard');
// })->where('any', '.*');


Route::prefix('user')->middleware('auth')->namespace('User')->group( function () {
    Route::resource('stays' , 'StayController');
    Route::get('messages' , 'MessageController@index');
    Route::post('add-sponsor' , 'SponsorPackageStayController@store')->name('add-sponsor');
    Route::get('sponsor-packages' , 'SponsorPackageStayController@index')->name('sponsor-packages');
    Route::get('sponsor-packages-stay/{stay_id}' , 'SponsorPackageStayController@getSponsoredList')->name('sponsor-packages-stay');

    Route::get('/{any?}', function () {
        return view('registered_user.dashboard');
    })->where('any', '.*');
    
});



Route::get('{any?}', function () {
    return view('home');
})->where('any', '.*')->name('home');
