<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReactionPost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user_id;
    public $post_id;
    public $reaction_type;
    public $recipient_id;
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id,$post_id,$reaction_type,$recipient_id,$data)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->reaction_type = $reaction_type;
        $this->recipient_id = $recipient_id;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('reaction-post.'.$this->recipient_id);
    }
    public function broadcastAs(){
        return 'reaction-post-send';
    }
}
