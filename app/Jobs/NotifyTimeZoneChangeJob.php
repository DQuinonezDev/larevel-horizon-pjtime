<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class NotifyTimeZoneChangeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $newTimeZone;

    public function __construct($newTimeZone)
    {
        $this->newTimeZone = $newTimeZone;
    }

    public function handle()
    {
        Redis::set('timezone_change_messages', "Se cambió el huso horario a {$this->newTimeZone}");
    }
}
