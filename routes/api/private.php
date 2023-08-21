<?php

use App\Http\Controllers\Api\Guest\LoginController;
use app\Http\Controllers\Api\Private\GroupController;
use app\Http\Controllers\Api\Private\InterestController;
use App\Http\Controllers\Api\Private\ProfileController;
use App\Http\Controllers\Api\Private\SettingsController;
use App\Http\Controllers\Api\Private\NotificationController;
use App\Http\Controllers\Api\Private\PaymentController;
use App\Http\Controllers\Api\Private\ContentController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/authuser/{id}' , [ProfileController::class , 'getUser']);
    Route::post('/profile/{id}' , [ProfileController::class , 'postUser']);
    Route::get('/user-interest/{user_id}' , [InterestController::class , 'getUserInterest']);
    Route::post('/add-user-interest/{user_id}' , [InterestController::class , 'postUserInterest']);
    Route::get('/user-groups/{user_id}' , [GroupController::class , 'getUserGroups']);
    Route::get('/user/{user_id}/group/{group_id}/joined' , [GroupController::class , 'getJoinedGroupOfUser']);
    Route::post('/join-request/user/{user_id}/group/{group_id}' , [GroupController::class , 'createGroupJoinRequest']);
    // Settings
    Route::get('/user/settings', [SettingsController::class, 'getData']);
    Route::post('/user/settings', [SettingsController::class, 'store']);

    // Notification
    Route::get('/user/notification', [NotificationController::class, 'getData']);
    Route::post('/user/notification/{id}', [NotificationController::class, 'read']);

    // Payment
    Route::get('/user/payment', [PaymentController::class, 'getData']);
    Route::get('/user/payment/{id}', [PaymentController::class, 'view']);

    // Content
    Route::get('/user/content/{id}' , [ContentController::class , 'getData']);



});
