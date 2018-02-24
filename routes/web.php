<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', "RestController@loadTestUrl");

Route::resource("vehicles", "VehicleController");
Route::get("vehicles/{modelYear}/{manufacturer}/{model}", "VehicleController@vehicleSafetyRatings")
->where([
    'modelYear'=>'[a-zA-Z 0-9]+',
    'manufacturer'=>'[a-z A-Z]+',
    'model'=>'[a-zA-Z 0-9]+',

]);
