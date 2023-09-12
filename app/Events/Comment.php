<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Comment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $recipientId;
    public $senderId;
    public $data;
    public $post_id;
    public $comment_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($recipientId,$senderId,$data,$post_id,$comment_id)
    {
        //
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->data = $data;
        $this->post_id = $post_id;
        $this->comment_id = $comment_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('comment-'.$this->recipientId);
    }
    public function broadcastAs(){
        return 'comment-post';
    }
}
