<?php

namespace App\Listeners;

use App\Events\FriendRequestSent;
use App\Models\User;
use App\Notifications\FriendRequestNotification;
use App\Notifications\InvoicePaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;

class SendFriendRequestNotification implements ShouldQueue
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
     * @param  \App\Events\FriendRequestSent  $event
     * @return void
     */
    public function handle(FriendRequestSent $event)
    {
        //
        $recipient = User::findOrFail($event->recipientId);

        $sender = User::findOrFail($event->senderId);
//        dd(is_array($sender),$sender);
        $data = [
            'senderId'=>$event->senderId,
            'message'=>$sender->name.' đã gửi cho bạn lời mời kết bạn',
            'action_text'=>'Chấp nhận',
            'action_url'=>route('client.accept.friend.request',['senderId'=>$event->senderId]),
            'reject_text'=>'Từ chối',
            'reject_url'=>route('client.reject.friend.request',['senderId'=>$event->senderId])
        ];
        if ($recipient){
//            \Illuminate\Support\Facades\Notification::send($recipient, new FriendRequestNotification($data));
//            $recipient->notify(new InvoicePaid($event));
            Notification::create([
                'sender_id'=>$sender->id,
                'recipient_id'=>$recipient->id,
                'data'=>json_encode($data),
                'type'=>1,// friend request
            ]);
        }
    }
}