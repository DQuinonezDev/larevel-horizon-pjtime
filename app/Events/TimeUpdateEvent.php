<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class TimeUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $time;
    public $newTimeZone;
    public $currentTime;

    /**
     * Create a new event instance.
     */
    public function __construct($time)
    {
        $this->time = $time;

    }
    public function broadcastOn()
    {
        Redis::rpush('time_change', $this->time);

        return new Channel('channel');
    }

    public function broadcastAs()
    {
        return 'time.saved';
    }

    public function broadcastWith()
    {
        return [
            'newTimeZone' => $this->newTimeZone,
            'currentTime' => $this->currentTime,
        ];
    }
}
