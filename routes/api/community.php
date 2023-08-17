<?php

use App\Http\Controllers\Api\Community\CouponController;
use App\Http\Controllers\Api\Community\EventController;
use App\Http\Controllers\Api\Community\GroupController;
use App\Http\Controllers\Api\Community\MemberController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/{group_id}', [GroupController::class, 'getGroups']);
    Route::get('/{group_id}/members', [MemberController::class, 'getMembers']);
    Route::get('/{group_id}/coupons', [CouponController::class, 'getCoupons']);
    Route::get('/{group_id}/events', [EventController::class, 'getEvent']);

});
