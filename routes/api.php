<?php

use App\Http\Controllers\TimeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/time', [TimeController::class, 'getTime']);
Route::get('/tzms', [TimeController::class, 'getTimeZoneMessages']);
Route::get('/messages', [TimeController::class, 'getMessages']);
Route::post('/time', [TimeController::class, 'setTime']);
Route::post('/timezone', [TimeController::class, 'setTimeZone']);