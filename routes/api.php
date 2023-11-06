<?php

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
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tasks-all', [\App\Http\Controllers\Api\TaskController::class, 'index']);
    Route::post('/create-tasks', [\App\Http\Controllers\Api\TaskController::class, 'store']);
    Route::patch('/update-tasks/{id}', [\App\Http\Controllers\Api\TaskController::class, 'update']);
    Route::delete('/del-tasks/{id}', [\App\Http\Controllers\Api\TaskController::class, 'del']);
});
