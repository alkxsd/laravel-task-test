<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\TaskController as ApiTaskController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/test', function () {
    dd('WORKS');
})->name('api.test');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', ApiTaskController::class);
    Route::post('/tasks/{task}/update-status', [ApiTaskController::class, 'updateStatus']);
    Route::get('/test1', function () {
        dd('SHOULD WORK');
    })->name('api.test');
});
