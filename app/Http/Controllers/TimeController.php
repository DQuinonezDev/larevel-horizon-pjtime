<?php

namespace App\Http\Controllers;

use App\Events\Hello;
use App\Events\TimeUpdateEvent;
use App\Events\TimeZoneChanged;
use App\Events\TimeZoneChangedEvent;
use App\Jobs\NotifyTimeZoneChangeJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TimeController extends Controller
{
    public function getTime()
    {
        $timezone = Redis::lindex('timezones', -1) ?: 'UTC';
        $currentTime = now()->setTimezone($timezone)->toDateTimeString();

        // Redis::rpush('current_times_aut', $currentTime); 
        // $message = "time update: $currentTime";


        
        // broadcast(new TimeUpdateEvent($message));

        return response()->json(['timezone' => $timezone, 'current_time' => $currentTime]);
    }



    public function setTime(Request $request)
    {
        $newTimeZone = Redis::lindex('timezones', -1);

        if ($newTimeZone) {
            $currentTime = now()->setTimezone($newTimeZone)->toDateTimeString();
            Redis::rpush('current_times', $currentTime);

            return response()->json(['message' => 'Nueva hora configurada correctamente', 'current_time' => $currentTime]);
        }

        return response()->json(['error' => 'No se ha configurado un huso horario'], 400);
    }




    public function setTimeZone(Request $request)
    {
        $newTimeZone = $request->input('new_timezone');

        if ($newTimeZone) {
            Redis::rpush('timezones', $newTimeZone);

            $currentTime = now()->setTimezone($newTimeZone)->toDateTimeString();
            Redis::set('current_time', $currentTime);

            // broadcast(new TimeZoneChanged($newTimeZone));
            // broadcast(new Hello());
            event(new TimeZoneChangedEvent($newTimeZone));

            NotifyTimeZoneChangeJob::dispatch($newTimeZone);

            return response()->json(['message' => 'Nuevo huso horario y hora configurados correctamente']);
        }

        return response()->json(['error' => 'Se requiere un nuevo huso horario'], 400);
    }
}
