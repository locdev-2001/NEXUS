<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendRequestSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $recipientId;
    public $senderId;
    public $data;
    /**
     * Create a new event instance.
     * @param int $senderId
     * @param int $recipientId
     *
     */
    public function __construct($senderId,$recipientId,$data)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('friend-request.'.$this->recipientId);
    }
    public function broadcastAs()
    {
        return 'friend-request-sent';
    }
}
