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
    public function getTimeZoneMessages()
    {
        $messages = Redis::get('timezone_change_messages');

        return response()->json(['messages' => $messages]);
    }

    public function getMessages()
    {
        $message = Redis::lrange('time_change',-10,-1);

        return response()->json(['messages' => $message]);
    }


    public function getTime()
    {
        $timezone = Redis::lindex('timezones', -1) ?: 'UTC';
        $currentTime = now()->setTimezone($timezone)->toDateTimeString();

        Redis::rpush('current_times_aut', $currentTime);
        $message = "time update: $currentTime";
        broadcast(new TimeUpdateEvent($message));

        return response()->json(['timezone' => $timezone, 'current_time' => $currentTime]);
    }



    public function setTime()
    {

        $newTimeZone = Redis::lindex('timezones', -1);

        if ($newTimeZone) {
            $currentTime = now()->setTimezone($newTimeZone)->toDateTimeString();
            Redis::rpush('current_times', $currentTime);

            return response()->json(['message' => 'new time config successfully', 'current_time' => $currentTime]);
        }

        return response()->json(['error' => 'Timezone not updated'], 400);
    }



    public function setTimeZone(Request $request)
    {

        $newTimeZone = $request->input('new_timezone');

        if ($newTimeZone) {
            Redis::rpush('timezones', $newTimeZone);

            $currentTime = now()->setTimezone($newTimeZone)->toDateTimeString();
            Redis::set('current_time', $currentTime);

            broadcast(new TimeZoneChanged($newTimeZone));
            // broadcast(new Hello());
            event(new TimeZoneChangedEvent($newTimeZone));

            NotifyTimeZoneChangeJob::dispatch($newTimeZone);

            return response()->json(['message' => 'Time and timezone updated successfully']);
        }

        return response()->json(['error' => 'A new Timezone is required'], 400);
    }
}
