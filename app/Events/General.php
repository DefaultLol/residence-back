<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class General implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;
    public $message;

    public function __construct($title,$message)
    {
        $this->title=$title;
        $this->message=$message;
    }

    public function broadcastOn()
    {
        return new Channel('general-channel');
    }

    public function broadcastAs()
    {
        return 'general-event';
    }
}
