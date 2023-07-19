<?php

use App\Http\Controllers\ParcelController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(UserController::class)
    ->group(function() {
        //RouteServiceProvider puts 'api' prefix
       Route::get('/v1/users', 'listAllUsers');
       Route::post('/v1/users/add', 'addUser');
});

Route::controller(ParcelController::class)
    ->group(function() {
        Route::get('/v1/parcels/{parcel:parcel_number}', 'getParcelByNumber');
        Route::post('/v1/parcels/add', 'addParcel');
});
