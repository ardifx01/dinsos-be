<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Permission\PermissionController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, "login"]);
    Route::middleware('jwt.verify')->group(function () {
        Route::post('me', [AuthController::class, "me"]);
        Route::post('logout', [AuthController::class, "logout"]);
        Route::post('refresh', [AuthController::class, "refresh"]);
    });
});

Route::prefix('app')->middleware('jwt.verify')->group(function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('role', RoleController::class);
    Route::apiResource('permission', PermissionController::class);
});
