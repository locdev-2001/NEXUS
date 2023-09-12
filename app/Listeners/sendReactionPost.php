<?php

namespace App\Listeners;

use App\Events\ReactionPost;
use App\Models\Notification;
use App\Models\Post_reactions;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class sendReactionPost implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ReactionPost  $event
     * @return void
     */
    public function handle(ReactionPost $event)
    {
        $user_id = $event->user_id;
        $data = $event->data;
        if ($event->recipient_id !== $user_id){
            Notification::create([
                'sender_id'=>$user_id,
                'recipient_id'=>$event->recipient_id,
                'post_id'=>$event->post_id,
                'data'=>json_encode($data),
                'hyper_link'=>'/post?id='.$event->post_id,
                'type'=>3 // reaction
            ]);
        }
    }
}
