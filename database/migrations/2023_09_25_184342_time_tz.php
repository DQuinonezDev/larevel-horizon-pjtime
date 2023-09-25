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

        $currentTime = now()->toDateTimeString();
        Redis::rpush('current_times', $currentTime);

        Redis::rpush('timezones', 'UTC');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Redis::del('current_times, timezones'); // Limpia la base de datos Redis (solo en desarrollo)

    }
};
