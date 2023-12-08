<?php

namespace App\Listeners;

use App\Events\ReactionComment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReactionCommentNotification implements ShouldQueue
{
    use InteractsWithQueue;
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
     * @param  \App\Events\ReactionComment  $event
     * @return void
     */
    public function handle(ReactionComment $event)
    {
        //
        $recipient = User::findOrFail($event->recipientId);
        $sender = User::findOrFail($event->senderId);
        $data = $event->data;
        if($recipient){
            Notification::create([
               'sender_id'=>$sender->id,
               'recipient_id'=>$recipient->id,
               'hyper_link'=>'/post?id='.$event->post_id.'#cmt-'.$event->comment_id,
               'data'=>json_encode($data),
                'type'=>6,
            ]);
        }
    }
}
