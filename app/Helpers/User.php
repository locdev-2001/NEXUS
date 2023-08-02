<?php

namespace App\Helpers;
use App\Models\FriendRequests;
use App\Models\Friends;
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
    public function isFriend($userId){
        $myId = Auth::id();
        $friendRelationship = Friends::where(function($query) use ($myId,$userId){
            $query->where('user_id',$userId)->where('friend_id',$myId);// kiểm tra xem tôi có kết bạn với người này chưa
        })->orWhere(function($query) use ($myId,$userId){
            $query->where('user_id',$myId)->where('friend_id',$userId);//kiểm tra xem người này đã kết bạn với tôi chưa
        })->first();
        if ($friendRelationship){
            return true;
        }
        else{
            return false;
        }
    }
}
