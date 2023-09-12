<?php

namespace App\Listeners;

use App\Events\Reply;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReplyNotification implements ShouldQueue
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
     * @param  \App\Events\Reply  $event
     * @return void
     */
    public function handle(Reply $event)
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
                'type'=>5 // reply comment
            ]);
        }
    }
}
