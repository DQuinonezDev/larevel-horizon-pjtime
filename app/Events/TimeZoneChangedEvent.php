<?php
namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TimeZoneChangedEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $newTimeZone;

    public function __construct($newTimeZone)
    {
        $this->newTimeZone = $newTimeZone;
    }

    public function broadcastOn()
    {
        return ['channeltz'];
    }

    public function broadcastAs()
    {
        return 'time-zone-changed';
    }
}

