<?php

namespace App\Helpers;
use App\Models\FriendRequests;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class UserHelpers{
    public function getUser(){
       return Auth::user();
    }
    public static function getId(){
        return Auth::id();
    }
    public function getNotifications(){
        $userId = Auth::id();
        $notifications = Notification::where('recipient_id',$userId)->get();
        return $notifications;
    }
    public function getFriendRequest($recipientId){
        $senderId = Auth::id();
        return FriendRequests::where(function ($query) use ($senderId, $recipientId) {
            $query->where('sender_id', $senderId)
                ->where('recipient_id', $recipientId);//kiểm tra xem Auth có gửi request cho recipient này không
        })->orWhere(function ($query) use ($senderId, $recipientId) {
            // Hoặc kiểm tra nếu Auth là người nhận request từ recipient
            $query->where('sender_id', $recipientId)
                ->where('recipient_id', $senderId);
        })->first();
    }
}
