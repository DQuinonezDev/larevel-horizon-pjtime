<?php

use App\Events\Hello;
use App\Events\NuevoTiempo;
use App\Events\TimeZoneChanged;
use App\Http\Controllers\TimeController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/broadcast', function () {
    broadcast(new NuevoTiempo());
});

// Route::post('/time', [TimeController::class, 'setTime']);
// Route::post('/timezone', [TimeController::class, 'setTimeZone']);