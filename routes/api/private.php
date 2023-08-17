<?php

use App\Http\Controllers\Api\Guest\LoginController;
use App\Http\Controllers\Api\Private\PrivateController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/authuser/{id}' , [PrivateController::class , 'getUser']);

});
