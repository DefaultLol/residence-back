<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Comments implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $sender;

    public function __construct($id,$sender)
    {
        $this->id=$id;
        $this->sender=$sender;
    }

    public function broadcastOn()
    {
        return new Channel('comment-channel-'.$this->id);
    }

    public function broadcastAs()
    {
        return 'comment-event';
    }
}
