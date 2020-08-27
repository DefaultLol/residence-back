<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;
    public $message;
    public $receiver;

    public function __construct($title,$message,$receiver)
    {
        $this->title=$title;
        $this->message=$message;
        $this->receiver=$receiver;
    }

    public function broadcastOn()
    {
        return new Channel('notif-channel-'.$this->receiver);
    }

    public function broadcastAs()
    {
        return 'notif-event';
    }
}
