<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        Redis::flushdb(); // Limpia la base de datos Redis (solo cuando este esta desarrollo)

        $currentTime = now()->toDateTimeString();

        Redis::rpush('current_times', $currentTime);
        
        Redis::rpush('current_times_aut', $currentTime);

        Redis::rpush('time_change', 'Primer mensaje en Redis');
        Redis::rpush('timezone_change_messages', 'Primer mensaje en Redis');

        Redis::rpush('timezones', 'UTC'); //Usa utc como predeterminado
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Redis::flushdb(); 
    }
};
