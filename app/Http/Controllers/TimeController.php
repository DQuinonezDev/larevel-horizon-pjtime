<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TimeController extends Controller
{

    public function getTime()
    {
        $timezone = Redis::get('timezone') ?: 'UTC';
        $currentTime = Redis::get('current_time') ?: now()->toDateTimeString();

        return response()->json(['timezone_update' => $timezone, 'time_update' => $currentTime]);
    }


    public function setTime(Request $request)
    {
        $currentTime = now()->toDateTimeString();
        Redis::rpush('current_times', $currentTime);

        return response()->json(['message' => 'Nueva hora configurada correctamente']);
    }



    public function setTimeZone(Request $request)
    {

        $newTimeZone = $request->input('new_timezone');

        Redis::rpush('timezones', $newTimeZone);

        $currentTime = now()->setTimezone($newTimeZone)->toDateTimeString();
        Redis::rpush('current_times', $currentTime);

        return response()->json(['message' => 'Nuevo huso horario y hora configurados correctamente']);
    }
}
