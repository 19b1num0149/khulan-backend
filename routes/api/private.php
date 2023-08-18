<?php

use App\Http\Controllers\Api\Guest\LoginController;
use App\Http\Controllers\Api\Private\PrivateController;
use App\Http\Controllers\Api\Private\SettingsController;
use App\Http\Controllers\Api\Private\NotificationController;
use App\Http\Controllers\Api\Private\PaymentController;
use App\Http\Controllers\Api\Private\ContentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/authuser/{id}' , [PrivateController::class , 'getUser']);
    
    // Settings
    Route::get('/user/settings' , [SettingsController::class , 'getData']);
    Route::post('/user/settings' , [SettingsController::class , 'store']);

    // Notification
    Route::get('/user/notification' , [NotificationController::class , 'getData']);
    Route::post('/user/notification/{id}' , [NotificationController::class , 'read']);

    // Payment
    Route::get('/user/payment' , [PaymentController::class , 'getData']);
    Route::get('/user/payment/{id}' , [PaymentController::class , 'view']);

    // Content
    Route::get('/user/content/{id}' , [ContentController::class , 'getData']);


});
