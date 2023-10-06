<?php

use App\Http\Controllers\Api\Private\ContentController;
use App\Http\Controllers\Api\Private\GroupController;
use App\Http\Controllers\Api\Private\InterestController;
use App\Http\Controllers\Api\Private\NotificationController;
use App\Http\Controllers\Api\Private\PaymentController;
use App\Http\Controllers\Api\Private\ProfileController;
use App\Http\Controllers\Api\Private\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    // Profile
    Route::get('/{userid}', [ProfileController::class, 'getUser']);
    Route::post('/{userid}', [ProfileController::class, 'postUser']);
    // Interest
    Route::get('/{userid}/allinterests', [InterestController::class, 'getAllInterest']);
    Route::get('/{userid}/interests', [InterestController::class, 'getUserInterest']);
    Route::post('/{userid}/interests', [InterestController::class, 'postUserInterest']);
    // Group
    Route::get('/{userid}/groups', [GroupController::class, 'getUserGroups']);
    Route::get('/{userid}/groups/{groupid}', [GroupController::class, 'getJoinedGroupOfUser']);
    Route::post('/{userid}/groups/{groupid}', [GroupController::class, 'createGroupJoinRequest']);
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
    Route::get('/user/content/{id}', [ContentController::class, 'getData']);

});
