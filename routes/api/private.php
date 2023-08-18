<?php

use App\Http\Controllers\Api\Guest\LoginController;
use App\Http\Controllers\Api\Private\PrivateController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/authuser/{id}' , [PrivateController::class , 'getUser']);
    Route::post('/profile/{id}' , [PrivateController::class , 'postUser']);
    Route::get('/user-interest/{user_id}' , [PrivateController::class , 'getUserInterest']);
    Route::post('/add-user-interest/{user_id}' , [PrivateController::class , 'postUserInterest']);
    Route::get('/user-groups/{user_id}' , [PrivateController::class , 'getUserGroups']);
    Route::get('/user/{user_id}/group/{group_id}/joined' , [PrivateController::class , 'getJoinedGroupOfUser']);

});
