<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TimeZone;
use App\Models\Clock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeController extends Controller
{
     public function getTime()
    {
        $timezone = Timezone::first()->timezone ?? 'UTC';

        // Obtener la última hora configurada
        $latestTime = Clock::orderBy('created_at', 'desc')->first();

        $currentTime = $latestTime ? $latestTime->time : Carbon::now($timezone)->toTimeString();

        return response()->json(['timezone' => $timezone, 'time' => $currentTime]);
    }


    public function setTime(Request $request)
    {
        $newTime = $request->input('time');

        // Validar y guardar la nueva hora en la base de datos
        Clock::create(['time' => $newTime]);

        // Emitir el evento time_updated
        // event(new \App\Events\TimeUpdated($newTime));

        return response()->json(['message' => 'Time updated successfully']);

        
    }

    public function setTimezone(Request $request)
    {
        $newTimezone = $request->input('timezone');

        // Validar y guardar el nuevo timezone en la base de datos
        Timezone::updateOrCreate([], ['timezone' => $newTimezone]);

        return response()->json(['message' => 'Timezone updated successfully']);
    }
}
