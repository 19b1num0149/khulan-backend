<?php

use App\Http\Controllers\Api\Private\ContentController;
use App\Http\Controllers\Api\Private\GroupController;
use App\Http\Controllers\Api\Private\InterestController;
use App\Http\Controllers\Api\Private\NotificationController;
use App\Http\Controllers\Api\Private\PaymentController;
use App\Http\Controllers\Api\Private\ProfileController;
use App\Http\Controllers\Api\Private\SettingsController;

use App\Http\Controllers\Api\Private\ParkingController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {


    //get all parkings
    Route::get('/parking', [ParkingController::class, 'getAllParkings']);
    Route::get('/parking/{parkingid}', [ParkingController::class, 'getSinglePark']);
    Route::post('/parking/order/{parkingId}', [ParkingController::class, 'order']);
    Route::get('/parking/order/detail/get', [ParkingController::class, 'getOrder']);
    Route::post('/pay/{orderid}', [ParkingController::class, 'pay']);
    Route::get('/user/history', [ParkingController::class, 'history']);
    Route::get('/user', [ParkingController::class, 'getUser']);

});
