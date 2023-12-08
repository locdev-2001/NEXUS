<?php

namespace App\Helpers;
use App\Models\FriendRequests;
use App\Models\Friends;
use App\Models\Notification;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserHelpers{
    public function getUser(){
       return Auth::user();
    }
    public static function getId(){
        return Auth::id();
    }
    public function getProfile(){
        $profile = new Profile();
        return $profile::where('user_id',Auth::id())->first();
    }
    public function getNotifications(){
        $userId = Auth::id();
        $notifications = Notification::where('recipient_id',$userId)->orderBy('created_at','desc')->get();
//        $notifications->map(function ($n){
//            $n->created_at = $this->getTimeAgoAtrr($n->created_at);
//            $n->updated_at = $this->getTimeAgoAtrr($n->updated_at);
//            return $n;
//        });
        return $notifications;
    }
    public static function getFriendRequest($recipientId){
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
    public static function isFriend($userId){
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
    public function getTimeAgoAtrr($t){
        $created_at = Carbon::parse($t);
        $now = Carbon::now();
        $diff = $created_at->diff($now);
        if ($diff->days >= 3) {
            return $created_at->format('d \t\h\á\n\g m \n\ă\m Y');
        }
        elseif ($diff->days >= 1) {
            return $diff->days . ' ngày trước';
        }
        elseif ($diff->h >=1) {
            return $diff->format('%h giờ trước');
        }
        elseif($diff->i >=1){
            return $diff->i .' phút trước';
        }
        else{
            return 'Vừa xong';
        }
    }
}
